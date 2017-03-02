<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{

}

/**
 * all POST /login?email=email&password=password Запрос токена с валидным временем 20 минут
 */
Route::post('/login', ['as' => 'GetTokenByCredentials', 'uses' => 'AuthorizationController@getToken', 'role' => '*']);

/**
 *  all PUT /login?token=token Обновление времени валидности токена (с момента запроса + 20 минут) = ДЛЯ всех Валидных токенов
 */
Route::put('/login', ['as' => 'RenewToken', 'uses' => 'AuthorizationController@renewToken', 'role' => '*']);

/**
 * all DELETE /logout?token=token Уничтожение токена
 */
Route::delete('/logout', ['as' => 'UnsetToken', 'uses' => 'AuthorizationController@unsetToken', 'role' => '*']);