<?php

use Illuminate\Http\Request;

if(!defined("UUID_REGEXP_PATTERN"))
    define("UUID_REGEXP_PATTERN", '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$');

/**
 *  group - system alias
 *  as - type
 *  datatable - afected dt
 */
Route::group(['middleware' => ['throttle', 'auth.simple', 'output']], function () {

    Route::get('/', [
        'as' => 'Root:EmptyResource',
        function () {
            throw new \App\Exceptions\BadRequestExeption("Empty resource is not allowed");
        }
    ]);

    Route::group(['group' => 'Authorization', 'as' => 'authorization', 'datatable' => 'user'], function () {

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

    });

    Route::group(['group' => 'UserType', 'as' => 'user_types', 'datatable' => 'user_types'], function () {

        /**
         *
         */
        Route::get('users/types/', ['as' => 'GetAllUsersTypes', 'uses' => 'UserTypeController@getAll', 'role' => 'root']);

        /**
         *
         */
        Route::get('users/types/{typeGUID}', ['as' => 'GetSingleUsersType', 'uses' => 'UserTypeController@getSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('users/types/', ['as' => 'CreateNewUsersType', 'uses' => 'UserTypeController@createSingle', 'role' => 'root']);

        /**
         *
         */
        Route::put('users/types/{typeGUID}', ['as' => 'UpdateSingleUsersType', 'uses' => 'UserTypeController@updateSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('users/types/{typeGUID}', ['as' => 'DeleteSingleUsersType', 'uses' => 'UserTypeController@deleteSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);

    });

    Route::group(['group' => 'RouteLogsType', 'as' => 'route_logs_type', 'datatable' => 'route_log_types'], function () {

        /**
         *
         */
        Route::get('delivery/logs/type/', ['as' => 'GetAllDeliverysLogsTypes', 'uses' => 'DeliverysLogsTypeController@getAll', 'role' => 'root']);

        /**
         *
         */
        Route::get('delivery/logs/type/{typeGUID}', ['as' => 'GetSingleDeliverysLogsType', 'uses' => 'DeliverysLogsTypeController@getSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('delivery/logs/type/', ['as' => 'CreateNewDeliverysLogsType', 'uses' => 'DeliverysLogsTypeController@createSingle', 'role' => 'root']);

        /**
         *
         */
        Route::put('delivery/logs/type/{typeGUID}', ['as' => 'UpdateSingleDeliverysLogsType', 'uses' => 'DeliverysLogsTypeController@updateSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('delivery/logs/type/{typeGUID}', ['as' => 'DeleteSingleDeliverysLogsType', 'uses' => 'DeliverysLogsTypeController@deleteSingle', 'role' => 'root'])
            ->where('typeGUID', UUID_REGEXP_PATTERN);


    });

    Route::group(['group' => 'Users', 'as' => 'user', 'datatable' => ['user', 'user_types']], function () {

        /**
         *
         */
        Route::get('users/', ['as' => 'GetAllUsers', 'uses' => 'UserController@getAll', 'role' => 'root']);

        /**
         *
         */
        Route::get('users/{userGUID}', ['as' => 'GetSingleUser', 'uses' => 'UserController@getSingle', 'role' => ['root', 'self']])
            ->where('userGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('users/', ['as' => 'CreateNewUser', 'uses' => 'UserController@createSingle', 'role' => 'root']);

        /**
         *
         */
        Route::put('users/{userGUID}', ['as' => 'UpdateSingleUser', 'uses' => 'UserController@updateSingle', 'role' => ['root', 'self']])
            ->where('userGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('users/{userGUID}', ['as' => 'DeleteSingleUser', 'uses' => 'UserController@deleteSingle', 'role' => 'root'])
            ->where('userGUID', UUID_REGEXP_PATTERN);


    });

    Route::group(['group' => 'Cars', 'as' => 'cars', 'datatable' => 'cars'], function () {

        /**
         *
         */
        Route::get('cars/', ['as' => 'GetAllCars', 'uses' => 'CarController@getAll', 'role' => 'root']);

        /**
         *
         */
        Route::get('cars/{carGUID}', ['as' => 'GetSingleCar', 'uses' => 'CarController@getSingle', 'role' => 'root'])
            ->where('carGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('cars/', ['as' => 'CreateNewCar', 'uses' => 'CarController@createSingle', 'role' => 'root']);

        /**
         *
         */
        Route::put('cars/{carGUID}', ['as' => 'UpdateSingleCar', 'uses' => 'CarController@updateSingle', 'role' => 'root'])
            ->where('carGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('cars/{carGUID}', ['as' => 'DeleteSingleCar', 'uses' => 'CarController@deleteSingle', 'role' => 'root'])
            ->where('carGUID', UUID_REGEXP_PATTERN);


    });

    Route::group(['group' => 'Products', 'as' => 'products', 'datatable' => 'products'], function () {


        /**
         *
         */
        Route::get('products/', ['as' => 'GetAllProducts', 'uses' => 'ProductController@getAll', 'role' => ['root','manager']]);

        /**
         *
         */
        Route::get('products/{productGUID}', ['as' => 'GetSingleProduct', 'uses' => 'ProductController@getSingle', 'role' => ['root','manager']])
            ->where('productGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('products/', ['as' => 'CreateNewProduct', 'uses' => 'ProductController@createSingle', 'role' => ['root','manager']]);

        /**
         *
         */
        Route::put('products/{productGUID}', ['as' => 'UpdateSingleProduct', 'uses' => 'ProductController@updateSingle', 'role' => ['root','manager']])
            ->where('productGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('products/{productGUID}', ['as' => 'DeleteSingleProduct', 'uses' => 'ProductController@deleteSingle', 'role' => ['root','manager']])
            ->where('productGUID', UUID_REGEXP_PATTERN);

    });

    Route::group(['group' => 'Delivery', 'as' => 'delivery', 'datatable' => ['products', 'delivery', 'car_route']], function () {

        /**
         *
         */
        Route::get('delivery/', ['as' => 'GetAllDeliveries', 'uses' => 'DeliveryController@getAll', 'role' => ['root','manager']]);

        /**
         *
         */
        Route::get('delivery/{deliveryGUID}', ['as' => 'GetSingleDelivery', 'uses' => 'DeliveryController@getSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('delivery/', ['as' => 'CreateNewDelivery', 'uses' => 'DeliveryController@createSingle', 'role' => ['root','manager']]);

        /**
         *
         */
        Route::put('delivery/{deliveryGUID}', ['as' => 'UpdateSingleDelivery', 'uses' => 'DeliveryController@updateSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('delivery/{deliveryGUID}', ['as' => 'DeleteSingleDelivery', 'uses' => 'DeliveryController@deleteSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN);

    });

    Route::group(['group' => 'DeliveryRoutes', 'as' => 'delivery_routes', 'datatable' => ['car_route', 'delivery']], function () {



    });

    Route::group(['group' => 'DeliveryRouteLogs', 'as' => 'delivery_route_logs', 'datatable' => ['route_logs', 'car_route', 'route_log_types']], function () {

        /**
         *
         */
        Route::get('delivery/{deliveryGUID}/routes/{routeGUID}/logs/', ['as' => 'GetAllRouteLogs', 'uses' => 'DeliveryLogsController@getAll', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN)
            ->where('routeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::get('delivery/{deliveryGUID}/routes/{routeGUID}/logs/{logGUID}', ['as' => 'GetSingleRouteLog', 'uses' => 'DeliveryLogsController@getSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN)
            ->where('routeGUID', UUID_REGEXP_PATTERN)
            ->where('logGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::post('delivery/{deliveryGUID}/routes/{routeGUID}/logs/', ['as' => 'CreateNewRouteLog', 'uses' => 'DeliveryLogsController@createSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN)
            ->where('routeGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::put('delivery/{deliveryGUID}/routes/{routeGUID}/logs/{logGUID}', ['as' => 'UpdateSingleRouteLog', 'uses' => 'DeliveryLogsController@updateSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN)
            ->where('routeGUID', UUID_REGEXP_PATTERN)
            ->where('logGUID', UUID_REGEXP_PATTERN);

        /**
         *
         */
        Route::delete('delivery/{deliveryGUID}/routes/{routeGUID}/logs/{logGUID}', ['as' => 'DeleteSingleRouteLog', 'uses' => 'DeliveryLogsController@deleteSingle', 'role' => ['root','manager']])
            ->where('deliveryGUID', UUID_REGEXP_PATTERN)
            ->where('routeGUID', UUID_REGEXP_PATTERN)
            ->where('logGUID', UUID_REGEXP_PATTERN);


    });


});