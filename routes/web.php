<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-path', function () {

    $visiting = array(
        'days'=>array(
            'monday'=>array('start_time'=>'12:15 am','end_time'=>'11:00 pm','visiting_slot'=>'morning','is_available'=>1),
            'tuesday'=>array('start_time'=>'02:15 am','end_time'=>'11:00 pm','visiting_slot'=>'morning','is_available'=>1),
        ),
    );

    print_r(json_encode($visiting));

    return 'test path';
});
