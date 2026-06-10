<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', ['title' => 'Відеоматеріали'])
    <meta name="description" content="Відео огляди вуликів з ППУ, детальні інструкції зі складання, креслення рамок та варіанти комплектацій вуликів ТМ Хімекселен.">
</head>

<body class="bg-[#fbf8ef] text-[#2f2718] antialiased" x-data="{ activeTab: (new URLSearchParams(window.location.search)).get('tab') || 'video' }">
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

        // 1. Tab - Video content
        $generalCategories = \App\Models\VideoCategory::where('type', 'general')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($cat) => [
                'name' => $cat->name,
                'videos' => $cat->videos()->orderBy('sort_order')->get()->map(fn($v) => [
                    'title' => $v->title,
                    'id' => $v->youtube_id,
                    'image_url' => $v->image_path ? \Illuminate\Support\Facades\Storage::url($v->image_path) : "https://img.youtube.com/vi/{$v->youtube_id}/maxresdefault.jpg",
                ]),
            ]);

        // 2. Tab - Instruction content
        $instructions = \App\Models\Instruction::orderBy('sort_order')
            ->get()
            ->map(fn($inst) => [
                'title' => $inst->title,
                'label' => $inst->label,
                'image_url' => $inst->image_url,
                'pdf_url' => $inst->pdf_url,
            ]);

        $assemblyCategories = \App\Models\VideoCategory::where('type', 'assembly')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($cat) => [
                'name' => $cat->name,
                'videos' => $cat->videos()->orderBy('sort_order')->get()->map(fn($v) => [
                    'title' => $v->title,
                    'id' => $v->youtube_id,
                    'image_url' => $v->image_path ? \Illuminate\Support\Facades\Storage::url($v->image_path) : "https://img.youtube.com/vi/{$v->youtube_id}/maxresdefault.jpg",
                ]),
            ]);

        // 3. Tab - Sizes content
        $frames = \App\Models\Size::where('type', 'frame')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($f) => [
                'title' => $f->title,
                'image_url' => $f->image_url,
                'description' => $f->description,
            ]);

        $sets = \App\Models\Size::where('type', 'set')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($s) => [
                'title' => $s->title,
                'image_url' => $s->image_url,
            ]);

        $priceImages = \App\Models\Size::where('type', 'price_image')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($p) => [
                'title' => $p->title,
                'image_url' => $p->image_url,
            ]);
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
                                'text-[#b86f17] font-semibold' => request()->routeIs('video') && $item['name'] === 'Відеоматеріали',
                                'text-[#6d6045]' => !(request()->routeIs('video') && $item['name'] === 'Відеоматеріали')
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
        <!-- Page Title Section -->
        <section class="bg-white py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Матеріали та документація</span>
                    <h1 class="mt-3 font-serif text-4xl font-bold leading-tight sm:text-5xl">Відеоматеріали та інструкції</h1>
                    <p class="mt-4 text-lg leading-8 text-[#6d6045]">
                        Корисна добірка оглядів вуликів з ППУ, відео-інструкцій для складання, креслень рамок та варіантів комплектацій.
                    </p>
                </div>
            </div>
        </section>

        <!-- Dynamic Tabs Navigation -->
        <div class="sticky top-16 z-40 border-b border-[#e3d7b6] bg-[#fbf8ef]/95 backdrop-blur">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <nav class="-mb-px flex space-x-8 overflow-x-auto scrolling-touch" aria-label="Tabs">
                    <button
                        @click="activeTab = 'video'; history.replaceState(null, '', '?tab=video')"
                        :class="activeTab === 'video' ? 'border-[#b86f17] text-[#b86f17]' : 'border-transparent text-[#6d6045] hover:border-[#cdbb8c] hover:text-[#2f2718]'"
                        class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition cursor-pointer">
                        Відео огляди
                    </button>
                    <button
                        @click="activeTab = 'instruction'; history.replaceState(null, '', '?tab=instruction')"
                        :class="activeTab === 'instruction' ? 'border-[#b86f17] text-[#b86f17]' : 'border-transparent text-[#6d6045] hover:border-[#cdbb8c] hover:text-[#2f2718]'"
                        class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition cursor-pointer">
                        PDF Інструкції & Збірка
                    </button>
                    <button
                        @click="activeTab = 'sizes'; history.replaceState(null, '', '?tab=sizes')"
                        :class="activeTab === 'sizes' ? 'border-[#b86f17] text-[#b86f17]' : 'border-transparent text-[#6d6045] hover:border-[#cdbb8c] hover:text-[#2f2718]'"
                        class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-semibold transition cursor-pointer">
                        Розміри та Креслення
                    </button>
                </nav>
            </div>
        </div>
        <!-- Tabs Content Sections -->
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

            <!-- TAB 1: VIDEOS -->
            <div x-show="activeTab === 'video'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-12">
                @foreach ($generalCategories as $category)
                    @if (count($category['videos']) > 0)
                        <div>
                            @if (count($generalCategories) > 1)
                                <h2 class="text-2xl font-bold font-serif mb-6 text-[#2f2718]">{{ $category['name'] }}</h2>
                            @endif
                            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($category['videos'] as $video)
                                    <article
                                        class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white shadow-sm flex flex-col justify-between hover:shadow-md transition">
                                        <div class="relative aspect-square w-full overflow-hidden bg-[#f3ead3] group cursor-pointer"
                                            onclick="window.open('https://www.youtube.com/watch?v={{ $video['id'] }}', '_blank')">
                                            <img loading="lazy"
                                                src="{{ $video['image_url'] }}"
                                                alt="{{ $video['title'] }}"
                                                class="size-full object-cover group-hover:scale-105 transition duration-300" />
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/30 transition">
                                                <button
                                                    class="flex size-16 items-center justify-center rounded-full bg-[#b86f17] text-white shadow-lg group-hover:bg-[#97580f] transition opacity-90 group-hover:opacity-100">
                                                    <svg class="size-7 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="p-5 flex-1 flex flex-col justify-between">
                                            <h2 class="text-base font-semibold text-[#2f2718] line-clamp-2"
                                                title="{{ $video['title'] }}">
                                                {{ $video['title'] }}
                                            </h2>
                                            <a href="https://www.youtube.com/watch?v={{ $video['id'] }}" target="_blank"
                                                class="mt-4 inline-flex items-center gap-2 rounded-lg bg-[#b86f17] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#97580f]">
                                                Переглянути на YouTube
                                                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m4-6h-8m4 0l-4 4m4-4l4 4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- TAB 2: INSTRUCTIONS -->
            <div x-show="activeTab === 'instruction'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-16">
                <!-- PDF section -->
                <div>
                    <h2 class="text-2xl font-bold font-serif mb-6 text-[#2f2718]">Доступні PDF інструкції</h2>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($instructions as $instruction)
                            <article class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white shadow-sm">
                                 <div class="bg-[#f3ead3] p-4">
                                     <img src="{{ $instruction['image_url'] }}"
                                         alt="{{ $instruction['title'] }}"
                                         class="aspect-[3/4] w-full rounded-md object-cover">
                                 </div>
                                 <div class="p-5">
                                     <span
                                         class="rounded-full bg-[#f3ead3] px-3 py-1 text-xs font-semibold text-[#97580f]">{{ $instruction['label'] }}</span>
                                     <h2 class="mt-4 text-xl font-semibold">{{ $instruction['title'] }}</h2>
                                     <div class="mt-5 flex flex-col gap-3">
                                         <a href="{{ $instruction['pdf_url'] }}" target="_blank"
                                             rel="noreferrer"
                                             class="rounded-lg bg-[#b86f17] px-4 py-3 text-center font-semibold text-white transition hover:bg-[#97580f]">Відкрити
                                             PDF</a>
                                         <a href="{{ $instruction['pdf_url'] }}"
                                             class="rounded-lg border border-[#cdbb8c] px-4 py-3 text-center font-semibold transition hover:bg-[#fbf8ef]">Завантажити</a>
                                     </div>
                                 </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Video Assembly section -->
                <div class="border-t border-[#e3d7b6] pt-12 space-y-12">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Відео-інструкції</span>
                        <h2 class="mt-1 text-3xl font-bold font-serif">Збірка елементів вулика</h2>
                        <p class="mt-2 text-base text-[#6d6045]">
                            Детальні відео-інструкції зі складання окремих комплектуючих частин для вуликів ППУ.
                        </p>
                    </div>

                    @foreach ($assemblyCategories as $category)
                        @if (count($category['videos']) > 0)
                            <div>
                                <h3 class="text-xl font-bold font-serif mb-6 text-[#2f2718] border-b border-[#e3d7b6] pb-2">{{ $category['name'] }}</h3>
                                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                                    @foreach ($category['videos'] as $video)
                                        <article
                                            class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white shadow-sm flex flex-col justify-between hover:shadow-md transition">
                                            <div class="relative aspect-square w-full overflow-hidden bg-[#f3ead3] group cursor-pointer"
                                                onclick="window.open('https://www.youtube.com/watch?v={{ $video['id'] }}', '_blank')">
                                                <img loading="lazy"
                                                    src="{{ $video['image_url'] }}"
                                                    alt="{{ $video['title'] }}"
                                                    class="size-full object-cover group-hover:scale-105 transition duration-300" />
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/30 transition">
                                                    <button
                                                        class="flex size-14 items-center justify-center rounded-full bg-[#b86f17] text-white shadow-lg group-hover:bg-[#97580f] transition opacity-90 group-hover:opacity-100">
                                                        <svg class="size-6 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="p-4 flex-1 flex flex-col justify-between">
                                                <h3 class="text-sm font-semibold text-[#2f2718] line-clamp-2"
                                                    title="{{ $video['title'] }}">
                                                    {{ $video['title'] }}
                                                </h3>
                                                <a href="https://www.youtube.com/watch?v={{ $video['id'] }}" target="_blank"
                                                    class="mt-3 inline-flex items-center justify-center gap-2 rounded-lg bg-[#b86f17] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#97580f]">
                                                    Переглянути
                                                    <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m4-6h-8m4 0l-4 4m4-4l4 4" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- TAB 3: SIZES -->
            <div x-show="activeTab === 'sizes'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-16">
                <!-- Frame Drawings -->
                <div>
                    <h2 class="text-2xl font-bold font-serif mb-6 text-[#2f2718]">Розміри рамок</h2>
                    <div class="grid gap-6 md:grid-cols-3">
                        @foreach ($frames as $frame)
                            <article class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white shadow-sm">
                                <img src="{{ $frame['image_url'] }}" alt="{{ $frame['title'] }}" class="aspect-square w-full object-cover">
                                <div class="p-5">
                                    <h3 class="text-xl font-semibold">{{ $frame['title'] }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-[#6d6045]">{{ $frame['description'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <!-- Sets drawings -->
                <div class="border-t border-[#e3d7b6] pt-12">
                    <h2 class="text-2xl font-bold font-serif mb-6 text-[#2f2718]">Варіанти наборів (Комплектації)</h2>
                    <div class="grid gap-6 lg:grid-cols-2">
                        @foreach ($sets as $set)
                            <article class="overflow-hidden rounded-lg border border-[#dccb9f] bg-white p-4 shadow-sm">
                                <h3 class="mb-4 text-xl font-semibold">{{ $set['title'] }}</h3>
                                <img src="{{ $set['image_url'] }}" alt="{{ $set['title'] }}" class="w-full rounded-md object-contain">
                            </article>
                        @endforeach
                    </div>
                </div>


            </div>

        </div>
    </main>

    @include('partials.footer')

            <livewire:callback-form />
        @fluxScripts
</body>

</html>
