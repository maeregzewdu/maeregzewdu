<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SocialLink;

class SocialLinkController extends Controller
{
    public function toggleStatus(Request $request, SocialLink $socialLink)
    {
        $socialLink->update(['is_active' => $request->input('is_active')]);
        return response()->json(['success' => true]);
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $socialLink->update($validated);
        return response()->json(['socialLink' => $socialLink]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ]);

        $socialLink = SocialLink::create($validated);
        return response()->json(['success' => true, 'socialLink' => $socialLink]);
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        return response()->json(['success' => true, 'message' => 'Social link deleted successfully']);
    }
}
