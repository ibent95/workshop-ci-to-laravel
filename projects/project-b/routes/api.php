<?php

use App\Http\Controllers\Api\APIController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

	Route::get('/status', [APIController::class, 'status']);
});
