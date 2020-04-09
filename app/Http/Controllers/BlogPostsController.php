<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\BlogPostCategory;

class BlogPostsController extends Controller {

    public function index() {
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();


        return view('front.blogs.index', [
            'latestBlogPosts' => $latestBlogPosts,
            'blogPostCategories' => $blogPostCategories,
        ]);
    }

}
