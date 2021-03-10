<?php

use Illuminate\Support\Facades\Route;
use Codtail\AdminSuit\Http\Controllers\ListingViewController;

Route::get('listing-view', [ListingViewController::class, 'index'])->name('listing-view.index');
