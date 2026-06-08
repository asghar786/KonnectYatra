@extends('admin.layouts.app')
@section('content')
<style type="text/css">
    .pf-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 26px rgba(28,37,65,.07);margin-bottom:24px;overflow:hidden}
    .pf-card .hd{padding:15px 22px;border-bottom:1px solid #f1f2f6;font-weight:700;color:#1c2541;display:flex;align-items:center;gap:8px}
    .pf-card .bd{padding:22px}
    .pf-avatar-wrap{text-align:center;padding:26px 22px}
    .pf-avatar{width:150px;height:150px;border-radius:50%;object-fit:cover;border:4px solid #fff;box-shadow:0 8px 24px rgba(28,37,65,.18);background:#eef0f4}
    .pf-avatar-name{font-size:18px;font-weight:700;color:#1c2541;margin-top:14px}
    .pf-avatar-role{font-size:13px;color:#8b93a4;text-transform:capitalize}
    .pf-upload{display:inline-flex;align-items:center;gap:8px;margin-top:16px;border:1px solid #e2e4ea;border-radius:30px;padding:9px 18px;cursor:pointer;font-size:13px;font-weight:600;color:#1c2541;transition:.15s}
    .pf-upload:hover{border-color:#f54e18;color:#f54e18}
    .pf-upload input{display:none}
    .pf-label{font-weight:600;color:#374151;font-size:13.5px;margin-bottom:5px}
    .pf-hint{font-size:12px;color:#9aa0ac;margin-top:5px}
    .pf-pass-toggle{position:relative}
    .pf-pass-toggle .eye{position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#9aa0ac}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">My Profile</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>My Profile</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0" style="padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form method="POST" action="{{ url('/admin/profile') }}" enctype="multipart/form-data" class="admin_form">
                @csrf
                <div class="row">
                    <!-- Avatar -->
                    <div class="col-lg-4">
                        <div class="pf-card">
                            <div class="pf-avatar-wrap">
                                <img id="pfAvatarImg" class="pf-avatar"
                                     src="{{ !empty($user->avatar) ? asset($user->avatar) : asset('assets2/images/pp.jpg') }}"
                                     onerror="this.src='{{ asset('assets2/images/pp.jpg') }}'" alt="Profile photo">
                                <div class="pf-avatar-name">{{ $user->name }}</div>
                                <div class="pf-avatar-role">{{ $user->role ?: 'Administrator' }}</div>
                                <label class="pf-upload">
                                    <i class="fa fa-camera"></i> <span id="pfUploadText">Change Photo</span>
                                    <input type="file" name="avatar" accept="image/*" id="pfAvatarInput">
                                </label>
                                <div class="pf-hint">JPG, PNG or WebP · square works best</div>
                            </div>
                        </div>
                    </div>

                    <!-- Details + Password -->
                    <div class="col-lg-8">
                        <div class="pf-card">
                            <div class="hd"><i class="fa fa-user text-info"></i> Account Details</div>
                            <div class="bd">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="pf-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="pf-label">Email</label>
                                        <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                        <div class="pf-hint">Email cannot be changed here.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pf-card">
                            <div class="hd"><i class="fa fa-lock text-danger"></i> Change Password</div>
                            <div class="bd">
                                <p class="pf-hint" style="margin-top:0;margin-bottom:16px">Leave these blank if you don't want to change your password.</p>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label class="pf-label">Current Password</label>
                                        <div class="pf-pass-toggle">
                                            <input type="password" class="form-control pf-pass" name="current_password" autocomplete="current-password">
                                            <i class="fa fa-eye eye"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="pf-label">New Password</label>
                                        <div class="pf-pass-toggle">
                                            <input type="password" class="form-control pf-pass" name="new_password" autocomplete="new-password">
                                            <i class="fa fa-eye eye"></i>
                                        </div>
                                        <div class="pf-hint">At least 8 characters.</div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="pf-label">Retype New Password</label>
                                        <div class="pf-pass-toggle">
                                            <input type="password" class="form-control pf-pass" name="new_password_confirmation" autocomplete="new-password">
                                            <i class="fa fa-eye eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
<div class="ttr-overlay"></div>
@endsection
@section('js')
<script>
    (function () {
        var input = document.getElementById('pfAvatarInput');
        if (input) input.addEventListener('change', function () {
            var f = this.files && this.files[0];
            if (!f) return;
            document.getElementById('pfUploadText').textContent = 'Photo selected';
            var reader = new FileReader();
            reader.onload = function (e) { document.getElementById('pfAvatarImg').src = e.target.result; };
            reader.readAsDataURL(f);
        });
        document.querySelectorAll('.pf-pass-toggle .eye').forEach(function (eye) {
            eye.addEventListener('click', function () {
                var inp = this.parentNode.querySelector('input');
                if (inp.type === 'password') { inp.type = 'text'; this.classList.replace('fa-eye', 'fa-eye-slash'); }
                else { inp.type = 'password'; this.classList.replace('fa-eye-slash', 'fa-eye'); }
            });
        });
    })();
</script>
@endsection
