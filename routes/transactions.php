<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

//TODO: Alterar para POST
Route::get('/', TransactionController::getActionName('store'));
