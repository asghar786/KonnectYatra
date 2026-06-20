<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PaymentSettingController extends Controller
{
    /** All payment-instruction setting keys. */
    private array $keys = [
        // Bank Wire Transfer
        'pay_bank_name',
        'pay_bank_account_title',
        'pay_bank_routing',
        'pay_bank_account',
        'pay_bank_instructions',
        // Check
        'pay_check_payable_to',
        'pay_check_account',
        'pay_check_mail_address',
        'pay_check_instructions',
        // Cash
        'pay_cash_address',
        'pay_cash_instructions',
        'pay_cash_map_url',
    ];

    public function index()
    {
        $data = [];
        foreach ($this->keys as $key) {
            $data[$key] = SiteSetting::get($key);
        }
        return view('admin.payment_settings.index', $data);
    }

    public function update(Request $request)
    {
        foreach ($this->keys as $key) {
            if ($request->has($key)) {
                SiteSetting::put($key, trim((string) $request->input($key)));
            }
        }
        return redirect(url('admin/payment-settings'))->with('success', 'Payment settings saved.');
    }
}
