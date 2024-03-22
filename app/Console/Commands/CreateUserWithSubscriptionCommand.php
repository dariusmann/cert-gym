<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserWithSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user-with-subscription-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => 'Sasha Lopez',
            'email' => 'sasha@lopez.com',
            'password' => 'F4Hcag8564i5Y9Tn'
        ]);

        $subscription = $user->subscriptions()->create([
            'name' => 'default',
            'stripe_id' => 'sub_certgym_team',
            'stripe_status' => 'active',
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);

        $subscription->items()->create([
            'stripe_product' => 'prod_certgym_team',
            'stripe_price' => 'price_certgym_team',
            'stripe_id' => 'si_certgym_team',
            'quantity' => 1,
        ]);
    }
}
