<?php

namespace Coderello\Proximage\Tests;

use Coderello\Proximage\ImageProxy;
use Coderello\Proximage\Enums\Parameter\Mask;
use Coderello\Proximage\Enums\Parameter\Output;
use Coderello\Proximage\Templates\AvatarTemplate;
use Coderello\Proximage\Enums\Parameter\CropAlignment;
use Coderello\Proximage\Templates\DisableProxyingForLocalEnvironmentTemplate;

class OutOfTheBoxTemplatesTest extends AbstractTestCase
{
    const IMAGE_URL = 'http://exmaple.com/image.png';

    public function test_avatar_template()
    {
        $this->assertSame(
            (string) (new ImageProxy)->url(self::IMAGE_URL)
                ->crop(CropAlignment::ENTROPY)
                ->mask(Mask::CIRCLE)
                ->output(Output::PNG)
                ->maskTrim(true),
            (string) (new ImageProxy)
                ->url(self::IMAGE_URL)
                ->template(AvatarTemplate::class)
        );
    }

    public function test_disable_proxying_for_local_environment_template()
    {
        foreach (['local', 'production'] as $environment) {
            config(['app.env' => $environment]);

            $this->assertSame(
                (string) (new ImageProxy)->url(self::IMAGE_URL)
                    ->shouldProxy(function ($url) {
                        return ! is_null($url)
                            && ! app()->environment('local');
                    }),
                (string) (new ImageProxy)->url(self::IMAGE_URL)
                    ->template(DisableProxyingForLocalEnvironmentTemplate::class)
            );
        }
    }
}
