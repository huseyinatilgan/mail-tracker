<?php

namespace App\Providers;

use App\Models\Campaign;
use App\Policies\CampaignPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Campaign::class => CampaignPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Policy'leri kaydet
        $this->registerPolicies();

        // Register Action Layer Listeners
        \Illuminate\Support\Facades\Event::listen(
            \App\Events\SalesSignalDetected::class,
            \App\Listeners\SendWebhooks::class
        );
    }

    /**
     * Policy'leri kaydet
     */
    protected function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
