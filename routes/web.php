<?php

use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UsersController;
use App\Mail\TemplateDeadlineReminder;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email', function () {
    $user = App\Models\User::first(); // user to test
    $template = App\Models\Template::first(); // template to test

    Mail::to('iacob.eliza12@gmail.com')->send(new TemplateDeadlineReminder($template, $user));
    Mail::to('iacob.eliza12@yahoo.com')->send(new TemplateDeadlineReminder($template, $user));

    return 'Test email sent!';
});


Route::middleware(['web'])->group(function () {
    Route::get('/register', [UsersController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UsersController::class, 'register']);

    Route::get('/login', [UsersController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UsersController::class, 'login']);
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
    Route::get('/reports/history', [ReportsController::class, 'reportHistory'])->name('reports.history');
    Route::post('/reports/share', [ReportsController::class, 'shareReport'])->name('reports.share');
    Route::post('/reports/{templateId}', [ReportsController::class, 'generateReport'])->name('reports.generate');
    Route::get('/reports/shared', [ReportsController::class, 'sharedWithMe'])->name('reports.shared');
    Route::get('/reports/download/{id}', [ReportsController::class, 'downloadReport'])->name('reports.download');
    Route::delete('/reports/{id}', [ReportsController::class, 'deleteReport'])->name('reports.delete');
    Route::get('/reports/create/{templateId}', [ReportsController::class, 'showForm'])->name('create.reports');
    Route::get('/user-templates', [TemplateController::class, 'userTemplates'])->name('user.templates');
    Route::post('/reports/upload/{templateId}', [ReportsController::class, 'upload'])->name('reports.upload');
});
Route::middleware(['web', 'auth', 'is_admin'])->group(function () {
    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::delete('/templates/{id}', [TemplateController::class, 'destroy'])->name('templates.delete');
    Route::get('/templates/{id}/reports', [TemplateController::class, 'showReports'])->name('templates.reports');
    Route::get('/admin/reports/download/{id}', [ReportsController::class, 'adminDownloadReport'])->name('admin.reports.download');
    Route::get('/admin/reports/downloadAll/{templateId}', [ReportsController::class, 'adminDownloadAllReports'])->name('admin.reports.downloadAll');
});
