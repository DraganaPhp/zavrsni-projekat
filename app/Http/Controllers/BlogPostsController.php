<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogPostCategory;
use App\Models\Tag;
use App\User;

class BlogPostsController extends Controller {

    public function index() {
        
        $blogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags','user','comments'])
                ->where('status',1)
                ->orderBy('created_at','DESC')
                ->paginate(12);
        
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status',1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

        $tags = Tag::query()
                //->orderBy('priority')
                ->get();
        $users = User::query()
                //->orderBy('priority')
                ->get();

 $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();
        return view('front.blogs.index', [
            'blogPosts' => $blogPosts,
            'latestBlogPosts' => $latestBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
            'users' => $users,
        ]);
    }

}
