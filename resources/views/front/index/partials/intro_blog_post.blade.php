       @if (($order==0) ||($order==2))
<div class="row d-flex align-items-stretch">
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category"><a href="blog-category.html">{{$blogPost->blogPostCategory->name}}</a></div><a href="blog-post.html">
                                <h2 class="h4">{{$blogPost->subject}}</h2></a>
                        </header>
                        <p>{{$blogPost->description}}</p>
                        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blogPost->user->name}}</span></div></a>
                            <div class="date"><i class="icon-clock"></i> {{$blogPost->created_at}}</div>
                            <div class="comments"><i class="icon-comment"></i>{{$blogPost->comments->count()}}</div>
                        </footer>
                    </div>
                </div>
            </div>
            <div class="image col-lg-5"><img src="{{$blogPost->getPhotoUrl()}}" alt="..."></div>
        </div>
       @else
        <!-- Post        -->
        <div class="row d-flex align-items-stretch">
            <div class="image col-lg-5"><img src="{{$blogPost->getPhotoUrl()}}" alt="..."></div>
            <div class="text col-lg-7">
                <div class="text-inner d-flex align-items-center">
                    <div class="content">
                        <header class="post-header">
                            <div class="category"><a href="blog-category.html">{{$blogPost->blogPostCategory->name}}</a></div><a href="blog-post.html">
                                <h2 class="h4">{{$blogPost->subject}}</h2></a>
                        </header>
                        <p>{{$blogPost->description}}</p>
                        <footer class="post-footer d-flex align-items-center"><a href="blog-author.html" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blogPost->user->name}}</span></div></a>
                            <div class="date"><i class="icon-clock"></i>{{$blogPost->created_at}}</div>
                            <div class="comments"><i class="icon-comment"></i>{{$blogPost->comments->count()}}</div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        @endif
       