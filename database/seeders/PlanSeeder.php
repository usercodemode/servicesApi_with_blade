<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Free Plan',
                'description' => 'Limited features for basic needs.',
                'features' => json_encode(['1 Project', '5 GB Storage', 'Basic Support']),
                'price' => 0, // Informational, not for payment processing
            ],
            [
                'name' => 'Pro Plan',
                'description' => 'More features for growing businesses.',
                'features' => json_encode(['Unlimited Projects', '50 GB Storage', 'Priority Support']),
                'price' => 24.99, // Informational, not for payment processing
            ],
            [
                'name' => 'Enterprise Plan',
                'description' => 'Advanced features for large teams.',
                'features' => json_encode(['Customizable Features', 'Dedicated Support', 'Enterprise Security']),
                'price' => 49.99, // Informational, not for payment processing
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
