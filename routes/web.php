<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MyProjectController;
use App\Http\Controllers\QrscannerController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\SalaryOverviewController;
use App\Http\Controllers\CheckInCheckOutController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskDraggableController;

Auth::routes(['register'=>false]);

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::resource('employee', EmployeeController::class);
    Route::get('/employee/datatable/data', [EmployeeController::class,'datatable'])->name('datatable.data');

    Route::resource('/company-setting', CompanySettingController::class);

    Route::resource('department', DepartmentController::class);
    Route::get('/department/datatable/data', [DepartmentController::class,'datatable'])->name('department.datatable.data');

    Route::get('/profile', [ProfileController::class,'index'])->name('profile');

    Route::resource('roles', RoleController::class);
    Route::get('/roles/datatable/data', [RoleController::class,'datatable'])->name('roles.datatable.data');

    Route::resource('permission', PermissionController::class);
    Route::get('/permission/datatable/data', [PermissionController::class,'datatable'])->name('permission.datatable.data');

    Route::resource('attendence', AttendenceController::class);
    Route::get('/attendence/datatable/data', [AttendenceController::class,'datatable'])->name('attendence.datatable.data');
    Route::get('/my-attendence/datatable/data', [AttendenceController::class,'myDatatable'])->name('my-attendence.datatable.data');
    Route::get('/attendance/overview', [AttendenceController::class,'overview'])->name('attendance.overview');
    Route::get('/attendance/overview/table', [AttendenceController::class,'overviewTable']);
    Route::get('/my-attendance/overview/table', [AttendenceController::class,'myOverviewTable']);

    Route::get('/qr-scanner', [QrscannerController::class,'qrScanner'])->name('attendance.qr-scanner');
    Route::post('/chekin-checkout/scanner', [QrscannerController::class,'checkScanner']);

    Route::resource('/salary', SalaryController::class);
    Route::get('/salary/datatable/data', [SalaryController::class,'datatable'])->name('salary.datatable.data');
    Route::get('/overview/salary', [SalaryOverviewController::class,'salaryOverview'])->name('overview.salary');
    Route::get('/salary/overview/table', [SalaryOverviewController::class,'overviewTable']);
    Route::get('/my-salary/overview/table', [SalaryOverviewController::class,'myOverviewTable']);

    Route::resource('project', ProjectController::class);
    Route::get('/project/datatable/data', [ProjectController::class,'datatable'])->name('project.datatable.data');

    Route::resource('/my-project', MyProjectController::class);
    Route::get('/my-project/datatable/data', [MyProjectController::class,'datatable'])->name('my-project.datatable.data');

    Route::resource('/task', TaskController::class)->only(['store','update','destroy']);
    Route::get('/task-data', [TaskController::class,'taskData']);

    Route::post('/taskDraggable', [TaskDraggableController::class,'taskData']);
});

Route::get('/checkin-checkout', [CheckInCheckOutController::class,'index']);
Route::post('/pincode', [CheckInCheckOutController::class,'checkPincode']);
