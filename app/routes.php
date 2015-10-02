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
    //Route::GET('/{id:int}', array('use'=>'UserController@getUser'));
    Route::GET('/register', array('use'=>'UserController@getRegister'));
    Route::POST('/register', array('use'=>'UserController@postRegister', 'before' => 'csrf'));
    Route::GET('/login', array('use'=>'UserController@getLogin'));
    Route::POST('/login', array('use'=>'UserController@postLogin', 'before' => 'csrf'));
    Route::GET('/logout', array('use'=>'UserController@logout', 'before' => 'auth'));
    Route::GET('/cart', array('use'=>'CartController@getAll', 'before' => 'auth'));
    Route::GET('/cart/add/{id:int}', array('use'=>'CartController@add', 'before' => 'auth'));
    Route::POST('/cart/product/{id:int}/quantity', array('use'=>'CartController@changeQuantity', 'before' => 'auth|csrf'));
    Route::GET('/{id:int}/products', array('use'=>'UserController@getProducts', 'before' => 'auth'));
    Route::POST('/product/{id:int}/sell', array('use'=>'UserController@sellProduct', 'before' => 'auth|csrf'));
    Route::GET('/cart/buy', array('use'=>'CartController@buy', 'before' => 'auth'));
    Route::GET('/cart/product/{id:int?}/remove', array('use'=>'CartController@removeProduct'));
});

Route::Group('category', array(), function() {
    Route::GET('/{id:int}', array('use' => 'CategoryController@getCategory'));
    Route::GET('/delete/{id:int}', array('use' => 'CategoryController@deleteCategory', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/add', array('use' => 'CategoryController@getAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/add', array('use' => 'CategoryController@postAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/edit/{id:int}', array('use' => 'CategoryController@getEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/edit/{id:int}', array('use' => 'CategoryController@postEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
});

Route::Group('product', array(), function() {
    Route::GET('/{id:int}', array('use' => 'ProductController@getProduct'));
    Route::GET('/delete/{id:int}', array('use' => 'ProductController@delete', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/add', array('use' => 'ProductController@getAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/add', array('use' => 'ProductController@postAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/edit/{id:int}', array('use' => 'ProductController@getEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/edit/{id:int}', array('use' => 'ProductController@postEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/{id:int}/add/comment', array('use' => 'CommentController@post', 'before' => 'auth|csrf'));
});

Route::Group('promotion', array(), function() {
    Route::GET('', array('use' => 'PromotionController@getAll', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/delete/{id:int}', array('use' => 'PromotionController@delete', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::GET('/add', array('use' => 'PromotionController@getAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    Route::POST('/add', array('use' => 'PromotionController@postAdd', 'before' => 'auth', 'roles' => 'editor|admin'));
    //Route::GET('/edit/{id:int}', array('use' => 'PromotionController@getEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
    //Route::POST('/edit/{id:int}', array('use' => 'PromotionController@postEdit', 'before' => 'auth', 'roles' => 'editor|admin'));
});

Route::GET('comment/delete/{id:int}', array('use' => 'CommentController@delete', 'before' => 'auth'));
Route::GET('admin/users', array('use' => 'AdminController@getUsers', 'before' => 'auth', 'roles' => 'admin'));
Route::GET('admin/make/{id:int}/{role}', array('use' => 'AdminController@setRole', 'before' => 'auth', 'roles' => 'admin'));
Route::GET('admin/ban/{id:int}', array('use' => 'AdminController@banUser', 'before' => 'auth', 'roles' => 'admin'));
//Route::GET('users/{id:int}/edit', array('use'=>'UsersController@EditUser3','before'=>'csrf'));
////Route::GET('users/edit/{id?}', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
////Route::GET('users/edit', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
//Route::GET('users/delete/{sas:int}/{sss}', array('use'=>'UsersController@EditUser2','before'=>'csrf','roles'=>'admin|edit'));
//Route::POST('users/test/{test1}', array('use'=>'UsersController@testmethod','before'=>'csrf'));