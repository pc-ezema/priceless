<?php

namespace App\Http\Controllers;

use App\Models\Service;
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
        
        // Get dynamic pages from database (if you have any)
        $services = [];
        if (class_exists('App\Models\Service')) {
            $services = Service::where('is_active', true)
                ->orderBy('updated_at', 'desc')
                ->get()
                ->map(function ($service) {
                    return [
                        'loc' => url('/services/' . \Illuminate\Support\Str::slug($service->name)),
                        'lastmod' => $service->updated_at->toDateString(),
                        'changefreq' => 'weekly',
                        'priority' => '0.8'
                    ];
                });
        }

        return response()->view('sitemap', compact('staticPages', 'services'))
            ->header('Content-Type', 'text/xml');
    }
}
