<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupportRequestRequest;
use App\Http\Resources\SupportRequestResource;
use App\Models\SupportRequest;
use Illuminate\Http\JsonResponse;

class SupportRequestController extends Controller
{
    public function store(SupportRequestRequest $request): JsonResponse
    {
        $supportRequest = SupportRequest::create($request->validated());
        return response()->json([
            'success'        => true,
            'message'        => 'Support request created successfully, we will get back to you soon!',
            'supportRequest' => SupportRequestResource::make($supportRequest),
        ]);
    }
}
