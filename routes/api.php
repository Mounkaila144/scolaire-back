<?php

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
use Illuminate\Support\Facades\Route;


Route::resource('users', UserController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
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




