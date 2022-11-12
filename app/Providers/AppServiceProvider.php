<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Cashier\Cashier;
use App\Models\Page;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Http\Request $request) {
        if (!empty( env('NGROK_URL') ) && $request->server->has('HTTP_X_ORIGINAL_HOST')) {
            $this->app['url']->forceRootUrl(env('NGROK_URL'));
        }
        
        Blade::directive('icon', function($expression) {
            $name = str_replace("'", '', $expression);
            return '<i class="fas fa-' . $name . '"></i>';
        });
        Blade::directive('price', function($expression) {
            return "<?php echo number_format($expression, 2, '.', ''); ?>";
        });
        Blade::if('admin', function() {
            return ! auth()->check() && auth()->user()->admin;
        });

        if(\Schema::hasTable('pages')) {
            $pages = Page::all();
            view()->share('pages', $pages);
        }
    }
}
