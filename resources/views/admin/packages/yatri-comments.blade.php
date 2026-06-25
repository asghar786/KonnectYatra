@extends('admin.layouts.app')
@section('content')
<style>
    .cm-card{background:#fff;border:1px solid #eef0f4;border-radius:16px;box-shadow:0 8px 28px rgba(28,37,65,.07);padding:22px;margin-bottom:20px}
    .cm-head{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:6px}
    .cm-title{font-weight:700;color:#1f2a44;font-size:18px;margin:0}
    .cm-sub{color:#7b8499;font-size:13px}
    .cm-form textarea{width:100%;border:1px solid #e2e2e2;border-radius:12px;padding:12px 14px;outline:none;resize:vertical;min-height:90px}
    .cm-form textarea:focus{border-color:#f54e18;box-shadow:0 0 0 3px rgba(245,78,24,.12)}
    .cm-btn{background:#1f2a44;color:#fff;border:none;border-radius:10px;padding:10px 20px;font-weight:600;font-size:14px;cursor:pointer}
    .cm-btn:hover{background:#33415f}
    .cm-item{display:flex;gap:14px;padding:16px 0;border-bottom:1px solid #f0f2f6}
    .cm-item:last-child{border-bottom:0}
    .cm-avatar{flex:0 0 40px;width:40px;height:40px;border-radius:50%;background:#eef1f6;color:#5a6273;display:flex;align-items:center;justify-content:center;font-size:16px}
    .cm-body{flex:1;min-width:0}
    .cm-meta{display:flex;gap:10px;align-items:baseline;flex-wrap:wrap;margin-bottom:3px}
    .cm-author{font-weight:700;color:#1f2a44}
    .cm-time{color:#98a2b5;font-size:12px}
    .cm-text{color:#2c3446;font-size:14px;white-space:pre-wrap;word-break:break-word}
    .cm-empty{color:#98a2b5;text-align:center;padding:30px}
</style>
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="breadcrumb-title mb-0">Communication Log</h4>
                <ul class="db-breadcrumb-list">
                    <li><a href="{{ route('yatri-visa') }}"><i class="fa fa-home"></i>Yatri Bookings</a></li>
                    <li>Comments</li>
                </ul>
            </div>
            <a href="{{ route('yatri-visa') }}" class="cm-btn"><i class="fa fa-arrow-left"></i> Back to Bookings</a>
        </div>

        <div class="main-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="cm-card">
                <div class="cm-head">
                    <div>
                        <p class="cm-title">{{ trim($yatri->first_name.' '.$yatri->last_name) ?: 'Yatri' }}</p>
                        <span class="cm-sub">Yatri #{{ $yatri->yatri_id }} &middot; {{ $yatri->email ?: '—' }} &middot; {{ $yatri->phone ?: '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="cm-card">
                <h6 style="font-weight:700;color:#1f2a44;margin-bottom:12px;">Add a comment</h6>
                <form class="cm-form" method="POST" action="{{ route('yatri-comments-store', $yatri->id) }}">
                    @csrf
                    <textarea name="comment" placeholder="e.g. Called the traveller to confirm passport details — will email the invoice tomorrow." required></textarea>
                    @error('comment')<small class="text-danger">{{ $message }}</small>@enderror
                    <div class="mt-3"><button type="submit" class="cm-btn"><i class="fa fa-paper-plane"></i> Add Comment</button></div>
                </form>
            </div>

            <div class="cm-card">
                <h6 style="font-weight:700;color:#1f2a44;margin-bottom:6px;">History ({{ $yatri->comments->count() }})</h6>
                @forelse($yatri->comments as $comment)
                    <div class="cm-item">
                        <div class="cm-avatar"><i class="fa fa-user"></i></div>
                        <div class="cm-body">
                            <div class="cm-meta">
                                <span class="cm-author">{{ $comment->author ?: 'Staff' }}</span>
                                <span class="cm-time">{{ optional($comment->created_at)->format('d M Y, h:i A') }}</span>
                            </div>
                            <div class="cm-text">{{ $comment->comment }}</div>
                        </div>
                    </div>
                @empty
                    <div class="cm-empty">No comments yet. Add the first note about this traveller above.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="ttr-overlay"></div>
</main>
@endsection
