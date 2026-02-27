<x-guest-layout>
    <x-slot name="title">Create Account</x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full Name')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
            <x-text-input id="name" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
            <x-text-input id="email" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
                <x-text-input id="password" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm')" class="text-xs uppercase tracking-widest font-bold opacity-60" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full !rounded-xl border-[#19140015] focus:border-[#f53003] focus:ring-[#f53003]" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <div class="pt-4 space-y-4">
            <x-primary-button class="w-full justify-center !bg-[#f53003] hover:!bg-[#d42a02] !py-4 !rounded-xl !text-base shadow-lg shadow-red-500/20 transition-all hover:scale-[1.02]">
                {{ __('Create My Account') }}
            </x-primary-button>

            <div class="text-center">
                <a class="text-xs font-bold text-gray-500 hover:text-[#f53003] transition underline underline-offset-4" href="{{ route('login') }}">
                    {{ __('Already have an account? Sign in') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>