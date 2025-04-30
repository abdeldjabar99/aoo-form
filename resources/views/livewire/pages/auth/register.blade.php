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
    public string $email = ''; 
    public string $passport_name = '';
    public string $passport_number = '';
    public string $national_number = '';
    public string $job_number = '';
    public string $phone_number = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $advance = false;
    public bool $murabaha_purchase = false;
    public string $management = '';
    public string $department = '';
    public string $workplace = '';
    public bool $showTermsModal = false;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'passport_name' => ['required', 'string', 'max:255'],
           'passport_number' => ['required', 'string', 'size:8', 'unique:users', 'regex:/^[A-Za-z0-9]+$/'], // Allows only letters and numbers
            'national_number' => ['required', 'string', 'size:12', 'regex:/^[12][0-9]{11}$/', 'unique:users'], // 13 digits, starts with 1 or 2
            'job_number' => ['required', 'string', 'max:20', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:15', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'advance' => ['boolean'],
            'murabaha_purchase' => ['boolean'],
            'management' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'workplace' => ['nullable', 'string', 'max:255'],
        ]);

       // dd($validated);
        $validated['password'] = Hash::make($validated['password']);

         //$validated['password'] = Hash::make($validated['passport_number']);
        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect("/", navigate: true);
    }

    public function confirmTerms()
    {
        $this->showTermsModal = true;
    }
}; ?>

