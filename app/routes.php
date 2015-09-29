<?php
use \FW\Route;

Route::Group('helppage', array(), function() {
    Route::GET('', array('use'=>'HelpPageController@index','name'=>'sds'));
    Route::GET('/{index:int}', array('use'=>'HelpPageController@getItem'));
});

Route::GET('', array('use' => 'ProductController@index'));

Route::Group('user', array(), function() {
    Route::GET('', array('use'=>'UserController@getProfile'));
    Route::GET('/{id:int}', array('use'=>'UserController@getUser'));
    Route::GET('/register', array('use'=>'UserController@getRegister'));
    Route::POST('/register', array('use'=>'UserController@postRegister'));
    Route::GET('/login', array('use'=>'UserController@getLogin'));
    Route::POST('/login', array('use'=>'UserController@postLogin'));
    Route::GET('/logout', array('use'=>'UserController@logout'));
    Route::GET('/cart', array('use'=>'CartController@getAll'));
    Route::GET('/cart/add/{id:int}', array('use'=>'CartController@add'));
    Route::POST('/cart/product/{id:int}/quantity', array('use'=>'CartController@changeQuantity'));
    Route::GET('/products', array('use'=>'ProductController@getUserProducts'));
    Route::GET('/cart/buy', array('use'=>'CartController@buy'));
    Route::GET('/cart/product/{id:int?}/remove', array('use'=>'CartController@removeProduct'));
});

Route::GET('category/{id:int}', array('use' => 'CategoryController@getCategory'));
Route::GET('product/{id:int}', array('use' => 'ProductController@getProduct'));
//Route::GET('users/{id:int}/edit', array('use'=>'UsersController@EditUser3','before'=>'csrf'));
////Route::GET('users/edit/{id?}', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
////Route::GET('users/edit', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
//Route::GET('users/delete/{sas:int}/{sss}', array('use'=>'UsersController@EditUser2','before'=>'csrf','roles'=>'admin|edit'));
//Route::POST('users/test/{test1}', array('use'=>'UsersController@testmethod','before'=>'csrf'));