# Introduction

**Proximage** is a handy package for proxying images through the [images.weserv.nl](https://images.weserv.nl) (free image cache & resize service) with which you can greatly increase the performance of the site.

# Some important notes

!> Images are **not** processed on your server (package generates a link to your image processed by a third-party service).

!> The only way to specify an input image is to pass its **public link**.

# Examples of use

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

# Testing

You can run the tests with:

```bash
composer test
```