<div class="w-full max-w-5xl bg-white p-8 rounded-2xl text-right">
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
                @error('full_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Passport Name -->
            <div>
                <x-input-label for="passport_name" :value="__('الإسم بإنجليزي كما  في جواز السفر')" />
                <x-text-input wire:model="passport_name" id="passport_name" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                @error('passport_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Passport Number -->
            <div>
                <x-input-label for="passport_number" :value="__('رقم جواز السفر')" />
                <x-text-input wire:model="passport_number" id="passport_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                @error('passport_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- National Number -->
            <div>
                <x-input-label for="national_number" :value="__('الرقم الوطني')" />
                <x-text-input wire:model="national_number" id="national_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                @error('national_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Job Number -->
            <div>
                <x-input-label for="job_number" :value="__('رقم الوظيفة')" />
                <x-text-input wire:model="job_number" id="job_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                @error('job_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('رقم الهاتف المربوط بالرقم الوطني')" />
                <x-text-input wire:model="phone_number" id="phone_number" type="text" class="w-full rounded-lg shadow-sm text-right" required />
                @error('phone_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('البريد الإلكتروني')" />
                <x-text-input wire:model="email" id="email" type="email" class="w-full rounded-lg shadow-sm text-right" required />
            </div>
            </div>
            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('تأكيد كلمة المرور')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" class="w-full rounded-lg shadow-sm text-right" required />
            </div>
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('كلمة المرور')" />
                <x-text-input wire:model="password" id="password" type="password" class="w-full rounded-lg shadow-sm text-right" required />
                @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- Do you have an advance? -->
            <div>
                <x-input-label for="advance" :value="__('هل لديك سُلفة؟')" />
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" wire:model="advance" value="1" class="rounded">
                        <span class="ml-2">نعم</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="advance" value="0" class="rounded">
                        <span class="ml-2">لا</span>
                    </label>
                </div>
                @error('advance') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Do you have a purchase in Islamic Murabaha? -->
            <div>
                <x-input-label for="murabaha_purchase" :value="__('هل لديك شراء بمرابحة إسلامية؟')" />
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" wire:model="murabaha_purchase" value="1" class="rounded">
                        <span class="ml-2">نعم</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" wire:model="murabaha_purchase" value="0" class="rounded">
                        <span class="ml-2">لا</span>
                    </label>
                </div>
                @error('murabaha_purchase') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>


            <!-- Management -->
            <div>
                <x-input-label for="management" :value="__('الإدارة')" />
                <x-text-input wire:model="management" id="management" type="text" class="w-full rounded-lg shadow-sm text-right" />
                @error('management') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Department -->
            <div>
                <x-input-label for="department" :value="__('القسم')" />
                <x-text-input wire:model="department" id="department" type="text" class="w-full rounded-lg shadow-sm text-right" />
                @error('department') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Workplace -->
<div class="md:col-span-2">
    <x-input-label for="workplace" :value="__('مكان العمل')" />
    <select wire:model="workplace" id="workplace" class="w-full rounded-lg shadow-sm text-right">
        <option value="">{{ __('اختر مكان العمل') }}</option>
        <option value="طرابلس">طرابلس</option>
        <option value="الزاوية">الزاوية</option>
        <option value="الحقل">الحقل</option>
        <option value="الحمادة">الحمادة</option>
    </select>
    @error('workplace') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
</div>

        </div>

        <!-- Submit & Login Link -->
        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-indigo-600">
                {{ __('هل لديك حساب بالفعل؟') }}
            </a>

            <x-primary-button type="button" wire:click="confirmTerms">
                {{ __('تسجيل') }}
            </x-primary-button>
        </div>
    </form>
    @if($showTermsModal)
<div class="fixed inset-0 flex items-center  justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl text-right">
        <h3 class="text-xl font-bold mb-4">الشروط والأحكام</h3>
        <div class="overflow-y-auto max-h-80 mb-4 text-sm leading-relaxed">
            <p class="mb-2">يرجى قراءة الشروط والأحكام بعناية قبل المتابعة. بضغطك على "موافق"، فإنك توافق على جميع البنود المذكورة.</p>
            
            <div class="space-y-4">
                <div>
                    <strong class="block mb-1">المادة رقم 1:</strong>
                    <p>تخضع عمليات السحب النقدي على الصرافات الآلية لعمولات تخصم لصالح الطرف الثاني حسب البيان التالي:</p>
                    <table class="w-full border text-right mt-2 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">القيمة</th>
                                <th class="border p-2">عمولة الآلة (للعملية الواحدة)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">800 د.ل</td>
                                <td class="border p-2">10 د.ل</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-2">مع مراعاة الملاحظات التالية:</p>
                    <ul class="list-disc pr-5 mt-1 space-y-1">
                        <li>السقف اليومي لعمليات السحب (5,000 د.ل).</li>
                        <li>قدرة السحب للآلة أربعون ورقة نقدية للعملية الواحدة.</li>
                    </ul>
                </div>

                <div>
                    <strong class="block mb-1">المادة رقم 2:</strong>
                    <p>
                        تخضع أي خدمات أخرى تقوم آلة السحب الآلي بتقديمها لنشرة العمولات المحددة من قبل الطرف الثاني، 
                        كما تخضع البطاقة للعمولات الخاصة بالموزع الوطني (نمو) حين الاستخدام خارج آلات الصراف الآلي للطرف الثاني.
                    </p>
                </div>

                <div>
                    <strong class="block mb-1">المادة رقم 3:</strong>
                    <p>تخضع عمليات إصدار البطاقات لعمولات يتم خصمها من حساب الطرف الأول لدى الطرف الثاني وفقًا للجدول الآتي:</p>
                    <table class="w-full border text-right mt-2 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">العملية</th>
                                <th class="border p-2">عمولة المصرف</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border p-2">إصدار وتجديد بطاقة</td>
                                <td class="border p-2">40 د.ل (صلاحية سنتان)</td>
                            </tr>
                            <tr>
                                <td class="border p-2">إصدار رقم سري</td>
                                <td class="border p-2">مجاني</td>
                            </tr>
                            <tr>
                                <td class="border p-2">إصدار بطاقة بدل فاقد</td>
                                <td class="border p-2">50 د.ل</td>
                            </tr>
                            <tr>
                                <td class="border p-2">إصدار رقم سري بدل فاقد</td>
                                <td class="border p-2">مجاني</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button wire:click="$set('showTermsModal', false)" class="text-gray-600 hover:text-red-600">لا أوافق</button>
            <button wire:click="register" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">موافق</button>
        </div>
    </div>
</div>
@endif

</div>
