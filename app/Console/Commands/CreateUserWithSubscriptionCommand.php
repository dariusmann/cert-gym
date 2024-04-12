<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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

        $randomStr = Str::random(15); // Generate a random string of 15 characters
        $stripeId = 'sub_certgym_team_' . $randomStr; // Append it to 'sub_certgym_team'

        $subscription = $user->subscriptions()->create([
            'name' => 'default',
            'stripe_id' => $stripeId,
            'stripe_status' => 'active',
            'trial_ends_at' => null,
            'ends_at' => null,
        ]);

        $subscription->items()->create([
            'stripe_product' => 'prod_certgym_team',
            'stripe_price' => 'price_certgym_team',
            'stripe_id' => $stripeId,
            'quantity' => 1,
        ]);

        $this->info("User with subscription created successfully.");
    }
}
