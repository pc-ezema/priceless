<?php
// app/Helpers/SEO.php

namespace App\Helpers;

class SEO
{
    public static $data = [];

    public static function set($title, $description = null, $keywords = null, $image = null)
    {
        self::$data = [
            'title' => $title,
            'description' => $description,
            'keywords' => $keywords,
            'image' => $image,
        ];
    }

    public static function get($key = null)
    {
        if ($key) {
            return self::$data[$key] ?? null;
        }
        return self::$data;
    }
}