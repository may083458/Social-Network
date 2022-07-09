<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Post;
use App\Helper\AllHelper;
use Auth;
use Validator;
use DB;

class PostController extends Controller
{
    //Page Attach Post
    public function pageAttachPost($pageId, Request $request) {
        //Check whether page id is include or not.
        if(empty($pageId)) return AllHelper::responseJson(500, 'Page Id is required');

        //Check whether page id is exist or not.
        $page = Page::find($pageId);
        if(empty($page)) return AllHelper::responseJson(500, 'Page Id is not found. Please check again');

        //Validation Of Data
        $validator = Validator::make(request()->all(),[
            'post_content' => 'required|min:1'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }

        //Store Post To Table
        Post::create([
            'post_content' => $request->post_content,
            'page_id' => $pageId,
        ]);

        return AllHelper::responseJson(200,'Post Successfully Created.');
    }

     //Person Attach Post
     public function personAttachPost(Request $request) {
        //Validation Of Data
        $validator = Validator::make(request()->all(),[
            'post_content' => 'required|min:1'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }

        //Store Post To Table
        Post::create([
            'post_content' => $request->post_content,
            'user_id' => Auth::id(),
        ]);

        $response = AllHelper::responseJson(200,'Post Successfully Created.');
        return $response;
    }

    //Show Feed Of The Currently Logged In User Ordered By Id
    public function feed() {
        $result = Post::where(function($q) {
                        $q->has("user.followingPerson")->orHas("page.followingPage");
                    })
                    ->with('user:id,first_name,last_name','page:id,page_name')
                    ->orderBy('id', 'desc')
                    ->get();

        return response()->json([
            'status' => 200,
            'data' => $result,
        ]);
    }
}
