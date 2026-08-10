<?php

namespace App\Http\Controllers;

use App\Mail\GurdwaraLeadMail;
use App\Models\GurdwaraLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GurdwaraLeadController extends Controller
{
    /**
     * Public: homepage "Near Gurdwara Sahib" popup submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:255'],
            'middle_name'   => ['nullable', 'string', 'max:255'],
            'last_name'     => ['required', 'string', 'max:255'],
            'father_name'   => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:40'],
            'email'         => ['required', 'email', 'max:255'],
            'city'          => ['required', 'string', 'max:255'],
            'state'         => ['required', 'string', 'max:255'],
            'zip_code'      => ['required', 'string', 'max:20'],
            'yatri_count'   => ['required', 'integer', 'min:1', 'max:999'],
            'near_gurdwara' => ['required', 'string', 'max:255'],
            'heard_from'    => ['required', 'string', 'in:Facebook,Friends,Gurdwara Sahib,Others'],
        ], [], [
            // Errors surface in the popup's banner, so keep the wording human.
            'father_name'   => "father's name",
            'phone'         => 'telephone',
            'zip_code'      => 'zip code',
            'yatri_count'   => 'number of Yatri interested',
            'near_gurdwara' => 'nearest Gurdwara Sahib',
            'heard_from'    => 'how you knew about Konnect Yatra USA',
        ]);

        $lead = GurdwaraLead::create($validated);

        try {
            Mail::to(\App\Support\BookingMailer::ADMIN_EMAIL)->send(new GurdwaraLeadMail($lead->toArray()));
        } catch (\Throwable $e) {
            Log::error('Gurdwara lead notification email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! We have received your details.',
        ]);
    }

    /**
     * Admin: list submissions.
     */
    public function index()
    {
        $leads = GurdwaraLead::orderBy('created_at', 'desc')->get();

        return view('admin.gurdwara-leads.index', compact('leads'));
    }

    /**
     * Admin: remove a submission.
     */
    public function destroy($id)
    {
        GurdwaraLead::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Submission removed.');
    }
}
