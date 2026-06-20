@extends('admin.layouts.app')
@section('content')
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="db-breadcrumb">
            <h4 class="breadcrumb-title">Payment Settings</h4>
            <ul class="db-breadcrumb-list">
                <li><a href="{{ url('/admin/dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
                <li>Payment Settings</li>
            </ul>
        </div>
        <div class="main-body">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

            <p class="text-muted">These details are shown to travellers on the payment page based on the payment method they choose. The amount due is taken automatically from the package price they selected.</p>

            <form method="POST" action="{{ url('admin/payment-settings') }}">
                @csrf
                <div class="row">
                    <!-- Bank Wire Transfer -->
                    <div class="col-lg-6">
                        <div class="card" style="border-radius:14px">
                            <div class="card-body">
                                <h5 style="font-weight:700"><i class="fas fa-building-columns text-primary"></i> Bank Wire Transfer</h5>
                                <p class="text-muted">Shown when the traveller selects "Paid by Bank Wire Transfer".</p>
                                <div class="form-group">
                                    <label class="form_label_color">Bank Name</label>
                                    <input type="text" name="pay_bank_name" class="form-control" value="{{ $pay_bank_name }}" placeholder="e.g. Chase Bank">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Account Title</label>
                                    <input type="text" name="pay_bank_account_title" class="form-control" value="{{ $pay_bank_account_title }}" placeholder="e.g. Konnect.us, Inc.">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Routing Number</label>
                                    <input type="text" name="pay_bank_routing" class="form-control" value="{{ $pay_bank_routing }}" placeholder="e.g. 021000021">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Account Number</label>
                                    <input type="text" name="pay_bank_account" class="form-control" value="{{ $pay_bank_account }}" placeholder="e.g. 1234567890">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Additional Instructions <span class="text-muted">(optional)</span></label>
                                    <textarea name="pay_bank_instructions" class="form-control" rows="3" placeholder="e.g. Please email the transfer receipt to ...">{{ $pay_bank_instructions }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Check -->
                    <div class="col-lg-6">
                        <div class="card" style="border-radius:14px">
                            <div class="card-body">
                                <h5 style="font-weight:700"><i class="fas fa-money-check text-success"></i> Paid by Check</h5>
                                <p class="text-muted">Shown when the traveller selects "Paid by Check".</p>
                                <div class="form-group">
                                    <label class="form_label_color">Make Check Payable To (Account Title)</label>
                                    <input type="text" name="pay_check_payable_to" class="form-control" value="{{ $pay_check_payable_to }}" placeholder="e.g. Konnect.us, Inc.">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Account Number <span class="text-muted">(optional)</span></label>
                                    <input type="text" name="pay_check_account" class="form-control" value="{{ $pay_check_account }}" placeholder="e.g. 1234567890">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Mailing Address</label>
                                    <textarea name="pay_check_mail_address" class="form-control" rows="3" placeholder="e.g. 185-02 Hillside Ave, Jamaica, NY 11432">{{ $pay_check_mail_address }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Additional Instructions <span class="text-muted">(optional)</span></label>
                                    <textarea name="pay_check_instructions" class="form-control" rows="2">{{ $pay_check_instructions }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cash -->
                    <div class="col-lg-6">
                        <div class="card" style="border-radius:14px">
                            <div class="card-body">
                                <h5 style="font-weight:700"><i class="fas fa-money-bill-wave text-warning"></i> Paid by Cash</h5>
                                <p class="text-muted">Shown when the traveller selects "Paid by Cash".</p>
                                <div class="form-group">
                                    <label class="form_label_color">Office Location / Address</label>
                                    <textarea name="pay_cash_address" class="form-control" rows="3" placeholder="e.g. 148-36 Guy R Brewer Blvd, Suite #202A, Jamaica, NY 11434">{{ $pay_cash_address }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Office Hours / Instructions <span class="text-muted">(optional)</span></label>
                                    <textarea name="pay_cash_instructions" class="form-control" rows="2" placeholder="e.g. Mon–Fri, 10am–6pm. Please call before visiting.">{{ $pay_cash_instructions }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Google Maps Link <span class="text-muted">(optional)</span></label>
                                    <input type="url" name="pay_cash_map_url" class="form-control" value="{{ $pay_cash_map_url }}" placeholder="https://maps.app.goo.gl/...">
                                    <small class="text-muted">Paste your office's Google Maps share link for the "Get Directions" button. If left empty, the map uses the office address above.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary">Save Payment Settings</button>
            </form>
        </div>
    </div>
</main>
@endsection
