<?php

namespace App\Http\Controllers\API;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function conversation($bookingId)
    {
        $conversation = Conversation::where(
            'booking_id',
            $bookingId
        )->firstOrFail();

        $this->authorizeConversation($conversation);

        return response()->json($conversation);
    }

    public function messages(Conversation $conversation)
    {
        $this->authorizeConversation($conversation);

        return Message::with('sender')
            ->where(
                'conversation_id',
                $conversation->id
            )
            ->orderBy('id')
            ->get();
    }

    public function send(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
            'message' => 'required'
        ]);

        $conversation = Conversation::findOrFail(
            $request->conversation_id
        );

        $this->authorizeConversation($conversation);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        broadcast(
            new MessageSent($message)
        )->toOthers();

        return response()->json($message);
    }

    private function authorizeConversation($conversation)
    {
        if (
            Auth::id() != $conversation->driver_id &&
            Auth::id() != $conversation->passenger_id
        ) {
            abort(403, 'Unauthorized');
        }
    }
}
