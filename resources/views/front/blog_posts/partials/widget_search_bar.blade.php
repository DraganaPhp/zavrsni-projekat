<!-- Widget [Search Bar Widget]-->
<div class="widget search">
    <header>
        <h3 class="h6">@lang('Search the blog')</h3>
    </header>
    <form action="blog-search.html" class="search-form">
        <div class="form-group">
            <input type="search" placeholder="What are you looking for?">
            <button type="submit" class="submit"><i class="icon-search"></i></button>
        </div>
    </form>
</div>
<!-- Widget [Latest Posts Widget]        -->
<div class="widget latest-posts">
    <header>
        <h3 class="h6">@lang('Latest Posts')</h3>
    </header>
    <div class="blog-posts">
        @foreach($mostViewedBlogPosts as $mostViewedBlogPost)
        <a href="{{route('front.blog_posts.single',['blogPost'=>$mostViewedBlogPost->id])}}">
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
    <div class="item d-flex justify-content-between"><a href="blog-category.html">{{$blogPostCategory->name}}</a><span>{{$blogPostCategory->blog_posts()->count()}}</span></div>
    @endforeach
</div>
<!-- Widget [Tags Cloud Widget]-->
<div class="widget tags">       
    <header>
        <h3 class="h6">@lang('Tags')</h3>
    </header>
    <ul class="list-inline">
        @foreach($tags as $tag)
        <li class="list-inline-item"><a href="blog-tag.html" class="tag">#{{$tag->name}}</a></li>
        @endforeach
    </ul>
</div>