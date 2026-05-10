<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Master Data</h2></x-slot>
    <div class="py-8"><div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        @foreach (['Property Type' => $propertyTypes, 'Status Pemanfaatan' => $utilizationStatuses, 'Jenis Hak' => $landRightTypes, 'Status Sertifikat' => $certificateStatuses, 'Kategori Dokumen' => $documentCategories] as $title => $items)
            <section class="rounded-lg border bg-white p-5 shadow-sm"><h3 class="mb-3 font-semibold">{{ $title }}</h3><div class="divide-y text-sm">@foreach($items as $item)<div class="py-2">{{ $item->name }}</div>@endforeach</div></section>
        @endforeach
    </div></div>
</x-app-layout>
