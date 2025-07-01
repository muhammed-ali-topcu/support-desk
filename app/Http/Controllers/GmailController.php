<?php

namespace App\Http\Controllers;

use App\Enums\SettingsEnum;
use App\Models\Setting;
use App\Services\GmailService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GmailController extends Controller
{
    private $gmailService;

    public function __construct(GmailService $gmailService)
    {
        $this->gmailService = $gmailService;
    }

    public function authorize()
    {
        $authUrl = $this->gmailService->getAuthUrl();
        return redirect($authUrl);
    }

    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('gmail.index')
                ->with('error', 'Authorization failed: ' . $request->error);
        }

        if (!$request->has('code')) {
            return redirect()->route('gmail.index')
                ->with('error', 'No authorization code received');
        }

        try {
            $token = $this->gmailService->exchangeCodeForToken($request->code);
            Setting::set(SettingsEnum::GMAIL_ACCESS_TOKEN->value, $token);
            info($token);

            return redirect()->route('gmail.index')
                ->with('success', 'Gmail successfully connected!');

        } catch (\Exception $e) {
            return redirect()->route('gmail.index')
                ->with('error', 'Error connecting to Gmail: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $token = Setting::get(SettingsEnum::GMAIL_ACCESS_TOKEN->value);
        if (!$token) {
            return Inertia::render('gmail/Authorize');
        }

        try {
            $this->gmailService->setAccessToken($token);

            $result = $this->gmailService->getInboxEmails(20);

            return Inertia::render('gmail/Inbox', [
                'emails' => $result['emails'],
            ]);

        } catch (\Exception $e) {
            return redirect()->route('gmail.authorize')
                ->with('error', 'Please re-authorize Gmail access');
        }
    }

    public function disconnect()
    {
        Setting::set(SettingsEnum::GMAIL_ACCESS_TOKEN->value, null);

        return redirect()->route('gmail.index')
            ->with('success', 'Gmail disconnected successfully');
    }
}
