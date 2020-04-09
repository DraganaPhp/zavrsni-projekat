<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\BlogPost;
use App\Models\BlogPostCategory;

class IndexController extends Controller {

    public function index() {
        $slides = Slide::query()
                ->where('on_index_page',1)
                ->orderBy('priority')
                ->limit(3)
                ->get();
        
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();
        
        $blogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags','user','comments'])
                ->where('on_index_page',1)
                ->where('status',1)
                ->orderBy('created_at','DESC')
                ->limit(3)
                ->get();
        
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags','user','comments'])
                ->orderBy('created_at','DESC')
                ->where('status',1)
                ->limit(12)
                ->get();
        
      $latestBlogCollections=$latestBlogPosts->chunk(3);
      $latestBlogPosts=$latestBlogPosts->take(3);
      //dd($latestBlogPosts);
        return view('front.index.index', [
            'slides' => $slides,
            'blogPosts' => $blogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts'=>$latestBlogPosts,
            'latestBlogCollections' =>$latestBlogCollections,
        ]);
    }

}
