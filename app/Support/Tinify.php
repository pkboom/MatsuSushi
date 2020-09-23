<?php

namespace App\Support;

class Tinify
{
    protected $image;

    public static function createFromUrl($url)
    {
        static::setApiKey();

        $image = \Tinify\fromUrl($url);

        return new static($image);
    }

    public static function createFromPath($path)
    {
        static::setApiKey();

        $image = \Tinify\fromFile($path);

        return new static($image);
    }

    public function __construct($image)
    {
        $this->image = $image;
    }

    public function resize($config)
    {
        $this->image = $this->image->resize($config);

        return $this;
    }

    public function store($path)
    {
        $this->image->toFile($path);

        return basename($path);
    }

    public static function setApiKey()
    {
        \Tinify\setKey(config('services.tinify.api_key'));
    }
}
