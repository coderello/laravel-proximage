<?php

namespace Coderello\Proximage;

use Coderello\Proximage\Enums\Parameter;
use Illuminate\Support\Collection;

/**
 * @method self width($value)
 * @method self height($value)
 * @method self devicePixelRatio($value)
 * @method self transformation($value)
 * @method self crop($value)
 * @method self cropAlignment($value)
 * @method self mask($value)
 * @method self maskTrim($value)
 * @method self maskBackground($value)
 * @method self orientation($value)
 * @method self brightness($value)
 * @method self contrast($value)
 * @method self gamma($value)
 * @method self sharpen($value)
 * @method self trim($value)
 * @method self blur($value)
 * @method self filter($value)
 * @method self background($value)
 * @method self quality($value)
 * @method self output($value)
 * @method self interlace($value)
 * @method self encoding($value)
 * @method self defaultImage($value)
 * @method self page($value)
 * @method self filename($value)
 */
class ImageProxy
{
    const DOMAIN = 'images.weserv.nl';

    /** @var string|null */
    protected $url;

    /** @var array */
    protected $parameters = [];

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        $constantName = Parameter::class . '::' . strtoupper(snake_case($name));

        if (defined($constantName)) {
            $this->parameter(
                constant($constantName),
                $arguments[0] ?? null
            );

            return $this;
        }

        trigger_error(
            sprintf(
                'Call to undefined method %s::%s()',
                get_class($this),
                $name
            ),
            E_USER_ERROR
        );
    }

    /**
     * Convert object to string.
     *
     * @return string
     */
    public function __toString()
    {
        $url = $this->prepareUrl($this->url);

        if (is_null($url)) {
            return null;
        }

        $preparedParameters = Collection::make($this->parameters)
            ->reject(function ($value) {
                return is_null($value);
            })
            ->put('url', $url)
            ->toArray();

        return 'https://' . self::DOMAIN . '?' . http_build_query($preparedParameters);
    }

    /**
     * Set URL.
     *
     * @param null|string $url
     * @return ImageProxy
     */
    public function url(?string $url = null): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Add parameter.
     *
     * @param string $name
     * @param $value
     * @return ImageProxy
     */
    public function parameter(string $name, $value): self
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Remove unwanted parts from the URL.
     *
     * @param null|string $url
     * @return null|string
     */
    protected function prepareUrl(?string $url = null): ?string
    {
        $preparedUrl = '';

        if (is_null($host = parse_url($url, PHP_URL_HOST))) {
            return null;
        }

        $preparedUrl .= $host;

        if (! is_null($port = parse_url($url, PHP_URL_PORT))) {
            $preparedUrl .= ':'.$port;
        }

        if (! is_null($path = parse_url($url, PHP_URL_PATH))) {
            $preparedUrl .= $path;
        }

        if (! is_null($query = parse_url($url, PHP_URL_QUERY))) {
            $preparedUrl .= '?'.$query;
        }

        if (! is_null($fragment = parse_url($url, PHP_URL_FRAGMENT))) {
            $preparedUrl .= '#'.$fragment;
        }

        return $preparedUrl;
    }
}
