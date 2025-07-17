<?php

use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ViewFranchises;
use App\Livewire\Franchise\Dashboard;
use App\Livewire\Franchise\Login;
use App\Livewire\Franchise\ManageServiceRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix("admin")->group(function(){
    // admin login route here
    Route::name("admin")->group(function(){
        // Route::middleware("auth")->group(function(){
            Route::get('', AdminDashboard::class);
            Route::get('add-franchise',AddFranchises::class)->name('add-franchise');
            Route::get('manage-franchises',ManageFranchises::class)->name('manage-franchises');
            Route::get('view-franchises/{id}', ViewFranchises::class)->name('view-franchises');
        });
    });
// });

Route::prefix("franchise")->group(function(){
    Route::get("/login", Login::class)->name("franchise.login");
    // Route::middleware(['auth'])->group(function () {
    Route::get("/dashboard", Dashboard::class)->name("franchise.dashboard");
    // });
    Route::get("/manage/request", ManageServiceRequest::class)->name("franchise.manage.request");
});
