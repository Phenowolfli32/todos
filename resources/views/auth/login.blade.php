<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white rounded-xl p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Welcome Back
        </h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />

                <x-text-input
                    id="email"
                    class="block w-full mt-1"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input
                    id="password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="flex items-center text-gray-600">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember"
                    >
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-indigo-600 hover:text-indigo-800"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div>
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-3 text-sm text-gray-500">OR</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- Register Button -->
        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="block w-full text-center border border-gray-300 rounded-lg py-2 text-gray-700 hover:bg-gray-50 transition"
            >
                {{ __('Create an Account') }}
            </a>
        @endif

    </div>
</x-guest-layout><x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white shadow-lg rounded-xl p-8">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Welcome Back
        </h2>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email Address')" />

                <x-text-input
                    id="email"
                    class="block w-full mt-1"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                />

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input
                    id="password"
                    class="block w-full mt-1"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="flex items-center text-gray-600">
                    <input
                        id="remember_me"
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember"
                    >
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-indigo-600 hover:text-indigo-800"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <div>
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-3 text-sm text-gray-500">OR</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <!-- Register Button -->
        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="block w-full text-center border border-gray-300 rounded-lg py-2 text-gray-700 hover:bg-gray-50 transition"
            >
                {{ __('Create an Account') }}
            </a>
        @endif

    </div>
</x-guest-layout>
