<?php

use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SpecialtyController;
use Illuminate\Support\Facades\Route;

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

const REGEX = '[0-9]+';

Route::get('/', [RegisterController::class, 'registerView'])->name('registerView');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/login', [RegisterController::class, 'loginView'])->name('loginView');
Route::post('/signIn', [RegisterController::class, 'login'])->name('login');
Route::get('/home', [RegisterController::class, 'homeView'])->name('home')->middleware('auth');
Route::get('/activate/{id}', [RegisterController::class, 'activate'])->where('id', REGEX)->name('activate');
Route::post('/authentication/{id}',[RegisterController::class, 'authentication'])
    ->where('id','[0-9]+')->middleware('signed')->name('authentication');
Route::get('/logout', [RegisterController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('/verify')->group(function (){
    Route::get('/mail', [RegisterController::class, 'verifyMailView'])->name('verifyMailView');
    Route::get('/code', [RegisterController::class, 'verifyCodeView'])->name('verifyCodeView');
    Route::post('/code', [RegisterController::class, 'checkCode'])->middleware('signed')->name('checkCode');
})->middleware('auth');


Route::group([],function(){
    Route::get('/insurances',[InsuranceController::class, 'index'])->name('insurances');
    Route::get('/specialties',[SpecialtyController::class, 'index'])->name('specialties');
    Route::post('/addInsurance',[InsuranceController::class, 'add'])->name('addInsurance');
    Route::post('/addSpecialty',[SpecialtyController::class, 'add'])->name('addSpecialty');

    Route::post('/updateInsurance/{id}',[InsuranceController::class, 'update'])
        ->where('id',REGEX)->name('updateInsurance');

    Route::post('/updateSpecialty/{id}',[SpecialtyController::class, 'update'])
        ->where('id', REGEX)->name('updateSpecialty');

    Route::get('/deleteInsurance/{id}',[InsuranceController::class, 'delete'])
        ->where('id', REGEX)->name('deleteInsurance');

    Route::get('/deleteSpecialty/{id}',[SpecialtyController::class, 'delete'])
        ->where('id', REGEX)->name('deleteSpecialty');

})->middleware('auth');
