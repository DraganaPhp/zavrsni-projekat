<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>@yield('seo_title', __('Selected Blog Posts')) | Blog Post</title>
        <meta name="description" content="@yield('seo_description', __('Read posts for most popular themes'))">
        <meta property="og:site_name" content="{{config('app.name')}}">
        <meta property="og:site_type" content="@yield('seo_type', __('Blog post'))">
        <meta property="og:title" content="@yield('seo_title', __('Selected Blog Posts')) | Blog Post">
        <meta property="og:description" content="@yield('seo_description', __('Read posts for most popular themes'))">
        <meta property="og:image" content="@yield('seo_image',url('/themes/front/img/logo.png'))">
        <meta property="og:url" content="{{url()->current()}}">
        
        
        
        <meta name="twitter:card" content="{{config('app.name')}}">
        <meta name="twitter:title" content="@yield('seo_title', __('Selected Blog Posts')) | Blog Post">
        <meta name="twitter:description" content="@yield('seo_description', __('Read posts for most popular themes'))">
        <meta name="twitter:image" content="@yield('seo_image',url('/themes/front/img/logo.png'))">
        
        
         
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/bootstrap/css/bootstrap.min.css')}}">
        <!-- Font Awesome CSS-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/font-awesome/css/font-awesome.min.css')}}">
        <!-- Custom icon font-->
        <link rel="stylesheet" href="{{url('/themes/front/css/fontastic.css')}}">
        <!-- Google fonts - Open Sans-->
        <link rel="stylesheet" href="{{url('/themes/front/https://fonts.googleapis.com/css?family=Open+Sans:300,400,700')}}">
        <!-- Fancybox-->
        <link rel="stylesheet" href="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.css')}}">
        <!-- theme stylesheet-->
        <link rel="stylesheet" href="{{url('/themes/front/css/style.default.css')}}" id="theme-stylesheet">
        <!-- Custom stylesheet - for your changes-->
        <link rel="stylesheet" href="{{url('/themes/front/css/custom.css')}}">
        <!-- Favicon-->
        <link rel="shortcut icon" href="{{url('/themes/front/favicon.png')}}">
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <!-- owl carousel 2 stylesheet-->
        <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.carousel.min.css')}}" id="theme-stylesheet">
        <link rel="stylesheet" href="{{url('/themes/front/plugins/owl-carousel2/assets/owl.theme.default.min.css')}}" id="theme-stylesheet">
        {!! htmlScriptTagJsApi([
        'action' => 'homepage',
        'custom_validation' => 'myCustomValidation'
        ]) !!}
    </head>
    <body>
        <header class="header">
            <!-- Main Navbar-->
            <nav class="navbar navbar-expand-lg">
                <div class="search-area">
                    <div class="search-area-inner d-flex align-items-center justify-content-center">
                        <div class="close-btn"><i class="icon-close"></i></div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-8">
                                @include('front.blog_posts.partials.search_form')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <!-- Navbar Brand -->
                    <div class="navbar-header d-flex align-items-center justify-content-between">
                        <!-- Navbar Brand --><a href="{{url('/themes/front/index.html')}}" class="navbar-brand">Bootstrap Blog</a>
                        <!-- Toggle Button-->
                        <button type="button" data-toggle="collapse" data-target="#navbarcollapse" aria-controls="navbarcollapse" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"><span></span><span></span><span></span></button>
                    </div>
                    <!-- Navbar Menu -->
                    <div id="navbarcollapse" class="collapse navbar-collapse">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item"><a href="{{route('front.index.index')}}" class="nav-link active">Home</a>
                            </li>
                            <li class="nav-item"><a href="{{route('front.blog_posts.index')}}" class="nav-link">Blog</a>
                            </li>
                            <li class="nav-item"><a href="{{route('front.contact.index')}}"  class="nav-link">Contact</a>
                            </li>
                        </ul>
                        <div class="navbar-text"><a href="{{route('front.blog_posts.blog_posts_search')}}" class="search-btn"><i class="icon-search-1"></i></a></div>
                    </div>
                </div>
            </nav>
        </header> 
        @yield('content')
        @include('front._layout.footer')
        <!-- JavaScript files-->
        <script src="{{url('/themes/front/vendor/jquery/jquery.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/popper.js/umd/popper.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{url('/themes/front/vendor/jquery.cookie/jquery.cookie.js')}}"></script>
        <script src="{{url('/themes/front/vendor/@fancyapps/fancybox/jquery.fancybox.min.js')}}"></script>
        <script src="{{url('/themes/front/js/front.js')}}"></script>
        <script src="{{url('/themes/front/plugins/owl-carousel2/owl.carousel.min.js')}}"></script>
        <script>
            $("#index-slider").owlCarousel({
            "items": 1,
                    "loop": true,
                    "autoplay": true,
                    "autoplayHoverPause": true
            });
            $("#latest-posts-slider").owlCarousel({
            "items": 1,
                    "loop": true,
                    "autoplay": true,
                    "autoplayHoverPause": true
            });
        </script>

        @stack('footer_javascript')
    </body>
</html>