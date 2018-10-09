<?php

namespace Coderello\Proximage;

use Coderello\Proximage\Enums\Parameter;
use Illuminate\Support\Collection;

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