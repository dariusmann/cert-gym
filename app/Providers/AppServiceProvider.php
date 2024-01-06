<?php

declare(strict_types=1);

namespace App\Providers;

use App\Overwrite\Spark\Actions\CreateSubscription as OverwriteCreateSubscription;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Spark\Actions\CreateSubscription as SparkCreateSubscription;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias(SparkCreateSubscription::class, OverwriteCreateSubscription::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
