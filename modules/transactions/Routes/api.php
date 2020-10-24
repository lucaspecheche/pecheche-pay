<?php

use Illuminate\Support\Facades\Route;
use Transactions\Http\Controllers\TransactionController;

Route::post('/transfer', TransactionController::getActionPath('transfer'));
