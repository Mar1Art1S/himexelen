<section class="relative overflow-hidden bg-[#faf9f6] py-10 lg:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        
        @if (session()->has('calculation_sent'))
            <div class="mb-8 rounded-2xl border-2 border-green-300 bg-green-50 p-6 text-green-800 shadow-sm flex items-start gap-4">
                <span class="text-4xl leading-none">✅</span>
                <div>
                    <h4 class="font-bold text-xl">Розрахунок успішно надіслано!</h4>
                    <p class="text-base mt-1 font-medium">{{ session('calculation_sent') }}</p>
                </div>
            </div>
        @endif



        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            
            <!-- Ліва колонка: Кроки вибору та Конструктор -->
            <div class="space-y-6 lg:col-span-7 xl:col-span-8 lg:max-h-[calc(100vh-220px)] lg:overflow-y-auto lg:pr-6 lg:pl-1 lg:py-2">
                
                <!-- ─── КРОК 1: КОНТАКТИ ДЛЯ ЗАМОВЛЕННЯ ─── -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 sm:p-6 lg:p-8 shadow-xs">
                    <h3 class="text-xl font-black text-zinc-950 mb-6 flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-amber-400 text-white text-lg font-black">1</span>
                        Залиште контакти для замовлення
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-base font-bold text-zinc-700">Ваше ім'я <span class="text-red-500">*</span></label>
                            <input wire:model.blur="name" type="text" placeholder="Іван Петренко"
                                class="h-14 w-full rounded-xl border-2 border-zinc-300 bg-zinc-50 px-5 text-lg transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                            @error('name')
                                <span class="mt-1.5 block text-sm text-red-600 font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-base font-bold text-zinc-700">Номер телефону <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input wire:model.blur="phone" type="tel" placeholder="+380 99 123 45 67"
                                    class="h-14 w-full rounded-xl border-2 border-zinc-300 bg-zinc-50 pl-14 pr-5 text-lg transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 text-lg select-none">🇺🇦</div>
                            </div>
                            @error('phone')
                                <span class="mt-1.5 block text-sm text-red-600 font-bold">{{ $message }}</span>
                            @enderror
                        </div>

                        <details class="group">
                            <summary class="cursor-pointer text-sm font-semibold text-zinc-500 hover:text-zinc-700 transition select-none list-none flex items-center gap-1 [&::-webkit-details-marker]:hidden">
                                <svg class="size-4 transition-transform duration-200 group-open:rotate-90" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                                Додати електронну пошту (необов'язково)
                            </summary>
                            <div class="mt-3">
                                <input wire:model.blur="email" type="email" placeholder="ivan@gmail.com"
                                    class="h-14 w-full rounded-xl border-2 border-zinc-300 bg-zinc-50 px-5 text-lg transition focus:border-amber-400 focus:outline-none focus:ring-3 focus:ring-amber-300/30">
                                @error('email')
                                    <span class="mt-1.5 block text-sm text-red-600 font-bold">{{ $message }}</span>
                                @enderror
                            </div>
                        </details>
                    </div>
                </div>

                <!-- ─── КРОК 2: Розмір вулика ─── -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 sm:p-6 lg:p-8 shadow-xs">
                    <h3 class="text-xl font-black text-zinc-950 mb-5 flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-amber-400 text-white text-lg font-black">2</span>
                        Оберіть розмір вулика
                    </h3>
                    
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                        @foreach ([
                            '8' => '8-рамковий',
                            '10' => '10-рамковий',
                            '12' => '12-рамковий',
                        ] as $size => $label)
                            <button wire:click="$set('frameSize', '{{ $size }}')" type="button" @class([
                                'relative flex items-center justify-center p-5 sm:p-6 rounded-2xl border-2 text-center transition duration-200 cursor-pointer focus:outline-none',
                                'border-amber-400 bg-amber-50 ring-4 ring-amber-400/20 shadow-md' => $frameSize == $size,
                                'border-zinc-200 bg-white hover:border-amber-300' => $frameSize != $size,
                            ])>
                                @if($frameSize == $size)
                                    <span class="absolute top-3 right-3 flex size-7 items-center justify-center rounded-full bg-amber-400 text-white text-sm font-bold">✓</span>
                                @endif
                                <span class="font-black text-zinc-950 text-lg sm:text-xl">{{ $label }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- ─── КРОК 3: Комплектація ─── -->
                <div class="rounded-2xl border border-zinc-200 bg-white p-4 sm:p-6 lg:p-8 shadow-xs">
                    <h3 class="text-xl font-black text-zinc-950 mb-5 flex items-center gap-3">
                        <span class="flex size-10 items-center justify-center rounded-xl bg-amber-400 text-white text-lg font-black">3</span>
                        Оберіть комплектацію
                    </h3>
                    
                    <div class="space-y-3">
                        @foreach ($this->packages() as $key => $package)
                            @php
                                $inCartQty = $this->getPackageQuantityInCart($key);
                            @endphp
                            <div @class([
                                'w-full flex flex-col p-5 rounded-2xl border-2 text-left transition duration-200',
                                'border-amber-400 bg-amber-50 ring-4 ring-amber-400/20 shadow-md' => $packageKey === $key,
                                'border-zinc-200 bg-white hover:border-amber-300' => $packageKey !== $key,
                            ])>
                                <div wire:click="selectPackage('{{ $key }}')" class="w-full flex items-center justify-between cursor-pointer select-none">
                                    <div class="flex items-center gap-4">
                                        @if ($packageKey === $key)
                                            <span class="flex size-8 items-center justify-center rounded-full bg-amber-400 text-white text-sm font-bold shrink-0">✓</span>
                                        @else
                                            <span class="flex size-8 items-center justify-center rounded-full border-2 border-zinc-300 shrink-0"></span>
                                        @endif
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                            <span class="font-bold text-zinc-950 text-base sm:text-lg">{{ $package['name'] }}</span>
                                            @if ($inCartQty > 0)
                                                <span class="inline-flex items-center rounded-md bg-amber-100 px-2 py-0.5 text-xs font-bold text-amber-800">
                                                    У замовленні: {{ $inCartQty }} шт
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="font-black text-amber-800 text-lg sm:text-xl whitespace-nowrap ml-4">
                                        {{ number_format($package['price'], 0, ',', ' ') }} грн
                                    </span>
                                </div>
                                
                                @if (!empty($package['components']))
                                    <div class="mt-3 pl-12 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5 text-xs text-zinc-500 font-semibold border-t border-zinc-100 pt-2.5 w-full">
                                        @foreach ($package['components'] as $pComp)
                                            <div class="flex items-center gap-2">
                                                <span class="text-amber-500 font-bold">✓</span>
                                                <span>{{ $pComp['name'] }}: {{ $pComp['qty'] }} {{ $pComp['unit'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-5 pl-12 pt-4 border-t border-dashed border-amber-300 flex flex-col sm:flex-row items-center gap-4 w-full">
                                    <div class="flex items-center gap-3 bg-white rounded-xl border border-zinc-200 p-1.5 shadow-2xs">
                                        <button type="button" wire:click="decrementQuantity('{{ $key }}')"
                                            class="flex size-9 cursor-pointer items-center justify-center rounded-lg hover:bg-zinc-100 text-zinc-700 font-black transition select-none text-lg"
                                            @if($this->getQuantity($key) <= 1) disabled @endif>−</button>
                                        <span class="w-10 text-center font-bold text-zinc-900 text-lg">{{ $this->getQuantity($key) }} шт</span>
                                        <button type="button" wire:click="incrementQuantity('{{ $key }}')"
                                            class="flex size-9 cursor-pointer items-center justify-center rounded-lg bg-amber-400 hover:bg-amber-300 text-black font-black transition select-none text-lg">+</button>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                                        <button wire:click="addPackage('{{ $key }}')" type="button"
                                            class="w-full sm:w-auto px-6 h-12 rounded-xl bg-[#b86f17] hover:bg-[#97580f] active:bg-[#7a460a] text-white font-black shadow-sm hover:shadow-md transition duration-200 cursor-pointer inline-flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                                            <span>➕</span> Додати до замовлення
                                        </button>

                                        <button wire:click="loadPackageIntoConstructor('{{ $key }}')" type="button"
                                            class="w-full sm:w-auto px-4 h-12 rounded-xl border border-zinc-300 bg-white hover:bg-zinc-50 active:bg-zinc-100 text-zinc-700 font-bold text-sm transition duration-200 cursor-pointer inline-flex items-center justify-center gap-2"
                                            title="Розкласти комплектацію на окремі деталі в конструкторі">
                                            <span>🔧</span> Розкласти на деталі
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                    <div class="rounded-2xl border border-zinc-200 bg-white p-4 sm:p-6 lg:p-8 shadow-xs">
                        <div class="mb-6 flex items-center justify-between gap-3 border-b border-zinc-100 pb-4">
                            <h3 class="text-xl font-bold text-zinc-950 flex items-center gap-3">
                                <span>🔧</span> Конструктор деталей
                            </h3>
                        </div>

                        <p class="text-sm text-zinc-600 mb-6 leading-relaxed">
                            Змінюйте кількість кожної деталі кнопками <span class="font-bold text-amber-600">+</span> та <span class="font-bold text-amber-600">−</span>
                        </p>

                        <!-- Frame Size Specific Components -->
                        <div class="mb-8">
                            <h4 class="mb-4 text-xs font-bold text-zinc-500 uppercase tracking-widest border-b border-zinc-100 pb-2">
                                Деталі для {{ $frameSize }}-рамкового вулика
                            </h4>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($this->components() as $key => $component)
                                    @if ($component['group'] !== 'інше')
                                        <div @class([
                                            'flex items-center justify-between gap-3 rounded-xl border-2 p-3 transition duration-200',
                                            'border-amber-400 bg-amber-50/10' => $this->getItemQuantity($key) > 0,
                                            'border-zinc-100 bg-zinc-50/60' => $this->getItemQuantity($key) == 0,
                                        ])>
                                            <div class="min-w-0 flex-1">
                                                <h5 class="text-sm font-bold text-zinc-950 leading-tight break-words whitespace-normal">{{ $component['name'] }}</h5>
                                                <span class="text-xs font-black text-amber-700 block mt-1">{{ number_format($component['price'], 0, ',', ' ') }} грн</span>
                                            </div>
                                            <div class="flex items-center gap-1 shrink-0 bg-white rounded-lg border border-zinc-200 p-0.5">
                                                <button type="button" wire:click="decrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-md hover:bg-zinc-100 text-zinc-700 font-bold transition select-none">−</button>
                                                <input type="number" min="0" max="999" value="{{ $this->getItemQuantity($key) }}"
                                                    wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                    class="h-8 w-10 text-center font-bold bg-transparent text-sm focus:outline-none focus:ring-0 border-0 p-0">
                                                <button type="button" wire:click="incrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-md bg-amber-400 hover:bg-amber-300 text-black font-bold transition select-none">+</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- General & Other Components -->
                        <div>
                            <h4 class="mb-4 text-xs font-bold text-zinc-500 uppercase tracking-widest border-b border-zinc-100 pb-2">
                                Додаткові комплектуючі
                            </h4>
                            <div class="grid gap-3 sm:grid-cols-2">
                                @foreach ($this->components() as $key => $component)
                                    @if ($component['group'] === 'інше')
                                        <div @class([
                                            'flex items-center justify-between gap-3 rounded-xl border-2 p-3 transition duration-200',
                                            'border-amber-400 bg-amber-50/10' => $this->getItemQuantity($key) > 0,
                                            'border-zinc-100 bg-zinc-50/60' => $this->getItemQuantity($key) == 0,
                                        ])>
                                            <div class="min-w-0 flex-1">
                                                <h5 class="text-sm font-bold text-zinc-950 leading-tight break-words whitespace-normal">{{ $component['name'] }}</h5>
                                                <span class="text-xs font-black text-amber-700 block mt-1">{{ number_format($component['price'], 0, ',', ' ') }} грн</span>
                                            </div>
                                            <div class="flex items-center gap-1 shrink-0 bg-white rounded-lg border border-zinc-200 p-0.5">
                                                <button type="button" wire:click="decrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-md hover:bg-zinc-100 text-zinc-700 font-bold transition select-none">−</button>
                                                <input type="number" min="0" max="999" value="{{ $this->getItemQuantity($key) }}"
                                                    wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                    class="h-8 w-10 text-center font-bold bg-transparent text-sm focus:outline-none focus:ring-0 border-0 p-0">
                                                <button type="button" wire:click="incrementComponent('{{ $key }}')"
                                                    class="flex size-8 cursor-pointer items-center justify-center rounded-md bg-amber-400 hover:bg-amber-300 text-black font-bold transition select-none">+</button>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Права колонка: Липка вартість замовлення, упакування, знижки -->
            <!-- Права колонка: Липка вартість замовлення (компактна) -->
            <div class="mt-6 lg:mt-0 lg:col-span-5 xl:col-span-4 lg:sticky lg:top-6 lg:max-h-[calc(100vh-120px)] lg:overflow-y-auto lg:pr-3 lg:pl-1 lg:py-2">
                
                <!-- 💰 РОЗРАХУНОК ВАРТОСТІ ─── -->
                <div class="rounded-2xl border-2 border-amber-300 bg-white p-4 sm:p-5 shadow-md space-y-4">
                    <div class="flex items-center justify-between border-b border-zinc-100 pb-3">
                        <h3 class="text-lg font-black text-zinc-950 flex items-center gap-2">
                            <span class="text-xl">💰</span>
                            Вартість замовлення
                        </h3>
                    </div>

                    <!-- Items list -->
                    @if (!empty($items))
                        <div class="rounded-xl bg-zinc-50 border border-zinc-100 p-3 space-y-3 max-h-48 overflow-y-auto scrollbar-thin">
                            @foreach ($items as $index => $item)
                                <div wire:key="summary-item-{{ $index }}" class="flex flex-col gap-1.5 border-b border-zinc-200 pb-2.5 last:border-0 last:pb-0">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="min-w-0">
                                            <span class="font-bold text-zinc-800 text-xs sm:text-sm leading-tight block">{{ $item['name'] }}</span>
                                        </div>
                                        <button wire:click="removeItem({{ $index }})" type="button"
                                            class="text-zinc-400 hover:text-red-600 transition text-base leading-none p-0.5 cursor-pointer"
                                            title="Видалити">×</button>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <!-- Керування кількістю -->
                                        <div class="flex items-center gap-0.5 bg-white rounded-lg border border-zinc-200 p-0.5 shadow-2xs">
                                            <button type="button" wire:click="decrementItem({{ $index }})"
                                                class="flex size-5 cursor-pointer items-center justify-center rounded-md hover:bg-zinc-100 text-zinc-700 font-bold transition select-none text-[10px]">−</button>
                                            <span class="w-5 text-center font-bold text-zinc-900 text-[10px]">{{ $item['quantity'] }}</span>
                                            <button type="button" wire:click="incrementItem({{ $index }})"
                                                class="flex size-5 cursor-pointer items-center justify-center rounded-md bg-amber-400 hover:bg-amber-300 text-black font-bold transition select-none text-[10px]">+</button>
                                        </div>
                                        <span class="font-black text-zinc-950 whitespace-nowrap text-xs sm:text-sm">
                                            {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} грн
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pt-1.5 border-t border-zinc-200 flex justify-between items-center">
                                <button wire:click="clear" type="button"
                                    class="text-[11px] font-bold text-zinc-500 hover:text-zinc-800 transition cursor-pointer">
                                    🗑️ Очистити кошик
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl bg-zinc-50 border border-zinc-100 p-5 text-center text-zinc-400 font-bold text-xs sm:text-sm">
                            🛒 Ваше замовлення порожнє.<br>Оберіть комплектацію ліворуч!
                        </div>
                    @endif

                    <!-- Packaging selector directly inside total card -->
                    @if (!empty($items))
                        <div class="border-t border-zinc-100 pt-3">
                            <label class="flex items-start gap-3 cursor-pointer select-none">
                                <input wire:model.live="includePackaging" type="checkbox"
                                    class="size-5 rounded border-2 border-zinc-300 text-amber-500 focus:ring-amber-400 cursor-pointer mt-0.5">
                                <span class="text-xs sm:text-sm font-bold text-zinc-700 leading-tight">
                                    📦 Додати упакування вуликів
                                    <span class="block text-[11px] font-semibold text-zinc-400 mt-0.5">70 грн за кожен вулик</span>
                                </span>
                            </label>
                        </div>
                    @endif

                    <!-- Prices breakdown -->
                    <div class="space-y-2 border-t border-zinc-100 pt-3">
                        <div class="flex justify-between text-xs sm:text-sm text-zinc-500 font-semibold">
                            <span>Сума:</span>
                            <span class="font-bold text-zinc-800">{{ number_format($pvSubtotal, 0, ',', ' ') }} грн</span>
                        </div>
                        
                        @if ($pvDiscountRate > 0)
                            <div class="flex justify-between text-xs sm:text-sm font-semibold text-green-700 bg-green-50 rounded-lg px-3 py-1.5 border border-green-200">
                                <span>🎁 Знижка {{ $pvDiscountRate }}%:</span>
                                <span class="font-bold">−{{ number_format($pvDiscountAmount, 0, ',', ' ') }} грн</span>
                            </div>
                        @endif

                        @if ($includePackaging && $pvPackaging > 0)
                            <div class="flex justify-between text-xs sm:text-sm text-zinc-500 font-semibold">
                                <span>📦 Упакування:</span>
                                <span class="font-bold text-zinc-800">{{ number_format($pvPackaging, 0, ',', ' ') }} грн</span>
                            </div>
                        @endif

                        <!-- Compact Grand Total -->
                        <div class="mt-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 p-3 sm:p-4 text-zinc-950 flex justify-between items-center gap-2 shadow-xs">
                            <span class="text-xs font-bold uppercase tracking-wider opacity-90">Разом до сплати:</span>
                            <span class="text-xl sm:text-2xl font-black whitespace-nowrap">{{ number_format($pvTotal, 0, ',', ' ') }} грн</span>
                        </div>
                    </div>

                    <!-- Discount tiers info (compact) -->
                    @if ($pvDiscountRate === 0 && $pvSubtotal > 0)
                        <p class="text-xs text-zinc-500 text-center font-medium">
                            💡 Додайте ще {{ number_format(30000 - $pvSubtotal, 0, ',', ' ') }} грн для знижки 5%
                        </p>
                    @endif

                    <!-- Compact Submit Button -->
                    <div>
                        <button wire:click="sendCalculation" wire:loading.attr="disabled" type="button"
                            class="w-full h-12 sm:h-14 rounded-xl bg-amber-400 hover:bg-amber-300 active:bg-amber-500 text-zinc-950 font-black shadow-md hover:shadow-lg transition duration-200 cursor-pointer inline-flex items-center justify-center gap-2 text-sm sm:text-base uppercase tracking-wider disabled:opacity-60 disabled:cursor-not-allowed"
                            @if(empty($items)) disabled @endif>
                            <span wire:loading.remove wire:target="sendCalculation">📨 Замовити</span>
                            <span wire:loading wire:target="sendCalculation" class="inline-block animate-spin text-xl">⏳</span>
                            <span wire:loading wire:target="sendCalculation" class="text-sm">Надсилаємо...</span>
                        </button>
                    </div>

                    <!-- Compact Discount Info at bottom of card -->
                    <div class="border-t border-zinc-100 pt-3 text-center text-[10px] sm:text-xs text-zinc-400 leading-relaxed font-semibold">
                        🎁 <b>Автоматичні знижки:</b> від 30т — 5% | 50т — 6% | 70т — 7% | 90т — 8% | 120т — 10%
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
