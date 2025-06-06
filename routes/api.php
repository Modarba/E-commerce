<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    });
Route::prefix('admin/products')
    ->name('admin.products.')
    ->middleware(['auth:sanctum', 'role:admin'])
    ->group(function () {
        Route::post('/', [AdminController::class, 'addProduct'])->name('store');
        Route::get('/', [AdminController::class, 'showProduct'])->name('index');
        Route::put('{id}', [AdminController::class, 'updateProduct'])->name('update');
        Route::put('{id}', [AdminController::class, 'updateStatus'])->name('update');
        Route::delete('{id}', [AdminController::class, 'deleteProduct'])->name('destroy');
    });
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth:sanctum', 'role:user'])
    ->group(function () {
        Route::post('search', [UserController::class, 'searchProduct'])->name('products.search');
        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::post('/', [UserController::class, 'makeOrder'])->name('store');
                Route::get('/', [UserController::class, 'orderForUser'])->name('index');
                Route::delete('{id}', [UserController::class, 'cancelOrder'])->name('destroy');
            });
        Route::prefix('order-products')->name('orderProducts.')->group(function () {
            Route::delete('{id}', [UserController::class, 'removeProductOrder'])->name('destroy');
            Route::put('{id}', [UserController::class, 'updateProductOrder'])->name('update');
        });
        Route::prefix('queryProduct')
            ->name('query.')
            ->group(function () {
                Route::get('/',[\App\Http\Controllers\Query\QueryController::class,'queryProduct'])->name('query');
            });
        Route::prefix('queryOrder')
            ->name('query.')
            ->group(function () {
                Route::get('/',[\App\Http\Controllers\Query\QueryController::class,'queryOrder'])->name('query');
            });
        Route::prefix('userQuery')
            ->name('user.')
            ->group(function () {
                Route::get('/',[\App\Http\Controllers\Query\QueryController::class,'queryUser'])->name('query');
            });
        Route::prefix('orderProductQuery')->name('orderProductQuery.')
            ->group(function () {
                Route::get('/',[\App\Http\Controllers\Query\QueryController::class,'queryOrderProduct'])->name('query');
            });
        Route::prefix('payments')
            ->name('payments.')
            ->group(function () {
                Route::post('/', [UserController::class, 'payment'])->name('process');
            });
    });
