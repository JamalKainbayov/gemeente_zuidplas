<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $complaints = Complaint::latest()->get();
        return view('admin.dashboard', compact('complaints'));
    }

    public function solve(Complaint $complaint) {
        $complaint->solved = true;
        $complaint->save();
        return redirect()->back()->with('success','Klacht opgelost!');
    }

}
