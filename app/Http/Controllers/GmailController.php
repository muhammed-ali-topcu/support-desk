<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GmailService;
use Illuminate\Support\Facades\Auth;
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
            
            // Store token in user's record or session
            $user = Auth::user();
            $user->gmail_token = json_encode($token);
            $user->save();
            
            return redirect()->route('gmail.index')
                ->with('success', 'Gmail successfully connected!');
                
        } catch (\Exception $e) {
            return redirect()->route('gmail.index')
                ->with('error', 'Error connecting to Gmail: ' . $e->getMessage());
        }
    }
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->gmail_token) {
            return Inertia::render('gmail/Authorize');
        }
        
        try {
            $token = json_decode($user->gmail_token, true);
            $this->gmailService->setAccessToken($token);
            
            $result = $this->gmailService->getInboxEmails(20);
            

            return Inertia::render('gmail/Inbox', [
                'emails' => $result['emails'],
            ]);
            
        } catch (\Exception $e) {
            // Token might be expired, redirect to authorize
            return redirect()->route('gmail.authorize')
                ->with('error', 'Please re-authorize Gmail access');
        }
    }
    
    public function disconnect()
    {
        $user = Auth::user();
        $user->gmail_token = null;
        $user->save();
        
        return redirect()->route('gmail.index')
            ->with('success', 'Gmail disconnected successfully');
    }
}
