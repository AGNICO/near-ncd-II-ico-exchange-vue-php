## PHP Laravel Gateway installation + usage

It's standard fresh Laravel 8 framework installation...[See official docs](https://laravel.com/docs/8.x)

Update `.env` to allow requests from localhost (see `.env.example` file). The IP middleware is located in `PHP-LARAVEL-GATEWAY\app\Http\Middleware\ClientIPsMiddleware.php` and registered for `API` routes in `PHP-LARAVEL-GATEWAY\app\Http\Kernel.php`:

    CLIENT_IPS=127.0.0.1

The main Near service class is using `NEAR` facade and is located in `PHP-LARAVEL-GATEWAY\app\Services\Near.php`. The service provider is located in `PHP-LARAVEL-GATEWAY\app\Providers\NearServiceProvider.php`.

You can see a brief walk through the code in the attached video.
