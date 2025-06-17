<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('graphql', '\Rebing\GraphQL\Support\GraphQLController@query');

