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
        // Zelle
        'pay_zelle_name',
        'pay_zelle_phone',
        'pay_zelle_email',
        'pay_zelle_account',
        'pay_zelle_instructions',
    ];

    /** Where the uploaded Zelle QR code lives, relative to public/. */
    public const QR_DIRECTORY = 'assets/payment';
    public const QR_KEY       = 'pay_zelle_qr';

    public function index()
    {
        $data = [];
        foreach ($this->keys as $key) {
            $data[$key] = SiteSetting::get($key);
        }
        $data[self::QR_KEY] = SiteSetting::get(self::QR_KEY);
        return view('admin.payment_settings.index', $data);
    }

    public function update(Request $request)
    {
        foreach ($this->keys as $key) {
            if ($request->has($key)) {
                SiteSetting::put($key, trim((string) $request->input($key)));
            }
        }

        // Zelle QR code. Rashad exports this from his bank's app, and it changes
        // if the account does, so it is uploaded here rather than committed.
        if ($request->hasFile(self::QR_KEY)) {
            $request->validate([
                self::QR_KEY => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            $file     = $request->file(self::QR_KEY);
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path(self::QR_DIRECTORY), $fileName);

            $this->deleteQr(SiteSetting::get(self::QR_KEY));
            SiteSetting::put(self::QR_KEY, $fileName);
        } elseif ($request->boolean('remove_zelle_qr')) {
            $this->deleteQr(SiteSetting::get(self::QR_KEY));
            SiteSetting::put(self::QR_KEY, '');
        }

        return redirect(url('admin/payment-settings'))->with('success', 'Payment settings saved.');
    }

    /** Remove a superseded QR image so the folder does not collect dead files. */
    private function deleteQr(?string $fileName): void
    {
        if (empty($fileName)) {
            return;
        }
        $path = public_path(self::QR_DIRECTORY . '/' . basename($fileName));
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
