
<div class="btn-group">
    <a href=# class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.blog_posts.edit',['blogPost'=>$blogPost->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="@if ($blogPost->status==1)#disable-modal @else #enable-modal @endif"
        data-action="change-featured"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="@if($blogPost->status==1)fas fa-minus-circle @else fas fa-check @endif"></i>

    </button>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>

</div>