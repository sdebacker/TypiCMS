<?php

Route::resource('posts', 'PostController');
Route::get('/posts/{id}/delete', 'PostController@destroy');
