<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();
        return view('admin.blogs.blogs', ['blogs' => $blogs]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $this->handle($request, []);
            Blog::create($data);
            return redirect(url('admin/blogs'))->with('success', 'Blog added successfully!');
        }

        $data['action'] = url('/admin/blogs/create');
        $data['btn_text'] = 'Create';
        return view('admin.blogs.create_edit', $data);
    }

    public function edit(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        if ($request->isMethod('post')) {
            $update = $this->handle($request, ['image' => $blog->image, 'featured_image' => $blog->featured_image]);
            $blog->fill($update)->save();
            return redirect(url('admin/blogs'))->with('success', 'Blog updated successfully!');
        }

        $data['blog'] = $blog;
        $data['action'] = url('/admin/blogs/edit', $id);
        $data['btn_text'] = 'Update';
        return view('admin.blogs.create_edit', $data);
    }

    public function delete($id)
    {
        Blog::where('id', $id)->delete();
        return back()->with('success', 'Blog deleted successfully!');
    }

    /**
     * Build the blog attributes from the request, moving any uploaded images.
     * $existing keeps the current filenames when no new file is uploaded.
     */
    private function handle(Request $request, array $existing)
    {
        $data = $request->only(['title', 'slug', 'excerpt', 'body', 'author', 'published_date', 'status']);

        foreach (['image', 'featured_image'] as $field) {
            if ($request->file($field)) {
                $data[$field] = \App\Support\ImageHelper::save($request->file($field), 'blog_images', ['width' => 1280, 'height' => 720, 'mode' => 'cover', 'quality' => 90]);
            } elseif (isset($existing[$field])) {
                $data[$field] = $existing[$field];
            }
        }

        if (empty($data['status'])) {
            $data['status'] = 'published';
        }

        return $data;
    }
}
