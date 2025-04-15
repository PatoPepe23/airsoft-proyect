<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostControllerAdvance;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\PartidaController;

use App\Http\Controllers\reservarController;

use App\Http\Controllers\Api\SendMailController;

use App\Http\Controllers\Api\discountController;



Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::post('posts/{id}', [PostControllerAdvance::class,'cancel']);

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::post('users', [UserController::class,'update']); //Listar
    Route::get('users', [UserController::class,'index']);
    Route::get('users/{user}', [UserController::class,'show']);
//    Route::apiResource('users', UserController::class);


    Route::apiResource('posts', PostControllerAdvance::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);

    Route::get('role-list', [RoleController::class, 'getList']);
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);
    Route::apiResource('permissions', PermissionController::class);

    Route::get('category-list', [CategoryController::class, 'getList']);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);



    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});

Route::get('category-list', [CategoryController::class, 'getList']);

Route::get('get-posts', [PostControllerAdvance::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostControllerAdvance::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostControllerAdvance::class, 'getPost']);

Route::get('note', [NoteController::class, 'index'])->name('note.index');
Route::post('note', [NoteController::class, 'store'])->name('note.store');
Route::get('note/{id}', [NoteController::class, 'show'])->name('note.show');
Route::put('note/{id}', [NoteController::class, 'update'])->name('note.update');
Route::delete('note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');

//Route::get('/partidas', [PartidaController::class, 'index']);
Route::get('/partidas', [PartidaController::class, 'index']);

Route::post('/reservar', [reservarController::class, 'store']);

Route::post('/send-mail', [SendMailController::class, 'send']);

Route::post('/discount', [discountController::class, 'store']);
