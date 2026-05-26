<?php

namespace App\Livewire;

use App\Mail\OrderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderForm extends Component
{
    /**
     * Listen for selectProduct event from catalog page to pre-fill product and open modal.
     */
    #[On('selectProduct')]
    public function selectProductAndOpen(string $productName, int $quantity = 1): void
    {
        $this->product = $productName;
        $this->quantity = $quantity;
        $this->addToCart($productName, $quantity);
        $this->showModal = true;
    }

    /**
     * Listen for addProductToCart event to add item and open modal.
     */
    #[On('addProductToCart')]
    public function addProductToCartAndOpen(string $productName, int $quantity = 1): void
    {
        $this->addToCart($productName, $quantity);
        $this->showModal = true;
    }

    public bool $showModal = false;

    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $product = 'інше';

    public int $quantity = 1;

    public array $cartItems = [];

    public string $message = '';

    public bool $isSubmitted = false;

    /**
     * Add an item to the shopping cart list.
     */
    public function addToCart(string $productName, int $quantity = 1): void
    {
        foreach ($this->cartItems as $index => $item) {
            if ($item['name'] === $productName) {
                $this->cartItems[$index]['quantity'] += $quantity;

                return;
            }
        }

        $this->cartItems[] = [
            'name' => $productName,
            'quantity' => $quantity,
        ];
    }

    /**
     * Increment cart item quantity.
     */
    public function incrementCartItem(int $index): void
    {
        if (isset($this->cartItems[$index])) {
            $this->cartItems[$index]['quantity']++;
        }
    }

    /**
     * Decrement cart item quantity.
     */
    public function decrementCartItem(int $index): void
    {
        if (isset($this->cartItems[$index])) {
            $this->cartItems[$index]['quantity']--;
            if ($this->cartItems[$index]['quantity'] <= 0) {
                $this->removeCartItem($index);
            }
        }
    }

    /**
     * Remove an item from the cart.
     */
    public function removeCartItem(int $index): void
    {
        if (isset($this->cartItems[$index])) {
            unset($this->cartItems[$index]);
            $this->cartItems = array_values($this->cartItems);
        }
    }

    /**
     * Add current product input selection to the cart list.
     */
    public function addCurrentProductToList(): void
    {
        $this->addToCart($this->product, $this->quantity);
        $this->product = 'інше';
        $this->quantity = 1;
    }

    /**
     * Get the validation rules.
     *
     * @return array<string, string>
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|min:2|max:100',
            'phone' => 'required|min:9|max:20',
            'email' => 'nullable|email|max:100',
            'product' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1|max:1000',
            'message' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array<string, string>
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
            'email.email' => 'Введіть коректну адресу електронної пошти.',
            'email.max' => 'Адреса електронної пошти занадто довга.',
            'quantity.required' => 'Будь ласка, вкажіть кількість.',
            'quantity.integer' => 'Кількість має бути цілим числом.',
            'quantity.min' => 'Кількість має бути щонайменше 1.',
            'quantity.max' => 'Кількість не може перевищувати 1000.',
            'message.max' => 'Повідомлення не може перевищувати 1000 символів.',
        ];
    }

    /**
     * Open the modal and reset state.
     */
    #[On('openOrderForm')]
    public function openForm(): void
    {
        $this->reset(['name', 'phone', 'email', 'product', 'quantity', 'cartItems', 'message', 'isSubmitted']);
        $this->quantity = 1;
        $this->cartItems = [];
        $this->showModal = true;
    }

    /**
     * Close the modal.
     */
    public function closeForm(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'phone', 'email', 'product', 'quantity', 'cartItems', 'message', 'isSubmitted']);
        $this->quantity = 1;
        $this->cartItems = [];
    }

    /**
     * Validate and submit the order.
     */
    public function submitOrder(): void
    {
        $this->validate();

        // If cart items are empty, automatically add the currently selected product/quantity
        if (empty($this->cartItems)) {
            $this->addToCart($this->product, $this->quantity);
        }

        $orderData = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'product' => count($this->cartItems) === 1 ? $this->cartItems[0]['name'] : 'Декілька товарів ('.count($this->cartItems).' найменувань)',
            'quantity' => count($this->cartItems) === 1 ? $this->cartItems[0]['quantity'] : collect($this->cartItems)->sum('quantity'),
            'items' => $this->cartItems,
            'message' => $this->message ?: null,
            'ip' => request()->ip(),
        ];

        // Resolve recipient: check config or env first
        $recipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'director@himpost.com');

        // Clean up recipient if it's malformed (e.g. directorhimpost.com without @)
        if (! str_contains($recipient, '@')) {
            $recipient = 'director@himpost.com';
        }

        // Send the email
        Mail::to($recipient)->send(new OrderMail($orderData));

        // Mark as submitted
        $this->isSubmitted = true;
    }

    /**
     * Render the component view.
     */
    public function render(): View
    {
        return view('livewire.order-form');
    }
}
