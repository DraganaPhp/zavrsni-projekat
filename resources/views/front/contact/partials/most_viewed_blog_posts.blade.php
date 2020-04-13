<a href="{{route('front.blog_posts.single',['blogPost'=>$mostViewedBlogPost,'seoSlug'=>\Str::slug($mostViewedBlogPost->subject)])}}">
    <div class="item d-flex align-items-center">
        <div class="image"><img src="{{$mostViewedBlogPost->getPhotoThumbUrl()}}" alt="..." class="img-fluid"></div>
        <div class="title"><strong>{{$mostViewedBlogPost->subject}}</strong>
            <div class="d-flex align-items-center">
                <div class="views"><i class="icon-eye"></i> {{$mostViewedBlogPost->views}}</div>
                <div class="comments"><i class="icon-comment"></i>{{$mostViewedBlogPost->comments->count()}}</div>
            </div>
        </div>
    </div></a>