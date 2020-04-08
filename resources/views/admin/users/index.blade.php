@extends('admin._layout.layout')

@section('seo_title', __('Users'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('Users')</li>
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
                        <h3 class="card-title">Search Users</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.users.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new User')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-1 form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">enabled</option>
                                        <option value="0">disabled</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Search by email" name="email">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" placeholder="Search by name" name="name">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" placeholder="Search by phone" name="phone">
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
                        <h3 class="card-title">@lang('All Users')</h3>
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
                                    <th class="text-center">@lang('Photo')</th>
                                    <th >@lang('Email')</th>
                                    <th >@lang('Name')</th>
                                    <th class="text-center">@lang('Phone')</th>
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


<!-- /.modal -->
<form class="modal fade" id="disable-modal" action="{{route('admin.users.disable_status')}}" method="post">
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
                <p>Are you sure you want to disable user?</p>
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
<form class="modal fade" id="enable-modal" action="{{route('admin.users.enable_status')}}" method="post">
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
                <p>Are you sure you want to enable user?</p>
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


    $('#entities-filter-form [name]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form [email]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form [phone]').on('change keyup', function (e) {
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
            "url": "{{route('admin.users.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["name"] = $('#entities-filter-form [name="name"]').val();
                dtData["email"] = $('#entities-filter-form [name="email"]').val();
                dtData["phone"] = $('#entities-filter-form [name="phone"]').val();
                dtData["status"] = $('#entities-filter-form [name="status"]').val();

            }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],
        "order": [[1, 'desc']],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "email", "data": "email"},
            {"name": "name", "data": "name"},
            {"name": "phone", "data": "phone"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });

    $('#entities-list-table').on('click', '[data-action="enable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        //let id = $(this).data('id');
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

            entitiesDataTable.ajax.reload(null, false);//drugi parametar false zaci da se NE RESETUJE paginacija

        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while enabling user')";

            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }

            toastr.error(systemError);

        });
    });


    $('#entities-list-table').on('click', '[data-action="disable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });

    $('#disable-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {

            toastr.success(response.system_message);

            // da refreshujemo datatables!!!

            entitiesDataTable.ajax.reload(null, false);

        }).fail(function (xhr) {
            let systemError = "@lang('Error occured while disabling user')";

            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }

            toastr.error(systemError);
        });
    });


</script>
@endpush