  <form 
        action={{route('front.comments.send_comment')}}"
        method="post" 
        role="form" 
        id="main_contact_form"
        class="commenting-form"
        >
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <input 
                    type="text" 
                    name="sender_nickname" 
                    value="{{old('sender_nickname')}}"
                    id="username" 
                    placeholder="Name" 
                    data-name="sender_nickname" 
                    class="form-control @if($errors->has('contact_person')) is-invalid @endif"
                    >
                 @include('front._layout.partials.form_errors', ['fieldName'=>'sender_nickname'])
            </div>  
            <div class="form-group col-md-6">
                <input 
                    type="email" 
                    value="{{old('sender_email')}}"
                    name="sender_email" 
                    id="useremail" 
                    placeholder="Email Address (will not be published)" 
                    class="form-control @if($errors->has('contact_email')) is-invalid @endif"
                    data-email="sender_email" 
                    >
                 @include('front._layout.partials.form_errors', ['fieldName'=>'contact_email'])
            </div>
            <div class="form-group col-md-12">
                <textarea 
                    name="body" 
                    id="usercomment" 
                    data-body="body" 
                    placeholder="Type your comment" 
                    class="form-control  @if($errors->has('contact_message')) is-invalid @endif">{{old('contact_message')}}</textarea>
                     @include('front._layout.partials.form_errors', ['fieldName'=>'contact_message'])
            </div>
            <div class="form-group col-md-12">
                <button 
                    type="submit" 
                    class="btn btn-secondary"
                    data-action="send-comment"
                    data-blogPost =" "
                    >Submit Comment</button>
            </div>
        </div>
    </form>