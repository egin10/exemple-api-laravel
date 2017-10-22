<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Transformers\PostTransformer;
use Auth;

class PostController extends Controller
{
    //Show Posts
    public function posts(Post $post)
    {
        $posts = $post->latestFirst()->get();

        return fractal()
                ->collection($posts)
                ->transformWith(new PostTransformer)
                ->toArray();
    }

    //Create Post
    public function add(Request $request, Post $post)
    {
        $this->validate($request, [
            'content'   => 'required|min:10',
        ]);

        $post = $post->create([
            'user_id'   => Auth::user()->id,
            'content'   => $request->content,
        ]);

        $response = fractal()
                ->item($post)
                ->transformWith(new PostTransformer)
                ->toArray();
        
        return response()->json($response, 201);
    }

    //Update Post
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->content = $request->get('content', $post->content);
        $post->save();

        return fractal()
                ->item($post)
                ->transformWith(new PostTransformer)
                ->toArray();
    }

    //Delete Post
    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message'   => "Post has deleted",
        ]);
    }
}
