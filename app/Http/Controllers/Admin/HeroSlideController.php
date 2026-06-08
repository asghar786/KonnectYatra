<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.slider.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slider.form', [
            'slide'    => new HeroSlide(['is_active' => 1, 'btn1_text' => 'BOOK NOW', 'btn2_text' => 'READ MORE']),
            'action'   => url('admin/home-slider'),
            'btn_text' => 'Create Slide',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);
        $data['image'] = $this->uploadImage($request);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        HeroSlide::create($data);

        return redirect(url('admin/home-slider'))->with('success', 'Slide added successfully.');
    }

    public function edit($id)
    {
        return view('admin.slider.form', [
            'slide'    => HeroSlide::findOrFail($id),
            'action'   => url('admin/home-slider/edit', $id),
            'btn_text' => 'Update Slide',
        ]);
    }

    public function update(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);
        $data = $this->validateData($request, false);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        if ($request->file('image')) {
            $data['image'] = $this->uploadImage($request);
        }
        $slide->update($data);

        return redirect(url('admin/home-slider'))->with('success', 'Slide updated successfully.');
    }

    public function destroy($id)
    {
        HeroSlide::where('id', $id)->delete();
        return redirect(url('admin/home-slider'))->with('success', 'Slide deleted.');
    }

    private function validateData(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'eyebrow'     => ['nullable', 'string', 'max:191'],
            'title'       => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string'],
            'image'       => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'btn1_text'   => ['nullable', 'string', 'max:50'],
            'btn1_link'   => ['nullable', 'string', 'max:191'],
            'btn2_text'   => ['nullable', 'string', 'max:50'],
            'btn2_link'   => ['nullable', 'string', 'max:191'],
            'sort_order'  => ['nullable', 'integer'],
        ]);
    }

    private function uploadImage(Request $request): string
    {
        return 'slider/' . \App\Support\ImageHelper::save($request->file('image'), 'slider', ['width' => 1920, 'height' => 900, 'mode' => 'cover', 'quality' => 90]);
    }
}
