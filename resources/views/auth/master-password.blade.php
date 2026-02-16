<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-purple-600 to-blue-600">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-slate-900/80 backdrop-blur-lg shadow-md overflow-hidden sm:rounded-lg border border-white/10">
            
            <div class="mb-6 text-center">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-2xl text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-white">ورود رمز اصلی</h2>
                <p class="text-sm text-gray-400 mt-2">برای دسترسی به اکانت‌ها، رمز اصلی را وارد کنید</p>
            </div>

            <form method="POST" action="{{ route('master-password.verify') }}">
                @csrf
                <input type="hidden" name="redirect" value="{{ $redirect }}">

                <div>
                    <x-input-label for="master_password" :value="__('رمز اصلی')" class="text-gray-300" />
                    <x-text-input id="master_password" class="block mt-1 w-full bg-slate-800/50 border-slate-600 text-white" 
                        type="password" 
                        name="master_password" 
                        required 
                        autofocus />
                    <x-input-error :messages="$errors->get('master_password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="bg-purple-600 hover:bg-purple-700">
                        {{ __('ورود') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>