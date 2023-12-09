<?php

namespace SSD\LaravelValidation;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\NotPwnedVerifier;

class ValidationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerPresenceVerifier();
        $this->registerUncompromisedVerifier();
        $this->registerValidationFactory();
    }

    /**
     * Register the validation factory.
     */
    protected function registerValidationFactory(): void
    {
        $this->app->singleton('validator', function ($app) {
            $validator = new Factory($app['translator'], $app);

            // The validation presence verifier is responsible for determining the existence of
            // values in a given data collection which is typically a relational database or
            // other persistent data stores. It is used to check for "uniqueness" as well.
            if (isset($app['db'], $app['validation.presence'])) {
                $validator->setPresenceVerifier($app['validation.presence']);
            }

            return $validator;
        });
    }

    /**
     * Register the database presence verifier.
     */
    protected function registerPresenceVerifier(): void
    {
        $this->app->singleton('validation.presence', function ($app) {
            return new DatabasePresenceVerifier($app['db']);
        });
    }

    /**
     * Register the uncompromised password verifier.
     */
    protected function registerUncompromisedVerifier(): void
    {
        $this->app->singleton(UncompromisedVerifier::class, function ($app) {
            return new NotPwnedVerifier($app[HttpFactory::class]);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['validator', 'validation.presence', UncompromisedVerifier::class];
    }
}
