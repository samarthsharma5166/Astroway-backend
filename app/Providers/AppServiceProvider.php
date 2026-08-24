<?php

namespace App\Providers;

use App\Models\AdminModel\SystemFlag;
use App\Models\Page;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.url')) {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
            if (str_starts_with(config('app.url'), 'https')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('ai_conversations')) {
            \Illuminate\Support\Facades\Schema::create('ai_conversations', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->string('conversation_id')->unique();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('ai_astrologer_id');
                $table->string('status')->default('active'); // active, closed
                $table->timestamps();
            });
        }

        if (!\Illuminate\Support\Facades\Schema::hasTable('ai_messages')) {
            \Illuminate\Support\Facades\Schema::create('ai_messages', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->id();
                $table->string('conversation_id');
                $table->string('role'); // user, assistant
                $table->text('content');
                $table->text('image')->nullable();
                $table->timestamps();
            });
        }

        Paginator::defaultView('vendor.pagination.simple-tailwind');

        View::composer('*', function ($view) {
            // Use helper functions for cached system flags
            $professionTitle = getProfessionTitle();
            $appname = getAppName();

            // Share the data with the view
            $view->with([
                'professionTitle' => $professionTitle,
                'appname' => $appname
            ]);

            // Cache footer pages for 1 hour
            $footerPages = cache()->remember('footer_pages_active', 3600, function () {
                return Page::where('isActive', 1)->get();
            });
            $view->with('footerPages', $footerPages);

            // Cache coin icon and wallet type for 1 hour
            $coinIcon = cache()->remember('system_flag_coinIcon', 3600, function () {
                return systemflag('coinIcon');
            });

            $walletType = cache()->remember('system_flag_walletType', 3600, function () {
                return strtolower(systemflag('walletType'));
            });

            // Share them with all Blade views
            View::share('coinIcon', $coinIcon);
            View::share('walletType', $walletType);
        });
    }
}
