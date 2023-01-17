<?php

namespace Matteomeloni\Foundation;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class FoundationResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Response::macro('success', function ($message, $data = [], $code = 200) {
            return Response::json([
                'code' => empty($data) ? 204 : $code,
                'message' => $message,
                'data' => $data
            ], $code);
        });

        Response::macro('validationErrors', function($errors) {
            return response::json([
                'code' => 422,
                'message' => __('responses.errors.validation'),
                'errors' => $errors
            ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        });

        Response::macro('unauthenticated', function () {
            return response::json([
                'code' => HttpResponse::HTTP_UNAUTHORIZED,
                'message' => __('responses.errors.unauthenticated')
            ], HttpResponse::HTTP_UNAUTHORIZED);
        });

        Response::macro('unauthorized', function () {
            return response::json([
                'code' => HttpResponse::HTTP_FORBIDDEN,
                'message' => __('responses.errors.unauthorized')
            ], HttpResponse::HTTP_FORBIDDEN);
        });

        Response::macro('modelNotFound', function () {
            return response::json([
                'code' => HttpResponse::HTTP_NOT_FOUND,
                'message' => __('responses.errors.model_not_found')
            ], HttpResponse::HTTP_NOT_FOUND);
        });

        Response::macro('error', function ($code = 500, $bag = []) {
            if ($code < 100 or $code > 599) {
                $code = 500;
            }

            return Response::json([
                'code' => $code,
                'message' => HttpResponse::$statusTexts[$code] ?? 'Unknown status',
                'bag' => $bag
            ], $code);
        });
    }
}
