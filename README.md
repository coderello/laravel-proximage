<p align="center"><img alt="Proximage" src="logo.png" width="450"></p>

<p align="center"><b>Proximage</b> is a handy package for proxying images through the <a href="https://images.weserv.nl">images.weserv.nl</a> (free image cache & resize service) with which you can greatly increase the performance of the site.</p>

## Installation

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

## Some important notes

- images are not processed on your server (package generates a link to your image processed by a third-party service);
- the only way to specify an input image is to pass its public link.

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

## Main methods

### url(?string $value): self

Sets the link to your input image.

### parameter(string $name, $value): self

Sets the value of the parameter by its name.

You can find all existing parameter names in `Parameter` enum situated in `Coderello\Proximage\Enums` namespace.

> More handy way is to use methods for image manipulations which can be found in the section below.

### shouldProxy(Closure $shouldProxy): self

Sets callback which detects if given image should be proxied. Callback receives `$url` as the first argument and should return `true` or `false`.

### template($template): self

Applies template to the current `ImageProxy` instance.

**Accepts:**

- `string` (template class name)
- `object` (template instance)

**Out-of-the-box templates (you can find them in `Coderello\Proximage\Templates\AvatarTemplate` namespace):**

- `AvatarTemplate`
- `DisableProxyingForLocalEnvironmentTemplate`

> Of course, you are not limited to these ones. You can create your own templates. Each one must implement `Template` contract situated in the `Coderello\Proximage\Contracts` namespace.

### get(): ?string

Returns URL of proxied image.

## Methods for image manipulations 

### width($value): self

Sets the width of the image, in pixels.

### height($value): self

Sets the height of the image, in pixels.

### devicePixelRatio($value): self

The device pixel ratio is used to easily convert between CSS pixels and device pixels. This makes it possible to display images at the correct pixel density on a variety of devices such as Apple devices with Retina Displays and Android devices. You must specify either a width, a height, or both for this parameter to work. Use values between `1` and `8`.

### transformation($value): self

Controls how the image is fitted to its target dimensions.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\Transformation`

**Accepts:**

- `Transformation::FIT`

Default. Resizes the image to fit within the width and height boundaries without cropping, distorting or altering the aspect ratio. Will not oversample the image if the requested size is larger than that of the original.

- `Transformation::FIT_UP`

Resizes the image to fit within the width and height boundaries without cropping, distorting or altering the aspect ratio. Will increase the size of the image if it is smaller than the output size.

- `Transformation::SQUARE`

Resizes the image to fill the width and height boundaries and crops any excess image data. The resulting image will match the width and height constraints without distorting the image. Will increase the size of the image if it is smaller than the output size.

- `Transformation::SQUARE_DOWN`

Resizes the image to fill the width and height boundaries and crops any excess image data. The resulting image will match the width and height constraints without distorting the image. Will not oversample the image if the requested size is larger than that of the original.

- `Transformation::ABSOLUTE`

Stretches the image to fit the constraining dimensions exactly. The resulting image will fill the dimensions, and will not maintain the aspect ratio of the input image.

- `Transformation::LETTERBOX`

Resizes the image to fit within the width and height boundaries without cropping or distorting the image, and the remaining space is filled with the background color. The resulting image will match the constraining dimensions.

### crop($value): self

Controls how the image is aligned.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\CropAlignment`

**Crop position**

You can set where the image is cropped by adding a crop position. Only works when transformation is `Transformation::SQUARE`. Accepts `CropAlignment::TOP`, `CropAlignment::LEFT`, `CropAlignment::CENTER`, `CropAlignment::RIGHT` or `CropAlignment::BOTTOM`. Default is `CropAlignment::CENTER`.

**Crop focal point**

In addition to the crop position, you can be more specific about the exact crop position using a focal point. Only works when transformation is `Transformation::SQUARE`. This is defined using two offset percentages: `crop-x%-y%`.

**Smart crop**

Crops the image down to specific dimensions by removing boring parts. Only works when transformation is `Transformation::SQUARE`.

Accepts:

