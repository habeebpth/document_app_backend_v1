<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SettingsController;
<<<<<<< HEAD
use App\Http\Controllers\UserController; // <-- Added
=======
>>>>>>> 9953726449f6cec3f1c51ad7166a16ea263cae0b

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
<<<<<<< HEAD
*/

Auth::routes();

// ---------------------- Categories ----------------------
=======
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
//Language Translation



// Route::get('categories/datatable', [CategoryController::class, 'datatable'])->name('categories.datatable');
// Route::resource('categories', CategoryController::class);
>>>>>>> 9953726449f6cec3f1c51ad7166a16ea263cae0b
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

<<<<<<< HEAD
// ---------------------- Tags ----------------------
=======
// Tags routes with AJAX/DataTables
>>>>>>> 9953726449f6cec3f1c51ad7166a16ea263cae0b
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
Route::get('/tags/{tag}', [TagController::class, 'show'])->name('tags.show');
Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');

Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

<<<<<<< HEAD
// ---------------------- Documents ----------------------
=======
// Route::resource('tags', TagController::class);
// Route::resource('documents', DocumentController::class);


// Documents routes with AJAX/DataTables
>>>>>>> 9953726449f6cec3f1c51ad7166a16ea263cae0b
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');

Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

<<<<<<< HEAD
// ---------------------- Settings ----------------------
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

// ---------------------- Language & Home ----------------------
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// ---------------------- User Profile ----------------------
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// ---------------------- Users Resource (Protected) ----------------------
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', UserController::class);
});

// ---------------------- Catch-all route (Always LAST) ----------------------
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])
     ->where('any', '.*')
     ->name('index');
=======

Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');


Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');
Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

>>>>>>> 9953726449f6cec3f1c51ad7166a16ea263cae0b
