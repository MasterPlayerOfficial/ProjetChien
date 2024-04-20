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
Route::get('/animal/{idAnimal}', [AnimalController::class, 'getAnimal']);
Route::get('/animals', [AnimalController::class, 'getAllAnimals']);
Route::put('animal/{idAnimal}', [AnimalController::class, 'updateAnimal']);
Route::delete('/animal/{idAnimal}', [AnimalController::class, 'deleteAnimal']);

Route::post('/alert', [AlertController::class, 'addAlert']);