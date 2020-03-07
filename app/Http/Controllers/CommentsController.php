<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function store(Request $request)
    {
        $params = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'body' => 'required|max:2000',
        ]);

        $post = Post::findOrFail($params['post_id']);
        $post->comments()->create($params);

        return redirect()->route('posts.show', ['post' => $post]);
    }

    public function edit($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        return view('comments.edit', [
            'comment' => $comment,
        ]);
    }

    public function update($comment_id, Request $request)
    {
        $params = $request->validate([
            'body' => 'required|max:200',
        ]);
        $comment = Comment::findOrFail($comment_id);
        $comment->fill($params)->save();

        return redirect()->route('posts.show', ['post' => $comment->post_id]);
    }

    public function destroy($post_id)
    {
        # code...
    }
}
