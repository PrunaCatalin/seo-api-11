<?php
/*
 * seo-api | SubscriptionService.php
 * https://www.webdirect.ro/
 * Copyright 2024 Pruna Catalin Costin
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 4/23/2024 4:33 PM
*/

namespace Modules\Tenants\App\Services\Subscription;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Tenants\App\Contracts\CrudMicroService;
use Modules\Tenants\App\Enums\Subscription\SubscriptionStatus;
use Modules\Tenants\App\Exceptions\ServiceException;
use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class SubscriptionService implements CrudMicroService
{

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @throws ServiceException
     */
    public function attachPlan(Customer|Model $customer, $data)
    {
        $subscriptionPlanId = $data['subscription_plan_id'];
        $frequency = $data['frequency'];

        $endedAt = $this->calculateEndedAt($frequency);

        $this->validateExistingSubscription($customer, $subscriptionPlanId);

        $customer->subscriptionPlans()->attach($subscriptionPlanId, [
            'frequency' => $frequency,
            'ended_at' => $endedAt,
            'is_active' => true,
        ]);
    }

    /**
     * @throws ServiceException
     */
    public function cancelPlan(Customer|Model $customer, int $subscriptionId)
    {
        $subscription = $customer->subscriptionPlans()->wherePivot('subscription_plan_id', $subscriptionId)->first();

        if (!$subscription) {
            throw new ServiceException('No subscription found with the provided ID.');
        }

        $customer->subscriptionPlans()->updateExistingPivot($subscriptionId, [
            'is_active' => false,
            'ended_at' => Carbon::now(),
            'status' => SubscriptionStatus::CANCELED->value
        ]);

        $customer->save();

        return 'Subscription canceled successfully.';
    }

    /**
     * @throws ServiceException
     */
    public function activatePlan(Customer|Model $customer, int $subscriptionId): string
    {
        $subscription = $customer->subscriptionPlans()->wherePivot('subscription_plan_id', $subscriptionId)->first();

        if (!$subscription) {
            throw new ServiceException('No subscription found with the provided ID.');
        }

        if ($subscription->status === SubscriptionStatus::ACTIVE->value) {
            throw new ServiceException('The subscription is already active.');
        }
        $activeSubscriptions = $customer->subscriptionPlans()->wherePivot(
            'status',
            '=',
            SubscriptionStatus::ACTIVE->value
        )->get();

        foreach ($activeSubscriptions as $activeSubscription) {
            if ($activeSubscription->pivot->subscription_plan_id != $subscriptionId) {
                $customer->subscriptionPlans()->updateExistingPivot($activeSubscription->pivot->subscription_plan_id, [
                    'is_active' => false,
                    'ended_at' => Carbon::now(),
                    'status' => SubscriptionStatus::CANCELED->value
                ]);
            }
        }
        $endedAt = $this->calculateEndedAt($subscription->pivot->frequency);
        $customer->subscriptionPlans()->updateExistingPivot($subscriptionId, [
            'is_active' => true,
            'ended_at' => $endedAt,
            'status' => SubscriptionStatus::ACTIVE->value
        ]);
        $creditsToAdd = $this->calculateCredits($subscription->pivot->frequency, $subscriptionId);
        $customer->credits += $creditsToAdd;
        $customer->save();

        return 'Subscription activated successfully.';
    }

    public function detachPlan(Customer|Model $customer, $data)
    {
        $subscriptionPlanId = $data['subscription_plan_id'];
        $frequency = $data['frequency'];
        if (!$customer->subscriptionPlans()->where('subscription_plan_id', $subscriptionPlanId)->exists()) {
            throw new ServiceException('Subscription plan not found or not attached to this customer.');
        }
        $creditsToDeduct = $this->calculateCredits($frequency, $subscriptionPlanId);
        $customer->subscriptionPlans()->detach($subscriptionPlanId);
        if (($customer->credits - $creditsToDeduct) < 0) {
            $customer->credits = 0;
        } else {
            $customer->credits -= $creditsToDeduct;
        }

        $customer->save();
    }


    /**
     * Calculates the end date based on the subscription frequency.
     *
     * @param string $frequency
     * @return Carbon|null
     */
    private function calculateEndedAt(string $frequency): ?Carbon
    {
        $currentDate = Carbon::now();
        return match ($frequency) {
            'monthly' => $currentDate->copy()->addMonth(),
            'yearly' => $currentDate->copy()->addYear(),
            default => null,
        };
    }

    /**
     * Calculates the credits to add based on the subscription frequency and plan.
     *
     * @param string $frequency
     * @param int $subscriptionPlanId
     * @return int
     */
    public function calculateCredits(string $frequency, int $subscriptionPlanId): float
    {
        $subscriptionPlan = SubscriptionPlan::find($subscriptionPlanId);
        return $subscriptionPlan ? ($frequency === 'monthly' ? $subscriptionPlan->points : $subscriptionPlan->points_annually) : 0;
    }

    /**
     * Validates if the subscription plan is already attached to the customer.
     *
     * @param mixed $relatedModel
     * @param int $subscriptionPlanId
     * @throws ServiceException
     */
    private function validateExistingSubscription($relatedModel, $subscriptionPlanId): void
    {
        if ($relatedModel->subscriptionPlans()->where('subscription_plan_id', $subscriptionPlanId)->exists()) {
            throw new ServiceException('Subscription plan is already attached to this customer.');
        }
    }
}
