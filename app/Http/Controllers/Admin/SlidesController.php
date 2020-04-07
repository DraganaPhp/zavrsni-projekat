<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Slide;
use Illuminate\Support\Facades\Hash;

class SlidesController extends Controller {

    public function index() {

        return view('admin.slides.index', [
        ]);
    }

    public function datatable(Request $request) {

        $searchFilters = $request->validate([
            'on_index_page' => ['nullable', 'in:0,1'],
            'subject' => ['nullable', 'string', 'max:255'],
            'link_name' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:13'],
        ]);

        $query = Slide::query();

        //Inicijalizacija datatables-a
        $dataTable = \DataTables::of($query);

        //Podesavanje kolona

        $dataTable->addColumn('actions', function ($slide) {
                    return view('admin.slides.partials.actions', ['slide' => $slide]);
                })
                ->editColumn('photo', function ($slide) {
                    return view('admin.slides.partials.slide_photo', ['slide' => $slide]);
                })
                ->editColumn('id', function ($slide) {
                    return "#" . $slide->id;
                })
                ->editColumn('subject', function ($slide) {
                    return '<strong>' . e($slide->subject) . '</strong>';
                })
                ->editColumn('created_at', function ($slide) {
                    return $slide->created_at->format('Y-m-d');
                })
                ->editColumn('status', function ($slide) {

                    if ($slide->on_index_page == 1) {
                        return '<span class="text-success">enabled</span>';
                    } else {
                        return '<span class="text-danger">disabled</span>';
                    }
                });


        $dataTable->rawColumns(['on_index_page', 'subject', 'photo', 'actions' . 'created_at']);

        $dataTable->filter(function ($query) use ($request, $searchFilters) {

            if (
                    $request->has('search') && is_array($request->get('search')) && isset($request->get('search')['value'])
            ) {
                $searchTerm = $request->get('search')['value'];

                $query->where(function ($query) use ($searchTerm) {

                    $query->orWhere('slides.subject', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('slides.link_url', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('slides.link_title', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('slides.on_index_page', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('slides.id', '=', $searchTerm);
                });
            }



            if (isset($searchFilters['subject'])) {
                $query->where('slides.subject', 'LIKE', '%' . $searchFilters['subject'] . '%');
            }

            if (isset($searchFilters['link_title'])) {
                $query->where('slides.link_title', 'LIKE', '%' . $searchFilters['link_title'] . '%');
            }

            if (isset($searchFilters['link_url'])) {
                $query->where('link_url', 'LIKE', '%' . $searchFilters['link_url'] . '%');
            }
            if (isset($searchFilters['on_index_page'])) {
                $query->where('on_index_page', '=', $searchFilters['on_index_page']);
            }
        });

        return $dataTable->make(true);
    }

    public function add(Request $request) {



        return view('admin.slides.add', [
        ]);
    }

    public function insert(Request $request) {
        $formData = $request->validate([
            'subject' => ['required', 'string', 'max:255', 'unique:slides,subject'],
            'link_title' => ['required', 'string', 'min:4', 'max:255'],
            'link_url' => ['nullable', 'url', 'min:9', 'max:13'],
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
            'photo' => ['nullable', 'file', 'image'],
        ]);

        $slide->fill($formData);

        $slide->save();

        $this->handlePhotoUpload($request, $slide);


        session()->flash('system_message', __('Slide has been saved!'));

        return redirect()->route('admin.slides.index');
    }

    public function enableStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $slide = Slide::findOrFail($formData['id']);

        $slide->on_index_page = Slide::INDEX_ENABLED;
        $slide->save();

        return response()->json([
                    'system_message' => __('Slide has been enabled')
        ]);
    }

    public function disableStatus(Request $request) {
        $formData = $request->validate([
            'id' => ['required', 'numeric', 'exists:slides,id'],
        ]);

        $formData['id'];

        $slide = Slide::findOrFail($formData['id']);
        $slide->on_index_page = Slide::INDEX_DISABLED;
        $slide->save();

        return response()->json([
                    'system_message' => __('Slide has been disabled')
        ]);
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


            \Image::make(public_path('/storage/slides/' . $slide->photo))
                    ->fit(300, 300)
                    ->save();
        }
    }

}
