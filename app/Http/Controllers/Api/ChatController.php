<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{


    /**
     * @bodyParam receiver string required The id of the receiver of the message.
     * @header Authorization Bearer {token} 
     */

    public function chatWidget(Request $request)
    {


        $sender = auth()->user()->id;
        $receiver = $request->input('receiver');


        $messages = Chat::where(function ($query) use ($sender, $receiver) {
            $query->where('sender', $sender)->where('receiver', $receiver);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('sender', $receiver)->where('receiver', $sender);
        })->orderBy('timestamp', 'desc')->get();

        $s1 = substr($sender, 0, 7);
        $s2 = substr($receiver, 0, 7);
        $sorted_user_ids =[ $s1, $s2];
        sort($sorted_user_ids);
        $caller_id = implode('_', $sorted_user_ids);


        $json = [
            'caller_id' => $caller_id,
            'messages' => $messages
        ];

        return  response()->json($json);
    }

    /**
     * @bodyParam receiver string required The id of the receiver of the message.
     * @bodyParam payload json required The message to be sent.
     * @header Authorization Bearer {token} 
     */

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

    /**
     * @bodyParam id string required The id of the message to be deleted.
     * @header Authorization Bearer {token} 
     */

    public function deleteMessage(Request $request)
    {
        $message = Chat::find($request->input('id'));

        $message->delete();

        return response()->json('Message deleted');
    }
}
