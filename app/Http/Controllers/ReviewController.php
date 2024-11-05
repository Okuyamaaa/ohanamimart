<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{


    public function create(User $user){
        
        return view('reviews.create', compact('user'));
    }

    public function store(Request $request, User $user){
        $request->validate([
            'score'=> 'required|numeric|min:1|max:5',
            'content' => 'required',
        ]);

        $review = new Review();
        $review->content = $request->input('content');
        $review->score = $request->input('score');
        $review->send_user_id = Auth::id();
        $review->user_id = $user->id;
        

        $review->save();

        return to_route('user.show', $user)->with('flash_message', 'レビューを投稿しました。');


    }
    public function edit(User $user, Review $review){
        $user_id = Auth::id();

        if($review->send_user_id == $user_id){
            return view('reviews.edit', compact('user', 'review'));
        }
            
       

return to_route('user.show', $user)->with('error_message', '不正なアクセスです。');
    }

    public function update(Request $request, User $user, Review $review){

        $request->validate([
            'score'=> 'required|numeric|min:1|max:5',
            'content' => 'required',
        ]);
        
        $user_id = Auth::id();

        if($review->user_id !== $user_id){
            return to_route('user.show', $user)->with('error_message', '不正なアクセスです。');
        }


            $review->content = $request->input('content');
            $review->score = $request->input('score');
            $review->send_user_id = Auth::id();
            $review->user_id = $user->id;
            
    
            $review->update();
    
            return to_route('user.show', $user)->with('flash_message', 'レビューを編集しました。');
        

    }

    public function destroy(User $user, Review $review){
        
       
        
        if($review->send_user_id == Auth::id()){
            
            $review->delete();
            
            return to_route('user.show', $user)->with('flash_message', 'レビューを削除しました。');
            
        }else{

            return to_route('user.show', $user)->with('error_message', '不正なアクセスです。');
        }
    
}
}