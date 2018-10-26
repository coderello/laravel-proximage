<p align="center"><img alt="Proximage" src="logo.png" width="450"></p>

<p align="center"><b>Proximage</b> is a handy package for proxying images through the <a href="https://images.weserv.nl">images.weserv.nl</a> (free image cache & resize service) with which you can greatly increase the performance of the site.</p>

## Installation

You can install this package via composer using this command:

```bash
composer require coderello/laravel-proximage
```

The package will automatically register itself.

## Examples of use

Only caching:

```php
proximage($imageUrl)
  ->get();
```

Caching and resizing:
```php
proximage($imageUrl)
  ->width(300)
  ->get();
```

Caching and cropping:
```php
use Coderello\Proximage\Enums\Parameter;
```
```php
proximage($imageUrl)
  ->crop(Parameter\CropAlignment::CENTER)
  ->transformation(Parameter\Transformation::SQUARE)
  ->get();
```


## Documentation

You'll find the documentation on [https://docs.coderello.com/laravel-proximage](https://docs.coderello.com/laravel-proximage).

Find yourself stuck using the package? Found a bug? Do you have general questions or suggestions for improving the media library? Feel free to [create an issue on GitHub](https://github.com/coderello/laravel-proximage/issues), we'll try to address it as soon as possible.

## Testing

You can run the tests with:

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
