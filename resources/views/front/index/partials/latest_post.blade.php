<div class="post col-md-4">
    <div class="post-thumbnail">
        <a href="{{route('front.blog_posts.single',['blogPost'=>$latestBlogPost])}}">
            <img src="{{$latestBlogPost->getPhotoUrl()}}" alt="..." class="img-fluid">
        </a>
    </div>
    <div class="post-details">
        <div class="post-meta d-flex justify-content-between">
            <div class="date">{{$latestBlogPost->created_at->format('d F | Y')}}</div>
            <div class="category"><a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>$latestBlogPost])}}">{{$latestBlogPost->blogPostCategory->name}}</a></div>
        </div>
        <a href="{{route('front.blog_posts.single',['blogPost'=>$latestBlogPost->id])}}">
            <h3 class="h4">{{$latestBlogPost->subject}}</h3>
        </a>
        <p class="text-muted">{{$latestBlogPost->description}}</p>
    </div>
</div>