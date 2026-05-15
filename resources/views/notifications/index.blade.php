<x-app-layout>
    <x-slot name="header">
    <div class="flex items-center justify-between w-full">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Notifications</h2>
            <p class="hidden lg:block text-sm text-gray-500 mt-1">View your recent system alerts and updates.</p>
        </div>
    </div>
</x-slot>
    <div class="py-8"><div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8"><div class="rounded-lg border bg-white p-5 shadow-sm">
        <div class="divide-y">@forelse($notifications as $notification)<div class="py-3 text-sm"><div class="font-medium">{{ $notification->title }}</div><div class="text-gray-500">{{ $notification->message }}</div></div>@empty<p class="text-sm text-gray-500">Belum ada notifikasi.</p>@endforelse</div>
        <div class="mt-4">{{ $notifications->links() }}</div>
    </div></div></div>
</x-app-layout>
