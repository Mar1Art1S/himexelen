<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', ['title' => 'Каталог'])
    <meta name="description" content="Каталог продукції ТМ Хімекселен: вулики з ППУ на 8, 10 та 12 рамок, а також повний асортимент оригінальних комплектуючих.">
</head>

<body class="bg-[#fbf8ef] text-[#2f2718] antialiased" x-data="{ activeTab: (new URLSearchParams(window.location.search)).get('tab') || 'all' }">
    @php
        $navigation = [
            ['name' => 'Головна', 'href' => route('home')],
            ['name' => 'Каталог', 'href' => route('catalog')],
            ['name' => 'Відеоматеріали', 'href' => route('video')],
            ['name' => 'Калькулятор', 'href' => route('calculator')],
            ['name' => 'Екосистема', 'href' => route('ecosystem')],
            ['name' => 'Контакти', 'href' => route('home') . '#contacts'],
        ];

        // Retrieve catalog data from the calculator catalog logic
        try {
            $reflection = new ReflectionClass(\App\Livewire\HiveCalculator::class);
            $loadCsvData = $reflection->getMethod('loadCsvData');
            $loadCsvData->setAccessible(true);
            $data = $loadCsvData->invoke(null);
            
            $hivesCatalog = $data['catalog'] ?? [];
            $rawComponents = $data['components'] ?? [];
        } catch (\Exception $e) {
            $hivesCatalog = [];
            $rawComponents = [];
        }
    @endphp

    <header class="sticky top-0 z-50 border-b border-[#e3d7b6] bg-[#fbf8ef]/90 backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="flex size-10 items-center justify-center rounded-lg bg-[#b86f17] text-white">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                        aria-hidden="true">
                        <path d="M12 2 2 7l10 5 10-5-10-5ZM2 12l10 5 10-5M2 17l10 5 10-5" />
                    </svg>
                </span>
                <span class="flex flex-col leading-tight">
                    <span class="text-lg font-bold">Хімекселен</span>
                    <span class="text-xs text-[#766748]">Вулики з ППУ</span>
                </span>
            </a>

            <div class="hidden items-center gap-6 md:flex">
                @foreach ($navigation as $item)
                    <a href="{{ $item['href'] }}"
                        @class([
                            'text-sm font-medium transition hover:text-[#b86f17]',
                            'text-[#b86f17] font-semibold' => request()->routeIs('catalog') && $item['name'] === 'Каталог',
                            'text-[#6d6045]' => !(request()->routeIs('catalog') && $item['name'] === 'Каталог')
                        ])>{{ $item['name'] }}</a>
                @endforeach
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <a href="tel:+380503403547"
                    class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white">Подзвонити</a>
                <button onclick="Livewire.dispatch('openOrderForm')" type="button" class="inline-flex w-auto items-center justify-center rounded-lg bg-[#b86f17] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] focus:outline-hidden focus:ring-2 focus:ring-[#b86f17] focus:ring-offset-2 cursor-pointer">
                    Замовити
                </button>
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
                            <a href="{{ $item['href'] }}" class="rounded-md px-3 py-2 text-base font-medium text-[#5d5035] hover:bg-[#f3ead3]">{{ $item['name'] }}</a>
                        @endforeach
                        <a href="tel:+380503403547" class="mt-2 rounded-lg border border-[#cdbb8c] px-4 py-3 text-center font-semibold text-[#2f2718] transition hover:bg-white">+38 050 340 35 47</a>
                        <div class="mt-1">
                            <button onclick="Livewire.dispatch('openOrderForm')" type="button" class="w-full inline-flex justify-center rounded-lg bg-[#b86f17] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] cursor-pointer">
                                Замовити
                            </button>
                        </div>
                    </div>
                </div>
            </details>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="bg-white py-16 sm:py-20 border-b border-[#e3d7b6]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Каталог товарів ТМ Хімекселен</span>
                    <h1 class="mt-4 font-serif text-4xl font-bold leading-tight sm:text-5xl">Продукція та ціни</h1>
                    <p class="mt-6 text-lg leading-8 text-[#6d6045]">
                        Широкий вибір екологічних вуликів з пінополіуретану на 8, 10 та 12 рамок, а також оригінальні комплектуючі деталі безпосередньо від виробника.
                    </p>
                </div>
            </div>
        </section>

        <!-- Product Catalog Section -->
        <section class="py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <!-- Category Tabs (AlpineJS) -->
                <div class="mb-10 flex flex-wrap justify-center gap-2 border-b border-[#e2d4ad] pb-6">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#b86f17] text-white' : 'bg-white text-[#6d6045] hover:bg-[#f3ead3]'" class="rounded-xl px-5 py-2.5 text-sm font-bold shadow-xs transition duration-200 cursor-pointer">
                        Всі товари
                    </button>
                    <button @click="activeTab = '8-frame'" :class="activeTab === '8-frame' ? 'bg-[#b86f17] text-white' : 'bg-white text-[#6d6045] hover:bg-[#f3ead3]'" class="rounded-xl px-5 py-2.5 text-sm font-bold shadow-xs transition duration-200 cursor-pointer">
                        8-рамкові вулики
                    </button>
                    <button @click="activeTab = '10-frame'" :class="activeTab === '10-frame' ? 'bg-[#b86f17] text-white' : 'bg-white text-[#6d6045] hover:bg-[#f3ead3]'" class="rounded-xl px-5 py-2.5 text-sm font-bold shadow-xs transition duration-200 cursor-pointer">
                        10-рамкові вулики
                    </button>
                    <button @click="activeTab = '12-frame'" :class="activeTab === '12-frame' ? 'bg-[#b86f17] text-white' : 'bg-white text-[#6d6045] hover:bg-[#f3ead3]'" class="rounded-xl px-5 py-2.5 text-sm font-bold shadow-xs transition duration-200 cursor-pointer">
                        12-рамкові вулики
                    </button>
                    <button @click="activeTab = 'components'" :class="activeTab === 'components' ? 'bg-[#b86f17] text-white' : 'bg-white text-[#6d6045] hover:bg-[#f3ead3]'" class="rounded-xl px-5 py-2.5 text-sm font-bold shadow-xs transition duration-200 cursor-pointer">
                        Комплектуючі
                    </button>
                </div>

                <!-- Catalog Grid -->
                <div>
                    <!-- 1. Hives Configurations -->
                    @foreach ($hivesCatalog as $frameSize => $group)
                        <div x-show="activeTab === 'all' || activeTab === '{{ $frameSize }}-frame'" class="mb-16">
                            <div class="mb-6 flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-xl bg-[#b86f17] text-white text-lg font-bold">🐝</div>
                                <h2 class="font-serif text-2xl font-bold text-[#2f2718] sm:text-3xl">{{ $group['label'] }}</h2>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($group['packages'] as $pkgKey => $package)
                                    <div class="flex flex-col rounded-2xl border border-[#e2d4ad] bg-white overflow-hidden shadow-xs hover:shadow-md hover:border-[#b86f17]/40 transition duration-300">
                                        <!-- Decorative honey gold stripe -->
                                        <div class="h-1.5 bg-[#b86f17]"></div>
                                        
                                        <div class="p-6 flex flex-col flex-1 justify-between">
                                            <div>
                                                <div class="flex items-start justify-between gap-2 mb-3">
                                                    <span class="text-xs font-semibold uppercase tracking-wider text-[#b86f17] bg-[#fbf8ef] px-2.5 py-1 rounded-md border border-[#e3d7b6]">
                                                        Комплектація {{ $pkgKey }}
                                                    </span>
                                                    <div class="text-lg font-black text-[#2f2718]">
                                                        {{ number_format($package['price'], 0, ',', ' ') }} грн
                                                    </div>
                                                </div>

                                                <h3 class="font-serif text-xl font-bold text-[#2f2718] mb-4">
                                                    Вулик на {{ $frameSize }} рамок
                                                </h3>

                                                <!-- Components list -->
                                                <div class="space-y-2 mb-6">
                                                    <div class="text-xs font-bold text-[#766748] uppercase tracking-wider mb-2">Склад комплекту:</div>
                                                    @foreach ($package['components'] as $pComp)
                                                        <div class="flex items-center gap-2 text-sm text-[#6d6045]">
                                                            <span class="text-[#b86f17] font-bold">✓</span>
                                                            <span>{{ $pComp['name'] }}</span>
                                                            <span class="ml-auto text-xs font-bold text-[#766748] bg-[#fbf8ef] px-1.5 py-0.5 rounded-sm">{{ $pComp['qty'] }} {{ $pComp['unit'] }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="pt-4 border-t border-zinc-100 flex flex-col sm:flex-row gap-2">
                                                <a href="{{ route('calculator') }}?size={{ $frameSize }}&package={{ $pkgKey }}" class="flex-1 text-center rounded-xl border border-[#cdbb8c] bg-white px-4 py-3 text-sm font-semibold text-[#2f2718] transition hover:bg-[#fbf8ef] flex items-center justify-center">
                                                    🧮 Калькулятор
                                                </a>
                                                <button onclick="Livewire.dispatch('addProductToCart', { productName: '{{ $frameSize }} рамок, Комплектація {{ $pkgKey }}' })" type="button" class="flex-1 rounded-xl bg-[#b86f17] px-4 py-3 text-sm font-semibold text-white shadow-xs transition hover:bg-[#97580f] cursor-pointer text-center flex items-center justify-center gap-1.5">
                                                    🛒 Замовити товар
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- 2. Components Catalog -->
                    <div x-show="activeTab === 'all' || activeTab === 'components'" class="mb-16">
                        <div class="mb-6 flex items-center gap-3">
                            <div class="flex size-10 items-center justify-center rounded-xl bg-[#b86f17] text-white text-lg font-bold">🛠️</div>
                            <h2 class="font-serif text-2xl font-bold text-[#2f2718] sm:text-3xl">Окремі комплектуючі та деталі</h2>
                        </div>

                        <!-- Sub-filtering inside components using nested tabs -->
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($rawComponents as $key => $component)
                                <div class="flex flex-col rounded-xl border border-[#e2d4ad] bg-white overflow-hidden shadow-xs hover:border-[#b86f17]/40 transition duration-300">
                                    <div class="p-5 flex flex-col flex-1 justify-between">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-3">
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#b86f17] bg-[#fbf8ef] px-2 py-0.5 rounded-md border border-[#e3d7b6]">
                                                    {{ $component['group'] === 'інше' ? 'додаткове' : $component['group'] . '-рамковий' }}
                                                </span>
                                                <div class="text-base font-black text-[#b86f17]">
                                                    {{ number_format($component['price'], 0, ',', ' ') }} грн
                                                </div>
                                            </div>
                                            <h3 class="font-semibold text-[#2f2718] text-base mb-4 leading-snug">
                                                {{ $component['name'] }}
                                            </h3>
                                        </div>
                                        
                                        <div class="pt-3 border-t border-zinc-100 w-full">
                                            <button onclick="Livewire.dispatch('addProductToCart', { productName: '{{ $component['name'] }} (окрема деталь)' })" type="button" class="w-full rounded-xl bg-[#b86f17] px-4 py-3 text-sm font-semibold text-white shadow-xs transition hover:bg-[#97580f] cursor-pointer text-center flex items-center justify-center gap-1.5">
                                                🛒 Замовити деталь
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

    <livewire:order-form />

    @fluxScripts
</body>

</html>
