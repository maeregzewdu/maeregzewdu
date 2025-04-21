<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyInfo;

class MyInfoController extends Controller
{
    public function toggleStatus(Request $request, MyInfo $myInfo)
    {
        $myInfo->is_active = $request->input('is_active');
        $myInfo->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function update(Request $request, MyInfo $myInfo)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        
        $myInfo->update($validated);

        return response()->json(['message' => 'My info updated successfully']);
    }
}
