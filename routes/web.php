<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EcoleController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\PayadminController;
use App\Http\Controllers\PayteacherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScolaireController;
use App\Http\Controllers\TexteController;
use App\Http\Controllers\UserController;
use App\Models\Promotion;

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


Route::resource('users', UserController::class);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/eleves/classe/{id}', [EleveController::class, 'filterByClasse']);
Route::resource('absences', AbsenceController::class);
Route::get('absences/eleve/{eleveId}', [AbsenceController::class, 'getAbsencesByEleve']);
Route::get('absences/matiere/{matiereId}', [AbsenceController::class, 'getAbsencesByMatiere']);
Route::get('evaluations/eleve/{eleveId}', [EvaluationController::class, 'getEvaluationsByEleve']);
Route::get('evaluations/matiere/{matiereId}', [EvaluationController::class, 'getEvaluationsByMatiere']);
Route::resource('ecoles', EcoleController::class);
Route::resource('matiers', MatiereController::class);
Route::resource('schedules', ScheduleController::class);
Route::resource('textes', TexteController::class);
Route::resource('cours', CourController::class);
Route::resource('evaluations', EvaluationController::class);
Route::resource('eleves', EleveController::class);
Route::resource('classes', ClassController::class);
Route::resource('professeurs', ProfController::class);
Route::resource('promotions', PromotionController::class);
Route::resource('scolarites', ScolaireController::class);
Route::resource('payteachers', PayteacherController::class);
Route::resource('payadmins', PayadminController::class);
Route::resource('depenses', DepenseController::class);
Route::get('/dashboard', [DashboardController::class, 'stats']);

Route::get('/me', [AuthController::class, 'me']);

Auth::routes();


//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


Route::get('/promotion', function () {
    return view('promoion.promotion');
});
Route::post('store',[PromotionController::class,'store'])->name('store');
Route::get('destroy/{id}',[PromotionController::class,'destroy'])->name('destroy');
Route::get('update/{id}',[PromotionController::class,'update'])->name('update');
