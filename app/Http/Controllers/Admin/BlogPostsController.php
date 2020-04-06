<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\BlogPost;
use App\Models\BlogPostCategory;
use App\User;
use App\Models\Tag;
use \Illuminate\Support\Str;

class BlogPostsController extends Controller {

    public function index() {

        return view('admin.blog_posts.index', [
        ]);
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'status' => ['nullable', 'in:0,1'],
            'subject' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'numeric', 'exists:users,id'],
            'blog_post_category_id' => ['nullable', 'numeric', 'exists:blog_post_categories,id'],
            'tag_ids' => ['nullable', 'array', 'exists:tags,id'],
        ]);

        $query = BlogPost::query()
                ->with(['user', 'blogPostCategory', 'tags'])
                ->join('users', 'blog_posts.user_id', '=', 'users.id')
                ->join('blog_post_categories', 'blog_posts.blog_post_category_id', '=', 'blog_post_categories.id')
                ->select(['blog_posts.*', 'users.name AS user_name', 'blog_post_categories.name AS blog_post_category.name']);

        //Inicijalizacija datatables-a
        $dataTable = \DataTables::of($query);

        //Podesavanje kolona




        $dataTable
                ->addColumn('tags', function ($blogPost) {
                    return optional($blogPost->tags->pluck('name'))->join(', ');
                })
                ->addColumn('user_name', function ($blogPost) {
                    return optional($blogPost->user)->name;
                })
                ->addColumn('blog_post_category_name', function ($blogPost) {
                    return optional($blogPost->blogPostCategory)->name;
                })
                ->addColumn('actions', function ($blogPost) {
                    return view('admin.blog_posts.partials.actions', ['blogPost' => $blogPost]);
                })
                ->editColumn('photo', function ($blogPost) {
                    return view('admin.blog_posts.partials.blog_post_photo', ['blogPost' => $blogPost]);
                })
                ->editColumn('id', function ($blogPost) {
                    return '#' . $blogPost->id;
                })
                ->editColumn('subject', function ($blogPost) {
                    return '<strong>' . e($blogPost->subject) . '</strong>';
                })
                ->editColumn('on_index_page', function ($blogPost) {

                    if ($blogPost->on_index_page == 1) {
                        return '<span class="text-success">yes</span>';
                    } else {
                        return '<span class="text-danger">no</span>';
                    }
                })
                ->editColumn('status', function ($blogPost) {

                    if ($blogPost->status == 1) {
                        return '<span class="text-success">yes</span>';
                    } else {
                        return '<span class="text-danger">no</span>';
                    }
                })
                ->editColumn('created_at', function ($blogPost) {
                    return $blogPost->created_at->format('Y-m-d');
                })
        ;


        $dataTable->rawColumns(['on_index_page', 'status', 'subject', 'photo', 'actions', 'created_at']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->orWhere('blog_posts.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_posts.body', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_post_categories.name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('blog_posts.id', '=', $searchTerm);
                });
            }



            if (isset($searchFilters['subject'])) {
                $query->where('blog_posts.subject', 'LIKE', '%' . $searchFilters['subject'] . '%');
            }

            if (isset($searchFilters['user_id'])) {
                $query->where('blog_posts.user_id', '=', $searchFilters['user_id']);
            }

            if (isset($searchFilters['blog_post_category_id'])) {
                $query->where('blog_posts.blog_post_category_id', '=', $searchFilters['blog_post_category_id']);
            }

            if (isset($searchFilters['status'])) {
                $query->where('blog_posts.status', '=', $searchFilters['status']);
            }

            if (isset($searchFilters['tag_ids'])) {
                $query->whereHas('tags', function ($subQuery) use ($searchFilters) {

                    $subQuery->whereIn('tag_id', $searchFilters['tag_ids']);
                });
            }
        });

        return $dataTable->make(true); //make - pravi json po specifikaciji DataTables.js plugin-a	
    }

    public function add(Request $request) {
        $user = \Auth::user();
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->get();

        $tags = Tag::all();

        return view('admin.blog_posts.add', [
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
            'user' => $user,
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'blog_post_category_id' => ['required', 'numeric', 'max:10', 'exists:blog_post_categories,id'],
            'subject' => ['required', 'string', 'max:255', 'unique:blog_posts,subject'],
            'body' => ['nullable', 'string', 'max:1000'],
            'tag_id' => ['required', 'array', 'exists:tags,id'],
            'photo' => ['nullable', 'file', 'image'],
            'description' => ['nullable', 'string'],
        ]);

        $newBlogPost = new BlogPost();
        $newBlogPost->fill($formData);
        $newBlogPost->user_id = \Auth::user()->id;
        $newBlogPost->save();
        $newBlogPost->tags()->sync($formData['tag_id']);


        $this->handlePhotoUpload('photo', $request, $newBlogPost);



        session()->flash('system_message', __('New blog post has been saved!'));

        return redirect()->route('admin.blog_posts.index');
    }

    public function edit(Request $request, BlogPost $blogPost) {
        $user = \Auth::user();
        $blogPostCategories = BlogPostCategory::query()
                ->orderBy('priority')
                ->get();

        $users = User::query()
                ->orderBy('name')
                ->get();

        $tags = Tag::all();
        return view('admin.blog_posts.edit', [
            'blogPost' => $blogPost,
            'blogPostCategories' => $blogPostCategories,
            'tags' => $tags,
            'user' => $user,
        ]);
    }

    public function update(Request $request, BlogPost $blogPost) {
        $formData = $request->validate([
            'blog_post_category_id' => ['required', 'numeric', 'max:10', 'exists:blog_post_categories,id'],
            'aubject' => ['required', 'string', 'max:255', Rule::unique('blog_posts')->ignore($blogPost->id)],
            'body' => ['nullable', 'string', 'max:1000'],
            'tag_id' => ['required', 'array', 'exists:tags,id'],
            'photo' => ['nullable', 'file', 'image'],
            'details' => ['nullable', 'string'],
        ]);

        $blogPost->fill($formData);
        $blogPost->user = \Auth::user();
        $blogPost->save();
        $blogPost->tags()->sync($formData['tag_id']);

        $this->handlePhotoUpload('photo', $request, $blogPost);

        session()->flash('system_message', __('BlogPost has been saved!'));

        return redirect()->route('admin.blog_posts.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $formData['id'];
        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost->delete();
        /* \DB::table('blog_post_tags')
          ->where('blog_post_id', '=', $blogPost->id)
          ->delete(); */


        return response()->json([
                    'system_message' => __('BlogPost has been deleted')
        ]);
    }

    public function enable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost->status = User::STATUS_ENABLED;
        $blogPost->save();

        return response()->json([
                    'system_message' => __('BlogPost has been enabled')
        ]);
    }

    public function disable(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $blogPost = BlogPost::findOrFail($formData['id']);
        $blogPost->status = User::STATUS_DISABLED;
        $blogPost->save();
        return response()->json([
                    'system_message' => __('BlogPost has been disabled')
        ]);
    }

    public function deletePhoto(Request $request, BlogPost $blogPost) {
        $formData = $request->validate([
            'photo' => ['required', 'string', 'in:photo1,photo2'],
        ]);

        $photoFieldName = $formData['photo'];

        $blogPost->deletePhoto($photoFieldName);

        $blogPost->$photoFieldName = null;
        $blogPost->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $blogPost->getPhotoUrl($photoFieldName),
        ]);
    }

    protected function handlePhotoUpload(
            string $photoFieldName,
            Request $request,
            BlogPost $blogPost
    ) {
        if ($request->hasFile($photoFieldName)) {


            $blogPost->deletePhoto($photoFieldName);

            $photoFile = $request->file($photoFieldName);

            $newPhotoFileName = $blogPost->id . '_' . $photoFieldName . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/blog_posts/'),
                    $newPhotoFileName
            );


            $blogPost->$photoFieldName = $newPhotoFileName;

            $blogPost->save();

            \Image::make(public_path('/storage/blog_posts/' . $blogPost->$photoFieldName))
                    ->fit(400, 600)
                    ->save();

            \Image::make(public_path('/storage/blog_posts/' . $blogPost->$photoFieldName))
                    ->fit(300, 300)
                    ->save(public_path('/storage/blog_posts/thumbs/' . $blogPost->$photoFieldName));
        }
    }

}
