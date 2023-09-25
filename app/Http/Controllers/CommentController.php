<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Validator;

class CommentController extends Controller
{
    public function show($postId){
        $post = Post::find($postId);
        if(!$post){
            return response()->json(['error' => 'Post not found'], 404);
        }
        $comments = $post->comments()->with('user')->latest(); /// get all the comments for the post
        return response()->json(['data' => $comments], 200);
        
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'post_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $data = $request->all(); /// get all the data from the request
        $user = auth()->user(); // get the currently authenticated user
        $post = Post::find($data['post_id']); // get the post with the given id
        if(!$post){
            return response()->json(['error' => 'Post not found'], 404);
        }
        $comment = $post->comments()->create([
            'user_id' => $user->id,
            'comment' => $data['comment'],
            'post_id' => $post->id
        ]);
        return response()->json(['data' => $comment], 201);
    }
    public function update(Request $request,$id){
        $data = $request->all(); /// get all the data from the request
        $user = auth()->user(); // get the currently authenticated user
        $comment = Comment::find($id); // get the comment with the given id
        if(!$comment){
            return response()->json(['error' => 'Comment not found'], 404);
        }
        if($comment->user_id != $user->id){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $comment->update($data);
        return response()->json(['data' => $comment], 200);
    }

    public function destroy($id){
        $user = auth()->user(); // get the currently authenticated user
        $comment = Comment::find($id); // get the comment with the given id
        if(!$comment){
            return response()->json(['error' => 'Comment not found'], 404);
        }
        /// check if the user is the owner of the comment
        if($comment->user_id != $user->id){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $comment->delete();
        return response()->json(['data' => $comment], 200);
    }
}
