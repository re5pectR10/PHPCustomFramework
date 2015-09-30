<?php
use \FW\Route;

Route::Group('helppage', array(), function() {
    Route::GET('', array('use'=>'HelpPageController@index','name'=>'sds'));
    Route::GET('/{index:int}', array('use'=>'HelpPageController@getItem'));
});

Route::GET('', array('use' => 'ProductController@index'));

Route::Group('user', array(), function() {
    Route::GET('', array('use'=>'UserController@getProfile', 'before' => 'auth'));
    Route::POST('', array('use'=>'UserController@editProfile', 'before' => 'auth|csrf'));
    Route::GET('/{id:int}', array('use'=>'UserController@getUser'));
    Route::GET('/register', array('use'=>'UserController@getRegister'));
    Route::POST('/register', array('use'=>'UserController@postRegister', 'before' => 'csrf'));
    Route::GET('/login', array('use'=>'UserController@getLogin'));
    Route::POST('/login', array('use'=>'UserController@postLogin', 'before' => 'csrf'));
    Route::GET('/logout', array('use'=>'UserController@logout', 'before' => 'auth'));
    Route::GET('/cart', array('use'=>'CartController@getAll', 'before' => 'auth'));
    Route::GET('/cart/add/{id:int}', array('use'=>'CartController@add', 'before' => 'auth'));
    Route::POST('/cart/product/{id:int}/quantity', array('use'=>'CartController@changeQuantity', 'before' => 'csrf'));
    Route::GET('/products', array('use'=>'ProductController@getUserProducts'));
    Route::GET('/cart/buy', array('use'=>'CartController@buy', 'before' => 'auth'));
    Route::GET('/cart/product/{id:int?}/remove', array('use'=>'CartController@removeProduct'));
});

Route::GET('category/{id:int}', array('use' => 'CategoryController@getCategory'));
Route::GET('product/{id:int}', array('use' => 'ProductController@getProduct'));
//Route::GET('users/{id:int}/edit', array('use'=>'UsersController@EditUser3','before'=>'csrf'));
////Route::GET('users/edit/{id?}', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
////Route::GET('users/edit', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
//Route::GET('users/delete/{sas:int}/{sss}', array('use'=>'UsersController@EditUser2','before'=>'csrf','roles'=>'admin|edit'));
//Route::POST('users/test/{test1}', array('use'=>'UsersController@testmethod','before'=>'csrf'));