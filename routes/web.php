<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [CurriculumController::class, 'obrigatorias'])->name('curriculum.obrigatorias');
Route::get('/eletivas', [CurriculumController::class, 'eletivas'])->name('curriculum.eletivas');
Route::get('/get-data', [CurriculumController::class, 'data'])->name('curriculum.data');
Route::get('/{disciplina:codigo}', [CurriculumController::class, 'show'])->name('curriculum.show');
