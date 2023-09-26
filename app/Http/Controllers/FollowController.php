<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    public  function  follow(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'user_id' => 'required', // user_id is the id of the user who is following
            'following_user_id' => 'required', /// following_user_id is the id of the user who is being followed
        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $follow = Follow::create($data);
        return response(['follow' => $follow, 'message' => 'Created successfully'], 200);
    }
    public  function  unFollow(Request $request){
        $follow = Follow::where('user_id', $request->user_id)->where('following_user_id', $request->following_user_id)->first();
        if ($follow) {
            $follow->delete();
            return response(['message' => 'Deleted']);
        }
        return response(['message' => 'Not found']);
    }
}
