<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ChatRoom; 
use Validator;
class ChatRoomController extends Controller
{
    //
    function index() {
        return ChatRoom::all();
    }

    function createChatRoom(Request $request) {

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

    
        return ChatRoom::create($request->all());
    }
}
