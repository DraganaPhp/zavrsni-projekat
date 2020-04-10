<a href="{{route('front.blog_posts.single',['blogPost'=>$latestBlogPost->id])}}">
    <div class="item d-flex align-items-center">
        <div class="image"><img src="{{$latestBlogPost->getPhotoThumbUrl()}}" alt="..." class="img-fluid"></div>
        <div class="title"><strong>{{$latestBlogPost->subject}}</strong>
            <div class="d-flex align-items-center">
                <div class="views"><i class="icon-eye"></i> {{$latestBlogPost->views}}</div>
                <div class="comments"><i class="icon-comment"></i>{{$latestBlogPost->comments->count()}}</div>
            </div>
        </div>
    </div></a>,