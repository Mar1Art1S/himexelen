<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => 'Розміри'])
        <meta name="description" content="Розміри рамок, корпусів та комплектацій вуликів з ППУ.">
    </head>
    <body class="bg-[#fbf8ef] text-[#2f2718] antialiased">
        @php
            $navigation = [
                ['name' => 'Головна', 'href' => route('home')],
                ['name' => 'Каталог', 'href' => route('catalog')],
                ['name' => 'Відео', 'href' => route('video')],
                ['name' => 'Інструкція', 'href' => route('instruction')],
                ['name' => 'Розміри', 'href' => route('sizes')],
                ['name' => 'Калькулятор', 'href' => route('calculator')],
                ['name' => 'Контакти', 'href' => route('home').'#contacts'],
            ];

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
                    <span class="flex size-10 items-center justify-center rounded-lg bg-[#b86f17] text-white">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2 2 7l10 5 10-5-10-5ZM2 12l10 5 10-5M2 17l10 5 10-5" /></svg>
                    </span>
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-[#766748]">Вулики з ППУ</span>
                    </span>
                </a>

                <div class="hidden items-center gap-6 md:flex">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['href'] }}" class="text-sm font-medium text-[#6d6045] transition hover:text-[#b86f17]">{{ $item['name'] }}</a>
                    @endforeach
                </div>

                <div class="hidden items-center gap-3 md:flex">
                    <a href="tel:+380503403547" class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white">Подзвонити</a>
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
            <section class="bg-white py-16 sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Креслення та комплектації</span>
                    <h1 class="mt-4 font-serif text-4xl font-bold leading-tight sm:text-5xl">Розміри</h1>
                    <p class="mt-6 max-w-3xl text-lg leading-8 text-[#6d6045]">
                        Сторінка з основними кресленнями рамок і візуальними таблицями комплектацій, перенесеними з WordPress-проєкту.
                    </p>
                </div>
            </section>

            <section class="py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-end justify-between gap-6">
                        <div>
                            <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Креслення</span>
                            <h2 class="mt-2 text-3xl font-bold">Розміри рамок</h2>
                        </div>
                    </div>
                    <div class="mt-8 grid gap-6 md:grid-cols-3">
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
            </section>

            <section class="bg-[#f3ead3] py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Комплектації</span>
                    <h2 class="mt-2 text-3xl font-bold">Варіанти наборів</h2>
                    <div class="mt-8 grid gap-6 lg:grid-cols-2">
                        @foreach ($sets as $set)
                            <article class="overflow-hidden rounded-lg border border-[#dccb9f] bg-white p-4 shadow-sm">
                                <h3 class="mb-4 text-xl font-semibold">{{ $set['title'] }}</h3>
                                <img src="{{ $set['image_url'] }}" alt="{{ $set['title'] }}" class="w-full rounded-md object-contain">
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Таблиці</span>
                    <h2 class="mt-2 text-3xl font-bold">Ціни та склад комплектів</h2>
                    <div class="mt-8 grid gap-6 lg:grid-cols-3">
                        @foreach ($priceImages as $priceImage)
                            <article class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white p-4 shadow-sm">
                                <h3 class="mb-4 text-xl font-semibold">{{ $priceImage['title'] }}</h3>
                                <img src="{{ $priceImage['image_url'] }}" alt="Таблиця комплектацій {{ $priceImage['title'] }}" class="w-full rounded-md object-contain">
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-[#2f2718] py-8 text-[#fbf8ef]">
            <div class="mx-auto flex max-w-7xl flex-col justify-between gap-4 px-4 text-sm text-white/70 sm:flex-row sm:px-6 lg:px-8">
                <p>© {{ date('Y') }} ТМ «Хімекселен»</p>
                <p>ПП Хімпостачальник</p>
            </div>
        </footer>

        <livewire:order-form />

        @fluxScripts
    </body>
</html>
