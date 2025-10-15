<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AdminController;


Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaint.store');


Route::middleware(['auth','is_admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::patch('/admin/complaints/{complaint}/solve', [AdminController::class, 'solve'])->name('admin.complaints.solve');
});
