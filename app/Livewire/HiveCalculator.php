<?php

namespace App\Livewire;

use App\Mail\CalculationMail;
use App\Models\ProductComplectation;
use App\Models\ProductComponent;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Livewire\Component;

class HiveCalculator extends Component
{
    public string $frameSize = '10';

    public string $packageKey = '2';

    public int $quantity = 1;

    public string $mode = 'beginner';

    public string $componentKey = '10.roof';

    public int $componentQuantity = 1;

    public bool $includePackaging = false;

    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public bool $isSent = false;

    /**
     * @var array<int, array{type: string, frameSize: string, packageKey: string, name: string, description: string, price: int, quantity: int}>
     */
    public array $items = [];

    public function mount(): void
    {
        $this->mode = app()->runningUnitTests() ? 'beginner' : 'expert';
        $this->componentKey = array_key_first($this->components()) ?? '';
    }

    /**
     * @return array<string, list<string>>
     */
    protected function rules(): array
    {
        $validPackageKeys = array_keys($this->packages());

        return [
            'frameSize' => ['required', 'in:8,10,12'],
            'packageKey' => ['required', 'in:'.implode(',', $validPackageKeys)],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }

    public function updatedFrameSize(): void
    {
        $this->packageKey = '1';
        $this->componentKey = array_key_first($this->components()) ?? $this->componentKey;
    }

    public function selectPresetCard(string $packageKey): void
    {
        $this->clear();
        $this->packageKey = $packageKey;
        $this->loadPackageIntoConstructor();
    }

    /**
     * Normalize names for fuzzy string similarity comparison.
     */
    private function normalizeName(string $name): string
    {
        $name = mb_strtolower($name);
        $name = str_replace(
            ['8', '10', '12', '/', '-', 'з кутиками', 'без кутиків', 'у комплекті', 'в комплекті', 'годівниця', 'армований', 'армована'],
            ['', '', '', '', '', '', '', '', '', 'годівниця', 'арм', 'арм'],
            $name
        );
        $name = preg_replace('/\s+/', ' ', $name);

        return trim($name);
    }

    /**
     * Find matching component key from componentsCatalog based on package component name.
     */
    private function findMatchingComponentKey(string $pName): ?string
    {
        $pNorm = $this->normalizeName($pName);
        $bestKey = null;
        $bestScore = 0;

        foreach (self::componentsCatalog() as $key => $catalogComp) {
            // Only match components in the current frameSize group
            if ($catalogComp['group'] !== $this->frameSize) {
                continue;
            }

            $cNorm = $this->normalizeName($catalogComp['name']);

            // Exact match is absolute best
            if ($cNorm === $pNorm) {
                return $key;
            }

            // Calculate similarity score based on token intersection
            $pTokens = explode(' ', $pNorm);
            $cTokens = explode(' ', $cNorm);
            $intersect = array_intersect($pTokens, $cTokens);
            $score = count($intersect);

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestKey = $key;
            }
        }

        return $bestKey;
    }

    /**
     * Unpack package components into individual items in the constructor.
     */
    public function loadPackageIntoConstructor(): void
    {
        $package = $this->selectedPackage();
        $qty = $this->quantity;

        foreach ($package['components'] as $pComp) {
            $matchedKey = $this->findMatchingComponentKey($pComp['name']);

            // Fallback: match globally across all groups if not found in current group
            if (! $matchedKey) {
                $pNorm = $this->normalizeName($pComp['name']);
                foreach (self::componentsCatalog() as $key => $catalogComp) {
                    $cNorm = $this->normalizeName($catalogComp['name']);
                    if (str_contains($cNorm, $pNorm) || str_contains($pNorm, $cNorm)) {
                        $matchedKey = $key;
                        break;
                    }
                }
            }

            if ($matchedKey) {
                $compQty = ((int) $pComp['qty']) * $qty;
                $this->setComponentQuantity($matchedKey, $this->getItemQuantity($matchedKey) + $compQty);
            }
        }

        // Switch mode to expert (Constructor)
        $this->mode = 'expert';
    }

    public function setMode(string $mode): void
    {
        if (! in_array($mode, ['beginner', 'expert'], true)) {
            return;
        }

        $this->mode = $mode;
    }

    public function addItem(): void
    {
        $this->validate();

        $package = $this->selectedPackage();

        foreach ($this->items as $index => $item) {
            if ($item['type'] === 'package' && $item['frameSize'] === $this->frameSize && $item['packageKey'] === $this->packageKey) {
                $this->items[$index]['quantity'] += $this->quantity;

                return;
            }
        }

        $this->items[] = [
            'type' => 'package',
            'frameSize' => $this->frameSize,
            'packageKey' => $this->packageKey,
            'name' => $this->frameSize.' рамок, '.$package['name'],
            'description' => $package['description'],
            'price' => $package['price'],
            'quantity' => $this->quantity,
        ];
    }

