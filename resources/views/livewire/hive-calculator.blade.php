<section class="relative overflow-hidden bg-[#f7f6f3] py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="mb-3 flex items-center gap-3">
                    <div class="flex size-14 items-center justify-center rounded-2xl bg-yellow-400 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-7 text-black" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.121 14.121 19 19m-7-4a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-4xl font-black text-zinc-900">Калькулятор комплектації пасіки</h2>
                        <p class="mt-2 max-w-3xl leading-relaxed text-zinc-600">
                            Розрахуйте необхідну кількість вуликів, корпусів та комплектуючих для вашої пасіки.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-1 rounded-2xl border border-zinc-200 bg-white p-1 shadow-sm w-full sm:w-auto shrink-0">
                <button wire:click="setMode('beginner')" type="button" @class([
                    'rounded-xl py-3 px-4 font-semibold transition text-sm sm:text-base text-center cursor-pointer select-none',
                    'bg-yellow-400 text-black shadow-xs' => $mode === 'beginner',
                    'text-zinc-600 hover:text-black hover:bg-zinc-50' => $mode !== 'beginner',
                ])>
                    Готові комплекти
                </button>

                <button wire:click="setMode('expert')" type="button" @class([
                    'rounded-xl py-3 px-4 font-semibold transition text-sm sm:text-base text-center cursor-pointer select-none',
                    'bg-yellow-400 text-black shadow-xs' => $mode === 'expert',
                    'text-zinc-600 hover:text-black hover:bg-zinc-50' => $mode !== 'expert',
                ])>
                    Конструктор деталей
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">
            <aside class="space-y-6 xl:col-span-3">
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                    <div class="mb-5 flex size-20 items-center justify-center rounded-2xl bg-yellow-100 text-4xl">🐝
                    </div>
                    <h3 class="mb-3 text-2xl font-bold text-zinc-900">Простий та зрозумілий розрахунок</h3>
                    <p class="leading-relaxed text-zinc-600">
                        Заповніть параметри та отримайте готову комплектацію для вашої пасіки.
                    </p>
                </div>

                <div class="rounded-3xl border border-yellow-200 bg-[#fff8e8] p-6">
                    <div class="mb-5 flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-xl bg-yellow-400 text-xl">💡</div>
                        <h3 class="text-xl font-bold text-zinc-900">Поради</h3>
                    </div>

                    <ul class="space-y-4 text-zinc-700">
                        <li class="flex gap-3"><span class="mt-1 text-yellow-500">•</span><span>Оберіть тип вулика та
                                комплектацію</span></li>
                        <li class="flex gap-3"><span class="mt-1 text-yellow-500">•</span><span>Створіть свій вулик за
                                допомогою конструктора</span></li>
                        <li class="flex gap-3"><span class="mt-1 text-yellow-500">•</span><span>Знижка застосовується
                                автоматично</span></li>
                        <li class="flex gap-3"><span class="mt-1 text-yellow-500">•</span><span>Розрахунок можна
                                роздрукувати</span></li>
                    </ul>
                </div>
            </aside>

            <div class="space-y-6 xl:col-span-9">
                <div class="rounded-3xl border border-zinc-200 bg-white p-7 shadow-sm">
                    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-zinc-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div class="flex size-11 items-center justify-center rounded-xl bg-yellow-100 text-xl">👤</div>
                            <h3 class="text-2xl font-bold text-zinc-900">Ваші контакти</h3>
                        </div>
                        
                        <div class="rounded-xl border border-yellow-200 bg-[#fffbeb] px-4 py-2.5 text-xs font-semibold text-[#5d5035]">
                            <span class="text-yellow-600 font-bold">⚠️ Увага!!! Знижки при купівлі від:</span>
                            <span class="ml-2 font-bold">30 000 грн — 5% | 50 000 грн — 6% | 70 000 грн — 7% | 90 000 грн — 8% | 120 000 грн — 10%</span>
                        </div>
                    </div>

                    @if (session()->has('calculation_sent'))
                        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-700 flex items-start gap-3">
                            <span class="text-2xl leading-none">🎉</span>
                            <div>
                                <h4 class="font-bold">Розрахунок успішно надіслано!</h4>
                                <p class="text-sm mt-1">{{ session('calculation_sent') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-zinc-700">Ім'я *</label>
                            <input wire:model.blur="name" type="text" placeholder="Іван Петренко"
                                class="h-14 w-full rounded-2xl border border-zinc-300 bg-zinc-50 px-5 transition focus:border-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                            @error('name')
                                <span class="mt-2 block text-xs text-red-600 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-zinc-700">Email</label>
                            <input wire:model.blur="email" type="email" placeholder="ivan@gmail.com"
                                class="h-14 w-full rounded-2xl border border-zinc-300 bg-zinc-50 px-5 transition focus:border-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                            @error('email')
                                <span class="mt-2 block text-xs text-red-600 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-zinc-700">Телефон *</label>
                            <div class="relative">
                                <input wire:model.blur="phone" type="text" placeholder="+380 99 123 45 67"
                                    class="h-14 w-full rounded-2xl border border-zinc-300 bg-zinc-50 py-0 pl-16 pr-5 transition focus:border-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2">🇺🇦</div>
                            </div>
                            @error('phone')
                                <span class="mt-2 block text-xs text-red-600 font-semibold">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl border border-zinc-200 bg-white p-7 shadow-sm">
                    <div class="mb-6 flex items-center gap-3">
                        <div class="flex size-11 items-center justify-center rounded-xl bg-yellow-100 text-xl">⚙️</div>
                        <h3 class="text-2xl font-bold text-zinc-900">Параметри розрахунку</h3>
                    </div>

                    <!-- Тип вулика кнопками -->
                    <div class="mb-8">
                        <label class="mb-3 block text-sm font-semibold text-zinc-700">Тип вулика</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach ([
        '8' => ['title' => '8-рамковий', 'desc' => 'Найпопулярніший'],
        '10' => ['title' => '10-рамковий', 'desc' => 'Більше місця'],
        '12' => ['title' => '12-рамковий', 'desc' => 'Для сильних'],
    ] as $size => $item)
                                <label class="cursor-pointer">
                                    <input wire:model.live="frameSize" type="radio" value="{{ $size }}"
                                        class="peer hidden" {{ $frameSize == $size ? 'checked' : '' }}>
                                    <span @class([
                                        'inline-block rounded-2xl px-6 py-3 font-semibold transition select-none border-2 cursor-pointer',
                                        'bg-yellow-400 text-black border-yellow-400' =>
                                            $frameSize == $size,
                                        'border-zinc-300 bg-white text-zinc-700 hover:border-yellow-300' =>
                                            $frameSize != $size,
                                    ])>
                                        {{ $item['title'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Комплектація та кількість -->
                    <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_180px]">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-zinc-700">Комплектація</label>
                            <select wire:model.live="packageKey"
                                class="h-14 w-full rounded-2xl border border-zinc-300 bg-zinc-50 px-5 transition focus:border-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                                @foreach ($this->packages() as $key => $package)
                                    <option value="{{ $key }}">{{ $package['name'] }} -
                                        {{ number_format($package['price'], 0, ',', ' ') }} грн</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-zinc-700">Кількість</label>
                            <input wire:model.live="quantity" type="number" min="1" max="999"
                                class="h-14 w-full rounded-2xl border border-zinc-300 bg-zinc-50 px-5 transition focus:border-yellow-400 focus:outline-none focus:ring-4 focus:ring-yellow-300">
                            @error('quantity')
                                <span class="mt-2 block text-sm text-red-700">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Склад обраної комплектації -->
                    @php($selectedComponents = $this->selectedPackageComponents())
                    @if ($selectedComponents !== [])
                        <div class="mt-4 rounded-2xl border border-yellow-200 bg-[#fffbeb] p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <div class="flex size-8 items-center justify-center rounded-lg bg-yellow-400 text-sm">📦</div>
                                <h4 class="text-sm font-bold text-zinc-800">Що входить у {{ $this->selectedPackage()['name'] }}:</h4>
                            </div>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach ($selectedComponents as $comp)
                                    <div class="flex items-center gap-3 rounded-xl bg-white/80 px-4 py-2.5 border border-yellow-100">
                                        <span class="text-yellow-500">✓</span>
                                        <span class="text-sm font-medium text-zinc-800">{{ $comp['name'] }}</span>
                                        <span class="ml-auto text-sm font-bold text-zinc-500">{{ $comp['qty'] }} {{ $comp['unit'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-5 pt-4 border-t border-yellow-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <span class="text-xs text-zinc-600 font-medium">Бажаєте налаштувати склад або додати додаткові деталі?</span>
                                <button wire:click="loadPackageIntoConstructor" type="button" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-yellow-400 px-5 py-2.5 text-xs font-bold text-black shadow-xs hover:bg-yellow-300 transition cursor-pointer">
                                    🛠️ Налаштувати склад в конструкторі
                                </button>
                            </div>
                        </div>
                    @endif

                    @if ($mode === 'expert')
                        <div class="rounded-3xl border border-zinc-200 bg-white p-7 shadow-sm">
                            <div class="mb-6 flex items-center gap-3">
                                <div class="flex size-11 items-center justify-center rounded-xl bg-yellow-100 text-xl">
                                    🛠️</div>
                                <h3 class="text-2xl font-bold text-zinc-900">Конструктор деталей</h3>
                            </div>

                            <p class="mb-6 leading-relaxed text-zinc-600">
                                Оберіть необхідну кількість кожної деталі. Загальна сума замовлення та знижка будуть
                                розраховані автоматично в реальному часі.
                            </p>

                            <!-- Group 1: Specific to Frame Size -->
                            <div class="mb-8">
                                <h4 class="mb-4 text-lg font-bold text-zinc-800 border-b border-zinc-100 pb-2">Деталі
                                    для {{ $frameSize }}-рамкового вулика</h4>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    @foreach ($this->components() as $key => $component)
                                        @if ($component['group'] !== 'інше')
                                            <div
                                                class="flex items-center justify-between gap-4 rounded-2xl border border-zinc-200 bg-zinc-50 p-4 transition hover:border-yellow-300">
                                                <div class="pr-2">
                                                    <h5 class="text-sm font-bold text-zinc-900 sm:text-base">
                                                        {{ $component['name'] }}</h5>
                                                    <span
                                                        class="text-sm font-black text-[#b86f17]">{{ number_format($component['price'], 0, ',', ' ') }}
                                                        грн/шт</span>
                                                </div>
                                                <div class="flex items-center gap-2 shrink-0">
                                                    <button type="button"
                                                        wire:click="decrementComponent('{{ $key }}')"
                                                        class="flex size-9 items-center justify-center rounded-xl bg-white border border-zinc-300 hover:bg-zinc-100 text-zinc-800 font-bold transition shadow-sm">-</button>
                                                    <input type="number" min="0" max="999"
                                                        value="{{ $this->getItemQuantity($key) }}"
                                                        wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                        class="h-9 w-14 rounded-xl border border-zinc-300 text-center font-bold bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                                                    <button type="button"
                                                        wire:click="incrementComponent('{{ $key }}')"
                                                        class="flex size-9 items-center justify-center rounded-xl bg-yellow-400 hover:bg-yellow-500 text-black font-bold transition shadow-sm">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <!-- Group 2: Other Components -->
                            <div>
                                <h4 class="mb-4 text-lg font-bold text-zinc-800 border-b border-zinc-100 pb-2">Загальні
                                    та
                                    додаткові комплектуючі</h4>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    @foreach ($this->components() as $key => $component)
                                        @if ($component['group'] === 'інше')
                                            <div
                                                class="flex items-center justify-between gap-4 rounded-2xl border border-zinc-200 bg-zinc-50 p-4 transition hover:border-yellow-300">
                                                <div class="pr-2">
                                                    <h5 class="text-sm font-bold text-zinc-900 sm:text-base">
                                                        {{ $component['name'] }}</h5>
                                                    <span
                                                        class="text-sm font-black text-[#b86f17]">{{ number_format($component['price'], 0, ',', ' ') }}
                                                        грн/шт</span>
                                                </div>
                                                <div class="flex items-center gap-2 shrink-0">
                                                    <button type="button"
                                                        wire:click="decrementComponent('{{ $key }}')"
                                                        class="flex size-9 items-center justify-center rounded-xl bg-white border border-zinc-300 hover:bg-zinc-100 text-zinc-800 font-bold transition shadow-sm">-</button>
                                                    <input type="number" min="0" max="999"
                                                        value="{{ $this->getItemQuantity($key) }}"
                                                        wire:change="setComponentQuantity('{{ $key }}', $event.target.value)"
                                                        class="h-9 w-14 rounded-xl border border-zinc-300 text-center font-bold bg-white focus:outline-none focus:ring-2 focus:ring-yellow-400 text-sm">
                                                    <button type="button"
                                                        wire:click="incrementComponent('{{ $key }}')"
                                                        class="flex size-9 items-center justify-center rounded-xl bg-yellow-400 hover:bg-yellow-500 text-black font-bold transition shadow-sm">+</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($items !== [])
                        <div class="rounded-3xl border border-zinc-200 bg-white p-7 shadow-sm">
                            <div class="mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-2xl font-bold text-zinc-900">Додані позиції</h3>
                                <button wire:click="clear" type="button"
                                    class="rounded-2xl border border-zinc-300 bg-white px-5 py-3 font-semibold text-zinc-700 transition hover:border-zinc-400 cursor-pointer w-full sm:w-auto text-center">
                                    Очистити розрахунок
                                </button>
                            </div>

                            <div class="divide-y divide-zinc-200 overflow-hidden rounded-2xl border border-zinc-200">
                                @foreach ($items as $index => $item)
                                    <div wire:key="calculator-item-{{ $index }}"
                                        class="grid gap-4 bg-zinc-50 p-5 grid-cols-1 md:grid-cols-[1fr_110px_130px_48px] md:items-center">
                                        <div class="flex justify-between items-start gap-4">
                                            <div>
                                                <h4 class="font-bold text-zinc-900">{{ $item['name'] }}</h4>
                                                <p class="mt-1 text-sm leading-relaxed text-zinc-600">
                                                    {{ $item['description'] }}</p>
                                            </div>
                                            <!-- Delete button directly on the right in mobile header -->
                                            <button wire:click="removeItem({{ $index }})" type="button"
                                                class="flex md:hidden size-10 shrink-0 items-center justify-center rounded-xl border border-zinc-300 bg-white text-xl font-bold text-zinc-600 transition hover:border-red-300 hover:text-red-700 cursor-pointer"
                                                aria-label="Видалити позицію">×</button>
                                        </div>
                                        <div class="flex items-center justify-between md:justify-end gap-2 border-t border-zinc-200 md:border-t-0 pt-3 md:pt-0">
                                            <span class="text-zinc-500 md:hidden font-medium text-sm">Кількість:</span>
                                            <span class="font-semibold text-zinc-700 md:text-right">{{ $item['quantity'] }} шт</span>
                                        </div>
                                        <div class="flex items-center justify-between md:justify-end gap-2">
                                            <span class="text-zinc-500 md:hidden font-medium text-sm">Вартість:</span>
                                            <span class="text-lg font-black text-zinc-900 md:text-right">
                                                {{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} грн
                                            </span>
                                        </div>
                                        <!-- Desktop delete button -->
                                        <button wire:click="removeItem({{ $index }})" type="button"
                                            class="hidden md:flex size-12 items-center justify-center rounded-2xl border border-zinc-300 bg-white text-xl font-bold text-zinc-600 transition hover:border-red-300 hover:text-red-700 cursor-pointer"
                                            aria-label="Видалити позицію">×</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 my-8">
                        <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                            <div class="mb-2 text-zinc-500">Загальна сума</div>
                            <div class="text-4xl font-black text-zinc-900">
                                {{ number_format($this->subtotal(), 0, ',', ' ') }} грн</div>
                            <div class="mt-2 text-sm font-semibold text-zinc-500">Знижка {{ $this->discountRate() }}%:
                                {{ number_format($this->discountAmount(), 0, ',', ' ') }} грн</div>
                        </div>

                        <div class="rounded-3xl bg-gradient-to-r from-yellow-400 to-amber-400 p-6 shadow-lg">
                            <div class="mb-2 font-medium text-black/70">Разом до сплати</div>
                            <div class="text-4xl font-black text-black">
                                {{ number_format($this->total(), 0, ',', ' ') }}
                                грн</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button wire:click="clear" type="button"
                            class="h-14 flex-1 rounded-2xl border border-zinc-300 bg-white px-6 font-semibold text-zinc-700 transition hover:border-zinc-400 cursor-pointer text-center">
                            Очистити форму
                        </button>

                        <button wire:click="sendCalculation" wire:loading.attr="disabled" type="button"
                            class="h-14 flex-1 rounded-2xl bg-yellow-400 px-6 font-bold text-black shadow-lg transition hover:bg-yellow-300 cursor-pointer text-center inline-flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="sendCalculation">📨 Відправити розрахунок</span>
                            <span wire:loading wire:target="sendCalculation" class="inline-block animate-spin mr-2">⏳</span>
                            <span wire:loading wire:target="sendCalculation">Надсилаємо...</span>
                        </button>

                        @if ($mode === 'beginner')
                            <button wire:click="addItem" type="button"
                                class="h-14 flex-1 rounded-2xl bg-yellow-400 px-6 font-bold text-black shadow-lg transition hover:bg-yellow-300 cursor-pointer text-center">
                                Розрахувати
                            </button>
                        @endif
                    </div>

                    @if (session()->has('calculation_sent'))
                        <div class="mt-4 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-700 flex items-start gap-3">
                            <span class="text-2xl leading-none">🎉</span>
                            <div>
                                <h4 class="font-bold">Розрахунок успішно надіслано!</h4>
                                <p class="text-sm mt-1">{{ session('calculation_sent') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
                        @if ($mode === 'beginner')
                            ✓ Оберіть комплектацію та кількість і натисніть «Розрахувати»
                        @else
                            ✓ Регулюйте кількість деталей кнопками + та - (зміни відображаються миттєво)
                        @endif
                    </div>
                </div>
            </div>
        </div>
</section>
