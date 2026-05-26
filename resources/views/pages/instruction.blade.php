<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    @include('partials.head', ['title' => 'Інструкція'])
    <meta name="description" content="Інструкції зі складання та експлуатації вуликів з ППУ на 8, 10 і 12 рамок.">
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
            ['name' => 'Контакти', 'href' => route('home') . '#contacts'],
        ];

        $instructions = \App\Models\Instruction::orderBy('sort_order')
            ->get()
            ->map(fn($inst) => [
                'title' => $inst->title,
                'label' => $inst->label,
                'image_url' => $inst->image_url,
                'pdf_url' => $inst->pdf_url,
            ]);

        $assemblyVideos = \App\Models\Video::where('category', 'assembly')
            ->orderBy('sort_order')
            ->get()
            ->map(fn($v) => [
                'title' => $v->title,
                'id' => $v->youtube_id,
            ]);
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
                        class="text-sm font-medium text-[#6d6045] transition hover:text-[#b86f17]">{{ $item['name'] }}</a>
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
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[1fr_24rem] lg:items-end">
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">PDF матеріали</span>
                        <h1 class="mt-4 font-serif text-4xl font-bold leading-tight sm:text-5xl">Інструкція</h1>
                        <p class="mt-6 max-w-3xl text-lg leading-8 text-[#6d6045]">
                            Інструкції зі складання та експлуатації перенесені з WordPress-проєкту. Оберіть потрібну
                            комплектацію та відкрийте PDF.
                        </p>
                    </div>
                    <div class="rounded-lg border border-[#d9bd77] bg-[#fff8e6] p-5">
                        <div class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Доступно</div>
                        <div class="mt-2 text-3xl font-bold">3 PDF</div>
                        <p class="mt-2 text-sm leading-6 text-[#6d6045]">Для 8, 10 та 12 рамок.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
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
        </section>

        <section class="border-t border-[#e3d7b6] bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mb-10">
                    <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Відео-інструкції</span>
                    <h2 class="mt-2 text-3xl font-bold">Збірка елементів вулика</h2>
                    <p class="mt-4 text-base text-[#6d6045]">
                        Детальні відео-інструкції зі складання окремих комплектуючих частин для 8-рамкового вулика
                        Дадан.
                    </p>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($assemblyVideos as $video)
                        <article
                            class="overflow-hidden rounded-lg border border-[#e2d4ad] bg-white shadow-sm flex flex-col justify-between hover:shadow-md transition">
                            <div class="relative aspect-video w-full overflow-hidden bg-[#f3ead3] group cursor-pointer"
                                onclick="window.open('https://www.youtube.com/watch?v={{ $video['id'] }}', '_blank')">
                                <img loading="lazy"
                                    src="https://img.youtube.com/vi/{{ $video['id'] }}/maxresdefault.jpg"
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
        </section>
    </main>

    <footer class="bg-[#2f2718] py-8 text-[#fbf8ef]">
        <div
            class="mx-auto flex max-w-7xl flex-col justify-between gap-4 px-4 text-sm text-white/70 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} ТМ «Хімекселен»</p>
            <p>ПП Хімпостачальник</p>
        </div>
    </footer>

    <livewire:order-form />

    @fluxScripts
</body>

</html>
