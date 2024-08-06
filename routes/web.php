<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/log', function () {
    return view('log');
});
Route::get('/user-management', function () {
    return view('user-management');
});
