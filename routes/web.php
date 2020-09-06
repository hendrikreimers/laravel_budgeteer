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

Auth::routes();

Route::get('/', 'MainController@index')->name('index');
Route::get('/login', 'Auth\LoginController@loginForm')->name('login');

Route::group(['middleware' => ['auth']], function () {
    // Home
    Route::get('/home', 'MainController@home')->name('home');

    // Profile
    Route::get('/profile', 'ProfileController@view')->name('profile');
    Route::post('/profile/update', 'ProfileController@update')->name('profile-update');

    // Create some administration routes for models with same routes
    $models = ['user', 'role', 'subject', 'account', 'receipt', 'limit'];
    foreach ( $models as $model ) {
        $upperModel = ucfirst($model);

        Route::get('/'. $model . 's', $upperModel . 'sController@list')->name($model . 's');
        Route::get('/'. $model . '/view/{'. $model . '}', $upperModel . 'sController@view')->name($model . '-view');
        Route::get('/'. $model . '/new' . $upperModel, $upperModel . 'sController@new' . $upperModel)->name($model . '-new');
        Route::post('/'. $model . '/create', $upperModel . 'sController@create')->name($model . '-create');
        Route::post('/'. $model . '/update/{'. $model . '}', $upperModel . 'sController@update')->name($model . '-update');
        Route::get('/'. $model . '/delete/{'. $model . '}', $upperModel . 'sController@delete')->name($model . '-delete');
    }

    // Additional routes for receipts to make a money transfer
    Route::get('/receipt/newTransfer', 'ReceiptsController@newTransfer')->name('receipt-newTransfer');
    Route::post('/receipt/transfer', 'ReceiptsController@transfer')->name('receipt-transfer');
});

/* ------------------------------------------------------------------------------------------------------------------ */

// Route to clear the cache by url
Route::get('/admin/clear-cache', 'AdminController@clearCacheAction');

// Installation route without shell access
Route::get('/admin/install', 'AdminController@installAction');
