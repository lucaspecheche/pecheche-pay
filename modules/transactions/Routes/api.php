<?php

use Illuminate\Support\Facades\Route;
use Transactions\Http\Controllers\TransactionController;

Route::post('/', TransactionController::getActionPath('store'));
