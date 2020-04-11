@extends('front._layout.layout')

@section('seo_title', 'Blog Posts by Author')

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3 author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid rounded-circle"></div>
                    <div class="title">
                        <span>Posts by author "{{$blogPost->user->name}}"</span>
                    </div>
                </h2>
                @include('front.blog_posts.partials.listed_blog_posts')
            </div>
        </main>
        <aside class="col-lg-4">
            @include('front.blog_posts.partials.widget_search_bar',[
            'blogPost' => $blogPost,
            'tags' => $tags,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,

            ]
            )
        </aside>
    </div>
</div>
@endsection