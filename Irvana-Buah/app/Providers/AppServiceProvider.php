<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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

        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');

        // Register Brevo mail transport
        Mail::extend('brevo', function () {
            return (new BrevoTransportFactory())->create(
                new Dsn(
                    'brevo+api',
                    'default',
                    config('mail.mailers.brevo.key')
                )
            );
        });
    }
}