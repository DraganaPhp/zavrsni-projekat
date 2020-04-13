<div class="btn-group">
    <a href="{{route('front.blog_posts.blog_posts_tag',['tag'=>$tag->id])}}" class="btn btn-info" target="_blank" title="View Blog posts for this tag">
        <i class="fas fa-info-circle"></i>
    </a>
    <a href="{{route('admin.tags.edit',['tag'=>$tag->id])}}" class="btn btn-info" title="Edit Tag">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$tag->id}}"
        data-name="{{$tag->name}}"
        title="Delete Tag"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>