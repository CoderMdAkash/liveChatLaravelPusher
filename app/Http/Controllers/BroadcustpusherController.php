<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\MessageEvent;
use App\Models\Message;
use Auth;

class BroadcustpusherController extends Controller
{

    public function index(){
        if(Auth::check()){
            return view('pusher.index');
        }else{
            return redirect('login');
        }
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;

        $data = ['user_id'=>$user_id, 'message'=>$request->message];
        event(new MessageEvent($data));

        Message::create([
            'user_id' => $user_id,
            // 'send_id' => 0,
            'message' => $request->message
        ]);

        return response()->json([
            'message' => 'Message Send Success'
        ]);
    }

    public function show(){
        $data['user_id'] = $user_id = Auth::user()->id;

        $data['messages'] = Message::join('users', 'users.id', '=', 'messages.user_id')
                // ->where('messages.user_id', $user_id)
                // ->where('messages.send_id', $user_id)
                // ->limit(20)
                ->select('messages.*', 'users.name as user_name')
                ->get();

        return view('pusher.message_show', $data);
    }
}
