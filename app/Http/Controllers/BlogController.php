<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->orderByRaw('COALESCE(published_date, created_at) DESC')
            ->get();
        return view('blogs', ['blogs' => $blogs]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 'published')->firstOrFail();
        $recent = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderByRaw('COALESCE(published_date, created_at) DESC')
            ->take(4)->get();
        return view('details.blog_detail', ['blog' => $blog, 'recent' => $recent]);
    }
}
