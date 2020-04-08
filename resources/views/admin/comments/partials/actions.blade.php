
<div class="btn-group">
    <a href=# class="btn btn-info" target="_blank">
        <i class="fas fa-info-circle"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="@if ($comment->status==1)#disable-modal @else #enable-modal @endif"
        data-action="change-featured"
        data-id="{{$comment->id}}"
        data-name="{{$comment->subject}}"
        >
        <i class="@if($comment->status==1)fas fa-minus-circle @else fas fa-check @endif"></i>

    </button>
    
</div>