<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => 'Вулики з ППУ'])
        <meta name="description" content="Вулики з пінополіуретану ТМ Хімекселен: легкі, довговічні та енергоефективні рішення для сучасного бджільництва.">
    </head>
    <body class="bg-[#fbf8ef] text-[#2f2718] antialiased">
        @php
            $navigation = [
                ['name' => 'Головна', 'href' => route('home')],
                ['name' => 'Каталог', 'href' => route('catalog')],
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
                ['name' => 'Контакти', 'href' => '#contacts'],
            ];

            $benefits = [
                ['title' => 'Легкість', 'stat' => '3x', 'label' => 'легше', 'text' => "Вулики з ППУ в 3 рази легше дерев'яних, що спрощує перенесення та зменшує навантаження на спину."],
                ['title' => 'Довговічність', 'stat' => '30+', 'label' => 'років', 'text' => "Служать від 30 років і більше, приблизно вдвічі довше у порівнянні з дерев'яними вуликами."],
                ['title' => 'Теплоізоляція', 'stat' => '50%', 'label' => 'краще', 'text' => 'Матеріал зменшує нагрів влітку та охолодження взимку, допомагаючи сімʼї стабільно тримати температуру.'],
                ['title' => 'Економічність', 'stat' => '60%', 'label' => 'економії', 'text' => 'Витрати на утримання знижуються від 30% до 60%, а взаємозамінні деталі легко миються.'],
                ['title' => 'Міцність', 'stat' => '100%', 'label' => 'захист', 'text' => 'Зовні покриті інтегральною кіркою: бджоли не гризуть, миші байдужі, корпус не деформується з часом.'],
                ['title' => 'Екологічність', 'stat' => 'Еко', 'label' => 'норма', 'text' => 'Пінополіуретан відповідає нормам екології, а бджоли витрачають менше сил на мікроклімат у вулику.'],
            ];

            $materialFacts = [
                ['label' => 'Складається з повітря', 'value' => '85-90%'],
                ['label' => 'Термін служби', 'value' => '30+ років'],
                ['label' => 'Теплоізоляція', 'value' => 'На 50% краще'],
                ['label' => 'Вага', 'value' => 'У 3 рази легше'],
            ];

            $deliveryMethods = [
                ['name' => 'Нова Пошта', 'description' => 'Найшвидша доставка'],
                ['name' => 'Укрпошта', 'description' => 'Економний варіант'],
                ['name' => 'Meest Express', 'description' => 'Зручна доставка'],
                ['name' => 'Делівері', 'description' => 'Для великих вантажів'],
                ['name' => 'Самовивіз', 'description' => 'За попередньою домовленістю'],
            ];

            $phones = [
                ['number' => '+38 050 340 35 47', 'label' => 'Основний'],
                ['number' => '+38 050 475 68 47', 'label' => 'Додатковий'],
                ['number' => '+38 050 348 23 10', 'label' => 'Київ'],
            ];

            $emails = [
                ['email' => 'info@bee.lg.ua', 'label' => 'Електронна пошта'],
            ];
        @endphp

        <header class="fixed inset-x-0 top-0 z-50 border-b border-[#e3d7b6] bg-[#fbf8ef]/90 backdrop-blur">
            <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="#hero" class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Логотип Хімекселен" class="h-10 w-auto object-contain">
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-[#766748]">Вулики з ППУ</span>
                    </span>
                </a>

                <div class="hidden items-center gap-6 lg:flex">
                    @foreach ($navigation as $item)
                        @if (isset($item['children']))
                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium text-[#6d6045] transition hover:text-[#b86f17] focus:outline-hidden cursor-pointer">
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
                            <a href="{{ $item['href'] }}" class="text-sm font-medium text-[#6d6045] transition hover:text-[#b86f17]">{{ $item['name'] }}</a>
                        @endif
                    @endforeach
                </div>

                <div class="hidden items-center gap-4 lg:flex">
                    <button onclick="Livewire.dispatch('openContactForm')" type="button" class="rounded-lg border border-[#cdbb8c] px-4 py-2 text-sm font-semibold text-[#2f2718] transition hover:bg-white cursor-pointer">Зв'язатися</button>
                    <button onclick="Livewire.dispatch('openOrderForm')" type="button" class="inline-flex w-auto items-center justify-center rounded-lg bg-[#b86f17] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-[#97580f] focus:outline-hidden focus:ring-2 focus:ring-[#b86f17] focus:ring-offset-2 cursor-pointer">
                        Замовити
                    </button>
                </div>

                <details class="relative lg:hidden">
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
            <section id="hero" class="relative min-h-[92vh] overflow-hidden pt-16">
                <img src="{{ asset('images/hero-beehive.jpg') }}" alt="Вулики з пінополіуретану" class="absolute inset-0 size-full object-cover">
                <div class="absolute inset-0 bg-linear-to-r from-[#fbf8ef] via-[#fbf8ef]/80 to-[#fbf8ef]/10"></div>

                <div class="relative mx-auto flex min-h-[calc(92vh-4rem)] max-w-7xl items-center px-4 py-16 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#d6c59c] bg-white/70 px-4 py-2 text-sm font-semibold text-[#6d6045] shadow-sm">
                            <svg class="size-4 text-[#b86f17]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                <circle cx="12" cy="10" r="2" />
                            </svg>
                            Виробництво у м. Кременчук
                        </div>

                        <h1 class="mt-6 font-serif text-4xl font-bold leading-tight text-[#2f2718] sm:text-5xl lg:text-7xl">
                            Наступне покоління <span class="text-[#b86f17]">вуликів</span>
                        </h1>
                        <p class="mt-6 max-w-xl text-lg leading-8 text-[#6d6045] sm:text-xl">
                            Нові технології на службі природи. Легкі, довговічні та енергоефективні вулики з пінополіуретану.
                        </p>

                        <div class="mt-8 flex flex-wrap gap-8">
                            <div>
                                <div class="text-3xl font-bold text-[#b86f17] sm:text-4xl">3x</div>
                                <div class="text-sm text-[#766748]">легше дерев'яних</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-[#b86f17] sm:text-4xl">30+</div>
                                <div class="text-sm text-[#766748]">років служби</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-[#b86f17] sm:text-4xl">50%</div>
                                <div class="text-sm text-[#766748]">краща теплоізоляція</div>
                            </div>
                        </div>

                        <div class="mt-10 flex flex-wrap gap-4">
                            <a href="{{ route('catalog') }}" class="rounded-xl bg-[#b86f17] px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition">
                                Каталог вуликів
                            </a>
                            <a href="{{ route('calculator') }}" class="rounded-xl border border-[#cdbb8c] bg-white px-6 py-3.5 text-sm font-bold text-[#2f2718] transition hover:bg-[#fbf8ef]">
                                Калькулятор комплектації
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="about" class="bg-white py-20 lg:py-28">
                <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
                    <div class="relative aspect-[4/3] overflow-hidden rounded-3xl lg:aspect-square shadow-lg">
                        <img src="{{ asset('images/beekeeper.jpg') }}" alt="Бджоляр працює з вуликами" class="size-full object-cover">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/10"></div>
                    </div>
                    <div>
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Про проект</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">ТМ Хімекселен</h2>
                        
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">
                            <strong class="text-[#2f2718]">Хімекселен</strong> — спеціалізований проект компанії <strong class="text-[#2f2718]">Хімпостачальник</strong> у сфері сучасного бджільництва та виробництва ППУ-вуликів.
                        </p>
                        
                        <p class="mt-4 text-sm sm:text-base leading-relaxed text-[#6d6045]">
                            Ми створюємо функціональні модульні системи для пасік, які поєднують сучасні матеріали, ефективну теплоізоляцію та практичність у щоденній експлуатації.
                        </p>

                        <p class="mt-3 text-sm sm:text-base leading-relaxed text-[#6d6045]">
                            Вулики ТМ <strong class="text-[#2f2718]">Хімекселен</strong> виготовляються з пінополіуретану (ППУ) за сучасною технологією, що дозволяє забезпечити довговічність конструкції, комфортне утримання бджіл та можливість індивідуальної комплектації під різні потреби пасічних господарств.
                        </p>

                        <div class="mt-4 p-4 rounded-2xl bg-[#fffcf5] border border-[#f3ead3] text-xs sm:text-sm text-[#766748] font-medium flex items-center gap-3">
                            <span class="text-xl flex-shrink-0">🌍</span>
                            <span>Продукція компанії використовується бджолярами в Україні та країнах Європи й успішно зарекомендувала себе в професійному середовищі.</span>
                        </div>



                        <div class="mt-8" id="about-ecosystem-link-container">
                            <a href="{{ route('ecosystem') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition cursor-pointer" id="about-read-more-btn">
                                🐝 Детальніше про Екосистему
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section id="benefits" class="bg-[#fbf8ef] py-20 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Переваги</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">Чому обирають вулики з ППУ?</h2>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">Переваги матеріалу дають кращий результат для вас та ваших бджіл.</p>
                    </div>
                    <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($benefits as $benefit)
                            <article class="rounded-lg border border-[#e2d4ad] bg-white p-6 shadow-sm transition hover:border-[#b86f17]/60">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex size-12 items-center justify-center rounded-lg bg-[#f3ead3] text-[#b86f17]">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 2v20M4 10h16M6 18h12M8 6h8" /></svg>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-[#b86f17]">{{ $benefit['stat'] }}</div>
                                        <div class="text-xs text-[#766748]">{{ $benefit['label'] }}</div>
                                    </div>
                                </div>
                                <h3 class="mt-5 text-xl font-semibold">{{ $benefit['title'] }}</h3>
                                <p class="mt-3 leading-7 text-[#6d6045]">{{ $benefit['text'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>


            <section id="material" class="bg-[#f3ead3] py-20 lg:py-28">
                <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:gap-16 lg:px-8">
                    <div class="lg:order-2">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Матеріал</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">Що таке пінополіуретан?</h2>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">
                            Пінополіуретан (ППУ) відноситься до групи газонаповнених пластмас, на 85-90% складається з «повітря». Завдяки універсальним властивостям, ППУ отримав широке поширення практично у всіх сферах діяльності.
                        </p>
                        <p class="mt-4 text-lg leading-8 text-[#6d6045]">
                            Губки для миття посуду, наповнювачі для матраців, м'які меблі, дитячі іграшки і автомобільні сидіння - це все те, що оточує кожного з нас щодня.
                        </p>
                        <div class="mt-10 grid grid-cols-2 gap-4">
                            @foreach ($materialFacts as $fact)
                                <div class="rounded-lg border border-[#dccb9f] bg-white p-4">
                                    <div class="text-2xl font-bold text-[#b86f17]">{{ $fact['value'] }}</div>
                                    <div class="mt-1 text-sm text-[#766748]">{{ $fact['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lg:order-1">
                        <div class="relative aspect-square overflow-hidden rounded-lg">
                            <img src="{{ asset('images/ppu-material.jpg') }}" alt="Пінополіуретан - матеріал вуликів" class="size-full object-cover">
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/10"></div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="video" class="bg-white py-20 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Відео</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">Перегляньте наші матеріали</h2>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">Відео матеріали допоможуть краще зрозуміти переваги вуликів з пінополіуретану та дадуть відповіді на багато питань.</p>
                    </div>
                    <div class="mx-auto mt-12 max-w-4xl">
                        <div class="aspect-video w-full overflow-hidden rounded-lg border border-[#e2d4ad] shadow-lg">
                            <iframe 
                                class="size-full" 
                                src="https://www.youtube.com/embed/PN5ktKn3dTM" 
                                title="Огляд вуликів з ППУ" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </section>

            <section id="delivery" class="bg-[#fbf8ef] py-20 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Доставка та оплата</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">Зручні умови для вас</h2>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">Підберемо найзручніший варіант доставки саме для вас.</p>
                    </div>
                    <div class="mt-14 grid gap-8 lg:grid-cols-2">
                        <article class="rounded-lg border border-[#e2d4ad] bg-white p-6 shadow-sm">
                            <h3 class="text-2xl font-semibold">Служби доставки</h3>
                            <ul class="mt-6 grid gap-4">
                                @foreach ($deliveryMethods as $method)
                                    <li class="flex items-center gap-4 rounded-lg bg-[#f8f1df] p-4">
                                        <span class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-[#ead9ad] text-[#b86f17]">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M3 7h11v9H3zM14 10h4l3 3v3h-7z" /><circle cx="7" cy="18" r="2" /><circle cx="18" cy="18" r="2" /></svg>
                                        </span>
                                        <span>
                                            <span class="block font-semibold">{{ $method['name'] }}</span>
                                            <span class="text-sm text-[#766748]">{{ $method['description'] }}</span>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                        <article class="rounded-lg border border-[#e2d4ad] bg-white p-6 shadow-sm">
                            <h3 class="text-2xl font-semibold">Способи оплати</h3>
                            <div class="mt-6 grid gap-4">
                                <div class="rounded-lg bg-[#f8f1df] p-4">
                                    <div class="font-semibold">Післяплата</div>
                                    <div class="text-sm text-[#766748]">Оплата при отриманні</div>
                                </div>
                                <div class="rounded-lg bg-[#f8f1df] p-4">
                                    <div class="font-semibold">На карту</div>
                                    <div class="text-sm text-[#766748]">Передоплата на картку</div>
                                </div>
                                <div class="rounded-lg border border-[#d9bd77] bg-[#fff8e6] p-4">
                                    <div class="font-semibold">Швидка обробка замовлень</div>
                                    <div class="mt-1 text-sm text-[#766748]">Все від потреби клієнта - підберемо найзручніший варіант саме для вас.</div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="contacts" class="bg-[#f3ead3] py-20 lg:py-28">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-3xl text-center">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Контакти</span>
                        <h2 class="mt-4 font-serif text-3xl font-bold text-[#2f2718] sm:text-4xl lg:text-5xl">Зв'яжіться з нами</h2>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">Ми завжди раді допомогти вам з вибором та замовленням вуликів.</p>
                    </div>
                    <div class="mt-14 grid gap-8 lg:grid-cols-2">
                        <div class="grid gap-6">
                            <article class="rounded-lg border border-[#dccb9f] bg-white p-6">
                                <h3 class="text-xl font-semibold">ТМ Хімекселен</h3>
                                <p class="mt-5 font-medium">ФОП Остраухов Андрій Євгенович</p>
                                <p class="mt-4 text-sm leading-6 text-[#6d6045]">Україна, Полтавська область<br>39600, м. Кременчук<br>вул. Профспілкова, буд. 11</p>
                            </article>
                            <article class="rounded-lg border border-[#dccb9f] bg-white p-6">
                                <h3 class="text-lg font-semibold">Телефони</h3>
                                <div class="mt-4 grid gap-3">
                                    @foreach ($phones as $phone)
                                        <a href="tel:{{ str_replace(' ', '', $phone['number']) }}" class="flex items-center justify-between rounded-lg bg-[#f8f1df] p-3 transition hover:bg-[#f0dfb4]">
                                            <span>
                                                <span class="block font-semibold">{{ $phone['number'] }}</span>
                                                <span class="text-xs text-[#766748]">{{ $phone['label'] }}</span>
                                            </span>
                                            <span class="text-sm font-semibold text-[#b86f17]">Зателефонувати</span>
                                        </a>
                                    @endforeach
                                </div>
                            </article>
                            <article class="rounded-lg border border-[#dccb9f] bg-white p-6">
                                <h3 class="text-lg font-semibold">Email</h3>
                                <div class="mt-4 grid gap-3">
                                    @foreach ($emails as $item)
                                        <a href="mailto:{{ $item['email'] }}" class="flex items-center justify-between rounded-lg bg-[#f8f1df] p-3 transition hover:bg-[#f0dfb4]">
                                            <span>
                                                <span class="block font-semibold">{{ $item['email'] }}</span>
                                                <span class="text-xs text-[#766748]">{{ $item['label'] }}</span>
                                            </span>
                                            <span class="text-sm font-semibold text-[#b86f17]">Написати</span>
                                        </a>
                                    @endforeach
                                </div>
                            </article>
                        </div>
                        <div class="grid gap-6">
                            <div class="relative aspect-[4/3] overflow-hidden rounded-lg border border-[#dccb9f] bg-white">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d41234.69685851714!2d33.38!3d49.07!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d82d7c0f7b7817%3A0x5e0c8ae9d3f7bd1!2sKremenchuk%2C%20Poltava%20Oblast%2C%20Ukraine!5e0!3m2!1sen!2s!4v1" class="absolute inset-0 size-full" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Карта Кременчука"></iframe>
                            </div>
                            <article class="rounded-lg border border-[#d9bd77] bg-white p-6">
                                <h3 class="text-xl font-semibold">Готові замовити?</h3>
                                <p class="mt-2 text-[#6d6045]">Зателефонуйте нам або напишіть на email для консультації та оформлення замовлення.</p>
                                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                                    <a href="tel:+380503403547" class="flex-1 rounded-lg bg-[#b86f17] px-5 py-3 text-center font-semibold text-white transition hover:bg-[#97580f]">Зателефонувати</a>
                                    <a href="mailto:info@bee.lg.ua" class="flex-1 rounded-lg border border-[#cdbb8c] bg-white px-5 py-3 text-center font-semibold transition hover:bg-[#fbf8ef]">Написати</a>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        @include('partials.footer')

        <livewire:order-form />
        <livewire:contact-form />

        @fluxScripts
    </body>
</html>
