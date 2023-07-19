<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExtracurricularController;
use App\Models\Extracurricular;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('extracurriculars',ExtracurricularController::class);
Route::get('/extracurriculars.search',[ExtracurricularController::class, 'search'])->name('extracurriculars.search');
Route::get('/extracurriculars/newest', [ExtracurricularController::class, 'getNewest'])->name('extracurriculars.newest');
Route::post('/extracurriculars.deleteAll', [ExtracurricularController::class, 'deleteAll'])->name('extracurriculars.deleteAll');
