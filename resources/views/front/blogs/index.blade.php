@extends('front._layout.layout')

@section('seo_title', 'Index Page')

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
                <div class="post-thumbnail"><a href="blog-post.html"><img src="{{$blogPost->getPhotoUrl()}}" alt="..." class="img-fluid"></a></div>
                <div class="post-details">
                  <div class="post-meta d-flex justify-content-between">
                    <div class="date meta-last">20 May | 2016</div>
                    <div class="category"><a href="blog-category.html">{{$blogPost->getBlogPostCategoryName()}}</a></div>
                  </div><a href="blog-post.html">
                    <h3 class="h4">{{$blogPost->subject}}</h3></a>
                  <p class="text-muted">{{$blogPost->description}}</p>
                  <footer class="post-footer d-flex align-items-center"><a href="" class="author d-flex align-items-center flex-wrap">
                      <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                      <div class="title"><span>{{$blogPost->user->name}}</span></div></a>
                    <div class="date"><i class="icon-clock"></i> 2 months ago</div>
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
          <!-- Widget [Search Bar Widget]-->
          <div class="widget search">
            <header>
              <h3 class="h6">Search the blog</h3>
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
              <h3 class="h6">Latest Posts</h3>
            </header>
            <div class="blog-posts">
                @foreach($latestBlogPosts as $latestBlogPost)
                <a href="blog-post.html">
                <div class="item d-flex align-items-center">
                    <div class="image"><img src="{{$latestBlogPost->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                  <div class="title"><strong>$latestBlogPost->subject</strong>
                    <div class="d-flex align-items-center">
                      <div class="views"><i class="icon-eye"></i>{{$latestBlogPost->views}}</div>
                      <div class="comments"><i class="icon-comment"></i>{{$latestBlogPost->comments->count()}}</div>
                    </div>
                  </div>
                </div></a>
            @endforeach
            </div>
          </div>
          <!-- Widget [Categories Widget]-->
          <div class="widget categories">
            <header>
              <h3 class="h6">Categories</h3>
            </header>
               @foreach($blogPostCategories as $blogPostCategory)
            <div class="item d-flex justify-content-between"><a href="blog-category.html">{{$blogPostCategory->name}}</a><span>{{$blogPostCategory->blog_posts()->count()}}</span></div>
            @endforeach
          </div>
          <!-- Widget [Tags Cloud Widget]-->
          <div class="widget tags">       
            <header>
              <h3 class="h6">Tags</h3>
            </header>
            <ul class="list-inline">
                @foreach($tags as $tag)
              <li class="list-inline-item"><a href="blog-tag.html" class="tag">#{{$tag->name}}</a></li>
              @endforeach
            </ul>
          </div>
        </aside>
      </div>
    </div>

@endsection