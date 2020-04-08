@extends('admin._layout.layout')

@section('seo_title', __('Comments'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Comments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Comments')</li>
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
                        <h3 class="card-title">Search Comments</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">Enable</option>
                                        <option value="0">Disable</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Blog Post</label>
                                    <select class="form-control" name="blog_post_id">
                                        <option value="">--Choose Category --</option>
                                        @foreach(\App\Models\BlogPost::orderBy('subject')->get() as $blogPost)
                                        <option value="{{$blogPost->id}}">{{$blogPost->subject}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Sender Nickname</label>
                                    <input type="text" class="form-control" placeholder="Search by nicname" name="sender_nickname">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Sender email</label>
                                    <input type="text" class="form-control" placeholder="Search by sender email" name="sender_email">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>



                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Comments')</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 10px">@lang('Status')</th>
                                    <th class="text-center">@lang('Blog post')</th>
                                    <th class="text-center">@lang('Body text')</th>
                                    <th class="text-center">@lang('Sender_nickname')</th>
                                    <th class="text-center">@lang('Sender_email')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">

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


<form class="modal fade" id="disable-modal" action="{{route('admin.comments.disable')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disable Comment</h4>
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
                <p>Are you sure you want to disable Comment?</p>
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
<form class="modal fade" id="enable-modal" action="{{route('admin.comments.enable')}}" method="post">
    @csrf
    <input type="text" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Enable Comment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enable this Comment?</p>
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

<!-- /.modal -->

<!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
<script type="text/javascript">


    $('#entities-filter-form [blog_post_id]').select2({
        "theme": "bootstrap4"
    });

    $('#entities-filter-form [sender_nickname]').select2({
        "theme": "bootstrap4"
    });

    $('#entities-filter-form [sender_email]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form [status]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });

    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault();
        entitiesDataTable.ajax.reload(null, true);
    });


    let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{route('admin.comments.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["blog_post_id"] = $('#entities-filter-form [name="blog_post_id"]').val();
                dtData["sender_nickname"] = $('#entities-filter-form [name="sender_nickname"]').val();
                dtData["status"] = $('#entities-filter-form [name="status"]').val();
                dtData["sender_email"] = $('#entities-filter-form [name="sender_email"]').val();
            }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],
        "order": [[6, 'desc']],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "blog_post_id", "data": "blog_post_id", "className": "text-center"},
            {"name": "body", "data": "body", "className": "text-center"},
            {"name": "sender_nickname", "data": "sender_nickname"},
            {"name": "sender_email", "data": "sender_email"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });


    $('#entities-list-table').on('click', '[data-action="change-featured"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="change-featured"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#enable-modal [name="id"]').val(id);
        $('#enable-modal [data-container="name"]').html(name);
    });





    $('#enable-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'), //citanje actio atributa sa forme
            "type": "post",
            "data": $(this).serialize() //citanje svih polja na formi  tj sve sto ima "name" atribut
        }).done(function (response) {

            toastr.success(response.system_message);

            // da refreshujemo datatables!!!

            entitiesDataTable.ajax.reload(null, false);

        }).fail(function () {
            toastr.error("@lang('Error occured while enabling comment')");
        });
    });
    $('#disable-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'), //citanje actio atributa sa forme
            "type": "post",
            "data": $(this).serialize() //citanje svih polja na formi  tj sve sto ima "name" atribut
        }).done(function (response) {

            toastr.success(response.system_message);

            // da refreshujemo datatables!!!

            entitiesDataTable.ajax.reload(null, false);

        }).fail(function () {
            toastr.error("@lang('Error occured while disabling Comment')");
        });
    });

</script>
@endpush