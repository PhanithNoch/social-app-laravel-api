<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
class LikeController extends Controller
{

    public function toggleLike($postId){
        $user = auth()->user(); // get the currently authenticated user
        $post = Post::find($postId); // get the post with the given id
        $like = Like::where('user_id', $user->id)->where('post_id', $post->id)->first();
        if($like){
            $like->delete();
            return response()->json(['success' => 'success'], 200);
        }else{
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $post->id;
            $like->save();
        }
        return response()->json(['success' => 'success'], 200);
    }
    public function show($postId){
        $post = Post::find($postId);
        if(!$post){
            return response()->json(['error' => 'Post not found'], 404);
        }
        $likes = $post->likes()->with('user')->latest(); /// get all the likes for the post
        return response()->json(['data' => $likes], 200);
        
    }
}
