<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallQueue;

class CallQueueController extends Controller
{
    //

    function updateQueue(Request $request, $id)
    {

       // \Log::info($request);
       $callQueue = CallQueue::findOrFail($id);
       $callQueue->update($request->all());

        return response()->json($callQueue);
    }

}