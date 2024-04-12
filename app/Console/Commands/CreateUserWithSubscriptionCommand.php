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
    protected $signature = 'app:create-user-with-subscription
                            {name : The name of the user}
                            {email : The email address of the user}
                            {password : The password for the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user with a subscription';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password), // It's important to hash the password
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

        $this->info("User with subscription created successfully.");
    }
}
