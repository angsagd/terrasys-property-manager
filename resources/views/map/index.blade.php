<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Property Distribution Map</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">Visual distribution of your entire property portfolio.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            <div id="map" class="h-[560px] rounded-md border border-gray-200 relative z-0"></div>
        </div>
    </div></div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-8.65, 115.2167], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
        fetch('{{ route('map.data') }}').then(r => r.json()).then(items => {
            items.forEach(item => {
                const marker = L.marker([item.latitude, item.longitude]).addTo(map);
                marker.bindPopup(`<strong>${item.property_name}</strong><br>${item.city || ''}, ${item.province || ''}<br>${item.land_right || ''}<br><a href="${item.detail_url}">View Detail</a>`);
                if (item.polygon_geojson) L.geoJSON(item.polygon_geojson).addTo(map);
            });
        });
    </script>
</x-app-layout>
