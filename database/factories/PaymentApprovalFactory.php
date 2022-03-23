<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentApproval>
 */
class PaymentApprovalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::where('type', 'APPROVER')
                ->inRandomOrder()
                ->first()
            ?? User::factory(1)->create(['type' => 'APPROVER']);

        return [
            'user_id' => $user->id,
            'status' => $this->faker->randomElement(['APPROVED', 'DISAPPROVED'])
        ];
    }
}
