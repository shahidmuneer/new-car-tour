<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PlansController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

Route::get('plans/list', [PlansController::class, 'index'])
    ->name('plans.list')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.plans.list'));
    });
Route::get('plans/create', [PlansController::class, 'create'])
    ->name('plans.list.create')
    ->breadcrumbs(function (Trail $trail) {
        $trail->parent('admin.plans.list')
            ->push("Create Plans", route('admin.plans.list.create'));
    });
