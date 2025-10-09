<?php

use App\Http\Controllers\ComplaintController;

Route::get('/klachten', [ComplaintController::class, 'index'])->name('complaints.index');
Route::get('/klachten/nieuw', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/klachten', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/klachten/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
