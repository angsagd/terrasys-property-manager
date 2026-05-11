<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">System Settings</h2></x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl space-y-5 px-4 sm:px-6 lg:px-8">@include('admin.partials.nav')<div class="rounded-lg border bg-white p-5 shadow-sm">
        <div class="divide-y text-sm">@foreach($settings as $setting)<div class="grid gap-2 py-3 md:grid-cols-3"><div class="font-medium">{{ $setting->setting_key }}</div><div class="md:col-span-2">{{ $setting->setting_value }}</div></div>@endforeach</div>
    </div></div></div>
</x-app-layout>
