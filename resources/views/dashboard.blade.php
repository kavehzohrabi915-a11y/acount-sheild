<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('داشبورد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                    <div class="text-2xl font-bold text-purple-400">{{ $stats['total'] }}</div>
                    <div class="text-sm text-gray-400">کل اکانت‌ها</div>
                </div>
                <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                    <div class="text-2xl font-bold text-pink-400">{{ $stats['social'] }}</div>
                    <div class="text-sm text-gray-400">شبکه اجتماعی</div>
                </div>
                <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                    <div class="text-2xl font-bold text-emerald-400">{{ $stats['bank'] }}</div>
                    <div class="text-sm text-gray-400">مالی</div>
                </div>
                <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                    <div class="text-2xl font-bold {{ $stats['weak'] > 0 ? 'text-amber-400' : 'text-emerald-400' }}">
                        {{ $stats['weak'] }}
                    </div>
                    <div class="text-sm text-gray-400">رمز ضعیف</div>
                </div>
            </div>

            <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                <h3 class="text-lg font-medium text-gray-100 mb-4">دسترسی سریع</h3>
                <div class="flex gap-3">
                    <a href="{{ route('accounts.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm transition">
                        مشاهده اکانت‌ها
                    </a>
                    <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-sm transition">
                        افزودن اکانت
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>