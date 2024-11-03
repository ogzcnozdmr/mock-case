<?php

use Illuminate\Support\Facades\Route;

/**
 * Task
 */
Route::controller(\App\Http\Controllers\TaskController::class)->name('task.')->group(function () {
    Route::get('/task','list')->name('list');
    Route::get('/task/{id}','detail')->name('detail');
});

/**
 * Task Mock bilgileri için kendi içerimizde basit provider servisimiz
 */
Route::controller(\App\Http\Controllers\TaskProviderController::class)->name('taskProvider.')->group(function () {
    Route::get('/data/task/{id}','run')->name('run');
});
