<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('welcome'); });

Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaint.store');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/complaints/{complaint}/resolve', [AdminController::class, 'resolve'])->name('admin.complaint.resolve');
    Route::delete('/admin/complaints/{complaint}', [AdminController::class, 'destroy'])->name('admin.complaint.destroy');
});

require __DIR__.'/auth.php';
