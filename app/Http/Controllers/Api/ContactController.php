<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contact\Actions\SendContactMessage;
use App\Http\Requests\Api\StoreContactMessageRequest;
use Illuminate\Http\JsonResponse;

class ContactController
{
    public function store(StoreContactMessageRequest $request, SendContactMessage $action): JsonResponse
    {
        $action->execute($request->validated());

        return response()->json(['message' => __('Message envoyé.')], 201);
    }
}
