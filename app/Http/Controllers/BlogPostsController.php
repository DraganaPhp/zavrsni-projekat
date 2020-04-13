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
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
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

    public function single(BlogPost $blogPost, $seoSlug = null) {

        if ($seoSlug != \Str::slug($blogPost->subject)) {
            return redirect()->away(route('front.blog_posts.single', ['blogPost' => $blogPost, 'seoSlug' => \Str::slug($blogPost->subject)]));
        }
        BlogPost::where('id', $blogPost->id)->increment('views');

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
                ->get();
        $latestBlogPosts = BlogPost::query()
                ->with(['blogPostCategory', 'tags', 'user', 'comments'])
                ->where('status', 1)
                ->orderBy('created_at', 'DESC')
                ->limit(3)
                ->get();
        $comments = $blogPost->comments();

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
            'comments' => $comments,
        ]);
    }

    public function blogPostsAuthor(BlogPost $blogPost, $seoSlug = null) {
        if ($seoSlug != \Str::slug($blogPost->user->name)) {
            return redirect()->away(route('front.blog_posts.blog_posts_author', ['blogPost' => $blogPost, 'seoSlug' => \Str::slug($blogPost->user->name)]));
        }
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
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
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

    public function blogPostsCategory(BlogPost $blogPost, $seoSlug = null) {
        if ($seoSlug != \Str::slug($blogPost->blogPostCategory->name)) {
            return redirect()->away(route('front.blog_posts.blog_posts_category', ['blogPost' => $blogPost, 'seoSlug' => \Str::slug($blogPost->blogPostCategory->name)]));
        }
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
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
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

    public function blogPostsTag(Tag $tag, $seoSlug = null) {
        if ($seoSlug != \Str::slug($tag->name)) {
            return redirect()->away(route('front.blog_posts.blog_posts_tag', ['tag' => $tag, 'seoSlug' => \Str::slug($tag->name)]));
        }
        $blogPosts = $tag->blogPosts()->paginate(12);

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
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


        return view('front.blog_posts.blog_posts_tag', [
            'blogPosts' => $blogPosts,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts' => $latestBlogPosts,
            'tags' => $tags,
            'tag' => $tag,
        ]);
    }

    public function blogPostsSearch(Request $request) {
        $formData = $request->validate([
            'search_term' => ['required', 'string', 'min:4', 'max:255']
        ]);
        $searchTerm = $formData['search_term'];

        $blogPosts = BlogPost::query()->where('blog_posts.subject', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('blog_posts.subject', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('blog_posts.description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('blog_posts.body', 'LIKE', '%' . $searchTerm . '%')
                ->paginate(4);

        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->limit(4)
                ->get();

        $tags = Tag::query()
                ->withCount('blogPosts')->orderBy('blog_posts_count', 'desc')
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


        return view('front.blog_posts.blog_posts_search', [
            'blogPosts' => $blogPosts,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            'latestBlogPosts' => $latestBlogPosts,
            'tags' => $tags,
            'searchTerm' => $searchTerm,
        ]);
    }

}
