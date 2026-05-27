<?php

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('contact form component can be rendered', function () {
    Livewire::test('contact-form')
        ->assertStatus(200)
        ->assertSet('showModal', false)
        ->assertSet('isSubmitted', false);
});

test('public home page renders the contact form component', function () {
    $this->get(route('home'))->assertOk()->assertSeeLivewire('contact-form');
});

test('contact form triggers open and close states correctly', function () {
    Livewire::test('contact-form')
        ->assertSet('showModal', false)
        ->call('openForm')
        ->assertSet('showModal', true)
        ->set('name', 'Тест')
        ->call('closeForm')
        ->assertSet('showModal', false)
        ->assertSet('name', '');
});

test('contact form requires name, phone number, and question', function () {
    Livewire::test('contact-form')
        ->call('submitQuestion')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
            'question' => 'required',
        ]);
});

test('contact form validates invalid email and too short question', function () {
    Livewire::test('contact-form')
        ->set('name', 'Іван')
        ->set('phone', '+380998887766')
        ->set('email', 'invalid-email')
        ->set('question', '123')
        ->call('submitQuestion')
        ->assertHasErrors([
            'email' => 'email',
            'question' => 'min',
        ]);
});

test('submitting valid contact form dispatches contact email to director', function () {
    Mail::fake();

    Livewire::test('contact-form')
        ->set('name', 'Олександр Коваленко')
        ->set('phone', '+380998887766')
        ->set('email', 'alex@example.com')
        ->set('question', 'Яка товщина стінок у ваших 10-рамкових вуликах?')
        ->call('submitQuestion')
        ->assertHasNoErrors()
        ->assertSet('isSubmitted', true);

    Mail::assertSent(ContactMail::class, function (ContactMail $mail) {
        $expectedRecipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'info@bee.lg.ua');
        if (! str_contains($expectedRecipient, '@')) {
            $expectedRecipient = 'info@bee.lg.ua';
        }

        return $mail->hasTo($expectedRecipient) &&
               $mail->contactData['name'] === 'Олександр Коваленко' &&
               $mail->contactData['phone'] === '+380998887766' &&
               $mail->contactData['email'] === 'alex@example.com' &&
               $mail->contactData['question'] === 'Яка товщина стінок у ваших 10-рамкових вуликах?';
    });
});
