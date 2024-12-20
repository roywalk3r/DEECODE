<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Shop\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateShopCustomer
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $event->user;

        $customer = Customer::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Update the customer if needed
        if ($customer->name !== $user->name || $customer->email !== $user->email) {
            $customer->update([
                'name' => $user->name,
                'email' => $user->email,
                'updated_at' => now(),
            ]);
        }
    }
}
