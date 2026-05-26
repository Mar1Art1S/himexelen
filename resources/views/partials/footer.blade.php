<footer class="bg-[#2f2718] text-[#fbf8ef] border-t border-[#3e3422]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 py-12 lg:grid-cols-4 lg:py-16">
            <div>
                <div class="flex items-center gap-3">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-[#b86f17] text-white">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path d="M12 2 2 7l10 5 10-5-10-5ZM2 12l10 5 10-5M2 17l10 5 10-5" />
                        </svg>
                    </span>
                    <span class="flex flex-col leading-tight">
                        <span class="text-lg font-bold">Хімекселен</span>
                        <span class="text-xs text-white/60">Вулики з ППУ</span>
                    </span>
                </div>
                <p class="mt-4 text-sm leading-6 text-white/70">Вулики з пінополіуретану нового покоління. Легкі, довговічні та енергоефективні.</p>
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
                    <li><a href="mailto:director@himpost.com" class="transition hover:text-[#e6a83c]">director@himpost.com</a></li>
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
