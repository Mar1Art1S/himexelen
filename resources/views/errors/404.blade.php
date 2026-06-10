<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => 'Сторінку не знайдено (404)'])
        <meta name="description" content="Помилка 404 - сторінку не знайдено. Мабуть, бджоли залетіли не в той вулик!">
        <style>
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-15px); }
            }
            .animate-float {
                animation: float 5s ease-in-out infinite;
            }
        </style>
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

        <!-- HEADER -->
        <header class="sticky top-0 z-50 border-b border-[#e3d7b6] bg-[#fbf8ef]/90 backdrop-blur">
            <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Логотип Хімекселен" class="h-10 w-auto object-contain">
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-[#766748]">Вулики з ППУ</span>
                    </span>
                </a>

                <div class="hidden items-center gap-6 md:flex">
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
                            <a href="{{ $item['href'] }}" class="text-sm font-medium transition hover:text-[#b86f17] text-[#6d6045]">{{ $item['name'] }}</a>
                        @endif
                    @endforeach
                </div>

                <div class="hidden items-center gap-3 md:flex">
                    <button onclick="Livewire.dispatch('openCallbackForm')" type="button"  class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white" cursor-pointer>Подзвонити</button>
                    
                </div>

                <details class="relative md:hidden">
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
                                    <a href="{{ $item['href'] }}" class="rounded-md px-3 py-2 text-base font-medium text-[#5d5035] hover:bg-[#f3ead3] transition">{{ $item['name'] }}</a>
                                @endif
                            @endforeach
                            <hr class="border-[#e3d7b6]">
                            <button onclick="Livewire.dispatch('openCallbackForm')" type="button"  class="flex justify-center rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white" cursor-pointer>Подзвонити</button>
                            
                        </div>
                    </div>
                </details>
            </nav>
        </header>

        <!-- MAIN CONTENT (404) -->
        <main class="flex min-h-[calc(100vh-16rem)] items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl text-center">
                <!-- 404 Illustration with floating animation -->
                <div class="relative mx-auto mb-8 flex justify-center max-w-sm sm:max-w-md">
                    <!-- Subtle Honey Radial Glow -->
                    <div class="absolute inset-0 -z-10 bg-radial from-[#ffd27d]/40 via-transparent to-transparent blur-2xl"></div>
                    <img src="{{ asset('images/beehive_404.png') }}" alt="Вулик 404" class="h-64 w-auto object-contain drop-shadow-2xl animate-float">
                </div>

                <!-- 404 Badge -->
                <span class="inline-flex items-center rounded-full bg-[#fceec7] px-3 py-1 text-sm font-semibold text-[#a15f0f] ring-1 ring-inset ring-[#edd593]/50">Помилка 404</span>
                <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-[#2f2718] sm:text-4xl">Схоже, бджоли залетіли не в той вулик!</h1>
                <p class="mt-4 text-base text-[#6d6045] leading-relaxed max-w-lg mx-auto">
                    Сторінка, яку ви шукаєте, не існує або була перенесена. Можливо, солодкий мед привів вас не туди!
                </p>

                <!-- Action Buttons -->
                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-lg bg-[#b86f17] px-6 py-3 text-base font-semibold text-white shadow-md transition duration-200 hover:bg-[#97580f] hover:shadow-lg">
                        На головну сторінку
                    </a>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center rounded-lg border-2 border-[#b86f17]/20 bg-white px-6 py-3 text-base font-semibold text-[#b86f17] shadow-sm transition duration-200 hover:bg-[#fbf8ef] hover:border-[#b86f17]/40">
                        Переглянути каталог
                    </a>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        @include('partials.footer')
        <livewire:contact-form />

                <livewire:callback-form />
        @fluxScripts
    </body>
</html>
