<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\GroupController;
use App\Controllers\PermissionController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api',static function ($routes) {
    $routes->post('register',[AuthController::class,'register']);
    $routes->post('login',[AuthController::class,'login']);
    $routes->get('logout',[AuthController::class,'logout']);
    
    $routes->get('user',[PermissionController::class,'getUserPermission'], [
        'filter'=> 'custom-jwt',
    ]);


    $routes->group('permission', static function ($routes) {
        $routes->post('',[PermissionController::class,'store']);
        $routes->put('(:num)',[PermissionController::class,'update']);        
        $routes->post('add_group_permission',[PermissionController::class,'addGroupPermission']);
    });

    $routes->group('group', static function ($routes) {
        $routes->get('',[GroupController::class,'showAll']);
        $routes->post('',[GroupController::class,'store']);
        $routes->put('(:num)',[GroupController::class,'update']);
        $routes->delete('(:num)',[GroupController::class,'delete']);
        $routes->get('(:num)',[GroupController::class,'show']);

    });

    $routes->group('users', static function ($routes) {
        $routes->get('',[UserController::class,'showAll']);
        $routes->get('(:num)',[UserController::class,'show']);
        $routes->put('(:num)',[UserController::class,'update']);
        $routes->put('change_password/(:num)',[UserController::class,'changePassword']);
        $routes->post('add_group',[UserController::class,'addUserGroup']);
        $routes->delete('(:num)',[UserController::class,'delete']);
        $routes->delete('groups/(:num)',[UserController::class,'deleteUserGroups']);
        $routes->delete('group', [UserController::class,'deleteUserGroup']);
        $routes->get('groups/(:num)',[UserController::class,'getUserGroup']);
    });


    
});

$routes->get('check-db', function(){
    try{
        $db = \Config\Database::connect();
        $db->initialize();
        echo "Database connected";
    } catch (\Throwable $e){
        echo "Database not connected";
    }
});