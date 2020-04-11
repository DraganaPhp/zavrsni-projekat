@extends('front._layout.layout')

@section('seo_title', 'Blog Posts by Tag')

@section('content')
<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <h2 class="mb-3">Tag "{{$tag->name}}"</h2>
                @include('front.blog_posts.partials.listed_blog_posts')
            </div>
        </main>
        <aside class="col-lg-4">
            @include('front.blog_posts.partials.widget_search_bar',[
            'tags' => $tags,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,
            ])
        </aside>
    </div>
</div>
@endsection