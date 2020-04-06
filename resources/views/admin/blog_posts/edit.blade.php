@extends('admin._layout.layout')

@section('seo_title', __('Edit BlogPost'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit blogPost')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.blog_posts.index')}}">@lang('BlogPosts')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        @lang('Edit PblogPost')
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
                            @lang('Editing blogPost')
                            #
                            {{$blogPost->id}}
                            -
                            {{$blogPost->subject}}
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        role="form" 
                        action="{{route('admin.blog_posts.update', ['blogPost'=>$blogPost->id])}}" 
                        method="post" 
                        id="entity-form" 
                        enctype="multipart/form-data" 
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Blog Post Category</label>
                                        <select 
                                            name="blog_post_category_id" 
                                            class="form-control @if($errors->has('blog_post_category_id')) is-invalid @endif"
                                            >
                                            <option value="">-- Choose Category --</option>
                                            @foreach($blogPostCategories as $blogPostCategory)       
                                            <option 
                                                value="{{$blogPostCategory->id}}"
                                                @if($blogPostCategory->id == old('blog_post_category_id', $blogPost->blog_post_category_id))
                                                selected
                                                @endif
                                                >
                                                {{$blogPostCategory->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' =>'blog_post_category_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Subject')</label>
                                        <input 
                                            name="subject"
                                            value="{{old('subject',$blogPost->subject)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('subject')) is-invalid @endif" 
                                            placeholder="Enter subject"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' =>'subject'])

                                    </div>
                                    <div class="form-group">
                                        <label>Short description</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="Enter Shor description"
                                            >{{old('description')}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' =>'description'])
                                    </div>
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <div>

                                            @foreach($tags as $tag)
                                            <div 
                                                class="form-check form-check-inline">
                                                <input 
                                                    name="tag_id[]"
                                                    class="form-check-input" 
                                                    multiple
                                                    type="checkbox"
                                                    id="{{'tag-checkbox-'.$tag->id}}"
                                                    value="{{$tag->id}}"
                                                    @if(
                                                    is_array(old('tag_id',$blogPost->tags->pluck('id')->toArray()))
                                                    &&in_array($tag->id, old('tag_id',$blogPost->tags->pluck('id')->toArray()))
                                                    )
                                                    checked
                                                    @endif
                                                    >
                                                    <label class="form-check-label" for="{{'tag-checkbox-'.$tag->id}}">{{$tag->name}}</label>

                                            </div>
                                            @endforeach
                                            <div style="display:none;" class="form-control @if($errors->has('tag_id')) is-invalid @endif"></div>
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'tag_id'])
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
                                    <div class="form-group">
                                        <label>Body</label>
                                        <textarea 
                                            name="body"
                                            class="form-control @if($errors->has('body')) is-invalid @endif" 
                                            placeholder="Enter Body"
                                            >{{old('body')}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' =>'body'])
                                    </div>
                                </div>
                                <div class="offset-md-1 col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Photo</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="#"
                                                        data-photo="photo"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        Delete Photo
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="https://via.placeholder.com/400x600" 
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
                            <a href="blogPosts-index.html" class="btn btn-outline-secondary">Cancel</a>
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
<script src="/themes/admin/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="/themes/admin/plugins/ckeditor/adapters/jquery.js" type="text/javascript"></script>
<script type="text/javascript">


    //select name=user_id
    $('#entity-form [name="user_id"]').select2({
        "theme": "bootstrap4",
        "language": {
            "noResults": function () {
                return "There is no user with that name"
            }}
    });

    //select name=blog_post_category_id
    $('#entity-form [name="blog_post_category_id"]').select2({
        "theme": "bootstrap4",
        "language": {
            "noResults": function () {
                return "There is no blogPost category with that name"
            }}
    });


    $('#entity-form').validate({
        rules: {
            "user_id": {
                "required": true
            },
            "blog_post_category_id": {
                "required": true
            },
            "name": {
                "required": true,
                "maxlength": 255
            },
            "description": {
                "maxlength": 1000
            },
            "price": {
                "required": true,
                "min": 0.01
            },
            "old_price": {
                "min": 0.01
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

</script>
@endpush