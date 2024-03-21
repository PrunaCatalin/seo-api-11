<?php

/*
 * wdirect-api | CustomerAuthController.php
 * https://www.webdirect.ro/
 * Copyright 2023 Eugen Buiac
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 6/16/2023 3:44 PM
*/

namespace Modules\Tenants\App\Http\Controllers\Customer;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Tenants\App\Http\Requests\Auth\CustomerForgotPasswordRequest;
use Modules\Tenants\App\Http\Requests\Auth\CustomerResetPasswordRequest;
use Modules\Tenants\App\Services\Customer\CustomerService;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Http\Requests\Auth\CustomerLoginRequest;

class AuthController extends Controller
{
    public function __construct(private readonly CustomerService $customerService)
    {
    }

    /**
     * @param CustomerLoginRequest $request
     * @return JsonResponse
     */
    public function login(CustomerLoginRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $customer = $this->customerService->login([
                'email' => $request['email'],
                'password' => $request['password']
            ]);
            return response()->json([
                'status' => true,
                'user' => $customer
            ]);
        } catch (ServiceException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param CustomerForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(CustomerForgotPasswordRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $customer = $this->customerService->forgotPassword([
                'email' => $request['email']
            ]);
            if ($customer) {
                return response()->json([
                    'status' => true,
                    'message' => 'Reset successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => ['email' => 'Email not found']
                ]);
            }
        } catch (ServiceException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param CustomerResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(CustomerResetPasswordRequest $request): JsonResponse
    {
        $request = $request->validated();
        try {
            $customer = $this->customerService->resetPassword([
                'token' => $request['token'],
                'password' => $request['password'],
            ]);
            if ($customer) {
                return response()->json([
                    'status' => true,
                    'message' => 'Reset successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => ['customer' => 'Reset failed']
                ]);
            }
        } catch (ServiceException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        auth('sanctum')->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => "Logout Success"
        ]);
    }
}
