<?php

use Illuminate\Support\Facades\Route;
use App\Http\Requests\PaymentRequest;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelPaymentController;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Controllers\UserController;
use App\Http\Requests\TravelPaymentRequest;
use App\Http\Requests\PaymentApprovalRequest;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('register')->post("/register", function (UserRegisterRequest $userRequest) {
    $userController = new UserController();
    return $userController->register($userRequest);
});

Route::name('register')->post("/login", function (UserLoginRequest $userLoginRequest) {
    $userController = new UserController();
    return $userController->login($userLoginRequest);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::name('logout')->post("/logout", [UserController::class, 'logout']);

    Route::group([
        'prefix' => 'payments',
        'as' => 'payments.'
    ], function () {
        Route::name('read')->get('/', [PaymentController::class, 'read']);
        Route::name('create')->post('/', function (PaymentRequest $paymentRequest) {
            $paymentController = new PaymentController();
            return $paymentController->create($paymentRequest);
        });
        Route::name('update')->put('/{id}', function (PaymentRequest $paymentRequest, int $id) {
            $paymentController = new PaymentController();
            return $paymentController->update($paymentRequest, $id);
        });
        Route::name('delete')->delete('/{id}', function (int $id) {
            $paymentController = new PaymentController();
            return $paymentController->delete($id);
        });
        Route::name('approval')->post('/{id}/approval', function (PaymentApprovalRequest $paymentApprovalRequest, int $id) {
            $paymentController = new PaymentController();
            return $paymentController->approval($paymentApprovalRequest, $id);
        });
    });

    Route::group([
        'prefix' => 'travel-payments',
        'as' => 'travel-payments.'
    ], function () {
        Route::name('read')->get('/', [TravelPaymentController::class, 'read']);

        Route::name('create')->post('/', function (TravelPaymentRequest $travelPaymentRequest) {
            $travelPaymentController = new TravelPaymentController();
            return $travelPaymentController->create($travelPaymentRequest);
        });
        Route::name('update')->put('/{id}', function (TravelPaymentRequest $travelPaymentRequest, int $id) {
            $travelPaymentController = new TravelPaymentController();
            return $travelPaymentController->update($travelPaymentRequest, $id);
        });
        Route::name('delete')->delete('/{id}', function (int $id) {
            $travelPaymentController = new TravelPaymentController();
            return $travelPaymentController->delete($id);
        });
        Route::name('approval')->post('/{id}/approval', function (PaymentApprovalRequest $paymentApprovalRequest, int $id) {
            $travelPaymentController = new TravelPaymentController();
            return $travelPaymentController->approval($paymentApprovalRequest, $id);
        });
    });

    Route::name('reports')->get('/reports', [ReportController::class, 'index']);
});
