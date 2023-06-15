<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ChatRoom;
use App\Models\CallQueue;
use App\Models\Caller;
use DB;
use Validator;

class ChatRoomController extends Controller
{
    //
    function index()
    {
        return ChatRoom::all();
    }

    function createChatRoom(Request $request)
    {

        $validateUser = Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'chat_name' => 'required'
            ]
        );
        if ($validateUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        $chat_room = ChatRoom::create($request->all());
        $chat_room_id = $chat_room->id;

        $call_queue = CallQueue::create(['caller_id' => $request->customer_id]);


        return (Caller::join('call_queues', 'call_queues.caller_id', '=', 'callers.id')
            ->leftJoin('users', 'call_queues.csr_id', '=', 'users.id')
            ->select(
                "call_queues.id",
                "callers.lastname",
                "callers.firstname",
                "call_queues.queue_status",
                "call_queues.date_onqueue",
                "date_ongoing",
                "date_end",
                "users.firstname as csr_firstname",
                "users.lastname as csr_lastname",
                "transaction"
            )
            ->where('call_queues.id', $call_queue->id)
            ->get()
        );
    }
}