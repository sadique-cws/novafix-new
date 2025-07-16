<?php

use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ViewFranchises;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', AdminDashboard::class);
Route::get('admin/add-franchise',AddFranchises::class)->name('admin.add-franchise');
Route::get('admin/manage-franchises',ManageFranchises::class)->name('admin.manage-franchises');
Route::get('/admin/view-franchises/{id}', ViewFranchises::class)
    ->name('admin.view-franchises');
