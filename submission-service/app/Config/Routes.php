<?php

use App\Controllers\Api\ApiSubmissionController;
use App\Controllers\Api\SubmissionItemController;
use App\Controllers\Client\AuthController;
use App\Controllers\Client\DashboardController;
use App\Controllers\Home;
use App\Controllers\Client\ItemController;
use App\Controllers\Client\SubmissionController;
use App\Controllers\Client\UserController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', [Home::class,'index']);
$routes->get('unauthorized',[Home::class,'unAuthorized']);
$routes->get('forbidden',[Home::class,'forbidden']);
$routes->post('/login',[Home::class,'login']);
$routes->get('register',[Home::class,'register']);
$routes->get('logout',[AuthController::class,'logout']);
$routes->post('register',[Home::class,'submitRegister']);



$routes->group('dashboard', function ($routes) {
    $routes->get('', [DashboardController::class,'index']);
    $routes->post('change_group', [DashboardController::class,'changeGroup']);
    $routes->post('change_password/(:num)', [DashboardController::class,'changePassword']);
});

$routes->group('submission',['filter' => 'permission:view_submissions_page'], function ($routes) {
    $routes->get('', [SubmissionController::class,'index'], ['filter' => 'permission:view_submissions_page']);
    $routes->get('detail/(:num)', [SubmissionController::class,'detail'], ['filter' => ['permission:view_submission_details', 'isMySubmission']]);
    $routes->post('add', [SubmissionController::class,'add'], ['filter' => 'permission:add_submissions']);
    $routes->get('delete/(:num)', [SubmissionController::class,'delete'], ['filter' => 'permission:delete_submissions']);
    $routes->post('update/(:num)', [SubmissionController::class,'update'], ['filter' => 'permission:update_submission']);
    $routes->get('submit/(:num)', [SubmissionController::class,'submit'], ['filter' => 'permission:submit_submission']);
    $routes->get('submit-two/(:num)', [SubmissionController::class,'submitTwo'], ['filter' => 'permission:submit_submission']);
    $routes->get('approve-one/(:num)', [SubmissionController::class,'approveOne'], ['filter' => 'permission:approval_one_submission']);
    $routes->get('approve-two/(:num)', [SubmissionController::class,'approveTwo'], ['filter' => 'permission:approval_two_submission']);
    $routes->get('authenticate/(:num)', [SubmissionController::class,'authenticate'], ['filter' => 'permission:authenticate_submission']);
    $routes->post('reject/(:num)', [SubmissionController::class,'reject'], ['filter' => 'permission:reject_submission']); // belum masuk permission
    $routes->post('revision/(:num)', [SubmissionController::class,'revision'], ['filter' => 'permission:revision_submission']); // belum masuk permission
    $routes->post('upload-invoice/(:num)', [SubmissionController::class,'uploadInvoice'], ['filter' => 'permission:upload_invoice_submission']); // ganti nama permission

});

$routes->group('item',['filter' => 'isMySubmission'], function ($routes) {
    $routes->post('add/(:num)', [ItemController::class,'add'], ['filter' => 'permission:add_submission_items']);
    $routes->post('fetch', [ItemController::class,'fetch'], ['filter' => 'permission:update_submission_items']);
    $routes->post('update/(:num)', [ItemController::class,'update'], ['filter' => 'permission:update_submission_items']);
    $routes->get('delete/(:num)', [ItemController::class,'delete'], ['filter' => 'permission:delete_submission_items']);
});

$routes->group('user', ['filter' => 'permission:view_user_management_page'],function ($routes) {
    $routes->get('', [UserController::class,'index']);
    $routes->get('accept/(:num)', [UserController::class,'accept']);
    $routes->get('delete/(:num)', [UserController::class,'delete'], );
    $routes->post('add_group/(:num)', [UserController::class,'addGroup']);
    $routes->post('get_group', [UserController::class,'getGroup']);
    $routes->post('get_user', [UserController::class,'getUser']);
    $routes->post('update_user/(:num)', [UserController::class,'updateUser']);
    $routes->post('reset_password/(:num)', [UserController::class,'resetPassword']);
});
