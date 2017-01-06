<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /*

    We redirect users to home protected view

    */

    Route::get('/', function () {

    return redirect('/home');

     });

    /*

    Auth Routes scaffold from Laravel Auth scaffolding

    */

    Auth::routes();


    /*

    Main Secured Home Route

    */

    Route::get('/home', 'HomeController@index');


    /*

    Secured business logic views.

    */

    Route::group(['middleware' => ['auth']], function () {

    /*

      Main Laravel View Route Sanitized for Vue JS router use

    */

    Route::get('/business-locations{vue_capture?}','BusinessLocationsController@index')->where('vue_capture', '[\/\w\.-]*');



        /*

      Get business location API endpoint

      */

     Route::get('/api/business-locations','BusinessLocationsController@listLocations');


        /*



        /*

        Get business location API endpoint

        */

    Route::get('/api/business-locations/{id}','BusinessLocationsController@get');


    /*

    Create new business location API endpoint

   */

    Route::post('/api/business-locations','BusinessLocationsController@create');

    /*

   Update a business location API endpoint

   */

    Route::put('/api/business-locations','BusinessLocationsController@update');


    /*

     Delete a business location API endpoint

   */

    Route::delete('/api/business-locations','BusinessLocationsController@delete');

    /*

   Upload an image location API endpoint

     */

    Route::post('/api/upload','BusinessLocationsController@upload');






});



