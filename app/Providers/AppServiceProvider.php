<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

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
        Response::macro('success', function (array $data = []): JsonResponse {
            return response()->json(array_merge($data, [
                'success' => true,
            ]));
        });

        Response::macro('fail', function (string $message, array $data = []): JsonResponse {
            return response()->json(array_merge($data, [
                'success' => false,
                'error' => $message,
            ]));
        });
    }
}
