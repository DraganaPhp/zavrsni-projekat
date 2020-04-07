<div class="btn-group">
    <a href="{{route('admin.slides.edit', ['slide' => $slide->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    @if($slide->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$slide->id}}"
        data-name="{{$slide->subject}}"
        >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($slide->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$slide->id}}"
        data-name="{{$slide->subject}}"
        >
        <i class="fas fa-check"></i>
    </button>
    @endif
</div>
