<x-guest-layout>
    <x-slot name="title">Welcome Back</x-slot>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
            <x-text-input id="email" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
                @if (Route::has('password.request'))
                    <a class="text-[11px] font-bold text-[#f53003] hover:underline" href="{{ route('password.request') }}">
                        {{ __('Forgot?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-md border-[#19140030] text-[#f53003] shadow-sm focus:ring-[#f53003] dark:bg-[#0a0a0a]" name="remember">
                <span class="ms-2 text-sm text-gray-500 font-medium">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center !bg-[#f53003] hover:!bg-[#d42a02] !py-4 !rounded-xl !text-base shadow-lg shadow-red-500/20 transition-all hover:scale-[1.02]">
                {{ __('Sign In') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>