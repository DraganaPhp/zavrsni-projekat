
<div class="btn-group">
    <a href="{{route('front.blog_posts.single',['blogPost'=>$blogPost->id])}}" class="btn btn-info" target="_blank" title="View Blog Post details">
        <i class="fas fa-info-circle"></i>
    </a>
    <a href="{{route('admin.blog_posts.edit',['blogPost'=>$blogPost->id])}}" class="btn btn-info" title="Edit Blog Post">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="@if ($blogPost->status==1)#disable-modal @else #enable-modal @endif"
        data-action="change-featured"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->subject}}"
        title="Change status of Blog Post"
        >
        <i class="@if($blogPost->status==1)fas fa-minus-circle @else fas fa-check @endif"></i>

    </button>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="@if ($blogPost->on_index_page==1)#unimportant-modal @else #important-modal @endif"
        data-action="change-importance"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->subject}}"
        title="Change importance of Blog Post"
        >
        <i class="@if($blogPost->on_index_page==1)fas fa-eye-slash @else fas fa-eye @endif"></i>

    </button>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->subject}}"
        title="Delete Blog Post"
        >
        <i class="fas fa-trash"></i>
    </button>

</div>