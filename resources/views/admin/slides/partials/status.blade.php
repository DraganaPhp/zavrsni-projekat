@if($slide->isEnabled())
<span class="text-success">@lang('enabled')</span>
@endif
@if($slide->isDisabled())
<span class="text-danger">@lang('disabled')</span>
@endif