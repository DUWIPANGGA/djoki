<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PrivacySetting;
use Illuminate\Http\Request;

class PrivacySettingController extends Controller
{
    public function edit(Request $request)
    {
        $settings = PrivacySetting::firstOrCreate(['user_id' => $request->user()->id]);

        return view('djoki.privacy-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = PrivacySetting::firstOrCreate(['user_id' => $request->user()->id]);
        $validated = $request->validate([
            'profile_public' => 'boolean',
            'show_portfolio' => 'boolean',
            'allow_direct_messages' => 'boolean',
            'encrypt_stored_files' => 'boolean',
            'anonymize_reviews' => 'boolean',
        ]);
        $settings->update($validated);

        return redirect()->route('privacy-settings.edit')->with('success', 'Pengaturan privasi disimpan.');
    }
}
