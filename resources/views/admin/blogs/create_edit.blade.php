@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Blogs</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/blogs') }}">Blogs</a></li>
                <li>{{ @$btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-12">
                    <form method="POST" action="{{ @$action }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Title</label>
                                <input type="text" class="form-control" value="{{ @$blog->title }}" name="title" required/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Author</label>
                                <input type="text" class="form-control" value="{{ @$blog->author }}" name="author"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Published Date</label>
                                <input type="date" class="form-control" value="{{ @$blog->published_date }}" name="published_date"/>
                            </div>
                            <div class="col-lg-6 form-group">
                                <label class="form_label_color">Status</label>
                                <select class="form-control" name="status">
                                    <option value="published" @if(@$blog->status == 'published') selected @endif>Published</option>
                                    <option value="draft" @if(@$blog->status == 'draft') selected @endif>Draft</option>
                                </select>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Short Excerpt / Summary</label>
                                <textarea class="form-control" name="excerpt" rows="2" maxlength="500" placeholder="A teaser line shown on the blog listing cards">{{ @$blog->excerpt }}</textarea>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="form_label_color">Body</label>
                                <textarea class="form-control" name="body" id="body">{{ @$blog->body }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form_label_color">Featured Image (listing card / banner)</label>
                                <input type="file" name="featured_image" class="form-control" accept="image/*">
                                @if(!empty(@$blog->featured_image))
                                <img src="{{ asset('blog_images/'.$blog->featured_image) }}" style="width: 220px; height: 120px; object-fit: cover; margin-top:10px;">
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form_label_color">Content Image (inside the post)</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                                @if(!empty(@$blog->image))
                                <img src="{{ asset('blog_images/'.$blog->image) }}" style="width: 220px; height: 120px; object-fit: cover; margin-top:10px;">
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="float: right;">{{ @$btn_text }}</button>
                        <div class="response"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js" integrity="sha512-F8fV4+wpHYl9zul08Soff9H9fCx6OMIFfgbQcy+2v2gV7PdbT0OgM1LFwujQmwlLGWWKNbOFZ13uWP+Cbe0Ngw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    CKEDITOR.replace('body', {
        extraPlugins: 'htmlwriter',
        docType: '<!DOCTYPE HTML>',
        allowedContent: true,
    });
</script>
@endsection
