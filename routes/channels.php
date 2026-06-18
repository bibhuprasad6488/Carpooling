<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(
    'conversation.{conversationId}',
    function ($user, $conversationId) {

        return Conversation::where('id', $conversationId)
            ->where(function ($q) use ($user) {

                $q->where('driver_id', $user->id)
                    ->orWhere('passenger_id', $user->id);

            })
            ->exists();
    }
);