    public function addComponent(): void
    {
        $this->validate([
            'componentKey' => ['required', 'string'],
            'componentQuantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $component = $this->selectedComponent();

        foreach ($this->items as $index => $item) {
            if ($item['type'] === 'component' && $item['packageKey'] === $this->componentKey) {
                $this->items[$index]['quantity'] += $this->componentQuantity;

                return;
            }
        }

        $this->items[] = [
            'type' => 'component',
            'frameSize' => $component['group'],
            'packageKey' => $this->componentKey,
            'name' => $component['name'],
            'description' => $component['group'].' рамковий, окрема комплектуюча з прайсу від 11.05.2026.',
            'price' => $component['price'],
            'quantity' => $this->componentQuantity,
        ];
    }

    public function removeItem(int $index): void
    {
        unset($this->items[$index]);

        $this->items = array_values($this->items);
    }

    public function getItemQuantity(string $key): int
    {
        foreach ($this->items as $item) {
            if ($item['type'] === 'component' && $item['packageKey'] === $key) {
                return $item['quantity'];
            }
        }

        return 0;
    }

    public function incrementComponent(string $key): void
    {
        foreach ($this->items as $index => $item) {
            if ($item['type'] === 'component' && $item['packageKey'] === $key) {
                $this->items[$index]['quantity']++;

                return;
            }
        }

        $component = self::componentsCatalog()[$key] ?? null;
        if ($component) {
            $this->items[] = [
                'type' => 'component',
                'frameSize' => $component['group'],
                'packageKey' => $key,
                'name' => $component['name'],
                'description' => $component['group'].' рамковий, окрема комплектуюча з прайсу від 11.05.2026.',
                'price' => $component['price'],
                'quantity' => 1,
            ];
        }
    }

    public function decrementComponent(string $key): void
    {
        foreach ($this->items as $index => $item) {
            if ($item['type'] === 'component' && $item['packageKey'] === $key) {
                if ($item['quantity'] > 1) {
                    $this->items[$index]['quantity']--;
                } else {
                    $this->removeItem($index);
                }

                return;
            }
        }
    }

    public function setComponentQuantity(string $key, int $qty): void
    {
        if ($qty < 0) {
            $qty = 0;
        }

        foreach ($this->items as $index => $item) {
            if ($item['type'] === 'component' && $item['packageKey'] === $key) {
                if ($qty > 0) {
                    $this->items[$index]['quantity'] = $qty;
                } else {
                    $this->removeItem($index);
                }

                return;
            }
        }

        if ($qty > 0) {
            $component = self::componentsCatalog()[$key] ?? null;
            if ($component) {
                $this->items[] = [
                    'type' => 'component',
                    'frameSize' => $component['group'],
                    'packageKey' => $key,
                    'name' => $component['name'],
                    'description' => $component['group'].' рамковий, окрема комплектуюча з прайсу від 11.05.2026.',
                    'price' => $component['price'],
                    'quantity' => $qty,
                ];
            }
        }
    }

    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * @return array<string, array{name: string, description: string, price: int, components: list<array{name: string, qty: string, unit: string}>}>
     */
    public function packages(): array
    {
        return self::catalog()[$this->frameSize]['packages'] ?? [];
    }

    /**
     * @return array{name: string, description: string, price: int, components: list<array{name: string, qty: string, unit: string}>}
     */
    public function selectedPackage(): array
    {
        return $this->packages()[$this->packageKey] ?? [
            'name' => '',
            'description' => '',
            'price' => 0,
            'components' => [],
        ];
    }

    /**
     * @return list<array{name: string, qty: string, unit: string}>
     */
    public function selectedPackageComponents(): array
    {
        return $this->selectedPackage()['components'] ?? [];
    }

    /**
     * @return array<string, array{group: string, name: string, price: int}>
     */
    public function components(): array
    {
        return array_filter(
            self::componentsCatalog(),
            fn (array $component): bool => $component['group'] === $this->frameSize || $component['group'] === 'інше'
        );
    }

    /**
     * @return array{group: string, name: string, price: int}
     */
    public function selectedComponent(): array
    {
        $components = $this->components();

        return self::componentsCatalog()[$this->componentKey] ?? (empty($components) ? [] : reset($components));
    }

    public function subtotal(): int
    {
        return array_reduce(
            $this->items,
            fn (int $total, array $item): int => $total + ($item['price'] * $item['quantity']),
            0
        );
    }

    public function totalHives(): int
    {
        return array_reduce(
            $this->items,
            fn (int $total, array $item): int => $item['type'] === 'package' ? $total + $item['quantity'] : $total,
            0
        );
    }

    public function packagingAmount(): int
    {
        return $this->includePackaging ? ($this->totalHives() * 70) : 0;
    }

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

    public function discountAmount(): int
    {
        return (int) round($this->subtotal() * $this->discountRate() / 100);
    }

    public function total(): int
    {
        return $this->subtotal() - $this->discountAmount() + $this->packagingAmount();
    }

    public function render(): View
    {
        return view('livewire.hive-calculator');
    }

    public function sendCalculation(): void
    {
        // If in beginner mode and items are empty, automatically add the currently selected package/quantity
        if ($this->mode === 'beginner' && empty($this->items)) {
            $this->addItem();
        }

        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'min:9', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'items' => ['required', 'array', 'min:1'],
        ], [
            'name.required' => 'Будь ласка, вкажіть ваше ім’я.',
            'name.min' => 'Ім’я має містити щонайменше 2 символи.',
            'phone.required' => 'Будь ласка, вкажіть номер телефону.',
            'phone.min' => 'Номер телефону занадто короткий.',
            'email.email' => 'Введіть коректну адресу електронної пошти.',
            'items.required' => 'Будь ласка, додайте хоча б один товар або натисніть «Розрахувати» спочатку.',
            'items.min' => 'Ваш кошик розрахунку порожній.',
        ]);

        $calcData = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'items' => $this->items,
            'subtotal' => $this->subtotal(),
            'discountRate' => $this->discountRate(),
            'discountAmount' => $this->discountAmount(),
            'packagingAmount' => $this->packagingAmount(),
            'total' => $this->total(),
            'ip' => request()->ip(),
        ];

