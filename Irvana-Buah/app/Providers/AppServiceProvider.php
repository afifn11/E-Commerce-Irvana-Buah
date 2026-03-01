<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    public function boot(): void
    {
        Blade::directive('money', function ($expression) {
            return "<?php echo 'Rp' . number_format((float)($expression), 0, ',', '.'); ?>";
        });
    }
}
