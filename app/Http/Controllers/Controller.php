<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function setSEO($title, $description = null, $keywords = null, $image = null)
    {
        // Default values if not provided
        $title = $title ?? 'Priceless Beauty Touch - Luxury Beauty & Spa in Ashford, Kent';
        $description = $description ?? 'Visit Priceless Beauty Touch in Ashford, Kent near Victoria Park. Luxury beauty and spa services including hair styling, waxing, wig services, makeup, and wood therapy. Free parking available. Book your appointment today!';
        $keywords = $keywords ?? 'beauty salon Ashford Kent, spa Ashford, hair styling near me, waxing Ashford, wood therapy Ashford, wigs Kent, makeup artist, Victoria Park beauty, priceless beauty touch';
        $image = $image ?? url('images/logo.png');

        view()->share([
            'seo_title' => $title,
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
