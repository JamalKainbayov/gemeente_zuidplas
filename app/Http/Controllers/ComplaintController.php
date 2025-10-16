<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location_name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'guest_name' => 'nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
        ]);

        $data['ip_address'] = $request->ip();

        Complaint::create($data);

        return redirect()->back()->with('success', 'Klacht ingediend!');
    }
}

