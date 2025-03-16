<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $full_name = '';
    public string $passport_name = '';
    public string $passport_number = '';
    public string $national_number = '';
    public string $job_number = '';
    public string $phone_number = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'passport_name' => ['required', 'string', 'max:255'],
            'passport_number' => ['required', 'string', 'max:20', 'unique:users'],
            'national_number' => ['required', 'string', 'max:20', 'unique:users'],
            'job_number' => ['required', 'string', 'max:20', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div>
    <form wire:submit="register">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Full Name -->
            <div>
                <x-input-label for="full_name" :value="__('Full Name')" />
                <x-text-input wire:model="full_name" id="full_name" class="block mt-1 w-full" type="text" required autofocus />
                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
            </div>

            <!-- Passport Name -->
            <div>
                <x-input-label for="passport_name" :value="__('Passport Name')" />
                <x-text-input wire:model="passport_name" id="passport_name" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('passport_name')" class="mt-2" />
            </div>

            <!-- Passport Number -->
            <div>
                <x-input-label for="passport_number" :value="__('Passport Number')" />
                <x-text-input wire:model="passport_number" id="passport_number" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('passport_number')" class="mt-2" />
            </div>

            <!-- National Number -->
            <div>
                <x-input-label for="national_number" :value="__('National Number')" />
                <x-text-input wire:model="national_number" id="national_number" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('national_number')" class="mt-2" />
            </div>

            <!-- Job Number -->
            <div>
                <x-input-label for="job_number" :value="__('Job Number')" />
                <x-text-input wire:model="job_number" id="job_number" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('job_number')" class="mt-2" />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input wire:model="phone_number" id="phone_number" class="block mt-1 w-full" type="text" required />
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
