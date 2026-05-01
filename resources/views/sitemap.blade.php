{{-- resources/views/sitemap.blade.php --}}
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['loc'] }}</loc>
        <lastmod>{{ $page['lastmod'] }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
    
    @foreach($services as $service)
    <url>
        <loc>{{ url('/services/' . \Illuminate\Support\Str::slug($service->name)) }}</loc>
        <lastmod>{{ $service->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
        <image:image>
            <image:loc>{{ url('images/services/' . strtolower(str_replace(' ', '-', $service->name)) . '.jpg') }}</image:loc>
            <image:title>{{ $service->name }}</image:title>
        </image:image>
    </url>
    @endforeach
</urlset>