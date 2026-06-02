<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware(['web'])
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('supplier')
                ->group(base_path('routes/supplier.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('salesmanager')
                ->group(base_path('routes/salesmanager.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('employee')
                ->group(base_path('routes/employee.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('customer')
                ->group(base_path('routes/customer.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('productdata')
                ->group(base_path('routes/productdata.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/vehicle.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/area.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/catalogcategory.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/usersaccount.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('distributor')
                ->group(base_path('routes/distributor.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('grn')
                ->group(base_path('routes/grn.php'));

            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/purchasingOrder.php'));

            Route::middleware(['web', 'auth'])
                ->prefix('reports')
                ->group(base_path('routes/report.php'))
            ;

            Route::middleware(['web', 'auth'])
                ->prefix('cpo')
                ->group(base_path('routes/cpo.php'))

            ;
            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/invoice.php'))
            ;
            Route::middleware(['web', 'auth'])
                // ->prefix('loarding')
                ->group(base_path('routes/loading.php'))
            ;

            Route::middleware(['web', 'auth'])
                ->prefix('productreturn')
                ->group(base_path('routes/productreturn.php'))
            ;
            Route::middleware(['web', 'auth'])
                ->prefix('stock')
                ->group(base_path('routes/stock.php'))
            ;
            Route::middleware(['web', 'auth'])
                ->group(base_path('routes/vat.php'))
            ;

            Route::middleware(['web', 'auth'])
                ->prefix('location')
                ->group(base_path('routes/location.php'))
            ;
            Route::middleware(['web', 'auth'])
                ->prefix('menu')
                ->group(base_path('routes/menu.php'))
            ;
        });
    }
}
