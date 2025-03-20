<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div dir="rtl">
    <!-- حالة الجلسة -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- رقم الوظيفة -->
        <div class="text-right">
            <x-input-label for="job_number" :value="__('رقم الوظيفي')" />
            <x-text-input wire:model="form.job_number" id="job_number" class="block mt-1 w-full rtl text-right" type="text" required autofocus />
            <x-input-error :messages="$errors->get('job_number')" class="mt-2" />
        </div>

        <!-- كلمة المرور -->
        <div class="mt-4 text-right">
            <x-input-label for="password" :value="__('رقم جواز السفر')" />

            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full rtl text-right"
                          type="password"
                          name="password"
                          required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- تذكرني -->
        <div class="block mt-4 text-right">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="me-2 text-sm text-gray-600">{{ __('تذكرني') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4 text-right">
            <a class="underline text-sm mx-2 text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}" wire:navigate>
                {{ __('إنشاء حساب جديد') }}
            </a>

            <x-primary-button class="me-3 mx-2">
                {{ __('تسجيل الدخول') }}
            </x-primary-button>
        </div>
    </form>
</div>
