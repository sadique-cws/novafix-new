<?php

use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ViewFranchises;
use App\Livewire\Franchise\Dashboard;
use App\Livewire\Franchise\Login;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', AdminDashboard::class);
Route::get('admin/add-franchise',AddFranchises::class)->name('admin.add-franchise');
Route::get('admin/manage-franchises',ManageFranchises::class)->name('admin.manage-franchises');
Route::get('/admin/view-franchises/{id}', ViewFranchises::class)
    ->name('admin.view-franchises');


Route::prefix("franchise")->group(function(){
    Route::get("/login", Login::class)->name("franchise.login");
    // Route::middleware(['auth'])->group(function () {
    Route::get("/dashboard", Dashboard::class)->name("franchise.dashboard");
    // });
});
