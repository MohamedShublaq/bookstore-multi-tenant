<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Http\Requests\Library\Settings\toggleWebsiteStatusRequest;

class SettingsController extends Controller
{
    public function index()
    {
        $library = app('library');
        return view('Library.settings', compact('library'));
    }

    public function toggleWebsiteStatus(toggleWebsiteStatusRequest $request)
    {
        try {
            $library = app('library');
            $inactiveMessage = trim($request->inactive_message);
            $library->update([
                'is_published'     => $request->is_published,
                'inactive_message' => $inactiveMessage !== '' ? $inactiveMessage : null
            ]);
            return redirect()->back()->with('success', 'Operation Done Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Operation Failed');
        }
    }
}
