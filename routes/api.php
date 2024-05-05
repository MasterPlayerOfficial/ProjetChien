<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Animal;
use App\Http\Controllers\AnimalController;

use App\Models\Alert;
use App\Http\Controllers\AlertController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/animal', [AnimalController::class, 'addAnimal']);
Route::get('/animal/{id}', [AnimalController::class, 'getAnimal']);
Route::get('/animals', [AnimalController::class, 'getAllAnimals']);
Route::put('/animal/{id}', [AnimalController::class, 'updateAnimal']);
Route::delete('/animal/{id}', [AnimalController::class, 'deleteAnimal']);

Route::post('/alert', [AlertController::class, 'addAlert']);
Route::get('/alert/{id}', [AlertController::class, 'getAlert']);
Route::put('/alert/{id}', [AlertController::class, 'updateAlert']);