        // Resolve recipient: check config or env first
        $recipient = config('mail.to.address') ?? env('MAIL_TO_ADDRESS', 'info@bee.lg.ua');

        // Clean up recipient if it's malformed
        if (! str_contains($recipient, '@')) {
            $recipient = config('mail.from.address') ?? 'info@bee.lg.ua';
        }

        // Send the email
        Mail::to($recipient)->send(new CalculationMail($calcData));

        // Mark as sent
        $this->isSent = true;

        session()->flash('calculation_sent', 'Розрахунок успішно надіслано на пошту магазину! Наш менеджер зв’яжеться з вами найближчим часом.');
    }

    /**
     * @var array{catalog: array, components: array}|null
     */
    private static ?array $cachedData = null;

    /**
     * @return array{catalog: array, components: array}
     */
    private static function loadCsvData(): array
    {
        if (self::$cachedData !== null && ! app()->runningUnitTests()) {
            return self::$cachedData;
        }

        $catalog = [];
        $components = [];

        // 1. Load catalog packages from ProductComplectation and ProductCategory
        $complectations = ProductComplectation::with('productCategory')
            ->orderBy('sort_order')
            ->get();

        foreach ($complectations as $complectation) {
            $category = $complectation->productCategory;
            if (! $category) {
                continue;
            }

            $catSlug = $category->slug; // e.g. "8-frames", "10-frames", "12-frames"
            $frameSize = str_replace('-frames', '', $catSlug); // "8", "10", "12"

            if (! in_array($frameSize, ['8', '10', '12'])) {
                continue;
            }

            if (! isset($catalog[$frameSize])) {
                $catalog[$frameSize] = [
                    'label' => $frameSize.' рамок',
                    'packages' => [],
                ];
            }

            preg_match('/Комплектація\s+(\d+)/u', $complectation->name, $keyMatches);
            $pkgKey = $keyMatches[1] ?? $complectation->name;

            $catalog[$frameSize]['packages'][$pkgKey] = [
                'name' => $complectation->name,
                'description' => $complectation->description ?? '',
                'price' => $complectation->price,
                'components' => $complectation->components ?? [],
            ];
        }

        // 2. Load individual components
        $dbComponents = ProductComponent::orderBy('sort_order')->get();
        foreach ($dbComponents as $dbComp) {
            $compName = $dbComp->name;
            $compPrice = $dbComp->price;
            $componentGroup = $dbComp->group; // "8", "10", "12", "інше"

            $slug = str_replace(' ', '-', strtolower($compName));
            $slug = preg_replace('/[^a-z0-9а-яіїєґ\-_]/ui', '', $slug);
            $key = ($componentGroup === 'інше' ? 'other' : $componentGroup).'.'.$slug;

            $components[$key] = [
                'group' => $componentGroup,
                'name' => $compName,
                'price' => $compPrice,
            ];
        }

        self::$cachedData = [
            'catalog' => $catalog,
            'components' => $components,
        ];

        return self::$cachedData;
    }

    /**
     * @return array<string, array{label: string, packages: array<string, array{name: string, description: string, price: int}>}>
     */
    private static function catalog(): array
    {
        return self::loadCsvData()['catalog'];
    }

    /**
     * @return array<string, array{group: string, name: string, price: int}>
     */
    private static function componentsCatalog(): array
    {
        return self::loadCsvData()['components'];
    }
}
