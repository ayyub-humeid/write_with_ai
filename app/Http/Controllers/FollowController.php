<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\FollowNotification;
use Illuminate\Http\Request;



class FollowController extends Controller
{
    public function follow(Request $request, $userId)
    {
        $user = auth()->user();
        if ($user->id == $userId) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }
        $user->followings()->syncWithoutDetaching($userId); // we use syncWithoutDetaching to avoid duplicate entries in the pivot table
        // we avoided using attach() because it will throw an error if the user is already followed, while syncWithoutDetaching will ignore it and not throw an error
        //we avoided using sync() because it will detach all other followings and only keep the new one, while syncWithoutDetaching will keep all existing followings and add the new one if it doesn't exist
        $following = User::findOrFail($userId);
        $following->notify(new FollowNotification($following,$user));
        return response()->json(['message' => 'Followed successfully.']);
    }

    public function unfollow(Request $request, $userId)
    {
        $user = auth()->user();
        if ($user->id == $userId) {
            return response()->json(['message' => 'You cannot unfollow yourself.'], 400);
        }
        $user->followings()->detach($userId);
        // we use detach() to remove the entry from the pivot table, it will not throw an error if the user is not followed, it will just do nothing
        //we use followings() relationship to access the pivot table, we cannot use followers() relationship because it will look for the entry in the pivot table where the user is the following_id, while we want to look for the entry where the user is the follower_id
        return response()->json(['message' => 'Unfollowed successfully.']);
    }

}