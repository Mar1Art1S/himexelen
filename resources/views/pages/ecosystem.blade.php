<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => 'Екосистема брендів'])
        <meta name="description" content="Спеціалізовані retail та галузеві проекти компанії Хімпостачальник для окремих напрямків продукції та промислових рішень.">
    </head>
    <body class="bg-[#fbf8ef] text-[#2f2718] antialiased">
        @include('partials.noscript')
        @php
            $navigation = [
                ['name' => 'Головна', 'href' => route('home')],
                ['name' => 'Продукція та ціни', 'href' => route('catalog')],
                ['name' => 'Відеоматеріали', 'href' => route('video')],
                ['name' => 'Калькулятор', 'href' => route('calculator')],
                ['name' => 'Екосистема', 'href' => route('ecosystem')],
                [
                    'name' => 'Підтримка',
                    'children' => [
                        ['name' => 'Доставка та оплата', 'href' => route('delivery-payment')],
                        ['name' => 'Гарантія', 'href' => route('warranty')],
                        ['name' => 'Конфіденційність', 'href' => route('privacy')],
                        ['name' => 'Терміни', 'href' => route('terms')],
                    ]
                ],
                ['name' => 'Контакти', 'href' => route('home').'#contacts'],
            ];
        @endphp

        <header class="sticky top-0 z-50 border-b border-[#e3d7b6] bg-[#fbf8ef]/90 backdrop-blur">
            <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3" id="nav-logo-link">
                    <img src="{{ asset('images/Logo.png') }}" alt="Логотип Хімекселен" class="h-10 w-auto object-contain">
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-[#766748]">Вулики з ППУ</span>
                    </span>
                </a>

                <div class="hidden items-center gap-6 md:flex" id="desktop-nav-menu">
                    @foreach ($navigation as $item)
                        @if (isset($item['children']))
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium transition hover:text-[#b86f17] focus:outline-hidden cursor-pointer text-[#6d6045]">
                                    <span>{{ $item['name'] }}</span>
                                    <svg class="size-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100" 
                                     x-transition:enter-start="opacity-0 scale-95" 
                                     x-transition:enter-end="opacity-100 scale-100" 
                                     x-transition:leave="transition ease-in duration-75" 
                                     x-transition:leave-start="opacity-100 scale-100" 
                                     x-transition:leave-end="opacity-0 scale-95" 
                                     class="absolute left-0 mt-2 w-56 origin-top-left rounded-lg border border-[#e3d7b6] bg-[#fffdf8] p-1 shadow-lg ring-1 ring-black/5 z-50 focus:outline-hidden"
                                     style="display: none;">
                                    @foreach ($item['children'] as $child)
                                        <a href="{{ $child['href'] }}" class="block rounded-md px-3 py-2 text-sm text-[#5d5035] hover:bg-[#f3ead3] hover:text-[#b86f17] transition">{{ $child['name'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $item['href'] }}" @class([
                                'text-sm font-medium transition hover:text-[#b86f17]',
                                'text-[#b86f17] font-semibold' => request()->routeIs('ecosystem') && $item['name'] === 'Екосистема',
                                'text-[#6d6045]' => !(request()->routeIs('ecosystem') && $item['name'] === 'Екосистема')
                            ])>{{ $item['name'] }}</a>
                        @endif
                    @endforeach
                </div>

                <div class="hidden items-center gap-3 md:flex" id="desktop-nav-actions">
                    <button onclick="Livewire.dispatch('openCallbackForm')" type="button"  class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white" id="nav-call-btn" cursor-pointer>Подзвонити</button>
                    
                </div>

                <details class="relative md:hidden" id="mobile-nav-details">
                    <summary class="flex size-10 cursor-pointer list-none items-center justify-center rounded-lg border border-[#d6c59c] text-[#2f2718] [&::-webkit-details-marker]:hidden">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span class="sr-only">Відкрити меню</span>
                    </summary>
                    <div class="absolute right-0 mt-3 w-72 rounded-lg border border-[#e3d7b6] bg-[#fffdf8] p-4 shadow-xl">
                        <div class="grid gap-3">
                            @foreach ($navigation as $item)
                                @if (isset($item['children']))
                                    <details class="group">
                                        <summary class="flex items-center justify-between rounded-md px-3 py-2 text-base font-medium text-[#5d5035] hover:bg-[#f3ead3] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                                            <span>{{ $item['name'] }}</span>
                                            <svg class="size-4 transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </summary>
                                        <div class="mt-1 pl-4 grid gap-2">
                                            @foreach ($item['children'] as $child)
                                                <a href="{{ $child['href'] }}" class="rounded-md px-3 py-1.5 text-sm font-medium text-[#6d6045] hover:bg-[#f3ead3]">{{ $child['name'] }}</a>
                                            @endforeach
                                        </div>
                                    </details>
                                @else
                                    <a href="{{ $item['href'] }}" class="rounded-md px-3 py-2 text-base font-medium text-[#5d5035] hover:bg-[#f3ead3]">{{ $item['name'] }}</a>
                                @endif
                            @endforeach
                            <button onclick="Livewire.dispatch('openCallbackForm')" type="button"  class="mt-2 rounded-lg border border-[#cdbb8c] px-4 py-3 text-center font-semibold text-[#2f2718] transition hover:bg-white" cursor-pointer>Замовити дзвінок</button>
                            
                        </div>
                    </div>
                </details>
            </nav>
        </header>

        <main>
            <!-- Brand Ecosystem Section (Main Body) -->
            <section class="bg-white py-20 lg:py-28 border-b border-[#e3d7b6]" id="brand-ecosystem">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Екосистема брендів</span>
                        <h1 class="font-serif text-4xl font-bold text-[#2f2718] sm:text-5xl mt-3" id="page-title">Галузеві проекти компанії <a href="https://himpost.com/" target="_blank" rel="noopener" class="text-[#b86f17] underline decoration-2 decoration-[#b86f17]/40 hover:decoration-[#b86f17] transition-all duration-200">Хімпостачальник</a></h1>
                        <p class="text-[#6d6045] mt-6 text-lg leading-8">
                            Спеціалізовані retail та галузеві проекти компанії Хімпостачальник для окремих напрямків продукції та промислових рішень.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Card 1: TechPolymer Market -->
                        <div class="flex flex-col justify-between rounded-3xl border border-[#e2d4ad] bg-[#fffdfa] p-8 shadow-xs hover:shadow-md transition duration-300 transform hover:-translate-y-1" id="brand-card-techpolymer">
                            <div>
                                <span class="inline-flex items-center rounded-full bg-[#fcf8ec] px-3 py-1 text-xs font-semibold text-[#b86f17] border border-[#e3d7b6]">
                                    ⚙️ Технічні полімери та промислові матеріали
                                </span>
                                <h3 class="font-serif text-3xl font-bold text-[#2f2718] mt-6 mb-4">ТехПолімер Маркет</h3>
                                <p class="text-[#6d6045] leading-relaxed text-sm mb-6">
                                    Спеціалізований retail та B2B-проект для технічних полімерів, компаундів та промислових матеріалів для підприємств і виробництв.
                                </p>
                                <ul class="space-y-3 mb-8 text-sm">
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Прямі поставки полімерної сировини, епоксидних та поліуретанових компаундів.</span>
                                    </li>
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Індивідуальні рішення для меблевих виробництв, будівництва та автопрому.</span>
                                    </li>
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Сертифікація відповідно до європейських стандартів якості.</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-auto">
                                <a href="https://techpolymer.com.ua" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center gap-2 rounded-xl border-2 border-[#b86f17] px-6 py-3 font-bold text-[#b86f17] hover:bg-[#b86f17] hover:text-white transition duration-200 cursor-pointer" id="techpolymer-catalog-btn">
                                    Перейти до каталогу →
                                </a>
                            </div>
                        </div>

                        <!-- Card 2: Himexelen -->
                        <div class="flex flex-col justify-between rounded-3xl border border-[#e2d4ad] bg-[#fffdfa] p-8 shadow-xs hover:shadow-md transition duration-300 transform hover:-translate-y-1" id="brand-card-himexelen">
                            <div>
                                <span class="inline-flex items-center rounded-full bg-[#fcf8ec] px-3 py-1 text-xs font-semibold text-[#b86f17] border border-[#e3d7b6]">
                                    🐝 Товари для бджільництва
                                </span>
                                <h3 class="font-serif text-3xl font-bold text-[#2f2718] mt-6 mb-4">Хімекселен</h3>
                                <p class="text-[#6d6045] leading-relaxed text-sm mb-6">
                                    Спеціалізований retail-проект для пасічників та господарств. Продукція для догляду за пасіками, обладнання та супутні товари.
                                </p>
                                <ul class="space-y-3 mb-8 text-sm">
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Сучасні полімерні вулики, годівниці та засоби догляду за пасіками.</span>
                                    </li>
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Безпечні полімери харчового класу для виготовлення інвентарю.</span>
                                    </li>
                                    <li class="flex gap-3 items-start">
                                        <span class="mt-1 flex size-5 shrink-0 items-center justify-center rounded-full bg-[#b86f17] text-white">
                                            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                                        </span>
                                        <span class="text-[#5d5035]">Консультації та індивідуальні рішення для великих пасічних ферм.</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('catalog') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3 font-bold text-white shadow-xs hover:bg-[#97580f] transition duration-200 cursor-pointer" id="himexelen-catalog-btn">
                                    Перейти до каталогу →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Bottom CTA Section -->
            <section class="py-16 sm:py-24 bg-white">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
                    <h2 class="font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl">Готові зібрати свій перший вулик?</h2>
                    <p class="text-[#6d6045] mt-4 max-w-2xl mx-auto">
                        Спробуйте наш живий конструктор комплектації пасіки та розрахуйте вартість прямо зараз з автоматичними оптовими знижками.
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="{{ route('calculator') }}" class="rounded-xl bg-[#b86f17] px-6 py-3 font-bold text-white shadow-xs hover:bg-[#97580f] transition cursor-pointer" id="cta-calculator-btn">Перейти до калькулятора</a>
                        <button onclick="Livewire.dispatch('openCallbackForm')" type="button" class="rounded-xl border border-[#cdbb8c] px-6 py-3 font-bold text-[#2f2718] hover:bg-[#fbf8ef] transition cursor-pointer" id="cta-order-btn">Замовити дзвінок</button>
                    </div>
                </div>
            </section>
        </main>

        @include('partials.footer')
                <livewire:callback-form />
        @fluxScripts
    </body>
</html>
