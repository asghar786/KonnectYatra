@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">{{ $btn_text }}</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li><a href="{{ url('/admin/home-slider') }}">Home Slider</a></li>
                <li>{{ $btn_text }}</li>
            </ul>
        </div>
        <div class="main-body">
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <div class="row">
                <div class="col-lg-9">
                    <div class="card" style="border-radius:14px">
                        <div class="card-body">
                            <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="form_label_color">Eyebrow Text <span class="text-muted">(small line above title)</span></label>
                                    <input type="text" name="eyebrow" class="form-control" placeholder="A Holy Journey To" value="{{ old('eyebrow', $slide->eyebrow) }}">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="NANKANA SAHIB" value="{{ old('title', $slide->title) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Short paragraph shown under the title">{{ old('description', $slide->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Button 1 Text</label>
                                        <input type="text" name="btn1_text" class="form-control" placeholder="BOOK NOW" value="{{ old('btn1_text', $slide->btn1_text) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Button 1 Link</label>
                                        <input type="text" name="btn1_link" class="form-control" placeholder="all-packages or https://..." value="{{ old('btn1_link', $slide->btn1_link) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Button 2 Text</label>
                                        <input type="text" name="btn2_text" class="form-control" placeholder="READ MORE" value="{{ old('btn2_text', $slide->btn2_text) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Button 2 Link</label>
                                        <input type="text" name="btn2_link" class="form-control" placeholder="our-info or https://..." value="{{ old('btn2_link', $slide->btn2_link) }}">
                                    </div>
                                </div>
                                <p class="text-muted" style="font-size:13px;margin-top:-6px">Links can be a path on this site (e.g. <code>all-packages</code>) or a full URL (e.g. <code>https://...</code>). Leave a button's text empty to hide it.</p>

                                <div class="form-group">
                                    <label class="form_label_color">Background Image @if($btn_text === 'Create Slide')<span class="text-danger">*</span>@endif</label>
                                    <input type="file" name="image" accept="image/*" class="form-control" @if($btn_text === 'Create Slide') required @endif>
                                    @if(!empty($slide->image))
                                    <div class="mt-2"><img src="{{ asset($slide->image) }}" style="width:280px;height:120px;object-fit:cover;border-radius:8px;" onerror="this.style.display='none'"><div class="text-muted" style="font-size:12px;">Current image — choose a file to replace it.</div></div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color">Display Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slide->sort_order ?? 0) }}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="form_label_color d-block">Status</label>
                                        <label style="cursor:pointer;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $slide->is_active ?? 1) ? 'checked' : '' }}> Show this slide on the homepage</label>
                                    </div>
                                </div>

                                <button class="btn btn-primary">{{ $btn_text }}</button>
                                <a href="{{ url('admin/home-slider') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
