@extends('admin._layout.layout')

@section('seo_title', __('Slides'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Slides')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Slides')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Slides')</h3>
                        <div class="card-tools">
                            <form style="display:none;"id="change-priority-form" class="btn-group" action="{{route('admin.slides.change_priorities')}}" method="post">
                                @csrf
                                <input type="hidden" name="priorities" value="">
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                    @lang('Save Order')
                                </button>
                                <button type="button" data-action="hide-order" class="btn btn-outline-danger">
                                    <i class="fas fa-remove"></i>
                                    @lang('Cancel')
                                </button>
                            </form>
                            <button data-action="show-order" class="btn btn-outline-secondary">
                                <i class="fas fa-sort"></i>
                                @lang('Change Order')
                            </button>
                            <a href="{{route('admin.slides.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new Slide')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="text-center">@lang('Important')</th>
                                    <th style="text-center">@lang('Subject')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th class="text-center">@lang('Link title')</th>
                                    <th class="text-center">@lang('Link url')</th>
                                    <th class="text-center">@lang('created_at')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($slides as $slide)
                                <tr data-id="{{$slide->id}}">
                                    <td>
                                        <span style="display:none;" class="handle" class="btn btn-outline-secondary">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$slide->id}}
                                    </td>
                                    <td class="text-center">{{$slide->on_index_page}}</td>
                                    <td>
                                        <strong>{{$slide->subject}}</strong>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{$slide->getPhotoUrl()}}" style="max-width: 80px;">
                                    </td>
                                    <td class="text-center">{{$slide->link_title}}</td>
                                    <td class="text-center">{{$slide->link_url}}</td>
                                    <td class="text-center">{{$slide->created_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href={{route('front.index.index')}} class="btn btn-info" target="_blank" title="View index page">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a 
                                                href="{{route('admin.slides.edit', ['slide' => $slide->id])}}" 
                                                class="btn btn-info"
                                                title="Edit slide"
                                                >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#delete-modal"
                                                data-action="delete"
                                                data-id="{{$slide->id}}"
                                                data-name="{{$slide->subject}}"
                                                title="Delete slide"
                                                >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @if($slide->isEnabled())
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#disable-modal"
                                                data-action="disable"
                                                data-id="{{$slide->id}}"
                                                data-name="{{$slide->subject}}"
                                                title="Disable slide"
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
                                                title="Enable slide"
                                                >
                                                <i class="fas fa-check"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<form class="modal fade" id="delete-modal" action="{{route('admin.slides.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Slide</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete slide?</p>
                <strong data-container="name"></strong>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<!-- /.modal -->
<form class="modal fade" id="disable-modal" action="{{route('admin.slides.disable_status')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Remove User From Featured</h4>
                <button 
                    type="button" 
                    class="close" 
                    data-dismiss="modal" 
                    aria-label="Close"

                    >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to disable slide?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    Disable
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <!-- /.modal -->
</form>
<form class="modal fade" id="enable-modal" action="{{route('admin.slides.enable_status')}}" method="post">
    @csrf
    <input type="text" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mark User Featured</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enable slide?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Enable
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->




@endsection

@push('head_links')
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>

<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@push('footer_javascript')
<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });



    $('#entities-list-table').on('click', '[data-action="disable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="enable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#enable-modal [name="id"]').val(id);
        $('#enable-modal [data-container="name"]').html(name);
    });
    $('#sortable-list').sortable({
        "handle": ".handle",
        "update": function (event, ui) {
            let priorities = $('#sortable-list').sortable('toArray', {
                "attribute": "data-id"
            });
            console.log(priorities);
            $('#change-priority-form [name="priorities"]').val(priorities.join(','));
        }
    });
    $('[data-action="show-order"]').on('click', function (e) {
        $('[data-action="show-order"]').hide();
        $('#change-priority-form').show();
        $('#sortable-list .handle').show();

    });
    $('[data-action="hide-order"]').on('click', function (e) {
        $('[data-action="show-order"]').show();
        $('#change-priority-form').hide();
        $('#sortable-list .handle').hide();
        $('#sortable-list').sortable('cancel');

    });
</script>
@endpush