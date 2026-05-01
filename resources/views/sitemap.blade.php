<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    @foreach($staticPages as $page)
    <url>
        <loc>{{ $page['loc'] }}</loc>
        <lastmod>{{ $page['lastmod'] }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    @foreach($services as $service)
    <url>
        <loc>{{ $service['loc'] }}</loc>
        <lastmod>{{ $service['lastmod'] }}</lastmod>
        <changefreq>{{ $service['changefreq'] }}</changefreq>
        <priority>{{ $service['priority'] }}</priority>
    </url>
    @endforeach

</urlset>