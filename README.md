# Laravel validation wrapper

This package, when used with form requests expecting Json, generates Json response with the errors representing rule index rather than message for a failed rule i.e.

```php
[
    'message' => 'The given data was invalid.',
    'errors' => [
        'name' => ['required', 'max'],
        'email' ['email'],
    ],
]
```

If request is not expecting Json - default Laravel redirect response with errors stored in session is being used.

Using this package with front and back end validation allows us having validation message directly with the form and only reveal the relevant one based on which rule failed the validation.

## Installation

```bash
composer require sebastiansulinski/laravel-validation
```

## Service Provider

Replace default `Illuminate\Validation\ValidationServiceProvider::class` provider in `config/app.php`:


```php
<?php

return [
    ...
    
    'providers' => [
        ...
        // Illuminate\Validation\ValidationServiceProvider::class, - remove
        SSD\LaravelValidation\ValidationServiceProvider::class,
    
    ],
];
```