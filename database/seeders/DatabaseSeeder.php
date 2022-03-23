<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\PaymentApproval;
use App\Models\TravelPayment;
use Illuminate\Database\Seeder;
use \App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(110)->create()->each(function ($user) {

            if($user->type === 'BUYER'){
                Payment::factory(5)->create([
                    'user_id' => $user->id,
                ])->each(function ($payment){
                    PaymentApproval::factory(1)->create([
                        'payment_id' => $payment->id,
                        'payment_type' => 'payment',
                    ]);
                });

                TravelPayment::factory(110)->create([
                    'user_id' => $user->id,
                ])->each(function ($payment){
                    PaymentApproval::factory(1)->create([
                        'travel_payment_id' => $payment->id,
                        'payment_type' => 'travel_payment',
                    ]);
                });

            }
        });
    }
}
