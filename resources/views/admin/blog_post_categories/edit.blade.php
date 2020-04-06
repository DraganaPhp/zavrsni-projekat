@extends('admin._layout.layout')

@section('seo_title', __('Edit Blog Post Categories'))

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Blog Post Category')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.blog_post_categories.index')}}">@lang('Blog Post Categories')</a></li>
                    <li class="breadcrumb-item active"> @lang('Edit Blog Post Categories')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @lang('Edit Blog Post Categories')
                            #{{$blogPostCategory->id}}
                            - 
                            {{$blogPostCategory->name}}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.blog_post_categories.update', ['blogPostCategory' =>$blogPostCategory->id])}}" method="post" id="entity-form">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input 
                                    name="name"
                                    value="{{old('name',$blogPostCategory->name)}}"
                                    type="text" 
                                    class="form-control @if($errors->has('name')) is-invalid @endif" 

                                    >
                                @include('admin._layout.partials.form_errors', ['fieldName' =>'name'])
                            </div>
                            <div class="form-group">
                                <label>@lang('Desription')</label>
                                <textarea 
                                    class="form-control  @if($errors->has('name')) is-invalid @endif" 
                                    placeholder="Enter description"
                                    name="description"
                                    >{{old('description')}}</textarea>
                                @include('admin._layout.partials.form_errors', ['fieldName' =>'description'])
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection
@push('footer_javascript')
<script type="text/javascript">
    $('#entity-form').validate({
        rules: {
            "name": {
                required: true,
                maxlenght: 10
            },
            "description": {
                required: false,
                minlenght: 255,
                maxlenght: 255
            },
        },

        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

</script>
@endpush