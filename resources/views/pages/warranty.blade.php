<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => 'Гарантія'])
        <meta name="description" content="Гарантійні зобов'язання та умови обміну вуликів ТМ Хімекселен.">
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
                ['name' => 'Контакти', 'href' => route('home').'#contacts'],
            ];
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
                                <button @click="open = !open" class="flex items-center gap-1 text-sm font-medium transition hover:text-[#b86f17] focus:outline-hidden cursor-pointer text-[#b86f17] font-semibold">
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
                                'text-[#b86f17] font-semibold' => request()->url() === $item['href'],
                                'text-[#6d6045]' => request()->url() !== $item['href']
                            ])>{{ $item['name'] }}</a>
                        @endif
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
            <section class="bg-white py-16 sm:py-20 border-b border-[#e3d7b6]">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="max-w-3xl">
                        <span class="text-sm font-semibold uppercase tracking-wider text-[#b86f17]">Якість та надійність</span>
                        <h1 class="mt-4 font-serif text-4xl font-bold leading-tight sm:text-5xl text-[#2f2718]">Гарантійні зобов'язання</h1>
                        <p class="mt-6 text-lg leading-8 text-[#6d6045]">
                            Вулики ТМ Хімекселен створені для тривалої та надійної роботи. Ми гарантуємо високу якість матеріалів та технології виробництва.
                        </p>
                    </div>
                </div>
            </section>

            <section class="py-16 sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                        <!-- Quality & Material Guarantee -->
                        <div class="rounded-3xl border border-[#e2d4ad] bg-[#fffdfa] p-8 shadow-xs">
                            <h2 class="font-serif text-2xl font-bold text-[#2f2718] mb-6 flex items-center gap-2">
                                <span class="text-3xl">🛡️</span> Гарантія якості
                            </h2>
                            <div class="space-y-6">
                                <div class="border-b border-[#e3d7b6]/60 pb-6">
                                    <h3 class="font-semibold text-lg text-[#2f2718]">Офіційна гарантія виробника</h3>
                                    <p class="text-sm text-[#6d6045] mt-2">Ми надаємо офіційну гарантію на цілісність конструкції та стійкість матеріалу при дотриманні правил експлуатації.</p>
                                </div>
                                <div class="border-b border-[#e3d7b6]/60 pb-6">
                                    <h3 class="font-semibold text-lg text-[#2f2718]">Стійкість матеріалу</h3>
                                    <p class="text-sm text-[#6d6045] mt-2">Пінополіуретан (ППУ) сертифікований для контакту з харчовими продуктами. Він стійкий до грибків, плісняви, бджіл та гризунів. Продукція зберігає форму та геометричні розміри протягом усього терміну служби.</p>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg text-[#2f2718]">Термін служби 30+ років</h3>
                                    <p class="text-sm text-[#6d6045] mt-2">Завдяки унікальній технології формування з утворенням твердої зовнішньої інтегральної кірки, вулики здатні служити десятки років без втрати своїх унікальних теплоізоляційних властивостей.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Exchange & Returns -->
                        <div class="rounded-3xl border border-[#e2d4ad] bg-[#fffdfa] p-8 shadow-xs flex flex-col justify-between">
                            <div>
                                <h2 class="font-serif text-2xl font-bold text-[#2f2718] mb-6 flex items-center gap-2">
                                    <span class="text-3xl">🔄</span> Обмін та повернення
                                </h2>
                                <div class="space-y-6">
                                    <div class="border-b border-[#e3d7b6]/60 pb-6">
                                        <h3 class="font-semibold text-lg text-[#2f2718]">14 днів для повернення</h3>
                                        <p class="text-sm text-[#6d6045] mt-2">Відповідно до законодавства України, ви можете повернути або обміняти придбаний товар протягом 14 днів з моменту отримання, якщо він не був у використанні та зберіг свій первинний вигляд і товарний вид.</p>
                                    </div>
                                    <div class="border-b border-[#e3d7b6]/60 pb-6">
                                        <h3 class="font-semibold text-lg text-[#2f2718]">Заміна у разі браку</h3>
                                        <p class="text-sm text-[#6d6045] mt-2">Перед відправкою кожна деталь проходить контроль якості. У випадку виявлення прихованого заводського браку, ми зробимо безкоштовну заміну деталі.</p>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-lg text-[#2f2718]">Пошкодження під час доставки</h3>
                                        <p class="text-sm text-[#6d6045] mt-2">Будь ласка, перевіряйте цілісність посилки безпосередньо у відділенні перевізника. У разі виявлення пошкоджень складіть акт разом із працівником служби доставки для відшкодування шкоди.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 p-6 rounded-2xl bg-[#fffcf5] border border-[#f3ead3] text-sm text-[#766748] font-medium flex items-center gap-4">
                                <span class="text-2xl">💡</span>
                                <span>Ми дбаємо про вашу довіру та репутацію нашого бренду. Виникли питання щодо гарантії? Ми завжди на зв'язку та готові допомогти!</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <button onclick="Livewire.dispatch('openContactForm')" type="button" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#b86f17] px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-[#97580f] transition cursor-pointer">
                            Зв'язатися з відділом якості
                        </button>
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
