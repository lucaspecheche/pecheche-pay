<?php

use Illuminate\Support\Facades\Route;
use Modules\Transactions\Http\Controllers\TransactionController;

Route::post('/', TransactionController::getActionPath('store'));
