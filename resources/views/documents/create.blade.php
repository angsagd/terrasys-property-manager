<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Upload Document</h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-6 rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                @csrf

                @if ($errors->any())
                    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <div class="font-medium">Periksa kembali input dokumen.</div>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section>
                    <h3 class="mb-4 font-semibold text-gray-900">Relasi Dokumen</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="text-sm">Property
                            <select name="property_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                                <option value="">-</option>
                                @foreach ($properties as $property)
                                    <option value="{{ $property->id }}" @selected(old('property_id') == $property->id)>{{ $property->property_code }} - {{ $property->property_name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="text-sm">Certificate
                            <select name="certificate_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                                <option value="">-</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}" @selected(old('certificate_id') == $certificate->id)>{{ $certificate->certificate_number }} - {{ $certificate->property?->property_name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="text-sm">Additional Certificate
                            <select name="additional_certificate_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                                <option value="">-</option>
                                @foreach ($additionalCertificates as $additionalCertificate)
                                    <option value="{{ $additionalCertificate->id }}" @selected(old('additional_certificate_id') == $additionalCertificate->id)>{{ $additionalCertificate->document_number ?: 'Tanpa nomor' }} - {{ $additionalCertificate->property?->property_name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="text-sm">Lease Contract
                            <select name="lease_contract_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                                <option value="">-</option>
                                @foreach ($leaseContracts as $leaseContract)
                                    <option value="{{ $leaseContract->id }}" @selected(old('lease_contract_id') == $leaseContract->id)>{{ $leaseContract->counterparty_name }} - {{ $leaseContract->property?->property_name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Minimal pilih satu relasi dokumen.</p>
                </section>

                <section>
                    <h3 class="mb-4 font-semibold text-gray-900">Metadata Dokumen</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="text-sm">Kategori *
                            <select name="document_category_id" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('document_category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="text-sm">Nama Dokumen *
                            <input name="document_name" value="{{ old('document_name') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                        </label>
                        <label class="text-sm">Nomor Dokumen
                            <input name="document_number" value="{{ old('document_number') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                        </label>
                        <label class="text-sm">Tanggal Dokumen
                            <input type="date" name="document_date" value="{{ old('document_date') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                        </label>
                        <label class="text-sm">Tanggal Expired
                            <input type="date" name="expired_date" value="{{ old('expired_date') }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                        </label>
                        <label class="text-sm">File *
                            <input type="file" name="file" class="mt-1 w-full rounded-md border border-gray-300 p-2 text-sm" required>
                        </label>
                        <label class="text-sm md:col-span-2">Deskripsi
                            <textarea name="description" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('description') }}</textarea>
                        </label>
                    </div>
                </section>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('documents.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm">Batal</a>
                    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Upload</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
