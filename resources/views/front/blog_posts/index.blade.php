@extends('front._layout.layout')

@section('seo_title', 'Blog Posts')

@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="posts-listing col-lg-8"> 
            <div class="container">
                <div class="row">
                    <!-- post -->
                    @foreach($blogPosts as $blogPost)
                    <div class="post col-xl-6">
                        <div class="post-thumbnail">
                            <a href="{{route('front.blog_posts.single',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->subject)])}}">
                                <img src="{{$blogPost->getPhotoUrl()}}" alt="..." class="img-fluid">
                            </a>
                        </div>
                        <div class="post-details">
                            <div class="post-meta d-flex justify-content-between">
                                <div class="date meta-last">{{$blogPost->created_at->format('d F | Y')}}</div>
                                <div class="category">
                                    @if($blogPost->blogPostCategory)
                                    <a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>$blogPost->id,'seoSlug'=>\Str::slug($blogPost->getBlogPostCategoryName())])}}">
                                        {{$blogPost->getBlogPostCategoryName()}}
                                        @else
                                        
                                        {{$blogPost->getBlogPostCategoryName()}}
                                        
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <a href="{{route('front.blog_posts.single',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->subject)])}}">
                                <h3 class="h4">{{$blogPost->subject}}</h3>
                            </a>
                            <p class="text-muted">{{$blogPost->description}}</p>
                            <footer class="post-footer d-flex align-items-center">
                                <a href="{{route('front.blog_posts.blog_posts_author',['blogPost'=>$blogPost->id,'seoSlug'=>\Str::slug($blogPost->user->name)])}}" class="author d-flex align-items-center flex-wrap">
                                    <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                    <div class="title"><span>{{$blogPost->user->name}}</span></div>
                                </a>
                                <div class="date"><i class="icon-clock"></i>{{$blogPost->CreatedAt()}}</div>
                                <div class="comments meta-last"><i class="icon-comment"></i>{{$blogPost->comments->count()}}</div>
                            </footer>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-template d-flex justify-content-center">
                        {{$blogPosts->links()}}
                    </ul>
                </nav>
            </div>
        </main>
        <aside class="col-lg-4">
            @include('front.blog_posts.partials.widget_search_bar',[

            'tags' => $tags,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,

            ]
            )
        </aside>
    </div>
</div>

@endsection