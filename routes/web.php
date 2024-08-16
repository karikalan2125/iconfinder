<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\IconFinderController::class, 'home']);
Route::get('/download_icon', [App\Http\Controllers\IconFinderController::class, 'download']);
Route::get('/icons', [App\Http\Controllers\IconFinderController::class, 'category']);
Route::get('/icons/category-set/{slug}', [App\Http\Controllers\IconFinderController::class, 'cat_subcategory']);
Route::get('/icons/style-set/{slug}', [App\Http\Controllers\IconFinderController::class, 'style_subcategory']);
Route::get('/icons/category-set/{slug}/{cat_slug}', [App\Http\Controllers\IconFinderController::class, 'detail']);
Route::get('/icons/style-set/{slug}/{cat_slug}', [App\Http\Controllers\IconFinderController::class, 'detail']);
Route::get('/icons/search', [App\Http\Controllers\IconFinderController::class, 'search'])->name('icons.search');
