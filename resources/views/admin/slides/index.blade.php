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
                        <h3 class="card-title">Search Slides</h3>
                        <div class="card-tools">
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

                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label>On index page</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">important</option>
                                        <option value="0">Unimportant</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Link URL</label>
                                    <input type="text" class="form-control" placeholder="Search by link url" name="link_url">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" placeholder="Search by link name" name="link_name">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" placeholder="Search by subject" name="subject">
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
                        <h3 class="card-title">@lang('All Slides')</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 10px">@lang('On index page')</th>
                                    <th style="width: 10px">@lang('Subject')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th class="text-center">@lang('Link title')</th>
                                    <th class="text-center">@lang('Link URL')</th>
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
<form class="modal fade" id="disable-modal" action="{{route('admin.slides.disable_status')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Make Slide disable </h4>
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
                <h4 class="modal-title">Make Slide Enable</h4>
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

<!-- /.modal -->

<!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
<script type="text/javascript">


    $('#entities-filter-form [subject]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form [link_title]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });
    $('#entities-filter-form [link_url]').on('change keyup', function (e) {
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
            "url": "{{route('admin.slides.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["name"] = $('#entities-filter-form [name="subject"]').val();
                dtData["email"] = $('#entities-filter-form [name="link_name"]').val();
                dtData["phone"] = $('#entities-filter-form [name="link_url"]').val();
                dtData["status"] = $('#entities-filter-form [name="on_index_page"]').val();
            }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],
        "order": [[1, 'desc']],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "on_index_page", "data": "on_index_page", "className": "text-center"},
            {"name": "subject", "data": "subject"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "link_title", "data": "link_title"},
            {"name": "link_url", "data": "link_url"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });


    $('#entities-list-table').on('click', '[data-action="change-status"]', function (e) {
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
            let systemError = "@lang('Error occured while enabling slide')";

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
            let systemError = "@lang('Error occured while disabling slide')";

            if (xhr.responseJSON && xhr.responseJSON['system_error']) {
                systemError = xhr.responseJSON['system_error'];
            }

            toastr.error(systemError);
        });
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