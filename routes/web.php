<?php
use App\Livewire\Admin\Solution\StaffAnswers;
use App\Livewire\Auth\{Login,ForgotPassword, ResetPassword};
use App\Livewire\Admin\AddFranchises;
use App\Livewire\Admin\EditFranchise; 
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Franchises\Add;
use App\Livewire\Admin\ManageFranchises;
use App\Livewire\Admin\ManageStaffs;
use App\Livewire\Admin\Performance;
use App\Livewire\Admin\ReceptionstManage;
use App\Livewire\Admin\ReceptionstView;
use App\Livewire\Admin\Solution\ManageBrand;
use App\Livewire\Admin\Solution\ManageDevice;
use App\Livewire\Admin\Solution\ManageModel;
use App\Livewire\Admin\Solution\StaffDiagnosis;
use App\Livewire\Admin\Solution\ManageProblem;
use App\Livewire\Admin\Solution\ServiceSolution;
use App\Livewire\Admin\StaffManage;
use App\Livewire\Admin\StaffView;
use App\Livewire\Admin\ViewFranchises;
use App\Livewire\Franchise\AddReceptioners;
use App\Livewire\Franchise\AddStaff;
use App\Livewire\Franchise\Dashboard;
use App\Livewire\Franchise\ManageCustomer;
use App\Livewire\Franchise\ManageReceptioners;
use App\Livewire\Franchise\ManageService;
use App\Livewire\Franchise\ManagePayments;
use App\Livewire\Franchise\ManageServiceRequest;
use App\Livewire\Franchise\ManageStaff;
use App\Livewire\Franchise\StaffEdit;
use App\Livewire\Franchise\ViewCustomerPayment;
use App\Livewire\Franchise\ViewReceptioners;
use App\Livewire\Franchise\ViewStaff;
use App\Livewire\Frontdesk\CompletedTask;
use App\Livewire\Frontdesk\ManageServiceRequest as FrontdeskManageServiceRequest;
use App\Livewire\Frontdesk\FrontDashboard;
use App\Livewire\Frontdesk\ManagePayment;
use App\Livewire\Frontdesk\EditServiceRequest;
use App\Livewire\Frontdesk\OtpSender;
use App\Livewire\Frontdesk\Profile as FrontdeskProfile;
use App\Livewire\Frontdesk\ReviewServiceRequest;
use App\Livewire\Frontdesk\ServiceRequestForm;
use App\Livewire\Frontdesk\ShowCompletedTask;
use App\Livewire\Frontdesk\SmsSender;
use App\Livewire\Frontdesk\ViewPayments;
use App\Livewire\Frontdesk\ViewTask;
use App\Livewire\Public\Homepage;
use App\Livewire\Staff\AssignedTask;
use App\Livewire\Staff\CompletedTask as StaffCompletedTask;
use App\Livewire\Staff\Dashboard as StaffDashboard;
use App\Livewire\Staff\NovafixDiagnosis;
use App\Livewire\Staff\Profile;
use App\Livewire\Staff\ShowTask;
use App\Services\Msg91Service;
use Illuminate\Support\Facades\Route;
use Illuminate\Types\Relations\Role;

// Public Routes
Route::get("/", Homepage::class)->name('homepage');
Route::get('/login', Login::class)->name('login');
// Password reset routes
// Password reset routes
Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('password.request');
Route::get('/reset-password/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');

// Admin Routes (protected by 'auth:admin' middleware)
Route::prefix("admin")->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::name("admin.")->group(function () {
            Route::get('/logout', function () {
                auth()->guard('admin')->logout();
                return redirect()->route('login');
            })->name('logout');
            Route::get('', AdminDashboard::class)->name('dashboard');
            Route::get('add-franchise', AddFranchises::class)->name('add-franchise');
            Route::get('manage-franchises', ManageFranchises::class)->name('manage-franchises');
            Route::get('manage-staffs', ManageStaffs::class)->name('manage-staffs');
            Route::get('view-franchises/{id}', ViewFranchises::class)->name('view-franchises');
            Route::get('franchises/edit/{id}', EditFranchise::class)->name('edit-franchise');
            Route::get('Franchise-performance', Performance::class)->name('franchise.performance');
            Route::get('Receptionst-Management', ReceptionstManage::class)->name('receptionst.management');
            Route::get('Staff-Management', StaffManage::class)->name('staff.management');
            Route::get('Staff-Management/{id}', StaffView::class)->name('staff.view');
            Route::get('Receptionst-Management/{id}', ReceptionstView::class)->name('Receptionst.view');
            Route::get('solution', ServiceSolution::class)->name('solution');
            Route::get('solution/manage-devices', ManageDevice::class)->name('solution.manage-devices');
            Route::get('solution/manage-brands', ManageBrand::class)->name('solution.manage-brands');
            Route::get('solution/manage-models', ManageModel::class)->name('solution.manage-models');
            Route::get('solution/manage-problems', ManageProblem::class)->name('solution.manage-problems');
            Route::get('solution/staff-diagnosis',StaffDiagnosis::class)->name('solution.staff-diagnosis');
             Route::get('solution/staff-answers',StaffAnswers::class)->name('solution.staff-answers');
        });
    });
});

