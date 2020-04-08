@extends('admin._layout.layout')

@section('seo_title', __('Add new Slide'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit slide')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.slides.index')}}">@lang('Slides')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Edit slide')
                    </li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            @lang('Editing slide')
                            #
                            {{$slide->id}}
                            -
                            {{$slide->name}}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->


                    <form 
                        role="form" 
                        action="{{route('admin.slides.update', ['slide'=>$slide->id])}}" 
                        method="post" 
                        id="entity-form" 
                        enctype="multipart/form-data" 
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Subject')</label>
                                        <div class="input-group">
                                            <input 
                                                name="subject"
                                                value="{{old('subject',$slide->subject)}}"
                                                type="text" 
                                                class="form-control @if($errors->has('subject')) is-invalid @endif" 
                                                placeholder="Enter subject"
                                                >
                                            @include('admin._layout.partials.form_errors', ['fieldName' =>'subject'])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Link Title')</label>
                                        <input 
                                            name="link_title"
                                            value="{{old('link_title',$slide->link_title)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('link_title')) is-invalid @endif" 
                                            placeholder="Enter link title"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' =>'link_title'])
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('link URL')</label>
                                        <div class="input-group">
                                            <input 
                                                name="link_url"
                                                value="{{old('link_url,$slide->link_url')}}"
                                                type="text" 
                                                class="form-control @if($errors->has('link_url')) is-invalid @endif" 
                                                placeholder="Enter link url"
                                                >
                                            @include('admin._layout.partials.form_errors', ['fieldName' =>'link_url'])

                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-link"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Choose New Photo</label>
                                        <input 
                                            name="photo"
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo'])
                                    </div>

                                </div>
                                <div class="offset-md-3 col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Photo</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        Delete Photo
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$slide->getPhotoUrl()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container="photo"
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{route('admin.slides.index')}}" class="btn btn-outline-secondary">Cancel</a>
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
@endsection

@push('footer_javascript')
<script type="text/javascript">


    $('#entity-form').validate({
        rules: {
            "subject": {
                "required": true,
                "maxlength": 255
            },
            "link_name": {
                "required": true,
                "maxlength": 255
            }
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

    $('#entity-form').on('click', '[data-action="delete-photo"]', function (e) {
        e.preventDefault();

        let photo = $(this).attr('data-photo');

        $.ajax({
            "url": "{{route('admin.slides.delete_photo', ['slide' => $slide->id])}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}"
            }
        }).done(function (response) {

            toastr.success(response.system_message);

            $('img[data-container="photo"]').attr('src', response.photo_url);

        }).fail(function () {
            toastr.error('Error while deleteing photo');
        });
    });

</script>
@endpush