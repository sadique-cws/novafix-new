<?php

use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ViewFranchises;
use App\Livewire\Franchise\Dashboard;
use App\Livewire\Franchise\Login;
use App\Livewire\Franchise\ManageServiceRequest;
use App\Livewire\Frontdesk\ManageServiceRequest as FrontdeskManageServiceRequest;
use App\Livewire\Frontdesk\FrontDashboard;
use App\Livewire\Frontdesk\FrontDeskLogin;
use App\Livewire\Frontdesk\ServiceRequestForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix("admin")->group(function(){
    // admin login route here
    Route::name("admin.")->group(function(){
        // Route::middleware("auth")->group(function(){
            Route::get('', AdminDashboard::class)->name('dashboard');
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

Route::prefix("frontdesk")->group(function(){
    Route::get("/login", FrontDeskLogin::class)->name("frontdesk.login");
    // Route::middleware(['auth'])->group(function () {
    Route::get("/service-request/create", ServiceRequestForm::class)->name("frontdesk.servicerequest.create");
    Route::get("/dashboard", FrontDashboard::class)->name("frontdesk.dashboard");
    Route::get("/manage/service-request", FrontdeskManageServiceRequest::class)->name("frontdesk.servicerequest.manage");
    // });
});
