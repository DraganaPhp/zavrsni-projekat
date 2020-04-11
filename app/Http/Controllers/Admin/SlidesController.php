<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Slide;

class SlidesController extends Controller {

    public function index() {
        $slides = Slide::query()
                ->orderby('priority')
                ->get();

        return view('admin.slides.index', [
            'slides' => $slides,
        ]);
    }

    public function add(Request $request) {



        return view('admin.slides.add', [
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'subject' => ['required', 'string', 'max:255', 'unique:slides,subject'],
            'link_title' => ['required', 'string', 'min:4', 'max:255'],
            'link_url' => ['nullable', 'url', 'min:9', 'max:50'],
            'photo' => ['nullable', 'file', 'image'],
                ]
        );

        $newSlide = new Slide();

        $newSlide->fill($formData);
        $newSlide->save();

        $this->handlePhotoUpload($request, $newSlide);

        session()->flash('system_message', __('New slide has been saved!'));

        return redirect()->route('admin.slides.index');
    }

    public function edit(Request $request, Slide $slide) {
        return view('admin.slides.edit', [
            'slide' => $slide,
        ]);
    }

    public function update(Request $request, Slide $slide) {

        $formData = $request->validate([
            'subject' => ['required', 'string', 'max:255', Rule::unique('slides')->ignore($slide->id)],
            'link_title' => ['required', 'string', 'max:255'],
            'link_url' => ['nullable', 'string'],
            'photo' => ['required', 'file', 'image'],
        ]);

        $slide->fill($formData);

        $slide->save();

        $this->handlePhotoUpload($request, $slide);


        session()->flash('system_message', __('Slide has been saved!'));

        return redirect()->route('admin.slides.index');
    }

    public function delete(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $formData['id'];
        $slide = Slide::findOrFail($formData['id']);
        $slide->delete();



        Slide::query()
                ->where('priority', '>', $slide->priority)
                ->decrement('priority');

        session()->flash('system_message', __('Slide has been deleted!'));

        return redirect()->route('admin.slides.index');
    }

    public function enableStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $slide = Slide::findOrFail($formData['id']);

        $slide->on_index_page = Slide::INDEX_ENABLED;
        $slide->save();

        session()->flash('system_message', __('Slide has been enabled!'));

        return redirect()->route('admin.slides.index');
    }

    public function disableStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $formData['id'];

        $slide = Slide::findOrFail($formData['id']);
        $slide->on_index_page = Slide::INDEX_DISABLED;
        $slide->save();

        session()->flash('system_message', __('Slide has been disabled!'));

        return redirect()->route('admin.slides.index');
    }

    public function changePriorities(Request $request) {
        $formData = $request->validate([
            'priorities' => ['required', 'string'],
        ]);

        $priorities = explode(',', $formData['priorities']);

        foreach ($priorities as $key => $id) {
            $slide = Slide::findOrFail($id);
            $slide->priority = $key + 1;
            $slide->save();
        }
        session()->flash('system_message', __('Slides have been reordered'));

        return redirect()->route('admin.slides.index');
    }

    public function deletePhoto(Request $request, Slide $slide) {
        $slide->deletePhoto();
        $slide->photo = null;
        $slide->save();

        return response()->json([
                    'system_message' => __('Photo has been deleted'),
                    'photo_url' => $slide->getPhotoUrl(),
        ]);
    }

    protected function handlePhotoUpload(
            Request $request,
            Slide $slide
    ) {
        if ($request->hasFile('photo')) {


            $slide->deletePhoto();

            $photoFile = $request->file('photo');

            $newPhotoFileName = $slide->id . '_' . $photoFile->getClientOriginalName();

            $photoFile->move(
                    public_path('/storage/slides/'), $newPhotoFileName
            );

            $slide->photo = $newPhotoFileName;

            $slide->save();


            /* \Image::make(public_path('/storage/slides/' . $slide->photo))
              ->fit(300, 300)
              ->save(); */
        }
    }

}
