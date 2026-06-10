<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Mail\CallbackMail;
use Illuminate\Support\Facades\Mail;

new class extends Component
{
    public bool $showModal = false;

    public string $name = '';

    public string $phone = '';

    public bool $isSubmitted = false;

    /**
     * Listen for openCallbackForm event to open modal and reset state.
     */
    #[On('openCallbackForm')]
    public function openForm(): void
    {
        $this->reset(['name', 'phone', 'isSubmitted']);
        $this->showModal = true;
    }

    /**
     * Close the modal and reset state.
     */
    public function closeForm(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'phone', 'isSubmitted']);
    }

    /**
     * Validation rules.
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|min:2|max:100',
            'phone' => 'required|min:9|max:20',
        ];
    }

    /**
     * Custom validation error messages.
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Будь ласка, вкажіть ваше ім’я.',
            'name.min' => 'Ім’я має містити щонайменше 2 символи.',
            'name.max' => 'Ім’я занадто довге.',
            'phone.required' => 'Будь ласка, вкажіть номер телефону.',
            'phone.min' => 'Номер телефону занадто короткий.',
            'phone.max' => 'Номер телефону занадто довгий.',
        ];
    }

    /**
     * Validate and submit the callback request.
     */
    public function submitCallback(): void
    {
        $this->validate();

        $callbackData = [
            'name' => $this->name,
            'phone' => $this->phone,
            'ip' => request()->ip(),
        ];

        // Resolve recipient
        $recipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'info@bee.lg.ua');
        if (! str_contains($recipient, '@')) {
            $recipient = config('mail.from.address') ?? 'info@bee.lg.ua';
        }

        // Send email
        Mail::to($recipient)->send(new CallbackMail($callbackData));

        $this->isSubmitted = true;
    }
};
?>

<div>
    <!-- Flux UI Modal for Callback Form -->
    <flux:modal wire:model="showModal" class="max-w-md w-full !bg-[#fffdf8] border border-[#e2d4ad] rounded-2xl shadow-2xl p-0 overflow-hidden">
        <div class="relative">
            <!-- Decorative top bar matching honey gold theme -->
            <div class="h-2 bg-gradient-to-r from-[#b86f17] via-[#d6a254] to-[#b86f17]"></div>
            
            <div class="p-6">
                @if ($isSubmitted)
                    <!-- Success State -->
                    <div class="flex flex-col items-center text-center py-8 px-4 animate-fade-in">
                        <div class="flex size-16 items-center justify-center rounded-full bg-[#f3ead3] text-[#b86f17] mb-6 shadow-xs">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718] mb-3">
                            Заявку прийнято!
                        </h3>
                        
                        <p class="text-sm text-[#6d6045] leading-relaxed mb-8 max-w-xs">
                            Дякуємо, <strong>{{ $name }}</strong>! Ми зателефонуємо вам найближчим часом на вказаний номер телефону.
                        </p>

                        <button wire:click="closeForm" type="button" class="w-full inline-flex justify-center rounded-lg bg-[#b86f17] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] cursor-pointer">
                            Зрозуміло
                        </button>
                    </div>
                @else
                    <!-- Form State -->
                    <div class="mb-6">
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#b86f17]">Зворотний дзвінок</span>
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718] mt-1">
                            Замовити зворотний дзвінок
                        </h3>
                        <p class="text-xs text-[#766748] mt-1">
                            Будь ласка, вкажіть ваші контактні дані, і наш менеджер зв'яжеться з вами для консультації!
                        </p>
                    </div>

                    <form wire:submit.prevent="submitCallback" class="space-y-4">
                        <!-- Name Field -->
                        <flux:field>
                            <flux:label class="text-[#2f2718] font-medium text-sm">Ваше ім'я <span class="text-red-500">*</span></flux:label>
                            <flux:input wire:model.blur="name" type="text" placeholder="Олександр" class="!bg-white border-[#e3d7b6] focus:border-[#b86f17] focus:ring-1 focus:ring-[#b86f17] text-sm rounded-lg" />
                            <flux:error name="name" class="text-xs mt-1 text-red-600" />
                        </flux:field>

                        <!-- Phone Field -->
                        <flux:field>
                            <flux:label class="text-[#2f2718] font-medium text-sm">Номер телефону <span class="text-red-500">*</span></flux:label>
                            <flux:input wire:model.blur="phone" type="tel" placeholder="+38 050 123 45 67" class="!bg-white border-[#e3d7b6] focus:border-[#b86f17] focus:ring-1 focus:ring-[#b86f17] text-sm rounded-lg" />
                            <flux:error name="phone" class="text-xs mt-1 text-red-600" />
                        </flux:field>

                        <div class="pt-2 flex gap-3">
                            <button wire:click="closeForm" type="button" class="flex-1 inline-flex justify-center rounded-lg border border-[#cdbb8c] px-4 py-2.5 text-sm font-semibold text-[#2f2718] bg-white transition hover:bg-[#fbf8ef] cursor-pointer">
                                Скасувати
                            </button>
                            <button type="submit" class="flex-1 inline-flex justify-center rounded-lg bg-[#b86f17] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] focus:outline-hidden focus:ring-2 focus:ring-[#b86f17] cursor-pointer">
                                Надіслати
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </flux:modal>
</div>