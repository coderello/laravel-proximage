# Installation

You can install this package via composer using this command:

```bash
composer require coderello/laravel-proximage
```

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --tag="proximage-config"
```

This is the contents of the published config file:

```php
return [

    'defaults' => [
        /*
         * Templates which would be applied to all proxied images.
         *
         * Each template must implement \Coderello\Proximage\Contracts\Template
         */
        'templates' => [
            // \Coderello\Proximage\Templates\DisableProxyingForLocalEnvironmentTemplate::class,
        ],
    ],

];
```
