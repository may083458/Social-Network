<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Helper\AllHelper;
use Auth;
use Validator;

class PageController extends Controller
{
    //Create Page
    public function create(Request $request) {
        //Validation Of Data
        $validator = Validator::make(request()->all(),[
            'page_name' => 'required|min:1'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }

        //Store Page Data To Table
        $page = Page::create([
            'page_name' => $request->page_name,
            'user_id' => Auth::id(),
        ]);

        $response = AllHelper::responseJson(200,'Page Successfully Created.');
        return $response;
    }

}
