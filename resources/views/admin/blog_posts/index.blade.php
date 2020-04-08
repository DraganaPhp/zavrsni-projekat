@extends('admin._layout.layout')

@section('seo_title', __('BlogPosts'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('BlogPosts')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">
                            @lang('Home')
                        </a>
                    </li>
                    <li class="breadcrumb-item active">@lang('BlogPosts')</li>
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
                        <h3 class="card-title">Search BlogPosts</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.blog_posts.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new BlogPost')
                            </a>
                        </div>
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
                                    <label>Subject</label>
                                    <input type="text" class="form-control" placeholder="Search by name" name="subject">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>User</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">--Choose User --</option>
                                        @foreach(\App\User::query()->orderBy('name')->get() as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="blog_post_category_id">
                                        <option value="">--Choose Category --</option>
                                        @foreach(\App\Models\BlogPostCategory::orderBy('priority')->get() as $blogPostCategory)
                                        <option value="{{$blogPostCategory->id}}">{{$blogPostCategory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>In tag</label>
                                    <select class="form-control" multiple name="tag_ids">
                                        @foreach(\App\Models\Tag::orderBy('name')->get() as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
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
                        <h3 class="card-title">@lang('All BlogPosts')</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th style="width: 10px">@lang('Status')</th>
                                    <th style="width: 10px">@lang('Important')</th>
                                    <th class="text-center">@lang('Category')</th>
                                    <th class="text-center">@lang('Subject')</th>
                                    <th >@lang('No of Comments')</th>
                                    <th >@lang('No of views')</th>
                                    <th >@lang('Author')</th>
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

<form class="modal fade" id="delete-modal" action="{{route('admin.blog_posts.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete BlogPost</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete blogPost?</p>
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
<form class="modal fade" id="disable-modal" action="{{route('admin.blog_posts.disable')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disable Blog Post</h4>
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
                <p>Are you sure you want to disable Blog Post?</p>
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
<form class="modal fade" id="enable-modal" action="{{route('admin.blog_posts.enable')}}" method="post">
    @csrf
    <input type="text" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Enable Blog Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enable this Blog Post?</p>
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

<form class="modal fade" id="important-modal" action="{{route('admin.blog_posts.make_important')}}" method="post">
    @csrf
    <input type="text" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Add importance to this blog</h4>
                <button type="button" class="close add more" data-dismiss="modal" aria-label="Close" title='Change status of post'>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to make this Blog Post important?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Important
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<form class="modal fade" id="unimportant-modal" action="{{route('admin.blog_posts.make_unimportant')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Make Blog Post unimportant</h4>
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
                <p>Are you sure you want to make Blog Post unimportant?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    Unimportant
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <!-- /.modal -->
</form>
<!-- /.modal -->

<!-- /.modal -->

<!-- /.content-wrapper -->
@endsection

@push('footer_javascript')
<script type="text/javascript">


    $('#entities-filter-form [name="blog_post_category_id"]').select2({
        "theme": "bootstrap4"
    });

    $('#entities-filter-form [name="tag_ids"]').select2({
        "theme": "bootstrap4"
    });

    $('#entities-filter-form [name]').on('change keyup', function (e) {
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
            "url": "{{route('admin.blog_posts.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["subject"] = $('#entities-filter-form [name="subject"]').val();
                dtData["blog_post_category_id"] = $('#entities-filter-form [name="blog_post_category_id"]').val();
                dtData["user_id"] = $('#entities-filter-form [name="user_id"]').val();
                dtData["status"] = $('#entities-filter-form [name="status"]').val();
                dtData["tag_ids"] = $('#entities-filter-form [name="tag_ids"]').val();
            }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],
        "order": [[6, 'desc']],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "on_index_page", "data": "on_index_page", "className": "text-center"},
            {"name": "blog_post_category_name", "data": "blog_post_category_name"},
            {"name": "subject", "data": "subject"},
            {"name": "blog_post_comments", "data": "blog_post_comments", "className": "text-center"},
            {"name": "views", "data": "views", "className": "text-center"},
            {"name": "user_name", "data": "user_name"},
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
            toastr.error("@lang('Error occured while enabling blogPost')");
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
            toastr.error("@lang('Error occured while disabling Blog Post')");
        });
    });

    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });

    $('#delete-modal').on('submit', function (e) {
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
            toastr.error("@lang('Error occured while deleting blogPost')");
        });
    });
    $('#entities-list-table').on('click', '[data-action="change-importance"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#unimportant-modal [name="id"]').val(id);
        $('#unimportant-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="change-importance"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#important-modal [name="id"]').val(id);
        $('#important-modal [data-container="name"]').html(name);
    });





    $('#important-modal').on('submit', function (e) {
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
            toastr.error("@lang('Error occured while making blog Post important')");
        });
    });
    $('#unimportant-modal').on('submit', function (e) {
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
            toastr.error("@lang('Error occured while making Blog Post')");
        });
    });


</script>
@endpush