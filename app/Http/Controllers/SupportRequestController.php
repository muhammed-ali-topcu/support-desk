<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Inertia\Inertia;

class SupportRequestController extends Controller
{
    public function index()
    {
        $supportRequests = SupportRequest::query()
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(function ($supportRequest) {
                return [
                    'id'         => $supportRequest->id,
                    'subject'    => $supportRequest->subject,
                    'email'      => $supportRequest->email,
                    'message'    => $supportRequest->message,
                    'created_at' => $supportRequest->created_at->format('Y-m-d H:i'),
                ];

            });

        return Inertia::render('SupportRequest/Index', [
            'supportRequests' => $supportRequests,
        ]);

    }
}
