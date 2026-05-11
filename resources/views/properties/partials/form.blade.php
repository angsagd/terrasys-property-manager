@php($certificate = $property?->certificate)

@if ($errors->any())
    <div class="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <div class="font-medium">Periksa kembali input form.</div>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
    <h3 class="mb-4 font-semibold text-gray-900">Identitas Property</h3>
    <div class="grid gap-4 md:grid-cols-2">
        <label class="text-sm">Kode Property *
            <input name="property[property_code]" value="{{ old('property.property_code', $property?->property_code) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
        </label>
        <label class="text-sm">Nama Property *
            <input name="property[property_name]" value="{{ old('property.property_name', $property?->property_name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
        </label>
        <label class="text-sm">Jenis Property *
            <select name="property[property_type_id]" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                @foreach ($propertyTypes as $type)
                    <option value="{{ $type->id }}" @selected(old('property.property_type_id', $property?->property_type_id) == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm">Status Pemanfaatan *
            <select name="property[utilization_status_id]" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                @foreach ($utilizationStatuses as $status)
                    <option value="{{ $status->id }}" @selected(old('property.utilization_status_id', $property?->utilization_status_id) == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm">Kondisi Fisik
            <input name="property[physical_condition]" value="{{ old('property.physical_condition', $property?->physical_condition) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Luas Tanah
            <input type="number" step="0.01" name="property[land_area]" value="{{ old('property.land_area', $property?->land_area) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Luas Bangunan
            <input type="number" step="0.01" name="property[building_area]" value="{{ old('property.building_area', $property?->building_area) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <input type="hidden" name="property[area_unit]" value="m2">
        <label class="text-sm md:col-span-2">Deskripsi
            <textarea name="property[description]" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('property.description', $property?->description) }}</textarea>
        </label>
    </div>
</section>

<section
    x-data="{
        provinceId: @js((string) old('property.province_id', $property?->province_id ?? '')),
        cityId: @js((string) old('property.city_id', $property?->city_id ?? '')),
        districtId: @js((string) old('property.district_id', $property?->district_id ?? '')),
        villageId: @js((string) old('property.village_id', $property?->village_id ?? '')),
        cities: @js($cities->map(fn ($city) => ['id' => (string) $city->id, 'name' => $city->name])->values()),
        districts: @js($districts->map(fn ($district) => ['id' => (string) $district->id, 'name' => $district->name])->values()),
        villages: @js($villages->map(fn ($village) => ['id' => (string) $village->id, 'name' => $village->name])->values()),
        async loadCities() {
            this.cityId = '';
            this.districtId = '';
            this.villageId = '';
            this.cities = [];
            this.districts = [];
            this.villages = [];
            if (!this.provinceId) return;
            this.cities = await fetch(`/regions/provinces/${this.provinceId}/cities`).then(response => response.json());
        },
        async loadDistricts() {
            this.districtId = '';
            this.villageId = '';
            this.districts = [];
            this.villages = [];
            if (!this.cityId) return;
            this.districts = await fetch(`/regions/cities/${this.cityId}/districts`).then(response => response.json());
        },
        async loadVillages() {
            this.villageId = '';
            this.villages = [];
            if (!this.districtId) return;
            this.villages = await fetch(`/regions/districts/${this.districtId}/villages`).then(response => response.json());
        }
    }"
    class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm"
>
    <h3 class="mb-4 font-semibold text-gray-900">Lokasi</h3>
    <div class="grid gap-4 md:grid-cols-2">
        <label class="text-sm md:col-span-2">Alamat Lengkap
            <textarea name="property[address]" rows="2" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('property.address', $property?->address) }}</textarea>
        </label>
        <label class="text-sm">Provinsi *
            <select name="property[province_id]" x-model="provinceId" @change="loadCities" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                <option value="">Pilih Provinsi</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm">Kota/Kabupaten *
            <select name="property[city_id]" x-model="cityId" @change="loadDistricts" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                <option value="">Pilih Kota/Kabupaten</option>
                <template x-for="city in cities" :key="city.id">
                    <option :value="city.id" x-text="city.name"></option>
                </template>
            </select>
        </label>
        <label class="text-sm">Kecamatan
            <select name="property[district_id]" x-model="districtId" @change="loadVillages" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                <option value="">Pilih Kecamatan</option>
                <template x-for="district in districts" :key="district.id">
                    <option :value="district.id" x-text="district.name"></option>
                </template>
            </select>
        </label>
        <label class="text-sm">Desa/Kelurahan
            <select name="property[village_id]" x-model="villageId" class="mt-1 w-full rounded-md border-gray-300 text-sm">
                <option value="">Pilih Desa/Kelurahan</option>
                <template x-for="village in villages" :key="village.id">
                    <option :value="village.id" x-text="village.name"></option>
                </template>
            </select>
        </label>
        <label class="text-sm">Kode Pos
            <input name="property[postal_code]" value="{{ old('property.postal_code', $property?->postal_code) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Latitude
            <input type="number" step="0.0000001" name="property[latitude]" value="{{ old('property.latitude', $property?->latitude) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Longitude
            <input type="number" step="0.0000001" name="property[longitude]" value="{{ old('property.longitude', $property?->longitude) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm md:col-span-2">Polygon GeoJSON
            <textarea name="property[polygon_geojson]" rows="4" class="mt-1 w-full rounded-md border-gray-300 font-mono text-xs">{{ old('property.polygon_geojson', $property?->polygon_geojson) }}</textarea>
        </label>
    </div>
</section>

<section class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
    <h3 class="mb-4 font-semibold text-gray-900">Data Sertifikat Utama</h3>
    <div class="grid gap-4 md:grid-cols-2">
        <label class="text-sm">Nomor Sertifikat *
            <input name="certificate[certificate_number]" value="{{ old('certificate.certificate_number', $certificate?->certificate_number) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
        </label>
        <label class="text-sm">Jenis Hak *
            <select name="certificate[land_right_type_id]" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                @foreach ($landRightTypes as $type)
                    <option value="{{ $type->id }}" @selected(old('certificate.land_right_type_id', $certificate?->land_right_type_id) == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm">Status Sertifikat *
            <select name="certificate[certificate_status_id]" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
                @foreach ($certificateStatuses as $status)
                    <option value="{{ $status->id }}" @selected(old('certificate.certificate_status_id', $certificate?->certificate_status_id) == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-sm">Nama Pemegang Hak
            <input name="certificate[holder_name]" value="{{ old('certificate.holder_name', $certificate?->holder_name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Tanggal Terbit
            <input type="date" name="certificate[issued_date]" value="{{ old('certificate.issued_date', $certificate?->issued_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Tanggal Berakhir
            <input type="date" name="certificate[expired_date]" value="{{ old('certificate.expired_date', $certificate?->expired_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm">Luas Berdasarkan Sertifikat
            <input type="number" step="0.01" name="certificate[certificate_area]" value="{{ old('certificate.certificate_area', $certificate?->certificate_area) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <input type="hidden" name="certificate[area_unit]" value="m2">
        <label class="text-sm">Kantor Pertanahan
            <input name="certificate[land_office]" value="{{ old('certificate.land_office', $certificate?->land_office) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
        </label>
        <label class="text-sm md:col-span-2">Catatan Legal
            <textarea name="certificate[legal_notes]" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('certificate.legal_notes', $certificate?->legal_notes) }}</textarea>
        </label>
    </div>
</section>
