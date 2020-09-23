<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // for api success
        Response::macro('apiSuccess', function ($result, $httpCode) {
            return Response::json([
                'Code' => 0,
                'Message' => '',
                'Result' => $result,
            ], $httpCode);
        });

        // for api failed
        Response::macro('apiFail', function ($respone, $httpCode) {
            return Response::json([
                'Code' => $respone['Code'],
                'Message' => $respone['Message'],
                'Result' => null,
            ], $httpCode);
        });
    }
}
