<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'startGame'])->name('start');
Route::post('/', [MainController::class, 'prepareGame'])->name('prepare');
Route::get('/game', [MainController::class, 'game'])->name('game');
Route::get('/answer/{answer}', [MainController::class, 'answer'])->name('answer');
Route::get('/next-question', [MainController::class, 'nextQuestion'])->name('next');
Route::get('/show-results', [MainController::class, 'showResults'])->name('result');
