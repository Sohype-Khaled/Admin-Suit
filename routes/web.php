<?php

use Codtail\AdminSuit\Http\Controllers\ApplyActionController;
use Illuminate\Support\Facades\Route;
use Codtail\AdminSuit\Http\Controllers\ListingViewController;

Route::get('listing-view', [ListingViewController::class, 'index'])->name('listing-view.index');
Route::post('apply-action', ApplyActionController::class)->name('call-action');