- `CropAlignment::ENTROPY`: focus on the region with the highest Shannon entropy.
- `CropAlignment::ATTENTION`: focus on the region with the highest luminance frequency, colour saturation and presence of skin tones.

**Manual crop**

Crops the image to specific dimensions after any other resize operations. Required format: `width,height,x,y`.

### mask($value): self

Sets the mask type from a predefined list of shapes.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\Mask`

**Accepts:**

- `Mask::CIRCLE`
- `Mask::ELLIPSE`
- `Mask::TRIANLGE`
- `Mask::TRIANLGE_180`: triangle tilted upside down
- `Mask::PENTAGON`
- `Mask::PENTAGON_180`: pentagon tilted upside down
- `Mask::HEXAGON`
- `Mask::SQUARE`: square tilted 45 degrees
- `Mask::STAR`: 5-point star
- `Mask::HEART`

### maskTrim($value): self

Removes the remaining whitespace from the mask.

### maskBackground($value): self

Sets the background color of the mask.

### orientation($value): self

Rotates the image. Accepts `auto` or if an angle is specified, it is converted to a valid `90`/`180`/`270` degree rotation. For example, `-450` will produce a `270` degree rotation. Default is `auto`. The `auto` option uses Exif data to automatically orient images correctly.

### brightness($value): self

Adjusts the image brightness. Use values between `-100` and `+100`, where `0` represents no change.

### contrast($value): self

Adjusts the image contrast. Use values between `-100` and `+100`, where `0` represents no change.

### gamma($value): self

Adjusts the image gamma. Use values between `1` and `3`. The default value is `2.2`, a suitable approximation for sRGB images.

### sharpen($value): self

Sharpen the image. Required format: `f,j,r`

**Arguments:**

- Flat `f` - Sharpening to apply to flat areas. (Default: 1.0)
- Jagged `j` - Sharpening to apply to jagged areas. (Default: 2.0)
- Radius `r` - Sharpening mask to apply in pixels, but comes at a performance cost. (optional)

### trim($value): self

Trim "boring" pixels from all edges that contain values within a similarity of the top-left pixel. Trimming occurs before any resize operation. Use values between `1` and `254` to define a tolerance level to trim away similar color values. You also can specify just &trim, which defaults to a tolerance level of 10.

### background($value): self

Sets the background color of the image. Supports a variety of color formats. In addition to the 140 color names supported by all modern browsers (listed here), it also accepts hexadecimal RGB and RBG alpha formats.

**Hexadecimal**

- 3 digit RGB: `CCC`
- 4 digit ARGB (alpha): `5CCC`
- 6 digit RGB: `CCCCCC`
- 8 digit ARGB (alpha): `55CCCCCC`

### blur($value): self

Adds a blur effect to the image. Use values between `0` and `100`.

### filter($value): self

Applies a filter effect to the image.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\Filter`

**Accepts:**
- `Filter::GREYSCALE`
- `Filter::SEPIA`
- `Filter::NEGATE`

### quality($value): self

Defines the quality of the image. Use values between `0` and `100`. Defaults to `85`. Only relevant if the format is set to `Output::JPG`.

### output($value): self

Encodes the image to a specific format. If none is given, it will honor the origin image format.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\Output`

**Accepts:**
- `Output::JPG`
- `Output::PNG`
- `Output::GIF`
- `Output::TIFF`
- `Output::WEBP`

### interlace($value): self

Adds interlacing to GIF and PNG. JPEG's become progressive.

### encoding($value): self

Encodes the image to be used directly in the src= of the `<img>`-tag.

Namespace of enum with possible values: `Coderello\Proximage\Enums\Parameter\Encoding`

**Accepts:**
- `Encoding::BASE64`

### defaultImage($value): self

If there is a problem loading an image, then a error is shown. However, there might be a need where instead of giving a broken image to the user, you want a default image to be delivered.

### page($value): self

To load a given page (for an PDF, TIFF and multi-size ICO file). The value is numbered from zero.

### filename($value): self

To specify the filename returned in the `Content-Disposition` header. The filename must only contain alphanumeric characters.

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
