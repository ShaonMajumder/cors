# CORS (Cross-Origin Resource Sharing) Laravel Package
A Laravel package to handle Cross-Origin Resource Sharing (CORS) requests in Laravel applications. This package provides a middleware to manage CORS headers for your routes, making it easy to configure and use CORS in your Laravel project.

## Installation
1. **Install the package via Composer:**
Run the following command to install the package:
```bash
composer require shaonmajumder/cors
```

2. **Publish the configuration file:**
Configuration should automatically publish during installation.
Still, After installing, publish the configuration file using Artisan:
```bash
php artisan vendor:publish --provider="ShaonMajumder\\Cors\\Providers\\CorsServiceProvider" --tag=cors-config
```
This will create the `corsconfig.php` configuration file in the `config` directory of your Laravel application.

3. **Configure CORS settings:**
ENV is already set during installation. You can also configure these values in the `.env` file:
Example `.env` entries:
```env
CORS_ALLOWED_METHODS=GET, POST, PUT, DELETE, OPTIONS
CORS_ALLOWED_ORIGINS=http://localhost:8000, http://example.com
CORS_ALLOWED_HEADERS=Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin
```

## Usage
1. **Apply the middleware globally (optional):**
Altough we have registered the middleware.
You can add the `cors` middleware to the global middleware stack by editing the `app/Http/Kernel.php` file.
In the `$middleware` array, add:
```php
\ShaonMajumder\Cors\Http\Middleware\CorsMiddleware::class,
```
2. **Apply the middleware to specific routes:**
You can also apply the middleware to specific routes by adding it to your routes or controllers.
Example:
```php
Route::middleware(['cors'])->get('/some-endpoint', 'SomeController@someMethod');
```
Alternatively, if you want to apply the middleware to a controller:
```php
class SomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('cors');
    }

    public function someMethod()
    {
        return response()->json(['message' => 'CORS headers added']);
    }
}
```

## Configuration Options
You can configure the following options in the `config/corsconfig.php` file or in your `.env` file:
- `CORS_ALLOWED_METHODS`: Comma-separated list of allowed HTTP methods (default: `GET, POST, PUT, DELETE, OPTIONS`).
- `CORS_ALLOWED_ORIGINS`: Comma-separated list of allowed origins (default: `http://localhost:8000, http://localhost:8001`).
- `CORS_ALLOWED_HEADERS`: Comma-separated list of allowed headers (default: `Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin`).

## Environment Configuration
Ensure that the necessary entries exist in your `.env` file:
```env
CORS_ALLOWED_METHODS=GET, POST, PUT, DELETE, OPTIONS
CORS_ALLOWED_ORIGINS=http://localhost:8000, http://localhost:8001
CORS_ALLOWED_HEADERS=Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin
```

## License
This package is open-source and available under the [MIT License](LICENSE).

## Authors
Shaon Majumder <smazoomder@gmail.com>