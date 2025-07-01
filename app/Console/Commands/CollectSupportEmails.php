<?php

namespace App\Console\Commands;

use App\Enums\SettingsEnum;
use App\Models\Setting;
use App\Models\SupportRequest;
use App\Models\User;
use App\Services\GmailService;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CollectSupportEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:collect-support-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private GmailService $gmailService;

    /**
     * Execute the console command.
     */
    public function handle(GmailService $gmailService)
    {
        info('running app:collect-support-emails');
        $this->gmailService = $gmailService;
        $token              = Setting::get(SettingsEnum::GMAIL_ACCESS_TOKEN->value);
        $this->gmailService->setAccessToken($token);
        $result             = $this->gmailService->getInboxEmails(100);

        foreach ($result['emails'] as $email) {

            $emailAddress = Str::of($email['from'])->after('<')->before('>')->value();
            $subject      = $email['subject'];
            $message      = $email['body'];
            if ($this->_ensureNotExists($emailAddress, $subject)) {
             //   info('new support request saved form '. $emailAddress.' about:' .$subject);
                SupportRequest::create([
                    'email'   => $emailAddress,
                    'subject' => $subject,
                    'message' => $message,
                ]);
            }
        }
        info('finished app:collect-support-emails');

    }

    public function _ensureNotExists($emailAddress, $subject)
    {
        return !SupportRequest::where('email', $emailAddress)->where('subject', $subject)->exists();

    }
}