// Franchise Routes (protected by 'auth:franchise' middleware)
Route::prefix("franchise")->group(function () {
    Route::middleware('auth:franchise')->group(function () {
        Route::name("franchise.")->group(function () {
            Route::get('/logout', function () {
                auth()->guard('franchise')->logout();
                return redirect()->route('login');
            })->name('logout');
            Route::get("/profile", App\Livewire\Franchise\FranchiseProfile::class)->name("profile");
            Route::get("/dashboard", Dashboard::class)->name("dashboard");
            Route::get("/manage/request", ManageServiceRequest::class)->name("manage.request");
            Route::get('/add-receptioners', AddReceptioners::class)->name('add.receptioners');
            Route::get('/manage-receptioners', ManageReceptioners::class)->name('manage.receptioners');
            Route::get('/receptionists/{id}', ViewReceptioners::class)->name('view.receptionist');
            Route::get('/Add-staff', AddStaff::class)->name('add.staff');
            Route::get('/manage-staff', ManageStaff::class)->name('manage.staff');
            Route::get('/manage-staff/edit/{id}', StaffEdit::class)->name('staff.edit');
            Route::get('/staff-view/{id}', ViewStaff::class)->name('view.staff');
            Route::get('/manage-service', ManageService::class)->name('manage.service');
            Route::get('/manage-payments', ManagePayments::class)->name('manage.payments');
            Route::get('/manage-payments/{paymentId}', ViewCustomerPayment::class)->name('payments.view');
            Route::get('/manage-customers', ManageCustomer::class)->name('manage.customer');
        });
    });
});

// Frontdesk Routes (protected by 'auth:frontdesk' middleware)
Route::prefix("frontdesk")->group(function () {
    Route::middleware('auth:frontdesk')->group(function () {
        Route::get('/logout', function () {
            auth()->guard('frontdesk')->logout();
            return redirect()->route('login');
        })->name('frontdesk.logout');
        Route::get("/dashboard", FrontDashboard::class)->name("frontdesk.dashboard");
        Route::get("/service-request/create", ServiceRequestForm::class)->name("frontdesk.servicerequest.create");
        Route::get("/manage/service-request", FrontdeskManageServiceRequest::class)->name("frontdesk.servicerequest.manage");
        Route::get("/service-request/edit/{id}", EditServiceRequest::class)->name('franchise.edit.servicerequest');
        Route::get("/completed/service-request", CompletedTask::class)->name("frontdesk.servicerequest.completed");
        Route::get('/completed/service-request/{requestId}', ShowCompletedTask::class)->name('frontdesk.servicerequest.show');
        Route::get('/view-task/{task}', ViewTask::class)->name('frontdesk.view.task');
        Route::get('/profile', FrontdeskProfile::class)->name('frontdesk.profile');
        Route::get('/manage/payments', ManagePayment::class)->name('frontdesk.manage.payments');
        Route::get('/payment-details/{serviceCode}', ViewPayments::class)->name('frontdesk.payment-details');
        Route::get('/reviewServiceRequest/{id}', ReviewServiceRequest::class)->name('reviewServiceRequest');
    });
});

// Staff Routes (protected by 'auth:staff' middleware)
Route::prefix("staff")->group(function () {
    Route::middleware('auth:staff')->group(function () {
        Route::name("staff.")->group(function () {
            Route::get('logout', function () {
                auth()->guard('staff')->logout();
                return redirect()->route('login');
            })->name('logout');
            Route::get("/dashboard", StaffDashboard::class)->name("dashboard");
            Route::get('/novafix-diagnosis', NovafixDiagnosis::class)->name('novafix-diagnosis');
            Route::get("/assigned-task", AssignedTask::class)->name("assigned.task");
            Route::get("/task/{task}", ShowTask::class)->name("task.show");
            Route::get("/completed-task", StaffCompletedTask::class)->name("completed.task");
            Route::get("/profile", Profile::class)->name("profile");
        });
    });
});