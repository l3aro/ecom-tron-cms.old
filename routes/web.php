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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin Zone
 */
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function() {
    Route::get('login', [
        'as' => 'admin.login.showLoginForm',
        'uses' => 'LoginController@showLoginForm',
    ]);
    Route::post('login', [
        'as' => 'admin.login',
        'uses' => 'LoginController@login',
    ]);
    Route::get('logout',[
        'as' => 'admin.logout',
        'uses' => 'LoginController@logout'
    ]);
    /**
     * Authenticated and have role only
     */
    Route::group([
        'middleware' => ['auth.admin', 'role:admin|moderator|editor|publisher'],
    ], function() {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        
        /**
         * Authorized for admin, mod, editor
         */
        Route::group([
            'middleware' => ['role:admin|moderator|editor'],
        ], function() {
            Route::get('role_editor', function() {
                return "here editor";
            });

            /**
             * Authorized for admin, mod
             */
            Route::group([
                'middlware' => ['role:admin|moderator'],
            ], function() {
                Route::get('role_moderator', function() {
                    return "here moderator";
                });

                /**
                 * Authorized for admin only
                 */
                Route::group([
                    'middleware' => ['role:admin'],
                ], function() {
                    Route::get('role_admin', function() {
                        return "here admin";
                    });

                });
            });
        });
    });
});
