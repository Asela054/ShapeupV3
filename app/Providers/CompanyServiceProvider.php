<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Company;

class CompanyServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        try {
            $company = Cache::remember('company_details', now()->addHours(24), function () {
                return Company::first()?->toArray();
            });

            if ($company) {
                config(['company' => $company]);
            }

        } catch (\Throwable $e) {
            // Don't crash every request if DB is temporarily unavailable
            logger()->warning('CompanyServiceProvider: ' . $e->getMessage());
        }
    }
}