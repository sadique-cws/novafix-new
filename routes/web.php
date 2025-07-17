<?php

use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ViewFranchises;
use App\Livewire\Franchise\AddReceptioners;
use App\Livewire\Franchise\Dashboard;
use App\Livewire\Franchise\Login;
use App\Livewire\Franchise\ManageReceptioners;
use App\Livewire\Franchise\ManageServiceRequest;
use App\Livewire\Franchise\ViewReceptioners;
use App\Livewire\Frontdesk\ManageServiceRequest as FrontdeskManageServiceRequest;
use App\Livewire\Frontdesk\FrontDashboard;
use App\Livewire\Frontdesk\FrontDeskLogin;
use App\Livewire\Frontdesk\ServiceRequestForm;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix("admin")->group(function () {
    // admin login route here
    Route::name("admin.")->group(function () {
        // Route::middleware("auth")->group(function(){
        Route::get('', AdminDashboard::class)->name('dashboard');
        Route::get('add-franchise', AddFranchises::class)->name('add-franchise');
        Route::get('manage-franchises', ManageFranchises::class)->name('manage-franchises');
        Route::get('view-franchises/{id}', ViewFranchises::class)->name('view-franchises');
    });
});
// });

Route::prefix("franchise")->group(function () {
    Route::name("franchise.")->group(function () {
        Route::get("/login", Login::class)->name("login");
        // Route::middleware(['auth'])->group(function () {
        //logout 
        Route::post('/logout', function () {
            auth()->guard('franchise')->logout();
            return redirect()->route('franchise.login');
        })->name('logout');
       
        Route::get("/dashboard", Dashboard::class)->name("dashboard");
        // });
        Route::get("/manage/request", ManageServiceRequest::class)->name("manage.request");
        Route::get('/add-receptioners', AddReceptioners::class)->name('add.receptioners');
        Route::get('/manage-receptioners', ManageReceptioners::class)->name('manage.receptioners');
        Route::get('/receptionists/{id}', ViewReceptioners::class)
            ->name('view.receptionist');
    });
});

Route::prefix("frontdesk")->group(function(){
    Route::get("/login", FrontDeskLogin::class)->name("frontdesk.login");
    // Route::middleware(['auth'])->group(function () {
    Route::get("/service-request/create", ServiceRequestForm::class)->name("frontdesk.servicerequest.create");
    Route::get("/dashboard", FrontDashboard::class)->name("frontdesk.dashboard");
    Route::get("/manage/service-request", FrontdeskManageServiceRequest::class)->name("frontdesk.servicerequest.manage");
    // });
});
