<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\OwnEmailSentModel;
use jdavidbakr\MailTracker\MailTracker;

class AppServiceProvider extends ServiceProvider
{
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
        MailTracker::useSentEmailModel(OwnEmailSentModel::class);
    }
}
