<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Comment;

class CommentsController extends Controller {

    public function blogPostComments(BlogPost $blogPost) {
          $comments = $blogPost->comments()->orderby('created_at', 'asc')->get();
        return view('front.comments.blog_posts_comments', [
            'blogPost'=>$blogPost,
            'comments'=>$comments
                ]);
    }

    public function sendComment(Request $request, blogPost $blogPost) {


        $formData = $request->validate([
            'sender_nickname' => ['required', 'string', 'min:2', 'max:255'],
            'sender_email' => ['required', 'email', 'max:255'],
            'body' => ['required', 'string', 'min:10', 'max:255'],
        ]);
        
        $newComment = new Comment();
        $newComment->fill($formData);
        $newComment->blog_post_id=$blogPost->id;
        $newComment->save();
        session()->flash('system_message', __('Your comment has been saved!'));

        return redirect()->route('front.blog_posts_single',[
            
            'blogPost'=>$blogPost]
                );

    }

}
