<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\OwnEmailSentModel;
use jdavidbakr\MailTracker\MailTracker;
use Illuminate\Database\Schema\Builder;

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
        Builder::defaultStringLength(191);

        MailTracker::useSentEmailModel(OwnEmailSentModel::class);
    }
}
