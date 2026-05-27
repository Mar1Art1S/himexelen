<?php

namespace App\Livewire;

use App\Mail\OrderMail;
use App\Models\ProductCategory;
use App\Models\ProductComplectation;
use App\Models\ProductComponent;
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
     * Resolve product price from dynamic DB records.
     */
    public function resolveProductPrice(string $name): int
    {
        $name = trim($name);

        // 1. Check if it matches a basic hive
        if (preg_match('/вулик на (\d+) рамок/ui', $name, $matches)) {
            $frames = $matches[1]; // '8', '10', or '12'
            $category = ProductCategory::where('slug', "{$frames}-frames")->first();
            if ($category) {
                $complectation = ProductComplectation::where('product_category_id', $category->id)
                    ->where('name', 'Комплектація 1')
                    ->first();
                if ($complectation) {
                    return $complectation->price;
                }
            }

            return match ($frames) {
                '8' => 2607,
                '10' => 2837,
                '12' => 3230,
                default => 0,
            };
        }

        // 2. Check if it's a complectation (e.g. "8 рамок, Комплектація 1")
        if (preg_match('/^(8|10|12)\s+рамок,\s+(.+)$/u', $name, $matches)) {
            $frames = $matches[1];
            $compName = $matches[2];
            $category = ProductCategory::where('slug', "{$frames}-frames")->first();
            if ($category) {
                $complectation = ProductComplectation::where('product_category_id', $category->id)
                    ->where('name', $compName)
                    ->first();
                if ($complectation) {
                    return $complectation->price;
                }
            }
        }

        $cleanedName = preg_replace('/^(8|10|12)\s+рамок,\s+/u', '', $name);
        $complectation = ProductComplectation::where('name', $cleanedName)->first();
        if ($complectation) {
            return $complectation->price;
        }

        // 3. Check if it's a component
        $component = ProductComponent::where('name', $name)->first();
        if ($component) {
            return $component->price;
        }

        return 0;
    }

    /**
     * Get the subtotal of the cart items.
     */
    public function subtotal(): int
    {
        if (empty($this->cartItems)) {
            return $this->resolveProductPrice($this->product) * $this->quantity;
        }

        $subtotal = 0;
        foreach ($this->cartItems as $item) {
            $price = $this->resolveProductPrice($item['name']);
            $subtotal += $price * $item['quantity'];
        }

        return $subtotal;
    }

    /**
     * Get the discount rate based on subtotal.
     */
    public function discountRate(): int
    {
        $subtotal = $this->subtotal();

        return match (true) {
            $subtotal >= 120000 => 10,
            $subtotal >= 90000 => 8,
            $subtotal >= 70000 => 7,
            $subtotal >= 50000 => 6,
            $subtotal >= 30000 => 5,
            default => 0,
        };
    }

    /**
     * Get the discount amount.
     */
    public function discountAmount(): int
    {
        return (int) round($this->subtotal() * $this->discountRate() / 100);
    }

    /**
     * Get the total amount after discount.
     */
    public function total(): int
    {
        return $this->subtotal() - $this->discountAmount();
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
            'subtotal' => $this->subtotal(),
            'discountRate' => $this->discountRate(),
            'discountAmount' => $this->discountAmount(),
            'total' => $this->total(),
            'message' => $this->message ?: null,
            'ip' => request()->ip(),
        ];

        // Resolve recipient
        $recipient = config('mail.recipient') ?? env('MAIL_TO_ADDRESS', 'info@bee.lg.ua');
        if (! str_contains($recipient, '@')) {
            $recipient = config('mail.from.address') ?? 'info@bee.lg.ua';
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
        $categories = ProductCategory::with(['complectations' => function ($query) {
            $query->orderBy('sort_order');
        }])->get();

        $groupedComponents = ProductComponent::orderBy('sort_order')
            ->get()
            ->groupBy('group');

        return view('livewire.order-form', [
            'categories' => $categories,
            'groupedComponents' => $groupedComponents,
        ]);
    }
}
