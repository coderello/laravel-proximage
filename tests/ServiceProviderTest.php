<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Tests\Stubs\FooTemplate;

class ServiceProviderTest extends AbstractTestCase
{
    public function test_applying_default_templates_specified_in_config_file()
    {
        config([
            'proximage.defaults.templates' => [
                FooTemplate::class,
            ],
        ]);

        $this->assertSame(
            (string) (new ImageProxy)
                ->url('http://example.com/image.png')
                ->template(FooTemplate::class),
            (string) $this->app->make('proximage')
                ->url('http://example.com/image.png')
        );
    }
}
