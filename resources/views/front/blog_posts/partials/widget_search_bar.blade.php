<!-- Widget [Search Bar Widget]-->
<div class="widget search">
    <header>
        <h3 class="h6">@lang('Search the blog')</h3>
    </header>
    @include('front.blog_posts.partials.search_form')
</div>
<!-- Widget [Latest Posts Widget]        -->
<div class="widget latest-posts">
    <header>
        <h3 class="h6">@lang('Latest Posts')</h3>
    </header>
    <div class="blog-posts">
        @foreach($mostViewedBlogPosts as $mostViewedBlogPost)
        <a href="{{route('front.blog_posts.single',['blogPost'=>$mostViewedBlogPost,'seoSlug'=>\Str::slug($mostViewedBlogPost->subject)])}}">
            <div class="item d-flex align-items-center">
                <div class="image"><img src="{{$mostViewedBlogPost->getPhotoThumbUrl()}}" alt="..." class="img-fluid"></div>
                <div class="title"><strong>{{$mostViewedBlogPost->subject}}</strong>
                    <div class="d-flex align-items-center">
                        <div class="views"><i class="icon-eye"></i>{{$mostViewedBlogPost->views}}</div>
                        <div class="comments"><i class="icon-comment"></i>{{$mostViewedBlogPost->comments->count()}}</div>
                    </div>
                </div>
            </div></a>
        @endforeach
    </div>
</div>
<!-- Widget [Categories Widget]-->
<div class="widget categories">
    <header>
        <h3 class="h6">@lang('Categories')</h3>
    </header>
    @foreach($blogPostCategories as $blogPostCategory)
    <div class="item d-flex justify-content-between">
        <a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>App\Models\BlogPost::query()->where('blog_post_category_id',$blogPostCategory->id)->first(),'seoSlug'=>\Str::slug($blogPostCategory->name)])}}">{{$blogPostCategory->name}}</a><span>{{$blogPostCategory->blog_posts()->count()}}</span></div>
    @endforeach
</div>
<!-- Widget [Tags Cloud Widget]-->
<div class="widget tags">       
    <header>
        <h3 class="h6">@lang('Tags')</h3>
    </header>
    <ul class="list-inline">
        @foreach($tags as $tag)
        <li class="list-inline-item"><a href="{{route('front.blog_posts.blog_posts_tag',['tag'=>$tag,'seoSlug'=>\Str::slug($tag->name)])}}" class="tag">#{{$tag->name}}</a></li>
        @endforeach
    </ul>
</div>