<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\Enums\Parameter;
use Coderello\Proximage\Exceptions\InvalidArgumentException;
use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Tests\Stubs\FooTemplate;

class ImageProxyTest extends AbstractTestCase
{
    public function test___toString_method()
    {
        $this->assertSame(
            (new ImageProxy)->url('http://example.com:80/image.jpg?hello=world#laravel')->__toString(),
            'https://'.ImageProxy::DOMAIN.'?'.http_build_query([
                'url' => 'example.com:80/image.jpg?hello=world#laravel'
            ])
        );
    }

    public function test___toString_method_without_input_image_url()
    {
        $this->assertSame(
            (new ImageProxy)->__toString(),
            null
        );
    }

    public function test___toString_method_with_invalid_input_image_url()
    {
        $this->assertSame(
            (new ImageProxy)->url('It is not a url')->__toString(),
            null
        );
    }

    public function test_parameter_method()
    {
        $this->assertSame(
            (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->parameter(Parameter::WIDTH, 100)
                ->__toString(),
            'https://'.ImageProxy::DOMAIN.'?'.http_build_query([
                Parameter::WIDTH => 100,
                'url' => 'example.com/image.jpg'
            ])
        );
    }

    public function test___call_method_with_valid_shortcut()
    {
        $this->assertSame(
            (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->parameter(Parameter::MASK, Parameter\Mask::CIRCLE)
                ->__toString(),
            (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->mask(Parameter\Mask::CIRCLE)
                ->__toString()
        );
    }

    public function test___call_method_with_invalid_shortcut()
    {
        $this->expectExceptionMessage(
            sprintf(
                'Call to undefined method %s::%s()',
                ImageProxy::class,
                'invalidMethod'
            )
        );

        (new ImageProxy)
            ->url('http://example.com/image.jpg')
            ->invalidMethod(20)
            ->__toString();
    }

    public function test_shouldProxy_method()
    {
        $this->assertNotSame(
            'http://example.com/image.jpg',
            (string) (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->shouldProxy(function ($url) {
                    return ends_with($url, '.jpg');
                })
        );

        $this->assertSame(
            'http://example.com/image.jpg',
            (string) (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->shouldProxy(function ($url) {
                    return ends_with($url, '.png');
                })
        );
    }

    public function test_template_method_with_template_class_name_as_argument()
    {
        $this->assertSame(
            (string) (new ImageProxy)->url('http://example.com/image.jpg')
                ->parameter('foo', 'bar'),
            (string) (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->template(FooTemplate::class)
        );
    }

    public function test_template_method_with_template_instance_as_argument()
    {
        $this->assertSame(
            (string) (new ImageProxy)->url('http://example.com/image.jpg')
                ->parameter('foo', 'bar'),
            (string) (new ImageProxy)
                ->url('http://example.com/image.jpg')
                ->template(new FooTemplate)
        );
    }

    public function test_template_method_with_invalid_argument()
    {
        $this->expectException(InvalidArgumentException::class);

        (new ImageProxy)
            ->url('http://example.com/image.jpg')
            ->template('random string');
    }
}
