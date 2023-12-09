<?php

namespace SSDTest;

use Illuminate\Validation\ValidationServiceProvider as IlluminateValidationServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use SSD\LaravelValidation\ValidationServiceProvider;
use SSD\LaravelValidation\Validator;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageProviders($app): array
    {
        return [ValidationServiceProvider::class];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Validator' => Validator::class,
        ];
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<class-string<\Illuminate\Support\ServiceProvider>, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function overrideApplicationBindings($app)
    {
        return [
            IlluminateValidationServiceProvider::class => ValidationServiceProvider::class,
        ];
    }

    /**
     * Get validation response.
     */
    protected function validationError(array $response, string $message = 'The given data was invalid.'): array
    {
        return [
            'message' => $message,
            'errors' => $response,
        ];
    }
}
