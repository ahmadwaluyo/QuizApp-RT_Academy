<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', [QuizController::class, 'index'])->name('home');
Route::get('/setup', [QuizController::class, 'setupPage'])->name('quiz.setup.page');
Route::post('/setup', [QuizController::class, 'setup'])->name('quiz.setup');
Route::get('/play', [QuizController::class, 'play'])->name('quiz.play');
Route::post('/submit', [QuizController::class, 'submit'])->name('quiz.submit');

Route::get('/history', [QuizController::class, 'history'])->name('history.index');
Route::get('/history/{filename}', [QuizController::class, 'historyDetail'])->name('history.detail');
