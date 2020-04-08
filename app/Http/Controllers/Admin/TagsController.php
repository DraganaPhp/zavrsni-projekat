<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class TagsController extends Controller {

    public function index() {

        return view('admin.tags.index');
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $query = Tag::query();

        //Inicijalizacija datatables-a
        $dataTable = \DataTables::of($query);

        //Podesavanje kolona

        $dataTable->addColumn('actions', function ($tag) {
                    return view('admin.tags.partials.actions', ['tag' => $tag]);
                })
                ->editColumn('id', function ($tag) {
                    return '#' . $tag->id;
                })
                ->editColumn('name', function ($tag) {
                    return '<strong>' . e($tag->name) . '</strong>';
                })
                ->editColumn('created_at', function ($tag) {
                    return $tag->created_at->format('Y-m-d');
                })
                ->editColumn('updated_at', function ($tag) {
                    return $tag->created_at->format('Y-m-d');
                });



        $dataTable->rawColumns(['name', 'id', 'actions' . 'created_at']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->where('tags.name', 'LIKE', '%' . $searchTerm . '%');
                });
            }
        });

        return $dataTable->make(true);
    }

    public function add(Request $request) {
        return view('admin.tags.add', [
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'max:10', 'unique:tags,name'],
        ]);

        $newTag = new Tag();

        $newTag->fill($formData);
        $tagWithHigestPriority = Tag::query()
                ->orderBy('priority', 'DESC')
                ->first();

        if ($tagWithHigestPriority) {
            $newTag->priority = $tagWithHigestPriority->priority + 1;
        } else {
            $newTag->priority = 1;
        }
        $newTag->save();

        session()->flash('system_message', __('New tag has been saved!'));

        return redirect()->route('admin.tags.index');
    }

    public function edit(Request $request, Tag $tag) {
        return view('admin.tags.edit', [
            'tag' => $tag
        ]);
    }

    public function update(Request $request, Tag $tag) {
        $formData = $request->validate([
            'name' => ['required', 'string', 'max:10', Rule::unique('tags')->ignore($tag->id),],
        ]);

        $tag->fill($formData);

        $tag->save();

        session()->flash('system_message', __('Tag has been saved!'));

        return redirect()->route('admin.tags.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:blog_posts,id'],
        ]);

        $formData['id'];
        $tag = Tag::findOrFail($formData['id']);
        $tag->delete();
        \DB::table('blog_post_tags')
                ->where('tag_id', '=', $tag->id)
                ->delete();

        return response()->json([
                    'system_message' => __('BlogPost has been deleted')
        ]);
    }

}
