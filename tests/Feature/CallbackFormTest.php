<?php

use App\Mail\CallbackMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('callback form component can be rendered', function () {
    Livewire::test('callback-form')
        ->assertStatus(200)
        ->assertSet('showModal', false)
        ->assertSet('isSubmitted', false);
});

test('public home page renders the callback form component', function () {
    $this->get(route('home'))->assertOk()->assertSeeLivewire('callback-form');
});

test('callback form triggers open and close states correctly', function () {
    Livewire::test('callback-form')
        ->assertSet('showModal', false)
        ->call('openForm')
        ->assertSet('showModal', true)
        ->set('name', 'Тест')
        ->call('closeForm')
        ->assertSet('showModal', false)
        ->assertSet('name', '');
});

test('callback form requires name and phone number', function () {
    Livewire::test('callback-form')
        ->call('submitCallback')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
        ]);
});

test('submitting valid callback form dispatches callback email', function () {
    Mail::fake();

    Livewire::test('callback-form')
        ->set('name', 'Олександр Коваленко')
        ->set('phone', '+380998887766')
        ->call('submitCallback')
        ->assertHasNoErrors()
        ->assertSet('isSubmitted', true);

    Mail::assertSent(CallbackMail::class, function (CallbackMail $mail) {
        $expectedRecipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'info@bee.lg.ua');
        if (! str_contains($expectedRecipient, '@')) {
            $expectedRecipient = 'info@bee.lg.ua';
        }

        return $mail->hasTo($expectedRecipient) &&
               $mail->callbackData['name'] === 'Олександр Коваленко' &&
               $mail->callbackData['phone'] === '+380998887766';
    });
});
