@if(\Auth::user()->id != $user->id)
<div class="btn-group">
    <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info" title="Edit user" >
        <i class="fas fa-edit"></i>
    </a>
    @if($user->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
        title="Disable user"
        >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($user->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
        title="Enable user"
        >
        <i class="fas fa-check"></i>
    </button>
    @endif

    @else
    It is your account!!!
    @endif
</div>