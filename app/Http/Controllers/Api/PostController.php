<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

//Para sa JsonResource pwede mo icustomize ang return dito
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index(){

        //I fetch ang lahat ng data mula sa db
        $posts = Post::orderBy('created_at', 'desc')->get();

         // i-check if walang laman o data sa db
        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No record available'], 200);
        }

        //Customize na return mula sa PostResource Class
        // return PostResource::collection($posts);
        return response()->json($posts);
        
    }

    public function store(Request $request){

        //I validate ang request mula sa form
        $request->validate([
            'title' => "required|string|max:255",
            'body' => "required|string|max:255"
        ]);

        //Dito isesend yung data mula sa form papunta sa db
        $new_posts = Post::create([
            'title' => $request->title,
            'body' => $request->body
        ]);
        
        //response na naka json format kapag success ang pag send
        return response()->json([
            'message' => 'Data sent successfully!',
            'data' => $new_posts
        ], 200);

        //Customize na return mula sa PostResource Class
        // return new PostResource($new_posts);
    }

    public function show(Post $post){
        //I fetch ang specific/single post
        return response()->json($post);
    }


    public function update(Request $request, Post $post){
        
        //i validate muna ang request katulad sa pag send/post
        $request->validate([
            'title' => "required|string|max:255",
            'body' => "required|string|max:255"
        ]);

        //I update ang data gamit ang update()
        $post->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        //response na naka json format kapag success ang pag update
        return response()->json([
            'message' => 'Data updated successfully!',
            'data' => $post
        ], 200);

        //Customize na return mula sa PostResource Class
        // return new PostResource($post);
    }


    public function destroy(Post $post){

        $post->delete();

        //response na naka json format kapag success ang pag delete
        return response()->json([
            'message' => 'Data deleted successfully!'
        ], 200);
    }


}
