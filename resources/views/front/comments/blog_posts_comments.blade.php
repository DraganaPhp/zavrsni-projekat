
<div class="post-comments" id="post-comments>
     <div>
     <header>
     <h3 class="h6">Post Comments<span class="no-of-comments">({{$comments->count()}})</span></h3>
</header>
@foreach ($comments as $comment)
<div class="comment">
    <div class="comment-header d-flex justify-content-between">
        <div class="user d-flex align-items-center">
            <div class="image"><img src="/themes/front/img/user.svg" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title"><strong>{{$comment->sender_nickname}}</strong><span class="date">{{$comment->created_at}}</span></div>
        </div>
    </div>
    <div class="comment-body">
        <p>{{$comment->body}}</p>
    </div>
</div>
@endforeach
</div>
<div class="add-comment">
    <header>
        <h3 class="h6">Leave a reply</h3>
    </header>
    <form 
        action="{{route('front.comments.send_comment',['blogPost'=>$blogPost])}}"
        method="post" 
        role="form" 
        id="main_contact_form"
        class="commenting-form"
        >
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <input 
                    type="text" 
                    name="sender_nickname" 
                    value="{{old('sender_nickname')}}"
                    id="username" 
                    placeholder="Name" 
                    data-name="sender_nickname" 
                    class="form-control @if($errors->has('contact_person')) is-invalid @endif"
                    >
                @include('front._layout.partials.form_errors', ['fieldName'=>'sender_nickname'])
            </div>  
            <div class="form-group col-md-6">
                <input 
                    type="email" 
                    value="{{old('sender_email')}}"
                    name="sender_email" 
                    id="useremail" 
                    placeholder="Email Address (will not be published)" 
                    class="form-control @if($errors->has('contact_email')) is-invalid @endif"
                    data-email="sender_email" 
                    >
                @include('front._layout.partials.form_errors', ['fieldName'=>'contact_email'])
            </div>
            <div class="form-group col-md-12">
                <textarea 
                    name="body" 
                    id="usercomment" 
                    data-body="body" 
                    placeholder="Type your comment" 
                    class="form-control  @if($errors->has('contact_message')) is-invalid @endif">{{old('contact_message')}}</textarea>
                @include('front._layout.partials.form_errors', ['fieldName'=>'contact_message'])
            </div>
            <div class="form-group col-md-12">
                <button 
                    type="submit" 
                    class="btn btn-secondary"
                    data-action="send-comment"
                    data-blogPost =" "
                    >Submit Comment</button>
            </div>
        </div>
    </form>
</div>


