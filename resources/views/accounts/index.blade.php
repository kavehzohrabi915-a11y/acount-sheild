<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">اکانت‌ها</h2>
            <a href="{{ route('accounts.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-sm text-white">
                افزودن اکانت
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-emerald-500/20 text-emerald-400 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($accounts as $account)
                <div class="bg-slate-800/50 p-5 rounded-lg border border-white/10">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg">{{ $account['site_name'] }}</h3>
                            <p class="text-xs text-gray-400">{{ $account['category'] }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('accounts.edit', $account['id']) }}" class="text-blue-400 hover:text-blue-300">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('accounts.destroy', $account['id']) }}" method="POST" class="inline" onsubmit="return confirm('حذف شود؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between bg-slate-900/50 p-2 rounded">
                            <span class="text-sm text-gray-300">{{ $account['username'] }}</span>
                            <button onclick="copy('{{ addslashes($account['username']) }}')" class="text-purple-400 text-sm">
                                کپی
                            </button>
                        </div>
                        <div class="flex justify-between bg-slate-900/50 p-2 rounded">
                            <span class="text-sm text-gray-300 font-mono" id="pass-{{ $account['id'] }}">••••••••</span>
                            <div class="flex gap-2">
                                <button onclick="togglePass('{{ $account['id'] }}', '{{ addslashes($account['password']) }}')" class="text-gray-400 text-sm">
                                    نمایش
                                </button>
                                <button onclick="copy('{{ addslashes($account['password']) }}')" class="text-purple-400 text-sm">
                                    کپی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    هیچ اکانتی نیست
                </div>
                @endforelse
            </div>

        </div>
    </div>

    <script>
    function copy(text) {
        navigator.clipboard.writeText(text);
        alert('کپی شد!');
    }
    
    function togglePass(id, pass) {
        const el = document.getElementById('pass-' + id);
        el.textContent = el.textContent === '••••••••' ? pass : '••••••••';
    }
    </script>
</x-app-layout>