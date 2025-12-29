<?php

Route::get('/', function () {
    return view('Shop::welcome');
})->name('welcome');