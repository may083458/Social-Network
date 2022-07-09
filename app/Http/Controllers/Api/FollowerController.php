<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\User;
use App\Models\Follower;
use App\Helper\AllHelper;
use Auth;
use Validator;

class FollowerController extends Controller
{
     //Follow Person
     public function followPerson($personId) {
        //Check whether person id is include or not.
        if(empty($personId)) return AllHelper::responseJson(500, 'Person Id is required');

        //Can't Follow Myself
        $login_user_id = Auth::id();
        if($personId == $login_user_id) return AllHelper::responseJson(500, 'Login User Can\'t Follow Myself.');

        //Check whether person id is exist or not.
        $user = User::find($personId);
        if(empty($user)) return AllHelper::responseJson(500, 'Person Id is not found. Please check again');

        //Check already follow or not. If already follow, unfollow person id.
        $follow_person = Follower::where('follower_id',$login_user_id)->where('person_following_id',$personId)->first();
        if(!empty($follow_person)) {
            $follow_person->delete();
            return AllHelper::responseJson(200,'UnFollow Person Successfully.');
        }

        //Store Data To Follower Table
        Follower::create([
            'follower_id' => $login_user_id,
            'person_following_id' => $personId
        ]);

        $response = AllHelper::responseJson(200,'Follow Person Successfully.');
        return $response;
    }

    public function followPage($pageId) {
        //Check whether page id is include or not.
        if(empty($pageId)) return AllHelper::responseJson(500, 'Page Id is required');

        //Check whether page id is exist or not.
        $page = Page::find($pageId);
        if(empty($page)) return AllHelper::responseJson(500, 'Page Id is not found. Please check again');

        //Check already follow or not. If already follow, unfollow person id.
        $login_user_id = Auth::id();
        $follow_page = Follower::where('follower_id',$login_user_id)->where('page_following_id',$pageId)->first();
        if(!empty($follow_page)) {
            $follow_page->delete();
            return AllHelper::responseJson(200,'UnFollow Page Successfully.');
        }

        //Store Data To Follower Table
        Follower::create([
            'follower_id' => $login_user_id,
            'page_following_id' => $pageId
        ]);

        $response = AllHelper::responseJson(200,'Follow Page Successfully.');
        return $response;
    }

}
