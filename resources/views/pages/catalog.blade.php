<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', ['title' => 'Каталог'])
    <meta name="description" content="Каталог продукції ТМ Хімекселен: вулики з ППУ на 8, 10 та 12 рамок, а також повний асортимент оригінальних комплектуючих.">
</head>

<body class="bg-[#fbf8ef] text-[#2f2718] antialiased" x-data="{ activeTab: (new URLSearchParams(window.location.search)).get('tab') || '12-frame' }">
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
                        <a href="{{ $item['href'] }}"
                            @class([
                                'text-sm font-medium transition hover:text-[#b86f17]',
                                'text-[#b86f17] font-semibold' => request()->routeIs('catalog') && $item['name'] === 'Продукція та ціни',
                                'text-[#6d6045]' => !(request()->routeIs('catalog') && $item['name'] === 'Продукція та ціни')
                            ])>{{ $item['name'] }}</a>
                    @endif
                @endforeach
            </div>

            <div class="hidden items-center gap-3 md:flex">
                <button onclick="Livewire.dispatch('openCallbackForm')" type="button" 
                    class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white" cursor-pointer>Подзвонити</button>
                
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
                
                <!-- Фото цін -->
                <div class="mb-12 flex justify-center">
                    <img src="{{ asset('images/price/bee8-11-05.png') }}" alt="Таблиця цін на вулики" class="max-w-full md:max-w-4xl h-auto rounded-3xl border border-[#e2d4ad] shadow-lg bg-white p-2">
                </div>

                <!-- Слайдер 8-рамкового вулика -->
                <div class="mb-16 mx-auto max-w-5xl" x-data="{ 
                    activeSlide: 0,
                    showLightbox: false,
                    lightboxSrc: '',
                    lightboxTitle: '',
                    slides: [
                        { src: '{{ asset('images/8_beelg/8-rama-krisha.jpg') }}', title: 'Дах 8-рамковий' },
                        { src: '{{ asset('images/8_beelg/kormushka8-1.jpg') }}', title: 'Годівниця 8-рамкова' },
                        { src: '{{ asset('images/8_beelg/korpus-8-300.jpg') }}', title: 'Корпус 8-рамковий на 300 мм' },
                        { src: '{{ asset('images/8_beelg/korpus-8-145.jpg') }}', title: 'Корпус 8-рамковий на 145 мм' },
                        { src: '{{ asset('images/8_beelg/korpus-8.jpg') }}', title: 'Корпус 8-рамковий' },
                        { src: '{{ asset('images/8_beelg/8-rama-dno-setka-zagr.jpg') }}', title: 'Дно 8-рамкове сітчасте' },
                        { src: '{{ asset('images/8_beelg/8-rama-dno-letov-zagr.jpg') }}', title: 'Дно 8-рамкове з льотковим загороджувачем' }
                    ],
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                    openLightbox(src, title) {
                        this.lightboxSrc = src;
                        this.lightboxTitle = title;
                        this.showLightbox = true;
                    },
                    closeLightbox() {
                        this.showLightbox = false;
                    }
                }">
                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718]">Деталі 8-рамкового вулика</h3>
                        <p class="text-sm text-[#766748] mt-1">Ознайомтеся з елементами конструкції нашої продукції (клікніть для збільшення)</p>
                    </div>

                    <!-- Slider Container -->
                    <div class="relative overflow-hidden rounded-3xl border border-[#e2d4ad] bg-white shadow-lg p-6">
                        
                        <!-- Slides Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#fbf8ef] rounded-2xl p-6 min-h-[380px]">
                            
                            <!-- Slide 1 (Always Visible) -->
                            <div class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[activeSlide].src" :alt="slides[activeSlide].title" 
                                     @click="openLightbox(slides[activeSlide].src, slides[activeSlide].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${activeSlide + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[activeSlide].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 2 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 1) % slides.length].src" :alt="slides[(activeSlide + 1) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 1) % slides.length].src, slides[(activeSlide + 1) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 1) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 1) % slides.length].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 3 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 2) % slides.length].src" :alt="slides[(activeSlide + 2) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 2) % slides.length].src, slides[(activeSlide + 2) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 2) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 2) % slides.length].title"></h4>
                                </div>
                            </div>

                        </div>

                        <!-- Prev / Next Buttons -->
                        <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Dot Indicators -->
                    <div class="mt-4 flex justify-center gap-2">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="activeSlide = index" 
                                    :class="activeSlide === index ? 'bg-[#b86f17] w-6' : 'bg-[#d6c59c] hover:bg-[#b86f17]/60 w-2.5'" 
                                    class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        </template>
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="showLightbox" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/85 p-4"
                         @click="closeLightbox()"
                         style="display: none;"
                         @keydown.escape.window="closeLightbox()">
                        
                        <div class="relative max-w-5xl w-full flex flex-col items-center justify-center" @click.stop>
                            <!-- Close Button -->
                            <button @click="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-[#cdbb8c] cursor-pointer text-sm font-bold flex items-center gap-1">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Закрити
                            </button>

                            <!-- Image -->
                            <img :src="lightboxSrc" :alt="lightboxTitle" class="max-h-[80vh] max-w-full rounded-2xl border border-white/10 shadow-2xl object-contain bg-[#fbf8ef] p-2">
                            
                            <!-- Title -->
                            <h4 class="mt-4 text-center font-serif text-xl font-bold text-white" x-text="lightboxTitle"></h4>
                        </div>
                    </div>
                </div>

                <!-- Кнопка переходу до калькулятора -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('calculator') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition">
                        <span>🧮 Перейти до калькулятора та обрати свій набір для вулика</span>
                    </a>
                </div>

                <!-- Фото цін 10 рамок -->
                <div class="mt-12 flex justify-center">
                    <img src="{{ asset('images/price/bee10-11-05.png') }}" alt="Таблиця цін на вулики" class="max-w-full md:max-w-4xl h-auto rounded-3xl border border-[#e2d4ad] shadow-lg bg-white p-2">
                </div>

                <!-- Фото цін 12 рамок -->
                <div class="mt-12 flex justify-center">
                    <img src="{{ asset('images/price/bee12-11-05.png') }}" alt="Таблиця цін на вулики" class="max-w-full md:max-w-4xl h-auto rounded-3xl border border-[#e2d4ad] shadow-lg bg-white p-2">
                </div>

                <!-- Слайдер 10/12-рамкового вулика -->
                <div class="mt-16 mx-auto max-w-5xl" x-data="{ 
                    activeSlide: 0,
                    showLightbox: false,
                    lightboxSrc: '',
                    lightboxTitle: '',
                    slides: [
                        { src: '{{ asset('images/10_12_bee/dsc_3803-krisha.jpg') }}', title: 'Дах 10/12-рамковий' },
                        { src: '{{ asset('images/10_12_bee/kormushka-1.jpg') }}', title: 'Годівниця 10-рамкова' },
                        { src: '{{ asset('images/10_12_bee/kormushka-2.jpg') }}', title: 'Годівниця 12-рамкова' },
                        { src: '{{ asset('images/10_12_bee/korpusdsc_5995.jpg') }}', title: 'Корпус на 300 мм' },
                        { src: '{{ asset('images/10_12_bee/k145sc_5989.jpg') }}', title: 'Корпус на 145 мм' },
                        { src: '{{ asset('images/10_12_bee/setka_dno.jpg') }}', title: 'Дно сітчасте з сіткою' },
                        { src: '{{ asset('images/10_12_bee/2-letov-zagr.jpg') }}', title: 'Льотковий загороджувач' },
                        { src: '{{ asset('images/10_12_bee/vstavka-12-bee.lg_.ua_.jpg') }}', title: 'Вставка-перегородка для 12-рамкового вулика' }
                    ],
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                    openLightbox(src, title) {
                        this.lightboxSrc = src;
                        this.lightboxTitle = title;
                        this.showLightbox = true;
                    },
                    closeLightbox() {
                        this.showLightbox = false;
                    }
                }">
                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718]">Деталі 10/12-рамкового вулика</h3>
                        <p class="text-sm text-[#766748] mt-1">Ознайомтеся з елементами конструкції нашої продукції (клікніть для збільшення)</p>
                    </div>

                    <!-- Slider Container -->
                    <div class="relative overflow-hidden rounded-3xl border border-[#e2d4ad] bg-white shadow-lg p-6">
                        
                        <!-- Slides Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#fbf8ef] rounded-2xl p-6 min-h-[380px]">
                            
                            <!-- Slide 1 (Always Visible) -->
                            <div class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[activeSlide].src" :alt="slides[activeSlide].title" 
                                     @click="openLightbox(slides[activeSlide].src, slides[activeSlide].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${activeSlide + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[activeSlide].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 2 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 1) % slides.length].src" :alt="slides[(activeSlide + 1) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 1) % slides.length].src, slides[(activeSlide + 1) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 1) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 1) % slides.length].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 3 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 2) % slides.length].src" :alt="slides[(activeSlide + 2) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 2) % slides.length].src, slides[(activeSlide + 2) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 2) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 2) % slides.length].title"></h4>
                                </div>
                            </div>

                        </div>

                        <!-- Prev / Next Buttons -->
                        <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Dot Indicators -->
                    <div class="mt-4 flex justify-center gap-2">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="activeSlide = index" 
                                    :class="activeSlide === index ? 'bg-[#b86f17] w-6' : 'bg-[#d6c59c] hover:bg-[#b86f17]/60 w-2.5'" 
                                    class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        </template>
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="showLightbox" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/85 p-4"
                         @click="closeLightbox()"
                         style="display: none;"
                         @keydown.escape.window="closeLightbox()">
                        
                        <div class="relative max-w-5xl w-full flex flex-col items-center justify-center" @click.stop>
                            <!-- Close Button -->
                            <button @click="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-[#cdbb8c] cursor-pointer text-sm font-bold flex items-center gap-1">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Закрити
                            </button>

                            <!-- Image -->
                            <img :src="lightboxSrc" :alt="lightboxTitle" class="max-h-[80vh] max-w-full rounded-2xl border border-white/10 shadow-2xl object-contain bg-[#fbf8ef] p-2">
                            
                            <!-- Title -->
                            <h4 class="mt-4 text-center font-serif text-xl font-bold text-white" x-text="lightboxTitle"></h4>
                        </div>
                    </div>
                </div>

                <!-- Кнопка переходу до калькулятора -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('calculator') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition">
                        <span>🧮 Перейти до калькулятора та обрати свій набір для вулика</span>
                    </a>
                </div>

                <!-- Фото цін інші комплектуючі -->
                <div class="mt-16 flex justify-center">
                    <img src="{{ asset('images/price/bee-other-11-05.png') }}" alt="Таблиця цін на інші комплектуючі" class="max-w-full md:max-w-4xl h-auto rounded-3xl border border-[#e2d4ad] shadow-lg bg-white p-2">
                </div>

                <!-- Слайдер інших комплектуючих -->
                <div class="mt-16 mx-auto max-w-5xl" x-data="{ 
                    activeSlide: 0,
                    showLightbox: false,
                    lightboxSrc: '',
                    lightboxTitle: '',
                    slides: [
                        { src: '{{ asset('images/inshi/mikronukleus.jpg') }}', title: 'Мікронуклеус' },
                        { src: '{{ asset('images/inshi/vstavnaya-doska-230.jpg') }}', title: 'Заставна дошка на 230 мм' },
                        { src: '{{ asset('images/inshi/dvavstavnaya-doska-300.jpg') }}', title: 'Заставна дошка на 300 мм' }
                    ],
                    next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                    prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                    openLightbox(src, title) {
                        this.lightboxSrc = src;
                        this.lightboxTitle = title;
                        this.showLightbox = true;
                    },
                    closeLightbox() {
                        this.showLightbox = false;
                    }
                }">
                    <div class="text-center mb-6">
                        <h3 class="font-serif text-2xl font-bold text-[#2f2718]">Інші комплектуючі</h3>
                        <p class="text-sm text-[#766748] mt-1">Ознайомтеся з додатковими елементами нашої продукції (клікніть для збільшення)</p>
                    </div>

                    <!-- Slider Container -->
                    <div class="relative overflow-hidden rounded-3xl border border-[#e2d4ad] bg-white shadow-lg p-6">
                        
                        <!-- Slides Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-[#fbf8ef] rounded-2xl p-6 min-h-[380px]">
                            
                            <!-- Slide 1 (Always Visible) -->
                            <div class="flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[activeSlide].src" :alt="slides[activeSlide].title" 
                                     @click="openLightbox(slides[activeSlide].src, slides[activeSlide].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${activeSlide + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[activeSlide].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 2 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 1) % slides.length].src" :alt="slides[(activeSlide + 1) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 1) % slides.length].src, slides[(activeSlide + 1) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 1) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 1) % slides.length].title"></h4>
                                </div>
                            </div>

                            <!-- Slide 3 (Visible on Desktop only) -->
                            <div class="hidden md:flex flex-col items-center justify-center p-5 bg-white rounded-2xl border border-[#e2d4ad]/40 shadow-xs transition duration-300 hover:shadow-md hover:scale-102">
                                <img :src="slides[(activeSlide + 2) % slides.length].src" :alt="slides[(activeSlide + 2) % slides.length].title" 
                                     @click="openLightbox(slides[(activeSlide + 2) % slides.length].src, slides[(activeSlide + 2) % slides.length].title)"
                                     class="h-44 w-auto object-contain rounded-xl cursor-zoom-in transition duration-300 hover:scale-105">
                                <div class="mt-4 text-center">
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-[#f3ead3] text-[#b86f17] text-[10px] font-bold uppercase tracking-wider" x-text="`Елемент ${((activeSlide + 2) % slides.length) + 1} з ${slides.length}`"></span>
                                    <h4 class="mt-1.5 font-serif text-base font-bold text-[#2f2718] leading-tight" x-text="slides[(activeSlide + 2) % slides.length].title"></h4>
                                </div>
                            </div>

                        </div>

                        <!-- Prev / Next Buttons -->
                        <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 flex h-11 w-11 cursor-pointer items-center justify-center rounded-full border border-[#cdbb8c] bg-white text-[#2f2718] shadow-md transition hover:bg-[#fbf8ef] hover:text-[#b86f17] focus:outline-hidden z-10">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Dot Indicators -->
                    <div class="mt-4 flex justify-center gap-2">
                        <template x-for="(slide, index) in slides" :key="index">
                            <button @click="activeSlide = index" 
                                    :class="activeSlide === index ? 'bg-[#b86f17] w-6' : 'bg-[#d6c59c] hover:bg-[#b86f17]/60 w-2.5'" 
                                    class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"></button>
                        </template>
                    </div>

                    <!-- Lightbox Modal -->
                    <div x-show="showLightbox" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-black/85 p-4"
                         @click="closeLightbox()"
                         style="display: none;"
                         @keydown.escape.window="closeLightbox()">
                        
                        <div class="relative max-w-5xl w-full flex flex-col items-center justify-center" @click.stop>
                            <!-- Close Button -->
                            <button @click="closeLightbox()" class="absolute -top-12 right-0 text-white hover:text-[#cdbb8c] cursor-pointer text-sm font-bold flex items-center gap-1">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Закрити
                            </button>

                            <!-- Image -->
                            <img :src="lightboxSrc" :alt="lightboxTitle" class="max-h-[80vh] max-w-full rounded-2xl border border-white/10 shadow-2xl object-contain bg-[#fbf8ef] p-2">
                            
                            <!-- Title -->
                            <h4 class="mt-4 text-center font-serif text-xl font-bold text-white" x-text="lightboxTitle"></h4>
                        </div>
                    </div>
                </div>

                <!-- Кнопка переходу до калькулятора -->
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('calculator') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition">
                        <span>🧮 Перейти до калькулятора та обрати свій набір для вулика</span>
                    </a>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

            <livewire:callback-form />
        @fluxScripts
</body>

</html>
