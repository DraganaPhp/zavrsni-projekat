
<div class="btn-group">
    <a href="{{route('front.blog_posts.single',['blogPost'=>$comment->blog_post_id])}}" class="btn btn-info" target="_blank" title="View Blog posts for this comment">
        <i class="fas fa-info-circle"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="@if ($comment->status==1)#disable-modal @else #enable-modal @endif"
        data-action="change-status"
        data-id="{{$comment->id}}"
        data-name="{{$comment->subject}}"
        title="Disable/Enable comment"
        >
        <i class="@if($comment->status==1)fas fa-minus-circle @else fas fa-check @endif"></i>

    </button>

</div>