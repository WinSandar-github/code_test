<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::apiResource('/',InvoiceController::class);
Route::get('/getInvoice/{id}',[InvoiceController::class,'getInvoice']);
