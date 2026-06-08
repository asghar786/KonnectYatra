<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Public newsletter sign-up (footer + "Join us" forms).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:191'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email'    => 'Please enter a valid email address.',
        ]);

        $email = strtolower(trim($validated['email']));

        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            ['source' => $request->input('source', 'website'), 'ip' => $request->ip()]
        );

        $message = $subscriber->wasRecentlyCreated
            ? 'Thank you for subscribing! You will now receive our updates.'
            : 'You are already subscribed — thank you!';

        return redirect()->back()->with('subscribe_status', $message);
    }

    /**
     * Admin: list newsletter subscribers.
     */
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->get();

        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Admin: remove a subscriber.
     */
    public function destroy($id)
    {
        Subscriber::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Subscriber removed.');
    }
}
