<section class="relative overflow-hidden bg-[#faf9f6] py-12 lg:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-10">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-amber-400 shadow-md text-3xl">
                        🐝
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-zinc-950 font-serif leading-tight">Калькулятор комплектації пасіки</h2>
                        <p class="mt-1 text-sm text-zinc-600">
                            Сконструюйте ідеальні вулики для вашої пасіки в реальному часі без зайвих зусиль.
                        </p>
                    </div>
                </div>
                
                <!-- Discount Notice Banner -->
                <div class="rounded-2xl border border-amber-200 bg-amber-50/80 px-4 py-3 text-xs text-zinc-800 shadow-xs sm:max-w-md backdrop-blur-xs">
                    <div class="flex gap-2">
                        <span class="text-amber-500 font-bold">⚠️ Автоматичні знижки при замовленні від:</span>
                    </div>
                    <p class="mt-1 font-semibold text-zinc-700">
                        30 тис. грн — <span class="text-amber-600">5%</span> | 50 тис. грн — <span class="text-amber-600">6%</span> | 70 тис. грн — <span class="text-amber-600">7%</span> | 90 тис. грн — <span class="text-amber-600">8%</span> | 120 тис. грн — <span class="text-amber-600">10%</span>
                    </p>
                </div>
            </div>
        </div>

        @if (session()->has('calculation_sent'))
            <div class="mb-8 rounded-3xl border border-green-200 bg-green-50/80 p-6 text-green-800 shadow-xs backdrop-blur-xs flex items-start gap-4">
                <span class="text-3xl leading-none">🎉</span>
                <div>
                    <h4 class="font-bold text-lg">Розрахунок успішно надіслано!</h4>
                    <p class="text-sm mt-1 font-medium">{{ session('calculation_sent') }}</p>
                </div>
            </div>
        @endif

        <!-- Two-Part Grid Layout -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 items-start">
            
            <!-- PART 1: Selection & Configuration (Left Column) -->
            <div class="space-y-8 lg:col-span-8">
                
                <!-- Step 1: Select Hive Type -->
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 sm:p-8 shadow-xs transition hover:shadow-md duration-300">
                    <div class="mb-5 flex items-center gap-3 border-b border-zinc-100 pb-4">
                        <div class="flex size-9 items-center justify-center rounded-xl bg-amber-100 font-bold text-amber-800">1</div>
                        <h3 class="text-xl font-bold text-zinc-950">Оберіть тип вулика</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @foreach ([
                            '8' => ['title' => '8-рамковий вулик', 'desc' => 'Найбільш компактний та легкий'],
                            '10' => ['title' => '10-рамковий вулик', 'desc' => 'Золотий стандарт бджільництва'],
                            '12' => ['title' => '12-рамковий вулик', 'desc' => 'Для максимального медозбору'],
                        ] as $size => $item)
                            <button wire:click="$set('frameSize', '{{ $size }}')" type="button" @class([
                                'relative flex flex-col items-start p-5 rounded-2xl border-2 text-left transition duration-200 cursor-pointer hover:scale-[1.01] focus:outline-none',
                                'border-amber-400 bg-amber-50/30 ring-4 ring-amber-400/10' => $frameSize == $size,
                                'border-zinc-200 bg-white hover:border-amber-300 text-zinc-800' => $frameSize != $size,
                            ])>
                                @if($frameSize == $size)
                                    <span class="absolute top-4 right-4 flex size-6 items-center justify-center rounded-full bg-amber-400 text-black text-xs font-bold">✓</span>
                                @endif
                                <span class="text-3xl mb-3">🪵</span>
                                <span class="font-bold text-zinc-950 sm:text-base">{{ $item['title'] }}</span>
                                <span class="mt-1 text-xs text-zinc-500 font-medium leading-relaxed">{{ $item['desc'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Step 2: Choose Preset / Ready Set -->
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 sm:p-8 shadow-xs transition hover:shadow-md duration-300">
                    <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex size-9 items-center justify-center rounded-xl bg-amber-100 font-bold text-amber-800">2</div>
                            <h3 class="text-xl font-bold text-zinc-950">Готові комплекти</h3>
                        </div>
                        
                        <!-- Multiplier quantity for presets -->
                        <div class="flex items-center gap-3 bg-zinc-50 border border-zinc-200 px-3 py-1.5 rounded-xl">
                            <label class="text-xs font-bold text-zinc-600 uppercase tracking-wider">Кількість вуликів:</label>
                            <input wire:model.live="quantity" type="number" min="1" max="999" 
                                class="h-8 w-14 rounded-lg border border-zinc-300 text-center font-bold bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                            @error('quantity')
                                <span class="block text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <p class="text-xs text-zinc-500 mb-6 leading-relaxed font-medium">
                        💡 <span class="text-zinc-700 font-bold">Порада:</span> Вкажіть кількість вуликів справа, а потім оберіть готовий комплект. Його склад миттєво з'явиться в конструкторі нижче, де ви зможете вільно змінити кількість будь-якої деталі.
                    </p>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        @foreach ($this->packages() as $key => $package)
                            <div @class([
                                'flex flex-col rounded-2xl border-2 p-5 transition duration-200 hover:scale-[1.01]',
                                'border-amber-400 bg-amber-50/10' => $packageKey === $key,
                                'border-zinc-200 bg-white hover:border-amber-300' => $packageKey !== $key,
                            ])>
                                <div class="flex justify-between items-start gap-4 mb-3">
                                    <div>
                                        <h4 class="font-bold text-zinc-950 text-base">{{ $package['name'] }}</h4>
                                        <span class="text-xs text-zinc-500 font-semibold">{{ $frameSize }}-рамковий</span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-lg font-black text-amber-900 leading-tight">
                                            {{ number_format($package['price'], 0, ',', ' ') }} грн
                                        </div>
                                        <span class="text-[10px] text-zinc-400 font-bold uppercase">за 1 шт</span>
                                    </div>
                                </div>

                                <div class="flex-1"></div>

                                <button wire:click="selectPresetCard('{{ $key }}')" type="button" @class([
                                    'w-full py-2.5 rounded-xl font-bold text-xs transition duration-200 cursor-pointer uppercase tracking-wider text-center border',
                                    'bg-amber-400 text-black border-amber-400 hover:bg-amber-300' => $packageKey === $key,
                                    'bg-zinc-50 text-zinc-700 border-zinc-200 hover:bg-zinc-100 hover:text-zinc-950' => $packageKey !== $key,
                                ])>
                                    @if ($packageKey === $key)
                                        ✨ Комплект обрано
                                    @else
                                        ⚡ Обрати цей комплект
                                    @endif
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <!-- Склад обраної комплектації -->
                    @php($selectedComponents = $this->selectedPackageComponents())
                    @if ($selectedComponents !== [] && $packageKey)
                        <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50/50 p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <div class="flex size-8 items-center justify-center rounded-lg bg-amber-400 text-sm">📦</div>
                                <h4 class="text-sm font-bold text-zinc-900">Що входить у {{ $this->selectedPackage()['name'] }}:</h4>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach ($selectedComponents as $comp)
                                    <div class="flex items-center gap-3 rounded-xl bg-white/80 px-4 py-2 border border-amber-100">
                                        <span class="text-amber-500 font-bold">✓</span>
                                        <span class="text-xs font-semibold text-zinc-800">{{ $comp['name'] }}</span>
                                        <span class="ml-auto text-xs font-bold text-zinc-500">{{ $comp['qty'] }} {{ $comp['unit'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if ($mode === 'expert')
                    <!-- Step 3: Open Constructor (Individual Parts) -->
                    <div class="rounded-3xl border border-zinc-200 bg-white p-6 sm:p-8 shadow-xs transition hover:shadow-md duration-300">
                        <div class="mb-6 flex items-center gap-3 border-b border-zinc-100 pb-4">
                            <div class="flex size-9 items-center justify-center rounded-xl bg-amber-100 font-bold text-amber-800">3</div>
                            <h3 class="text-xl font-bold text-zinc-950">Деталі конструктора</h3>
                        </div>

                        <p class="text-sm text-zinc-600 mb-6 leading-relaxed">
                            Нижче представлено весь список доступних деталей. Регулюйте кількість кожної комплектуючої за допомогою кнопок <span class="font-bold text-amber-600">+</span> та <span class="font-bold text-amber-600">-</span>.
                        </p>

                        <!-- Group 1: Frame Size Specific Components -->
                        <div class="mb-8">
                            <h4 class="mb-4 text-xs font-bold text-zinc-500 uppercase tracking-widest border-b border-zinc-100 pb-2">
                                Основні деталі для {{ $frameSize }}-рамкового вулика
                            </h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($this->components() as $key => $component)
                                    @if ($component['group'] !== 'інше')
                                        @php($currentQty = $this->getItemQuantity($key))
                                        <div @class([
                                            'flex items-center justify-between gap-4 rounded-2xl border-2 p-4 transition duration-200 hover:scale-[1.01]',
                                            'border-amber-400 bg-amber-50/10' => $currentQty > 0,
                                            'border-zinc-100 bg-zinc-50/60 hover:border-zinc-200' => $currentQty == 0,
                                        ])>
                                            <div class="pr-2">
                                                <h5 class="text-sm font-bold text-zinc-950 leading-tight">
                                                    {{ $component['name'] }}
                                                </h5>
                                                <span class="text-xs font-black text-amber-700 block mt-1">
                                                    {{ number_format($component['price'], 0, ',', ' ') }} грн/шт
                                                </span>
                                            </div>
                                            
                                            <!-- tactile adjuster -->
                                            <div class="flex items-center gap-1.5 shrink-0 bg-white rounded-xl border border-zinc-200 p-1 shadow-xs">
                                                <button type="button" wire:click="decrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-lg hover:bg-zinc-100 text-zinc-700 font-bold transition select-none">-</button>
                                                
                                                <input type="number" min="0" max="999"
                                                    value="{{ $currentQty }}"
                                                    wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                    class="h-8 w-10 text-center font-bold bg-transparent text-sm focus:outline-none focus:ring-0 border-0 p-0">
                                                
                                                <button type="button" wire:click="incrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-lg bg-amber-400 hover:bg-amber-300 text-black font-bold transition select-none">+</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Group 2: General & Other Components -->
                        <div>
                            <h4 class="mb-4 text-xs font-bold text-zinc-500 uppercase tracking-widest border-b border-zinc-100 pb-2">
                                Загальні та додаткові комплектуючі
                            </h4>
                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach ($this->components() as $key => $component)
                                    @if ($component['group'] === 'інше')
                                        @php($currentQty = $this->getItemQuantity($key))
                                        <div @class([
                                            'flex items-center justify-between gap-4 rounded-2xl border-2 p-4 transition duration-200 hover:scale-[1.01]',
                                            'border-amber-400 bg-amber-50/10' => $currentQty > 0,
                                            'border-zinc-100 bg-zinc-50/60 hover:border-zinc-200' => $currentQty == 0,
                                        ])>
                                            <div class="pr-2">
                                                <h5 class="text-sm font-bold text-zinc-950 leading-tight">
                                                    {{ $component['name'] }}
                                                </h5>
                                                <span class="text-xs font-black text-amber-700 block mt-1">
                                                    {{ number_format($component['price'], 0, ',', ' ') }} грн/шт
                                                </span>
                                            </div>
                                            
                                            <!-- tactile adjuster -->
                                            <div class="flex items-center gap-1.5 shrink-0 bg-white rounded-xl border border-zinc-200 p-1 shadow-xs">
                                                <button type="button" wire:click="decrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-lg hover:bg-zinc-100 text-zinc-700 font-bold transition select-none">-</button>
                                                
                                                <input type="number" min="0" max="999"
                                                    value="{{ $currentQty }}"
                                                    wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                    class="h-8 w-10 text-center font-bold bg-transparent text-sm focus:outline-none focus:ring-0 border-0 p-0">
                                                
                                                <button type="button" wire:click="incrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-lg bg-amber-400 hover:bg-amber-300 text-black font-bold transition select-none">+</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- PART 2: Order Summary, Totals & Checkout (Right Column - Sticky) -->
            <div class="space-y-8 lg:col-span-4 lg:sticky lg:top-24">
                
                <!-- Order Summary Card -->
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-zinc-950 border-b border-zinc-100 pb-3 mb-4 flex items-center gap-2">
                        <span>🛒</span>
                        <span>Ваше замовлення</span>
                    </h3>

                    <!-- Order items list -->
                    @if (empty($items))
                        <div class="py-8 px-4 text-center rounded-2xl border-2 border-dashed border-zinc-200 bg-zinc-50/50">
                            <span class="text-3xl block mb-2 opacity-60">🐝</span>
                            <p class="text-xs font-semibold text-zinc-500 leading-relaxed">
                                Замовлення порожнє.<br>Оберіть готовий комплект або вкажіть кількість комплектуючих ліворуч.
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-zinc-100 max-h-80 overflow-y-auto pr-1">
                            @foreach ($items as $index => $item)
                                <div wire:key="cart-item-{{ $index }}" class="py-3 flex items-center justify-between gap-3 group">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-zinc-950 text-xs truncate leading-tight">{{ $item['name'] }}</h4>
                                        <span class="text-[10px] font-semibold text-zinc-500 block mt-0.5">
                                            {{ $item['quantity'] }} шт × {{ number_format($item['price'], 0, ',', ' ') }} грн
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 shrink-0">
                                        <span class="text-xs font-black text-zinc-900">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} грн
                                        </span>
                                        <button wire:click="removeItem({{ $index }})" type="button"
                                            class="opacity-0 group-hover:opacity-100 focus:opacity-100 transition size-6 cursor-pointer flex items-center justify-center rounded-md border border-zinc-200 bg-zinc-50 text-xs font-bold text-zinc-400 hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                            title="Видалити">×</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4 pt-3 border-t border-zinc-100 flex justify-between">
                            <button wire:click="clear" type="button"
                                class="text-xs font-bold text-zinc-500 hover:text-zinc-800 transition cursor-pointer">
                                🗑️ Очистити список
                            </button>
                        </div>
                    @endif

                    <!-- Packaging box option -->
                    <div class="mt-6 border-t border-zinc-100 pt-4">
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input wire:model.live="includePackaging" type="checkbox"
                                class="size-5 rounded-lg border-zinc-300 text-amber-500 focus:ring-amber-400 cursor-pointer">
                            <span class="text-xs font-semibold text-zinc-700 leading-normal">
                                📦 Включити упакування вуликів (70 грн/вулик)
                            </span>
                        </label>
                    </div>

                    <!-- Prices breakdown -->
                    <div class="mt-6 space-y-2 border-t border-zinc-100 pt-4">
                        <div class="flex justify-between text-xs font-medium text-zinc-600">
                            <span>Сума позицій:</span>
                            <span class="font-bold text-zinc-900">{{ number_format($this->subtotal(), 0, ',', ' ') }} грн</span>
                        </div>
                        
                        @if ($this->discountRate() > 0)
                            <div class="flex justify-between items-center text-xs font-medium text-green-700">
                                <span class="flex items-center gap-1.5">
                                    <span>🎁 Знижка {{ $this->discountRate() }}%:</span>
                                </span>
                                <span class="font-bold">-{{ number_format($this->discountAmount(), 0, ',', ' ') }} грн</span>
                            </div>
                        @endif

                        @if ($includePackaging && $this->packagingAmount() > 0)
                            <div class="flex justify-between text-xs font-medium text-zinc-600">
                                <span>Упакування:</span>
                                <span class="font-bold text-zinc-900">{{ number_format($this->packagingAmount(), 0, ',', ' ') }} грн</span>
                            </div>
                        @endif

                        <!-- Grand Total to Pay -->
                        <div class="mt-4 rounded-2xl bg-gradient-to-r from-amber-400 to-amber-500 p-4 text-zinc-950 flex justify-between items-center shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider opacity-90">Разом до сплати:</span>
                            <span class="text-xl font-black">{{ number_format($this->total(), 0, ',', ' ') }} грн</span>
                        </div>
                    </div>
                </div>

                <!-- Checkout Contact Information Card -->
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <h3 class="text-xl font-bold text-zinc-950 border-b border-zinc-100 pb-3 mb-4 flex items-center gap-2">
                        <span>👤</span>
                        <span>Контакти покупця</span>
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="mb-1 block text-xs font-bold text-zinc-700">Ваше ім'я *</label>
                            <input wire:model.blur="name" type="text" placeholder="Іван Петренко"
                                class="h-11 w-full rounded-xl border border-zinc-300 bg-zinc-50 px-4 text-sm transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                            @error('name')
                                <span class="mt-1 block text-[10px] text-red-600 font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-bold text-zinc-700">Номер телефону *</label>
                            <div class="relative">
                                <input wire:model.blur="phone" type="text" placeholder="+380 99 123 45 67"
                                    class="h-11 w-full rounded-xl border border-zinc-300 bg-zinc-50 pl-12 pr-4 text-sm transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-sm select-none">🇺🇦</div>
                            </div>
                            @error('phone')
                                <span class="mt-1 block text-[10px] text-red-600 font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-xs font-bold text-zinc-700">Електронна пошта</label>
                            <input wire:model.blur="email" type="email" placeholder="ivan@gmail.com"
                                class="h-11 w-full rounded-xl border border-zinc-300 bg-zinc-50 px-4 text-sm transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                            @error('email')
                                <span class="mt-1 block text-[10px] text-red-600 font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <button wire:click="sendCalculation" wire:loading.attr="disabled" type="button"
                            class="w-full mt-4 h-12 rounded-xl bg-amber-400 hover:bg-amber-300 text-zinc-950 font-black shadow-md transition duration-200 cursor-pointer inline-flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                            <span wire:loading.remove wire:target="sendCalculation">📨 Надіслати замовлення</span>
                            <span wire:loading wire:target="sendCalculation" class="inline-block animate-spin">⏳</span>
                            <span wire:loading wire:target="sendCalculation">Надсилаємо...</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
