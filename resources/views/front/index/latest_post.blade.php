<div class="post col-md-4">
    <div class="post-thumbnail"><a href="blog-post.html"><img src="{{$latestBlogPost->getPhotoUrl()}}" alt="..." class="img-fluid"></a></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="date">20 May | 2016</div>
                            <div class="category"><a href="blog-category.html">{{$latestBlogPost->blogPostCategory->name}}</a></div>
                        </div><a href="blog-post.html">
                            <h3 class="h4">{{$latestBlogPost->subject}}</h3></a>
                        <p class="text-muted">{{$latestBlogPost->description}}</p>
                    </div>
                </div>