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
