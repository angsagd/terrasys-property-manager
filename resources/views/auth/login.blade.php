<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
            <div class="mt-2 relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M3 4a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2H3zm0 2h14v.511l-7 4.2-7-4.2V6zm14 8H3V8.889l6.486 3.891a1 1 0 001.028 0L17 8.89V14z"/></svg>
                </div>
                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-xl border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-500 sm:text-sm sm:leading-6 transition-shadow" placeholder="you@company.com" value="{{ old('email') }}">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-500" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-semibold text-brand-600 hover:text-brand-500 transition-colors">Forgot password?</a>
                    </div>
                @endif
            </div>
            <div class="mt-2 relative rounded-md shadow-sm">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd"/></svg>
                </div>
                <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-500 sm:text-sm sm:leading-6 transition-shadow" placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-500" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-600 focus:ring-2 focus:ring-offset-2 transition-all">
            <label for="remember_me" class="ml-3 block text-sm leading-6 text-gray-700">Remember me</label>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center items-center gap-2 rounded-xl bg-gray-900 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-all">
                Sign in to account
                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </button>
        </div>
    </form>
</x-guest-layout>
