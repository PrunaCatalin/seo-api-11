<?php

/*
 * seo-api | CustomerService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email: office@webdirect.ro
 * Type: Javascript
 * Created on: 3/11/2024 12:12 PM
*/

namespace Modules\Tenants\App\Services\Customer;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use LaravelIdea\Helper\Modules\Tenants\App\Models\Customer\_IH_Customer_C;
use LaravelIdea\Helper\Modules\Tenants\App\Models\Customer\_IH_Customer_QB;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Emails\CustomerResetPassword;
use Modules\Tenants\App\Enums\Customer\CustomerAccountStatus;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Customer\CustomerTerm;

class CustomerService implements CrudMicroService
{

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @inheritDoc
     * @throws ServiceException
     */
    public function syncInfo(array $data, int $customerId = 0)
    {
        try {
            $customer = $this->find($customerId);
            if ($data['type'] == 'profile') {
                if (!$data['isNewUser']) {
                    $customer->customerDetails->update($data);
                } else {
                    $customer = Customer::create($data);
                    if (!$customer) {
                        throw new ServiceException('Something is wrong', []);
                    }
                    $customer->customerDetails->create($data);
                }
                $this->updateTerms(data: $data, customerId: $customer->id);
            } elseif ($data['type'] == 'addresses') {
                if (isset($data['address_id']) && is_numeric($data['address_id'])) {
                    $address = $customer->customerAddresses()->find($data['address_id']);
                    if ($address) {
                        $address->update($data);
                    } else {
                        throw new ServiceException('Address not found', []);
                    }
                } else {
                    $customer->customerAddresses()->create($data);
                }
            } else {
                throw new ServiceException('Unknown type', []);
            }
        } catch (ServiceException $exception) {
            throw new ServiceException($exception->getMessage(), []);
        }
    }

    private function updateTerms(array $data, int $customerId): void
    {
        foreach ($data['terms'] as $term => $value) {
            $identifyingAttributes = [
                'customer_id' => $customerId,
                'type' => $term
            ];
            $valuesToUpdate = [
                'checked' => (int)$value
            ];
            CustomerTerm::updateOrCreate($identifyingAttributes, $valuesToUpdate);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param int $id
     * @return Customer|Customer[]
     * @throws ServiceException
     */
    public function find(int $id)
    {
        $user = Customer::with(['customerDetails', 'customerTerms'])->find($id);
        if (!$user) {
            throw new ServiceException('Customer is not found', []);
        }
        return $user;
    }

    /**
     * @throws ServiceException
     */
    public function login(array $data)
    {
        $user = Customer::with(['customerDetails', 'referralsMade'])->where(
            'email',
            $data['email']
        )->first();
        if (!$user) {
            throw new ServiceException('Email is not found', []);
        } elseif ($user->account_status == CustomerAccountStatus::BLOCKED->value) {
            throw new ServiceException('Account is blocked', []);
        } elseif ($user->account_status == CustomerAccountStatus::PENDING->value) {
            throw new ServiceException('Account need to be activated', []);
        } else {
            $user->nameLetters = 'N/A';
            if (preg_match_all('/(?<=\s|^)\w/iu', ucwords(strtolower($user->name)), $matches)) {
                $user->nameLetters = implode('', $matches[0]);
            }
            if (Hash::check($data['password'], $user->password)) {
                $user->tokens()->where('tokenable_id', $user->id)->delete();
                // cleanup old tokens
                $user->token = $user->createAuthToken('WD-Auth')->plainTextToken;
                $user->current_plan = $user->currentPlan();
                return $user;
            } else {
                throw new ServiceException('Email password is wrong', []);
            }
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function resetPassword(array $data): bool
    {
        $record = DB::table('password_resets')->where('token', $data['token'])->first();
        if ($record) {
            $customer = Customer::where('email', $record->email)->first();
            $customer->password = bcrypt($data['password']);
            $customer->save();
            //Use transaction to avoid lost
            DB::transaction(function () use ($record) {
                DB::table('password_resets')->where('email', $record->email)->delete();
            });
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     * @return true
     */
    public function forgotPassword(array $data): bool
    {
        $token = hash('sha256', time());
        $user = Customer::with([
            'domains' => function ($q) {
                $q->isActive();
            }
        ])->where('email', $data['email'])->first();
        if ($user) {
            DB::table('password_resets')->insert([
                'email' => $data['email'],
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            Mail::to($data['email'])->send(new CustomerResetPassword($token, $data['email'], $user));
            return true;
        }
        return false;
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }
}
