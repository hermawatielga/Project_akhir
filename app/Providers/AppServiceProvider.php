<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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
        // 1. Set Timezone ke Jakarta (WIB)
        config(['app.timezone' => 'Asia/Jakarta']);

        // 2. Set Locale Carbon ke Bahasa Indonesia
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');

        // 3. Fix untuk panjang string database (opsional tapi disarankan)
        Schema::defaultStringLength(191);
    }
}