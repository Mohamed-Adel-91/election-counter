<?php

use App\Http\Controllers\VoterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [VoterController::class, 'index'])->name('voters.index');

Route::post('/voters/{voter}/increment', [VoterController::class, 'increment'])
    ->name('voters.increment');

Route::post('/invalid-votes/increment', [VoterController::class, 'incrementInvalid'])
    ->name('invalid_votes.increment');

Route::post('/invalid-votes/reset', [VoterController::class, 'resetInvalid'])
    ->name('invalid_votes.reset');

Route::post('/voters/reset', [VoterController::class, 'reset'])
    ->name('voters.reset');
