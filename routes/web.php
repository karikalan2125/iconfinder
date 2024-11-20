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

Route::get('/icons/style-set/{slug}/{cat_slug}/fetch_svg',[App\Http\Controllers\IconFinderController::class,'fetch_svg']);
Route::get('/icons/category-set/{slug}/{cat_slug}/fetch_svg',[App\Http\Controllers\IconFinderController::class,'fetch_svg']);
Route::get('/icons/{cat_slug}/fetch_svg',[App\Http\Controllers\IconFinderController::class,'fetch_svg']);

Route::post('/icons/style-set/{slug}/{cat_slug}/increment_view_count', [App\Http\Controllers\IconFinderController::class, 'incrementViewCount']);
Route::post('/icons/{cat_slug}/increment_view_count', [App\Http\Controllers\IconFinderController::class, 'incrementViewCount']);
Route::post('/icons/style-set/{slug}/increment_download_count', [App\Http\Controllers\IconFinderController::class, 'incrementDownloadCount']);
Route::post('/icons/category-set/{slug}/{cat_slug}/increment_view_count', [App\Http\Controllers\IconFinderController::class, 'incrementViewCount']);
Route::post('/icons/category-set/{slug}/{cat_slug}/increment_download_count', [App\Http\Controllers\IconFinderController::class, 'incrementDownloadCount']);
Route::post('/store-user-details', [App\Http\Controllers\IconFinderController::class, 'storeUserDetails']);
Route::post('/store-out-time', [App\Http\Controllers\IconFinderController::class, 'storeOutTime']);



