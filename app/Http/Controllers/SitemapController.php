<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // Static pages
        $pages = [
            ['loc' => url('/'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => now()->toDateString()],
            ['loc' => url('/#about-us'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/#services'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/#gallery'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/#faqs'), 'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/#contact-us'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => now()->toDateString()],
            ['loc' => url('/book-appointment'), 'priority' => '0.9', 'changefreq' => 'weekly', 'lastmod' => now()->toDateString()],
        ];
        
        // Get dynamic pages from database
        $services = Service::where('is_active', true)->get();
        
        return response()->view('sitemap', compact('pages', 'services'))
            ->header('Content-Type', 'text/xml');
    }
}
