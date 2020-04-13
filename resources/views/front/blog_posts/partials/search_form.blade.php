<form 
    action="{{route('front.blog_posts.blog_posts_search')}}" 
    class="search-form"
    method="get"
    role="form" 
    >
    <div class="form-group">
        <input 
            name="search_term" 
            type="search" 
            value="{{old('search_term')}}"
            placeholder="What are you looking for?"
            >
        <button type="submit" class="submit"><i class="icon-search"></i></button>
    </div>
</form>