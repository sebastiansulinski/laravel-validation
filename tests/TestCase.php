<?php

namespace SSDTest;

use SSD\LaravelValidation\Validator;
use Orchestra\Testbench\TestCase as BaseTestCase;
use SSD\LaravelValidation\ValidationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider as IlluminateValidationServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ValidationServiceProvider::class];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Validator' => Validator::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $index = array_search(
            IlluminateValidationServiceProvider::class,
            $providers = $app['config']->get('app.providers')
        );

        unset($providers[$index]);

        $app['config']->set('app.providers', $providers);
    }

    /**
     * Get validation response.
     *
     * @param  array $response
     * @param  string $message
     * @return array
     */
    protected function validationError(array $response, string $message = 'The given data was invalid.'): array
    {
        return [
            'message' => $message,
            'errors' => $response,
        ];
    }
}