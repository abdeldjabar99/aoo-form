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
            'password' => ['nullable'],
        ]);

        //$validated['password'] = Hash::make($validated['password']);

         $validated['password'] = Hash::make($validated['passport_number']);
        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect("/", navigate: true);
    }
}; ?>

    <div class="w-full max-w-5xl bg-white p-8 rounded-2xl  text-right">
        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
            {{ __('إنشاء حساب جديد') }}
        </h2>

        <form wire:submit="register" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <x-input-label for="full_name" :value="__('الإسم الكامل')" />
                    <x-text-input wire:model="full_name" id="full_name" type="text" class="w-full rounded-lg shadow-sm text-right" required autofocus />
                    <x-input-error :messages="$errors->get('full_name')" />
                </div>

                <!-- Passport Name -->
                <div>
                    <x-input-label for="passport_name" :value="__('الإسم بإنجليزي كما  في جواز السفر')" />
                    <x-text-input wire:model="passport_name" id="passport_name" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                    <x-input-error :messages="$errors->get('passport_name')" />
                </div>

                <!-- Passport Number -->
                <div>
                    <x-input-label for="passport_number" :value="__('رقم جواز السفر')" />
                    <x-text-input wire:model="passport_number" id="passport_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                    <x-input-error :messages="$errors->get('passport_number')" />
                </div>

                <!-- National Number -->
                <div>
                    <x-input-label for="national_number" :value="__('الرقم الوطني')" />
                    <x-text-input wire:model="national_number" id="national_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                    <x-input-error :messages="$errors->get('national_number')" />
                </div>

                <!-- Job Number -->
                <div>
                    <x-input-label for="job_number" :value="__('رقم الوظيفة')" />
                    <x-text-input wire:model="job_number" id="job_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                    <x-input-error :messages="$errors->get('job_number')" />
                </div>

                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_number" :value="__('رقم الهاتف المربوط بالرقم الوطني')" />
                    <x-text-input wire:model="phone_number" id="phone_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                    <x-input-error :messages="$errors->get('phone_number')" />
                </div>
            </div>

            <!-- Submit & Login Link -->
            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                    {{ __('هل لديك حساب بالفعل؟') }}
                </a>

                <x-primary-button>
                    {{ __('تسجيل') }}
                </x-primary-button>
            </div>
        </form>
    </div>
