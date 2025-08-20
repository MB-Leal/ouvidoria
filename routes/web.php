<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*** Rotas das páginas Web ***
*/

Route::get('/', function () {
    return view('welcome');
});
