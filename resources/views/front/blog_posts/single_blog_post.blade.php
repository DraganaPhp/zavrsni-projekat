@extends('front._layout.layout')
@section('seo_title', $blogPost->subject)
@section('seo_description', $blogPost->description)
@section('seo_image', $blogPost->getPhotoUrl())
@section('seo_type', 'Blog post')
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
                            <div class="category"><a href="{{route('front.blog_posts.blog_posts_category',['blogPost'=>$blogPost,'seoSlug'=>\Str::slug($blogPost->blogPostCategory->name)])}}">{{$blogPost->getBlogPostCategoryName()}}</a></div>
                        </div>
                        <h1>{{$blogPost->subject}}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                        <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="{{route('front.blog_posts.blog_posts_author',['blogPost'=>$blogPost->id,'seoSlug'=>\Str::slug($blogPost->user->name)])}}" class="author d-flex align-items-center flex-wrap">
                                <div class="avatar"><img src="{{$blogPost->user->getPhotoUrl()}}" alt="..." class="img-fluid"></div>
                                <div class="title"><span>{{$blogPost->user->name}}</span></div></a>
                            <div class="d-flex align-items-center flex-wrap">       
                                <div class="date"><i class="icon-clock"></i>{{$blogPost->CreatedAt()}}</div>
                                <div class="views"><i class="icon-eye"></i> {{$blogPost->views}}</div>
                                <div class="comments meta-last"><a href="#post-comments"><i class="icon-comment"></i>{{$blogPost->comments->count()}}</a></div>
                            </div>
                        </div>
                        <div class="post-body">
                            {!!$blogPost->body!!}
                        </div>
                        <div class="post-tags">
                            @foreach($blogPost->tags as $blogPostTag)
                            <a href="{{route('front.blog_posts.blog_posts_tag',['tag'=>$blogPostTag->id,'seoSlug'=>\Str::slug($blogPostTag->name)])}}" class="tag"># {{$blogPostTag->name}}</a>
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
                        <div id='comments'>

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
            ])
        </aside>
    </div>
</div>

@endsection
@push('footer_javascript')
<script type="text/javascript">
    $.ajax({
        "url": "{{route('front.comments.blog_post_comments',['blogPost'=>$blogPost])}}",
        "type": "get",
        "data": {}
    }).done(function (response) {

        $('#comments').html(response);
        console.log('Zavrseno ucitavanje sadrzaja korpe');
    }).fail(function (jqXHR, textStatus, error) {

        console.log('Greska prilikom ucitavanja sadrzaja korpe');
    });




    /*$('#main_contact_form').on('click', '[data-action="send-comment"]', function (e) {
     e.preventDefault();
     
     let sender_nickname = $(this).attr('data-name'); 
     let sender_email = $(this).attr('data-email'); 
     let body = $(this).attr('data-body');
     
     
     $.ajax({
     "url": "{{route('front.comments.send_comment',['blogPost'=>$blogPost])}}",
     "type": "post",
     "data": {
     "_token": "{{csrf_token()}}",
     "sender_nickname": sender_nickname,
     "sender_email": sender_email,
     "body": body
     }
     }).done(function (response) {
     
     toastr.success(response.system_message);
     
     }).fail(function () {
     toastr.error('An error ocured');
     });
     });*/
</script>
@endpush