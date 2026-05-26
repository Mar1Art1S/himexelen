<?php

use App\Livewire\OrderForm;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('order form component can be rendered', function () {
    Livewire::test(OrderForm::class)
        ->assertStatus(200)
        ->assertSet('showModal', false)
        ->assertSet('isSubmitted', false);
});

test('public pages render the order form component', function () {
    $this->get(route('home'))->assertOk()->assertSeeLivewire(OrderForm::class);
    $this->get(route('calculator'))->assertOk()->assertSeeLivewire(OrderForm::class);
    $this->followingRedirects()->get(route('sizes'))->assertOk()->assertSeeLivewire(OrderForm::class);
    $this->get(route('video'))->assertOk()->assertSeeLivewire(OrderForm::class);
    $this->followingRedirects()->get(route('instruction'))->assertOk()->assertSeeLivewire(OrderForm::class);
    $this->get(route('ecosystem'))->assertOk()->assertSeeLivewire(OrderForm::class);
});

test('order form triggers open and close states correctly', function () {
    Livewire::test(OrderForm::class)
        ->assertSet('showModal', false)
        ->call('openForm')
        ->assertSet('showModal', true)
        ->set('name', 'Тест')
        ->call('closeForm')
        ->assertSet('showModal', false)
        ->assertSet('name', '');
});

test('order form requires name and phone number', function () {
    Livewire::test(OrderForm::class)
        ->call('submitOrder')
        ->assertHasErrors([
            'name' => 'required',
            'phone' => 'required',
        ]);
});

test('order form validates invalid email and too short phone', function () {
    Livewire::test(OrderForm::class)
        ->set('name', 'Іван')
        ->set('phone', '123')
        ->set('email', 'invalid-email')
        ->call('submitOrder')
        ->assertHasErrors([
            'phone' => 'min',
            'email' => 'email',
        ]);
});

test('submitting valid order form dispatches order email to director', function () {
    Mail::fake();

    Livewire::test(OrderForm::class)
        ->set('name', 'Олександр Коваленко')
        ->set('phone', '+380998887766')
        ->set('email', 'alex@example.com')
        ->set('product', 'Вулик на 12 рамок')
        ->set('quantity', 3)
        ->set('message', 'Потрібна доставка Новою Поштою.')
        ->call('submitOrder')
        ->assertHasNoErrors()
        ->assertSet('isSubmitted', true);

    Mail::assertQueued(OrderMail::class, function (OrderMail $mail) {
        $expectedRecipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'director@himpost.com');
        if (! str_contains($expectedRecipient, '@')) {
            $expectedRecipient = 'director@himpost.com';
        }

        return $mail->hasTo($expectedRecipient) &&
               $mail->orderData['name'] === 'Олександр Коваленко' &&
               $mail->orderData['phone'] === '+380998887766' &&
               $mail->orderData['email'] === 'alex@example.com' &&
               $mail->orderData['product'] === 'Вулик на 12 рамок' &&
               $mail->orderData['quantity'] === 3 &&
               $mail->orderData['message'] === 'Потрібна доставка Новою Поштою.';
    });
});

test('order form validates quantity boundaries', function () {
    Livewire::test(OrderForm::class)
        ->set('name', 'Іван')
        ->set('phone', '+380998887766')
        ->set('quantity', 0)
        ->call('submitOrder')
        ->assertHasErrors(['quantity' => 'min']);

    Livewire::test(OrderForm::class)
        ->set('name', 'Іван')
        ->set('phone', '+380998887766')
        ->set('quantity', 1001)
        ->call('submitOrder')
        ->assertHasErrors(['quantity' => 'max']);
});

test('order form allows adding and submitting multiple cart items', function () {
    Mail::fake();

    Livewire::test(OrderForm::class)
        ->set('name', 'Михайло')
        ->set('phone', '+380501112233')
        ->call('addToCart', 'Вулик на 8 рамок', 2)
        ->call('addToCart', 'ДАХ 10', 4)
        ->call('incrementCartItem', 1) // increment ДАХ 10 to 5
        ->call('decrementCartItem', 0) // decrement Вулик to 1
        ->call('submitOrder')
        ->assertHasNoErrors()
        ->assertSet('isSubmitted', true);

    Mail::assertQueued(OrderMail::class, function (OrderMail $mail) {
        return $mail->orderData['name'] === 'Михайло' &&
               count($mail->orderData['items']) === 2 &&
               $mail->orderData['items'][0]['name'] === 'Вулик на 8 рамок' &&
               $mail->orderData['items'][0]['quantity'] === 1 &&
               $mail->orderData['items'][1]['name'] === 'ДАХ 10' &&
               $mail->orderData['items'][1]['quantity'] === 5;
    });
});
