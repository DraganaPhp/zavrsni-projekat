@extends('front._layout.layout')
@section('seo_title', $blogPost->name)
@section('content')

<div class="container">
    <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
            <div class="container">
                <div class="post-single">
                    <div class="post-thumbnail"><img src="{{$blogPost->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                    <div class="post-details">
                        <div class="post-meta d-flex justify-content-between">
                            <div class="category"><a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>$blogPost->id])}}">{{$blogPost->getBlogPostCategoryName()}}</a></div>
                        </div>
                        <h1>{{$blogPost->subject}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="{{route('front.blog_posts.blog_posts_author',['blogPost'=>$blogPost->id])}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blogPost->user->name}}</span></div></a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i> 2 months ago</div>
                                <div class="views"><i class="icon-eye"></i> {{$blogPost->views}}</div>
                                <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$blogPost->comments->count()}}</a></div>
                            </div>
                        </div>
                        <div class="post-body">
                            {{$blogPost->body}}
                        </div>
                        <div class="post-tags">
                            @foreach($blogPost->tags as $blogPostTag)
                            <a href="{{route('front.blog_posts.blog_posts_tag',['tag'=>$blogPostTag->id])}}" class="tag"># {{$blogPostTag->name}}</a>
                            @endforeach
                        </div>

                        <div class="posts-nav d-flex justify-content-between align-items-stretch flex-column flex-md-row">
                            @if($previousBlogPost)

                            <a href="{{route('front.blog_posts.single',['blogPost'=>$previousBlogPost->id])}}" class="prev-post text-left d-flex align-items-center">

                                <div class="icon prev"><i class="fa fa-angle-left"></i></div>
                                <div class="text"><strong class="text-primary">Previous Post </strong>
                                    <h6>{{$previousBlogPost->subject}}</h6>
                                </div></a>
                            @endif

                            @if($nextBlogPost) 
                            <a href="{{route('front.blog_posts.single',['blogPost'=>$nextBlogPost->id])}}" class="next-post text-right d-flex align-items-center justify-content-end">
                                <div class="text"><strong class="text-primary">Next Post </strong>
                                    <h6>{{$nextBlogPost->subject}}</h6>
                                </div>
                                <div class="icon next"><i class="fa fa-angle-right">   </i></div></a>
                            @endif
                        </div>

                        <div class="post-comments" id="post-comments">
                            <header>
                                <h3 class="h6">Post Comments<span class="no-of-comments">(3)</span></h3>
                            </header>
                            <div class="comment">
                                <div class="comment-header d-flex justify-content-between">
                                    <div class="user d-flex align-items-center">
                                        <div class="image"><img src="img/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="title"><strong>Jabi Hernandiz</strong><span class="date">May 2016</span></div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-header d-flex justify-content-between">
                                    <div class="user d-flex align-items-center">
                                        <div class="image"><img src="img/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="title"><strong>Nikolas</strong><span class="date">May 2016</span></div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </div>
                            </div>
                            <div class="comment">
                                <div class="comment-header d-flex justify-content-between">
                                    <div class="user d-flex align-items-center">
                                        <div class="image"><img src="img/user.svg" alt="..." class="img-fluid rounded-circle"></div>
                                        <div class="title"><strong>John Doe</strong><span class="date">May 2016</span></div>
                                    </div>
                                </div>
                                <div class="comment-body">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                                </div>
                            </div>
                        </div>
                        <div class="add-comment">
                            <header>
                                <h3 class="h6">Leave a reply</h3>
                            </header>
                            <form action="#" class="commenting-form">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" name="username" id="username" placeholder="Name" class="form-control">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="email" name="username" id="useremail" placeholder="Email Address (will not be published)" class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <textarea name="usercomment" id="usercomment" placeholder="Type your comment" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-secondary">Submit Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <aside class="col-lg-4">
            @include('front.blog_posts.partials.widget_search_bar',[
            'blogPost' => $blogPost,
            'tags' => $tags,
            'mostViewedBlogPosts' => $mostViewedBlogPosts,
            'blogPostCategories' => $blogPostCategories,

            ]
            )
        </aside>
    </div>
</div>

@endsection