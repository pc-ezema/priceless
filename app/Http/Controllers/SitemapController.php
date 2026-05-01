<?php
// app/Http/Controllers/SitemapController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // Serve static file if exists
        $staticFile = public_path('sitemap.xml');
        
        if (file_exists($staticFile)) {
            return response(file_get_contents($staticFile), 200)
                ->header('Content-Type', 'text/xml')
                ->header('Cache-Control', 'public, max-age=3600');
        }
        
        // Fallback sitemap
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $xml .= '    <url>' . "\n";
        $xml .= '        <loc>' . url('/') . '</loc>' . "\n";
        $xml .= '        <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '        <priority>1.0</priority>' . "\n";
        $xml .= '    </url>' . "\n";
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'text/xml');
    }
}