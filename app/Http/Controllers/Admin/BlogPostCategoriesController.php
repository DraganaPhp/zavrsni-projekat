<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPostCategory;
use Illuminate\Validation\Rule;
use App\Models\BlogPost;

class BlogPostCategoriesController extends Controller {

    public function index(Request $request) {
        $blogPostCategories = BlogPostCategory::query()
                ->orderby('priority')
                ->get();
        return view('admin.blog_post_categories.index', [
            'blogPostCategories' => $blogPostCategories,
        ]);
    }

    public function add(Request $request) {
        return view('admin.blog_post_categories.add');
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'min:2', 'unique:blog_post_categories,name'],
            'description' => ['nullable', 'string', 'min:10', 'max:255'],
        ]);

        $newBlogPostCategory = new BlogPostCategory();

        $newBlogPostCategory->fill($formData);

        $blogPostCategoryWithHigestPriority = BlogPostCategory::query()
                ->orderBy('priority', 'DESC')
                ->first();

        if ($blogPostCategoryWithHigestPriority) {
            $newBlogPostCategory->priority = $blogPostCategoryWithHigestPriority->priority + 1;
        } else {
            $newBlogPostCategory->priority = 1;
        }
        $newBlogPostCategory->save();

        session()->flash('system_message', __('New BlogPost Category has been saved!'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function edit(Request $request, BlogPostCategory $blogPostCategory) {
        return view('admin.blog_post_categories.edit', [
            'blogPostCategory' => $blogPostCategory
        ]);
    }

    public function update(Request $request, BlogPostCategory $blogPostCategory) {

        $formData = $request->validate([
            'name' => ['required', 'string', 'max:10', Rule::unique('blog_post_categories')->ignore($blogPostCategory->id),],
            'description' => ['nullable', 'string', 'min:10', 'max:255'],
        ]);

        $blogPostCategory->fill($formData);

        $blogPostCategory->save();

        session()->flash('system_message', __('BlogPost Category has been saved!'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_post_categories,id'],
        ]);

        $blogPostCategory = BlogPostCategory::findOrFail($formData['id']);


        if ($blogPostCategory->blog_posts()->count() > 0) {

            $sumOfChangedBlogPosts = $blogPostCategory->blog_posts()->count();
            BlogPost::query()
                    ->where('blog_post_category_id', '=', $blogPostCategory->id)
                    ->update([
                        "blog_post_category_id" => 0,
            ]);

            $blogPostCategory->delete();

            session()->flash(
                    'system_message', __('BlogPost Category has been deleted! ' . $sumOfChangedBlogPosts . ' blog posts signed as uncategorized'
            ));

            return redirect()->route('admin.blog_post_categories.index');
        }

        $blogPostCategory->delete();
        BlogPostCategory::query()
                ->where('priority', '>', $blogPostCategory->priority)
                ->decrement('priority');

        session()->flash('system_message', __('BlogPost Category has been deleted!'));

        return redirect()->route('admin.blog_post_categories.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string'],
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $blogPostCategory = BlogPostCategory::findOrFail($id);
            $blogPostCategory->priority = $key + 1;
            $blogPostCategory->save();
        }
        session()->flash('system_message', __('BlogPost Categories have been reordered'));

        return redirect()->route('admin.blog_post_categories.index');
    }

}
