<section style="background:url({{$slide->getPhotoUrl()}}); background-size: cover; background-position: center center"
         class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1>{{$slide->subject}}</h1>
                <a href="{{$slide->link_url}}" class="hero-link">{{$slide->link_title}}</a>
            </div>
        </div>
    </div>
</section>