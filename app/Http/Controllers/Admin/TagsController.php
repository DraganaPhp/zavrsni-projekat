<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class TagsController extends Controller {

    public function index() {
        $tags = Tag::query()
                ->orderby('priority')
                ->get();

        return view('admin.tags.index', [
            'tags' => $tags,
        ]);
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
            'id' => ['required', 'numeric', 'exists:tags,id'],
        ]);

        $formData['id'];
        $tag = Tag::findOrFail($formData['id']);
        $tag->delete();
        \DB::table('bog_tags')
                ->where('tag_id', '=', $tag->id)
                ->delete();


        Tag::query()
                ->where('priority', '>', $tag->priority)
                ->decrement('priority');

        session()->flash('system_message', __('Tag has been deleted!'));

        return redirect()->route('admin.tags.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string'],
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $tag = Tag::findOrFail($id);
            $tag->priority = $key + 1;
            $tag->save();
        }
        session()->flash('system_message', __('Tags have been reordered'));

        return redirect()->route('admin.tags.index');
    }

}
