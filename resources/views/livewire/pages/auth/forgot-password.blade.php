<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div dir="rtl">
    <div class="mb-4 text-sm text-gray-600 text-right">
        {{ __('نسيت كلمة المرور؟ لا مشكلة. فقط أخبرنا بعنوان بريدك الإلكتروني وسنرسل لك رابطًا لإعادة تعيين كلمة المرور، يمكنك من خلاله تعيين كلمة جديدة.') }}
    </div>

    <!-- حالة الجلسة -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <!-- البريد الإلكتروني -->
        <div class="text-right">
            <x-input-label for="email" :value="__('البريد الإلكتروني')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full rtl text-right" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 text-right">
            <x-primary-button>
                {{ __('إرسال رابط إعادة تعيين كلمة المرور') }}
            </x-primary-button>
        </div>
    </form>
</div>
