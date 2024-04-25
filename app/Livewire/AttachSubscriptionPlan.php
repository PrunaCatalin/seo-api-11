<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

use Modules\Tenants\App\Models\Customer\Customer;
use Modules\Tenants\App\Models\Subscription\SubscriptionPlan;

class AttachSubscriptionPlan extends Component
{
    public $customer;
    public $subscriptionPlanId;
    public $subscriptionPlans;
    public $showModal = false;
    public $data;

    protected $listeners = ['attachSubscriptionPlan' => 'openModal'];

    public function openModal($data)
    {
        $this->data = $data;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->subscriptionPlans = SubscriptionPlan::all()->pluck('name', 'id');
    }

    public function attachSubscriptionPlan()
    {
        $this->customer->subscriptionPlans()->attach($this->subscriptionPlanId);
        $this->emit('refreshTable');
        $this->emit('saved');
    }

    public function render()
    {
        Log::debug(SubscriptionPlan::all());
        return view('livewire.attach-subscription-plan', [
            'subscriptionPlans' => $this->subscriptionPlans
        ]);
    }
}
