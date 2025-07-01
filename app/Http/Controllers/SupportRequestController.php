<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SupportRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $supportRequests = SupportRequest::query()
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%")
                      ->orWhere('subject', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%");
                });
            })
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
            'filters' => $request->only(['search']),
        ]);
    }
}
