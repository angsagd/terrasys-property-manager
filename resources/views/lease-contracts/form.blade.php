@if ($errors->any())
    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <div class="font-medium">Periksa kembali input form.</div>
        <ul class="mt-2 list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-4 md:grid-cols-2">
    <label class="text-sm md:col-span-2">Property *
        <select name="property_id" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
            <option value="">Pilih Property</option>
            @foreach ($properties as $property)
                <option value="{{ $property->id }}" @selected(old('property_id', $leaseContract?->property_id ?? $selectedPropertyId ?? null) == $property->id)>{{ $property->property_code }} - {{ $property->property_name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">Jenis Sewa *
        <select name="lease_type_id" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
            <option value="">Pilih Jenis Sewa</option>
            @foreach ($leaseTypes as $leaseType)
                <option value="{{ $leaseType->id }}" @selected(old('lease_type_id', $leaseContract?->lease_type_id) == $leaseType->id)>{{ $leaseType->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">Status Kontrak *
        <select name="lease_status_id" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
            <option value="">Pilih Status</option>
            @foreach ($leaseStatuses as $leaseStatus)
                <option value="{{ $leaseStatus->id }}" @selected(old('lease_status_id', $leaseContract?->lease_status_id) == $leaseStatus->id)>{{ $leaseStatus->name }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">Nama Pihak Lawan *
        <input name="counterparty_name" value="{{ old('counterparty_name', $leaseContract?->counterparty_name) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
    </label>
    <label class="text-sm">Nomor Perjanjian
        <input name="agreement_number" value="{{ old('agreement_number', $leaseContract?->agreement_number) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </label>
    <label class="text-sm md:col-span-2">Alamat Pihak Lawan
        <textarea name="counterparty_address" rows="2" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('counterparty_address', $leaseContract?->counterparty_address) }}</textarea>
    </label>
    <label class="text-sm">Tanggal Perjanjian
        <input type="date" name="agreement_date" value="{{ old('agreement_date', $leaseContract?->agreement_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </label>
    <label class="text-sm">Tanggal Mulai *
        <input type="date" name="start_date" value="{{ old('start_date', $leaseContract?->start_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
    </label>
    <label class="text-sm">Tanggal Selesai *
        <input type="date" name="end_date" value="{{ old('end_date', $leaseContract?->end_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
    </label>
    <label class="text-sm">Reminder Date
        <input type="date" name="reminder_date" value="{{ old('reminder_date', $leaseContract?->reminder_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </label>
    <label class="text-sm">Nilai Sewa
        <input type="number" step="0.01" min="0" name="rental_value" value="{{ old('rental_value', $leaseContract?->rental_value ?? 0) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </label>
    <label class="text-sm">Periode Pembayaran *
        <select name="payment_period" class="mt-1 w-full rounded-md border-gray-300 text-sm" required>
            @foreach ($paymentPeriods as $value => $label)
                <option value="{{ $value }}" @selected(old('payment_period', $leaseContract?->payment_period ?? 'yearly') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </label>
    <label class="text-sm">Status Pembayaran
        <input name="payment_status" value="{{ old('payment_status', $leaseContract?->payment_status) }}" class="mt-1 w-full rounded-md border-gray-300 text-sm">
    </label>
    <label class="text-sm md:col-span-2">Catatan
        <textarea name="notes" rows="3" class="mt-1 w-full rounded-md border-gray-300 text-sm">{{ old('notes', $leaseContract?->notes) }}</textarea>
    </label>
</div>

<div class="mt-6 flex items-center justify-end gap-3">
    <a href="{{ route('lease-contracts.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700">Batal</a>
    <button class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white">Simpan</button>
</div>
