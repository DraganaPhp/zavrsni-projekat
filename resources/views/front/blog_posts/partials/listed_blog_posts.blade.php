<div class="row">
    <!-- post --> 
    @foreach ($blogPosts as $blogPost)
    <div class="post col-xl-6">
        <div class="post-thumbnail">
            <a href="{{route('front.blog_posts.single',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->subject)])}}">
                <img src="{{$blogPost->getPhotoUrl()}}" alt="..." class="img-fluid">
            </a>
        </div>
        <div class="post-details">
            <div class="post-meta d-flex justify-content-between">
                <div class="date meta-last">{{$blogPost->created_at->format('d F | Y')}}</div>
                <div class="category"><a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->blogPostCategory->name)])}}">{{$blogPost->getBlogPostCategoryName()}}</a></div>
            </div>
            <a href="{{route('front.blog_posts.single',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->subject)])}}">
                <h3 class="h4">{{$blogPost->subject}}</h3>
            </a>
            <p class="text-muted">{{$blogPost->description}}</p>
            <footer class="post-footer d-flex align-items-center">
                <a href="{{route('front.blog_posts.blog_posts_author',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->user->name)])}}" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="title"><span>{{$blogPost->user->name}}</span></div>
                </a>
                <div class="date"><i class="icon-clock"></i> {{$blogPost->createdAt()}}</div>
                <div class="comments meta-last">
                    <i class="icon-comment"></i>{{$blogPost->comments->count()}}
                </div>
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