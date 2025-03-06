<?php

namespace ShaonMajumder\Cors\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use ShaonMajumder\Cors\Http\Middleware\CorsMiddleware;
use RuntimeException;

class CorsServiceProvider extends ServiceProvider
{
    protected $configFilePath = __DIR__ . '/../../config/corsconfig.php';
    
    /**
     * Register services.
     */
    public function register()
    {
        $this->configExists();
        $this->mergeConfigFrom(
            $this->configFilePath, 'corsconfig'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->configExists();
        $this->publishes([
            $this->configFilePath => config_path('corsconfig.php'),
        ], 'cors-config');
        $this->ensureEnvEntries();
        $this->registerMiddleware();
    }

    /**
     * Check if the config file exists.
     *
     * @throws \RuntimeException
     */
    public function configExists()
    {
        if (!File::exists($this->configFilePath)) {
            throw new RuntimeException('Config file corsconfig.php not found. Please ensure the config file is in the correct location.');
        }
    }

    /**
     * Ensure that necessary entries exist in the .env file.
     */
    protected function ensureEnvEntries()
    {
        $envFilePath = base_path('.env'); // Store the path to the .env file

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);
            $this->ensureEnvEntry($envFilePath, $envContent, 'CORS_ALLOWED_METHODS', 'GET, POST, PUT, DELETE, OPTIONS');
            $this->ensureEnvEntry($envFilePath, $envContent, 'CORS_ALLOWED_ORIGINS', 'http://localhost:8000, http://localhost:8001');
            $this->ensureEnvEntry($envFilePath, $envContent, 'CORS_ALLOWED_HEADERS', 'Content-Type, Authorization, X-CSRF-TOKEN, Referer, X-Origin');
        } else {
            throw new RuntimeException('.env file not found. Please ensure the .env file exists in the root of the project.');
        }
    }

    /**
     * Check and append a missing entry in the .env file.
     *
     * @param string $envFilePath
     * @param string $envContent
     * @param string $key
     * @param string $value
     */
    protected function ensureEnvEntry(string $envFilePath, string $envContent, string $key, string $value)
    {
        if (strpos($envContent, $key) === false) {
            File::append($envFilePath, "\n$key=$value\n");
        }
    }

    /**
     * Register the CORS middleware in the application kernel.
     */
    public function registerMiddleware()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('cors', CorsMiddleware::class);
    }

}
