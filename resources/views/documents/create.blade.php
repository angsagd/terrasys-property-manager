<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Upload Document</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
            @csrf
            @if ($errors->any())<div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-800">{{ $errors->first() }}</div>@endif
            <div class="grid gap-4 md:grid-cols-2">
                <label class="text-sm">Kategori *<select name="document_category_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">@foreach($categories as $category)<option value="{{ $category->id }}">{{ $category->name }}</option>@endforeach</select></label>
                <label class="text-sm">Property<select name="property_id" class="mt-1 w-full rounded-md border-gray-300 text-sm"><option value="">-</option>@foreach($properties as $property)<option value="{{ $property->id }}">{{ $property->property_name }}</option>@endforeach</select></label>
                <label class="text-sm">Nama Dokumen *<input name="document_name" class="mt-1 w-full rounded-md border-gray-300 text-sm" required></label>
                <label class="text-sm">Nomor Dokumen<input name="document_number" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
                <label class="text-sm">Tanggal Dokumen<input type="date" name="document_date" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
                <label class="text-sm">Tanggal Expired<input type="date" name="expired_date" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
                <label class="text-sm md:col-span-2">File *<input type="file" name="file" class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm" required></label>
                <label class="text-sm md:col-span-2">Deskripsi<textarea name="description" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm"></textarea></label>
            </div>
            <div class="mt-5 flex justify-end"><button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Upload</button></div>
        </form>
    </div></div>
</x-app-layout>
