<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::paginate(5);
        return response()->json([
            "status" => 1,
            "message" => "Posts fetched.",
            "data" => $posts
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => "Validation Errors",
                "data" => $validator->errors()->all()
            ]);
        }

        $post = Post::create([
            "title" => $request->title,
            "body" => $request->body
        ]);

        return response()->json([
            "status" => 1,
            "message" => "Post Created",
            "data" => $post
        ]);
    }

    public function show(Request $request, $id)
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return response()->json([
                "status" => 0,
                "message" => "Post Not Found",
                "data" => NULL
            ], 404);
        }

        return response()->json([
            "status" => 1,
            "message" => "Post Return",
            "data" => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "body" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => 0,
                "message" => "Validation Errors",
                "data" => $validator->errors()->all()
            ]);
        }

        $post = Post::find($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return response()->json([
            "status" => 1,
            "message" => "Post Updated",
            "data" => $post
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        $post->delete();

        return response()->json([
            "status" => 1,
            "message" => "Post Deleted",
            "data" => NULL
        ]);
    }
}
