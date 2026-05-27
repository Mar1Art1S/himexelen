<footer class="bg-[#2f2718] text-[#fbf8ef] border-t border-[#3e3422]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 py-12 lg:grid-cols-4 lg:py-16">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Логотип Хімекселен" class="h-10 w-auto object-contain">
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-white/60">Вулики з ППУ</span>
                    </span>
                </div>
                <p class="mt-4 text-sm leading-6 text-white/70">Вулики з пінополіуретану нового покоління. Легкі, довговічні та енергоефективні.</p>
                <div class="mt-6 flex flex-col gap-2.5">
                    <a href="https://himpost.com/" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#b86f17]/20 border border-[#b86f17]/40 px-4 py-2 text-xs font-semibold text-[#fbf8ef] transition hover:bg-[#b86f17] hover:border-[#b86f17] w-full">
                        <span>ПП Хімпостачальник</span>
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://techpolymersmarket.com/" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#b86f17]/20 border border-[#b86f17]/40 px-4 py-2 text-xs font-semibold text-[#fbf8ef] transition hover:bg-[#b86f17] hover:border-[#b86f17] w-full">
                        <span>Техполімер Маркет</span>
                        <svg class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider">Навігація</h3>
                <ul class="mt-4 grid gap-3">
                    @foreach ($navigation as $item)
                        <li><a href="{{ $item['href'] }}" class="text-sm text-white/70 transition hover:text-[#e6a83c]">{{ $item['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider">Контакти</h3>
                <ul class="mt-4 grid gap-3 text-sm text-white/70">
                    <li><a href="tel:+380503403547" class="transition hover:text-[#e6a83c]">+38 050 340 35 47</a></li>
                    <li><a href="mailto:info@bee.lg.ua" class="transition hover:text-[#e6a83c]">info@bee.lg.ua</a></li>
                    <li>м. Кременчук, Полтавська обл.</li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold uppercase tracking-wider">Графік роботи</h3>
                <div class="mt-4 grid gap-2 text-sm text-white/70">
                    <p>Пн - Пт: 9:00 - 18:00</p>
                    <p>Сб: 9:00 - 14:00</p>
                    <p>Нд: Вихідний</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col items-center justify-between gap-4 border-t border-white/10 py-6 text-sm text-white/60 sm:flex-row">
            <p>© {{ date('Y') }} ТМ «Хімекселен». Всі права захищено.</p>
            <p>ПП Хімпостачальник</p>
        </div>
    </div>
</footer>
