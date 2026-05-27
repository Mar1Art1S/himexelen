<div>
    <!-- Flux UI Modal -->
    <flux:modal wire:model="showModal" class="max-w-md w-full !bg-[#fffdf8] border border-[#e2d4ad] rounded-2xl shadow-2xl p-0 overflow-hidden">
        <div class="relative flex flex-col max-h-[95vh] md:max-h-[90vh]">
            <!-- Decorative top bar matching honey gold theme -->
            <div class="h-2 bg-gradient-to-r from-[#b86f17] via-[#d6a254] to-[#b86f17] shrink-0"></div>
            
            <div class="p-6 overflow-y-auto flex-1">

                @if ($isSubmitted)
                    <!-- Success State -->
                    <div class="flex flex-col items-center text-center py-8 px-4 animate-fade-in">
                        <div class="flex size-16 items-center justify-center rounded-full bg-[#f3ead3] text-[#b86f17] mb-6 shadow-xs">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718] mb-3">
                            Замовлення прийнято!
                        </h3>
                        
                        <p class="text-sm text-[#6d6045] leading-relaxed mb-8 max-w-xs">
                            Дякуємо, <strong>{{ $name }}</strong>! Ми отримали ваше замовлення на обрані товари (всього <strong>{{ collect($cartItems)->sum('quantity') }} шт.</strong>) і зв'яжемося з вами за телефоном <strong>{{ $phone }}</strong> найближчим часом для узгодження всіх деталей.
                        </p>

                        <button wire:click="closeForm" type="button" class="w-full inline-flex justify-center rounded-lg bg-[#b86f17] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] cursor-pointer">
                            Зрозуміло
                        </button>
                    </div>
                @else
                    <!-- Form State -->
                    <div class="mb-6">
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#b86f17]">Швидке замовлення</span>
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718] mt-1">
                            Зворотний зв'язок
                        </h3>
                        <p class="text-xs text-[#766748] mt-1">
                            Заповніть форму, і наш менеджер зателефонує вам найближчим часом для узгодження деталей.
                        </p>
                    </div>

                    <!-- Discount Info Callout Banner -->
                    <div class="mb-5 rounded-xl border border-amber-200 bg-[#fffbeb] p-4 text-xs">
                        <div class="font-black text-[#b86f17] flex items-center gap-1.5 mb-1.5 uppercase tracking-wide">
                            <span>⚠️ Увага!!! Знижки при купівлі від:</span>
                        </div>
                        <ul class="grid grid-cols-2 gap-x-4 gap-y-1 font-bold text-[#5d5035]">
                            <li>• від 30 000 грн — <span class="text-[#b86f17]">5%</span></li>
                            <li>• від 50 000 грн — <span class="text-[#b86f17]">6%</span></li>
                            <li>• від 70 000 грн — <span class="text-[#b86f17]">7%</span></li>
                            <li>• від 90 000 грн — <span class="text-[#b86f17]">8%</span></li>
                            <li class="col-span-2">• від 120 000 грн — <span class="text-[#b86f17]">10%</span></li>
                        </ul>
                    </div>

                    <form wire:submit.prevent="submitOrder" class="space-y-4">
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

                        <!-- Email Field -->
                        <flux:field>
                            <flux:label class="text-[#2f2718] font-medium text-sm">Електронна пошта <span class="text-[#766748] text-xs font-normal">(опціонально)</span></flux:label>
                            <flux:input wire:model.blur="email" type="email" placeholder="example@gmail.com" class="!bg-white border-[#e3d7b6] focus:border-[#b86f17] focus:ring-1 focus:ring-[#b86f17] text-sm rounded-lg" />
                            <flux:error name="email" class="text-xs mt-1 text-red-600" />
                        </flux:field>

                        <!-- Product Selection & Quantity -->
                        <div class="grid grid-cols-3 gap-3 items-end">
                            <div class="col-span-2">
                                <flux:field>
                                    <flux:label class="text-[#2f2718] font-medium text-sm">Оберіть товар / деталь</flux:label>
                                    <flux:select wire:model="product" class="!bg-white border-[#e3d7b6] text-sm rounded-lg">
                                        @foreach ($categories as $catItem)
                                            @if ($catItem->complectations->isNotEmpty())
                                                @php
                                                    $prefix = '';
                                                    if (str_contains($catItem->slug, '8-frames')) {
                                                        $prefix = '8 рамок, ';
                                                    } elseif (str_contains($catItem->slug, '10-frames')) {
                                                        $prefix = '10 рамок, ';
                                                    } elseif (str_contains($catItem->slug, '12-frames')) {
                                                        $prefix = '12 рамок, ';
                                                    }
                                                @endphp
                                                <flux:select.option value="" disabled class="font-bold text-[#b86f17] pt-2">--- {{ mb_strtoupper($catItem->name) }} ---</flux:select.option>
                                                @if (str_contains($catItem->slug, '8-frames'))
                                                    <flux:select.option value="Вулик на 8 рамок">Вулик на 8 рамок (Базовий)</flux:select.option>
                                                @elseif (str_contains($catItem->slug, '10-frames'))
                                                    <flux:select.option value="Вулик на 10 рамок">Вулик на 10 рамок (Базовий)</flux:select.option>
                                                @elseif (str_contains($catItem->slug, '12-frames'))
                                                    <flux:select.option value="Вулик на 12 рамок">Вулик на 12 рамок (Базовий)</flux:select.option>
                                                @endif
                                                @foreach ($catItem->complectations as $complectation)
                                                    <flux:select.option value="{{ $prefix }}{{ $complectation->name }}">{{ $prefix }}{{ $complectation->name }}</flux:select.option>
                                                @endforeach
                                            @endif
                                        @endforeach

                                        <!-- Комплектуючі -->
                                        @if ($groupedComponents->isNotEmpty())
                                            <flux:select.option value="" disabled class="font-bold text-[#b86f17] pt-2">--- ОКРЕМІ ДЕТАЛІ ---</flux:select.option>
                                            @foreach ($groupedComponents as $groupName => $group)
                                                @foreach ($group as $compItem)
                                                    <flux:select.option value="{{ $compItem->name }}">{{ $compItem->name }}</flux:select.option>
                                                @endforeach
                                            @endforeach
                                        @endif
                                        <flux:select.option value="інше">Інша комплектація / Інше</flux:select.option>
                                    </flux:select>
                                    <flux:error name="product" class="text-xs mt-1 text-red-600" />
                                </flux:field>
                            </div>
                            <div>
                                <flux:field>
                                    <flux:label class="text-[#2f2718] font-medium text-sm">Кількість <span class="text-red-500">*</span></flux:label>
                                    <flux:input wire:model.blur="quantity" type="number" min="1" max="1000" class="!bg-white border-[#e3d7b6] focus:border-[#b86f17] focus:ring-1 focus:ring-[#b86f17] text-sm rounded-lg" />
                                    <flux:error name="quantity" class="text-xs mt-1 text-red-600" />
                                </flux:field>
                            </div>
                        </div>

                        <!-- Button to add current item to list -->
                        <div class="flex justify-end pt-1">
                            <button wire:click="addCurrentProductToList" type="button" class="inline-flex items-center gap-1.5 rounded-lg border border-[#cdbb8c] bg-white px-3.5 py-2 text-xs font-bold text-[#b86f17] transition hover:bg-[#fbf8ef] hover:border-[#b86f17]/40 cursor-pointer">
                                ➕ Додати до списку замовлення
                            </button>
                        </div>

                        <!-- Selected Products List (Calculator/Cart style) -->
                        <div class="mt-4 p-4 rounded-xl border border-[#e3d7b6] bg-[#fffdf8] space-y-3">
                            <div class="flex items-center justify-between border-b border-[#e3d7b6] pb-2">
                                <span class="text-xs font-bold text-[#766748] uppercase tracking-wider">Список товарів у замовленні:</span>
                                <span class="text-xs font-bold text-[#b86f17] bg-[#f3ead3] px-2 py-0.5 rounded-md">
                                    Всього: {{ empty($cartItems) ? $quantity : collect($cartItems)->sum('quantity') }} шт.
                                </span>
                            </div>

                            @if (empty($cartItems))
                                <div class="flex items-center justify-between gap-3 text-sm bg-white p-3 rounded-lg border border-[#e3d7b6]/60 shadow-2xs">
                                    <div class="flex-1 font-medium text-[#2f2718] leading-tight text-xs">
                                        {{ $product === 'інше' ? 'Інша комплектація / Інше' : $product }}
                                    </div>
                                    <div class="shrink-0 font-bold text-xs text-[#b86f17] bg-[#fffdf8] border border-[#e3d7b6]/40 px-2 py-1 rounded-md">
                                        {{ $quantity }} шт.
                                    </div>
                                </div>
                            @else
                                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                    @foreach ($cartItems as $index => $item)
                                        <div class="flex items-center justify-between gap-3 text-sm bg-white p-2 rounded-lg border border-[#e3d7b6]/60 shadow-2xs">
                                            <div class="flex-1 font-medium text-[#2f2718] leading-tight text-xs">
                                                {{ $item['name'] }}
                                            </div>
                                            <div class="flex items-center gap-2 shrink-0">
                                                <button wire:click="decrementCartItem({{ $index }})" type="button" class="flex size-6 items-center justify-center rounded-md bg-[#f3ead3] text-[#b86f17] hover:bg-[#e9dbb7] font-black cursor-pointer text-xs focus:outline-hidden">
                                                    -
                                                </button>
                                                <span class="font-bold text-xs text-[#2f2718] min-w-4 text-center">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button wire:click="incrementCartItem({{ $index }})" type="button" class="flex size-6 items-center justify-center rounded-md bg-[#f3ead3] text-[#b86f17] hover:bg-[#e9dbb7] font-black cursor-pointer text-xs focus:outline-hidden">
                                                    +
                                                </button>
                                                <button wire:click="removeCartItem({{ $index }})" type="button" class="flex size-6 items-center justify-center rounded-md bg-red-50 text-red-600 hover:bg-red-100 cursor-pointer text-xs focus:outline-hidden" title="Видалити">
                                                    ✕
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Summary Block -->
                            @php
                                $subtotal = $this->subtotal();
                                $discountRate = $this->discountRate();
                                $discountAmount = $this->discountAmount();
                                $total = $this->total();
                            @endphp

                            <div class="border-t border-[#e3d7b6] pt-3 mt-2 space-y-1.5 text-xs text-[#6d6045]">
                                @if ($discountRate > 0)
                                    <div class="flex justify-between">
                                        <span>Сума:</span>
                                        <span class="font-semibold text-[#2f2718]">{{ number_format($subtotal, 0, ',', ' ') }} грн</span>
                                    </div>
                                    <div class="flex justify-between text-green-700 font-medium">
                                        <span>Знижка ({{ $discountRate }}%):</span>
                                        <span>-{{ number_format($discountAmount, 0, ',', ' ') }} грн</span>
                                    </div>
                                @endif
                                <div class="flex justify-between items-center text-sm font-bold text-[#2f2718] pt-1">
                                    <span>Загальна сума замовлення:</span>
                                    <span class="text-[#b86f17] text-base font-extrabold">
                                        {{ number_format($total, 0, ',', ' ') }} грн
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Message Field -->
                        <flux:field>
                            <flux:label class="text-[#2f2718] font-medium text-sm">Коментар або деталі замовлення <span class="text-[#766748] text-xs font-normal">(опціонально)</span></flux:label>
                            <flux:textarea wire:model="message" rows="3" placeholder="Напишіть ваші побажання або запитання тут..." class="!bg-white border-[#e3d7b6] focus:border-[#b86f17] focus:ring-1 focus:ring-[#b86f17] text-sm rounded-lg resize-none" />
                            <flux:error name="message" class="text-xs mt-1 text-red-600" />
                        </flux:field>

                        <!-- Submit Button with Loading State -->
                        <div class="pt-2 flex items-center justify-end gap-3">
                            <button wire:click="closeForm" type="button" class="text-sm font-semibold text-[#766748] hover:text-[#2f2718] hover:bg-[#f3ead3] px-4 py-2 rounded-lg cursor-pointer transition focus:outline-hidden">
                                Скасувати
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="bg-[#b86f17] hover:bg-[#97580f] text-white font-semibold transition px-6 py-2.5 rounded-lg cursor-pointer flex items-center justify-center text-sm shadow-xs focus:outline-hidden">
                                <span wire:loading.remove wire:target="submitOrder">Надіслати замовлення</span>
                                <span wire:loading wire:target="submitOrder" class="flex items-center gap-2">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Відправка...
                                </span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </flux:modal>
</div>
