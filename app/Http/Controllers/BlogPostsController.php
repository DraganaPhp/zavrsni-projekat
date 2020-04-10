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
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->paginate(12);

        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();

        $mostViewedBlogPosts = BlogPost::query()->
                        orderby('views', 'DESC')
                        ->limit(3)->get();

        $tags = Tag::query()
                ->get();

        $users = User::query()
                //->orderBy('priority')
                ->get();

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();
        return view('front.blog_posts.index', [
            'blogPosts' => $blogPosts,
            'latestBlogPosts' => $latestBlogPosts,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
            'users' => $users,
        ]);
    }

    public function single(BlogPost $blogPost) {

        BlogPost::where('id', $blogPost->id)->increment('views');

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                //->orderBy('priority')
                ->get();
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();


        $mostViewedBlogPosts = BlogPost::query()->
                        orderby('views', 'DESC')
                        ->limit(3)->get();

        $previousBlogPost = Optional(BlogPost::where('created_at', '<', $blogPost->created_at))->orderBy('created_at', 'desc')->first();
        $nextBlogPost = Optional(BlogPost::where('created_at', '>', $blogPost->created_at))->orderBy('created_at')->first();
//dd($nextBlogPost);
        return view('front.blog_posts.single_blog_post', [
            'blogPost' => $blogPost,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts' => $latestBlogPosts,
            'previousBlogPost' => $previousBlogPost,
            'nextBlogPost' => $nextBlogPost,
            'tags' => $tags,
        ]);
    }

    public function blogPostsAuthor(BlogPost $blogPost) {
        $user = User::query()
                ->where('id', $blogPost->user->id)
                ->get();

        $blogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('user_id', $blogPost->user->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(12);


        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                //->orderBy('priority')
                ->get();
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();


        $mostViewedBlogPosts = BlogPost::query()->
                        orderby('views', 'DESC')
                        ->limit(3)->get();


        return view('front.blog_posts.blog_posts_author', [
            'blogPosts' => $blogPosts,
            'blogPost' => $blogPost,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts' => $latestBlogPosts,
            'tags' => $tags,
        ]);
    }

    public function blogPostsCategory(BlogPost $blogPost) {

        $blogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('blog_post_category_id', $blogPost->blogPostCategory->id)
                ->orderBy('created_at', 'DESC')
                ->paginate(12);


        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                //->orderBy('priority')
                ->get();
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();


        $mostViewedBlogPosts = BlogPost::query()->
                        orderby('views', 'DESC')
                        ->limit(3)->get();


        return view('front.blog_posts.blog_posts_category', [
            'blogPosts' => $blogPosts,
            'blogPost' => $blogPost,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts' => $latestBlogPosts,
            'tags' => $tags,
        ]);
    }

}
