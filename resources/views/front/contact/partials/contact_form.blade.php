@push('head_scripts')
{!! htmlScriptTagJsApi() !!}
@endpush


<form action="{{route('front.contact.send_message')}}" method="post" role="form" id='main_contact_form' class="commenting-form">
    @csrf
              <div class="row">
                <div class="form-group col-md-6">
        <input 
            type="text" 
            value="{{old('contact_person')}}"
            class="form-control @if($errors->has('contact_person')) is-invalid @endif "
            name="contact_person" 
            placeholder="Your Name"
            id=""
            >
        @include('front._layout.partials.form_errors', ['fieldName'=>'contact_person'])
                </div>
                <div class="form-group col-md-6">
                  <input 
            type="email" 
            value="{{old('contact_email')}}"
            class="form-control @if($errors->has('contact_email')) is-invalid @endif " 
            name="contact_email" 
            placeholder="Email Address (will not be published)"
            id=""
            >
        @include('front._layout.partials.form_errors', ['fieldName'=>'contact_email'])
                </div>
                <div class="form-group col-md-12">
                  <textarea 
            class="form-control @if($errors->has('contact_message')) is-invalid @endif " 
            name="contact_message" 
            id="" 
            rows="20"
            placeholder="Type your message"
            >{{old('contact_message')}}</textarea>
        @include('front._layout.partials.form_errors', ['fieldName'=>'contact_message'])
                </div>
            <div class="form-group">
        <label for="Captcha">Please confirm that you are not robot</label>
        {!! htmlFormSnippet() !!}
        @error('g-recaptcha-response')
        <span class='invalid-feedback' role='alert' style='display: block'>
            <strong>{{$message}}</strong>
        </span>
        @enderror
    </div>
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-secondary">Submit Your Message</button>
                </div>
              </div>
            </form>