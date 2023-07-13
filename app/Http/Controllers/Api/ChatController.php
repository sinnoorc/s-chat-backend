<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function chatWidget(Request $request)
    {


        $sender = auth()->user()->id;
        $receiver = $request->input('receiver');


        $messages = Chat::where(function ($query) use ($sender, $receiver) {
            $query->where('sender', $sender)->where('receiver', $receiver);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('sender', $receiver)->where('receiver', $sender);
        })->orderBy('timestamp', 'desc')->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        try {


            $sender = auth()->user()->id;
            $receiver = $request->input('receiver');
            $payload = $request->input('payload');
            $timestamp = new \DateTime();
            $chat = new Chat();
            $chat->sender = $sender;
            $chat->receiver = $receiver;
            $chat->message_type = 'text';
            $chat->payload = $payload;
            $chat->timestamp = $timestamp;

            $chat->save();

            return response()->json($chat);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function deleteMessage(Request $request)
    {
        $message = Chat::find($request->input('id'));

        $message->delete();

        return response()->json('Message deleted');
    }
}
