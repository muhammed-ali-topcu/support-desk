<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Inertia\Inertia;
use Str;

class SupportRequestController extends Controller
{
    public function index()
    {
        $supportRequests = SupportRequest::query()->paginate(10);

        $supportRequests->through(function ($supportRequest) {
            return [
                'id'         => $supportRequest->id,
                'subject'    => $supportRequest->subject,
                'email'      => $supportRequest->email,
                'message'    => Str::limit($supportRequest->message, 50),
                'created_at' => $supportRequest->created_at->format('Y-m-d H:i'),
            ];

        });

        return Inertia::render('SupportRequest/Index', [
            'supportRequests' => $supportRequests,
        ]);

    }
}
