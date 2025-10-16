<?php

namespace App\Http\Controllers;

use App\Models\Complaint;

class AdminController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->get();
        return view('admin.dashboard', compact('complaints'));
    }
}

