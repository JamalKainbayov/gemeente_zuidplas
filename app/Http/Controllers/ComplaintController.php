<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->get();
        return view('complaints.index', compact('complaints'));
    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Complaint::create($request->all());

        return redirect()->route('complaints.index')
            ->with('success', 'Uw klacht is succesvol ingediend!');
    }

    public function show(Complaint $complaint)
    {
        return view('complaints.show', compact('complaint'));
    }
}

