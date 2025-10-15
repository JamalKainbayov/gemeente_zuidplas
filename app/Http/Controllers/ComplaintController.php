<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function create() {
        return view('complaints.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'latitude'=>'required|numeric',
            'longitude'=>'required|numeric',
            'guest_name'=>'nullable',
            'guest_email'=>'nullable|email',
        ]);

        Complaint::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'location_name'=>$request->location_name,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'guest_name'=>$request->guest_name,
            'guest_email'=>$request->guest_email,
            'ip_address'=>$request->ip(),
        ]);

        return redirect()->back()->with('success','Klacht ingediend!');
    }

}
