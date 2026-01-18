<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebhookController extends Controller
{
    public function index()
    {
        $webhooks = Auth::user()->webhooks()->get();
        return view('webhooks.index', compact('webhooks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
        ]);

        Auth::user()->webhooks()->create([
            'url' => $validated['url'],
            'events' => ['sales_signal_detected'],
        ]);

        return redirect()->back()->with('success', 'Webhook added successfully.');
    }

    public function destroy(Webhook $webhook)
    {
        // Policy check should be here, assuming one user owns it
        if ($webhook->user_id !== Auth::id()) {
            abort(403);
        }

        $webhook->delete();

        return redirect()->back()->with('success', 'Webhook deleted.');
    }
}
