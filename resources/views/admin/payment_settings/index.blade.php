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

            <form method="POST" action="{{ url('admin/payment-settings') }}" enctype="multipart/form-data">
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
                    <!-- Zelle -->
                    <div class="col-lg-6">
                        <div class="card" style="border-radius:14px">
                            <div class="card-body">
                                <h5 style="font-weight:700"><i class="fas fa-mobile-screen-button text-info"></i> Pay by Zelle</h5>
                                <p class="text-muted">Shown when the traveller selects "Paid by Zelle".</p>
                                <div class="form-group">
                                    <label class="form_label_color">Recipient Name</label>
                                    <input type="text" name="pay_zelle_name" class="form-control" value="{{ $pay_zelle_name }}" placeholder="e.g. Konnect.us, Inc.">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Zelle Phone Number</label>
                                    <input type="text" name="pay_zelle_phone" class="form-control" value="{{ $pay_zelle_phone }}" placeholder="e.g. +1 (718) 908-9464">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Zelle Email <span class="text-muted">(optional)</span></label>
                                    <input type="text" name="pay_zelle_email" class="form-control" value="{{ $pay_zelle_email }}" placeholder="e.g. payments@konnect.us">
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Account Shown in Zelle <span class="text-muted">(optional)</span></label>
                                    <input type="text" name="pay_zelle_account" class="form-control" value="{{ $pay_zelle_account }}" placeholder="e.g. BUS COMPLETE CHK (…9855)">
                                    <small class="text-muted">Copy it exactly as Zelle displays it, so a payer can check they have the right account.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Additional Instructions <span class="text-muted">(optional)</span></label>
                                    <textarea name="pay_zelle_instructions" class="form-control" rows="3" placeholder="e.g. Kindly test the account by sending $1 first. Upon confirmation, transfer the full / balance amount to the given number.">{{ $pay_zelle_instructions }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form_label_color">Zelle QR Code</label>
                                    <p class="text-muted mb-2" style="font-size:13px">
                                        Printed on the Yatri application form so a candidate can scan and pay.
                                        In your bank's app open Zelle &rarr; <b>Scan or Share Code</b> &rarr; <b>My code</b>, then save or share the image and upload it here.
                                    </p>
                                    @if(!empty($pay_zelle_qr))
                                    <div class="d-flex align-items-center mb-2" style="gap:14px">
                                        <img src="{{ asset(\App\Http\Controllers\Admin\PaymentSettingController::QR_DIRECTORY.'/'.$pay_zelle_qr) }}" alt="Zelle QR code" style="width:120px;height:120px;object-fit:contain;border:1px solid #e3e6ec;border-radius:8px;padding:6px;background:#fff">
                                        <label class="mb-0" style="font-weight:500">
                                            <input type="checkbox" name="remove_zelle_qr" value="1"> Remove this code
                                        </label>
                                    </div>
                                    @else
                                    <p class="text-danger mb-2" style="font-size:13px"><i class="fa fa-exclamation-triangle"></i> No code uploaded — the form prints payment details without a QR code.</p>
                                    @endif
                                    <input type="file" name="pay_zelle_qr" class="form-control" accept="image/*">
                                    <small class="text-muted">JPG, PNG or WebP, up to 4&nbsp;MB. Uploading a new code replaces the old one.</small>
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
