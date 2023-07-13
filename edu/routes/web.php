<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeminarController;
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
Route::post('checkAdd',[SeminarController::class, 'addSeminar'])->name("addSermina");
Route::get('/', [SeminarController::class, 'loadData'])->name("home");
Route::get('checkDelete/{id}',[SeminarController::class, 'deleteSeminar'])->name("deleteSeminar");
Route::post('deleteAll',[SeminarController::class, 'deleteAllSeminar']);
Route::get('EditSer/{id}',[SeminarController::class, 'editSeminar'])->name("editSeminar");
Route::post('updateSer/{id}',[SeminarController::class, 'updateSeminar'])->name("updateSeminar");
Route::get('/search',[SeminarController::class, 'searchSeminar'])->name("search");
Route::get('/filter',[SeminarController::class, 'filterSeminar'])->name("filter");
Route::post('test',[SeminarController::class, 'test'])->name("test");