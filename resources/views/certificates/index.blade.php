<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Certificate Registry</h2>
                <p class="hidden lg:block text-sm text-gray-500 mt-1">A consolidated view of all property land rights and certificates.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6">Certificate Info</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Linked Property</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left font-semibold text-gray-900">Expiration Date</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($certificates as $certificate)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900 group-hover:text-brand-600 transition-colors">
                                                    {{ $certificate->certificate_number }}
                                                </div>
                                                <div class="text-gray-500 text-xs mt-0.5">{{ $certificate->landRightType?->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        @if($certificate->property)
                                            <a href="{{ route('properties.show', $certificate->property) }}" class="font-medium text-gray-900 hover:text-brand-600 transition-colors">
                                                {{ $certificate->property->property_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">No Property Linked</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4">
                                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
                                            {{ $certificate->certificateStatus?->name }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-gray-500">
                                        @if($certificate->expired_date)
                                            <span class="{{ $certificate->expired_date->isPast() ? 'text-rose-600 font-medium' : '' }}">
                                                {{ $certificate->expired_date->format('d M Y') }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route('certificates.show', $certificate) }}" class="text-gray-400 hover:text-brand-600 transition-colors" title="View Details">
                                            <svg class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No certificates found</h3>
                                        <p class="mt-1 text-sm text-gray-500">There are currently no certificates available.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($certificates->hasPages())
                <div class="border-t border-gray-100 bg-gray-50/50 px-4 py-3 sm:px-6">
                    {{ $certificates->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
