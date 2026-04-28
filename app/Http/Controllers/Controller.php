<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function setSEO($title, $description = null, $keywords = null, $image = null)
    {
        view()->share([
            'seo_title' => $title . ' | ' . config('app.name'),
            'seo_description' => $description,
            'seo_keywords' => $keywords,
            'seo_og_title' => $title,
            'seo_og_description' => $description,
            'seo_og_image' => $image,
            'seo_twitter_title' => $title,
            'seo_twitter_description' => $description,
            'seo_twitter_image' => $image,
        ]);
    }
}
