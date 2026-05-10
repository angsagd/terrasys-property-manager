@if ($errors->any())<div class="mb-4 rounded-md bg-red-50 p-3 text-sm text-red-800">{{ $errors->first() }}</div>@endif
<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm">Property *<select name="property_id" class="mt-1 w-full rounded-md border-gray-300 text-sm">@foreach($properties as $property)<option value="{{ $property->id }}" @selected(old('property_id', $additionalCertificate?->property_id) == $property->id)>{{ $property->property_name }}</option>@endforeach</select></label>
    <label class="text-sm">Jenis Hak<select name="land_right_type_id" class="mt-1 w-full rounded-md border-gray-300 text-sm"><option value="">-</option>@foreach($landRightTypes as $type)<option value="{{ $type->id }}" @selected(old('land_right_type_id', $additionalCertificate?->land_right_type_id) == $type->id)>{{ $type->name }}</option>@endforeach</select></label>
    <label class="text-sm">Nomor Dokumen<input name="document_number" value="{{ old('document_number', $additionalCertificate?->document_number) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
    <label class="text-sm">Jenis Dokumen<input name="document_type" value="{{ old('document_type', $additionalCertificate?->document_type) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
    <label class="text-sm">Pemegang Hak<input name="holder_name" value="{{ old('holder_name', $additionalCertificate?->holder_name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
    <label class="text-sm">Expired<input type="date" name="expired_date" value="{{ old('expired_date', $additionalCertificate?->expired_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm"></label>
    <label class="text-sm md:col-span-2">Keterangan<textarea name="relationship_description" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('relationship_description', $additionalCertificate?->relationship_description) }}</textarea></label>
</div>
<div class="mt-5 flex justify-end"><button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan</button></div>
