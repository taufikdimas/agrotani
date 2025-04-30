<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('settings.index', compact('settings'));
    }

    public function edit($group)
    {
        $settings = Setting::where('group', $group)->get();
        return view('settings.edit', compact('settings', 'group'));
    }

    public function update(Request $request, $group)
    {
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable'
        ]);

        foreach ($validated['settings'] as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui');
    }
}