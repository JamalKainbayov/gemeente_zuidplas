<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    public function index()
    {
        $complaints = Complaint::latest()->get();
        return view('admin.dashboard', compact('complaints'));
    }

    public function resolve(Complaint $complaint): RedirectResponse
    {
        $complaint->update(['status' => 'resolved']);
        return redirect()->back()->with('success', 'Klacht gemarkeerd als opgelost!');
    }

    public function destroy(Complaint $complaint): RedirectResponse
    {
        $complaint->delete();
        return redirect()->back()->with('success', 'Klacht verwijderd!');
    }
}
