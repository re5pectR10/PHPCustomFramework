<?php
use \FW\Route;

Route::GET('helppage', array('use'=>'HelpPageController@index'));
Route::GET('helppage/{index:int}', array('use'=>'HelpPageController@getItem'));

Route::GET('users/{id:int}/edit', array('use'=>'UsersController@EditUser3','before'=>'csrf|auth'));
//Route::GET('users/edit/{id?}', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
//Route::GET('users/edit', array('use'=>'UsersController@EditUser','before'=>'csrf|auth'));
Route::GET('users/delete/{sas:int}/{sss}', array('use'=>'UsersController@EditUser2','before'=>'csrf|auth'));
Route::POST('users/test/{test1}', array('use'=>'UsersController@testmethod','before'=>'csrf|auth'));