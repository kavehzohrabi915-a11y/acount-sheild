<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100">افزودن اکانت</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800/50 p-6 rounded-lg border border-white/10">
                
                <form method="POST" action="{{ route('accounts.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">نام سایت *</label>
                        <input type="text" name="site_name" required class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">دسته‌بندی</label>
                        <select name="category" class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2">
                            <option value="social">شبکه اجتماعی</option>
                            <option value="email">ایمیل</option>
                            <option value="bank">مالی</option>
                            <option value="work">کاری</option>
                            <option value="shopping">خرید</option>
                            <option value="other">سایر</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">آدرس سایت</label>
                        <input type="url" name="site_url" class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2 text-left">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">نام کاربری *</label>
                        <input type="text" name="username" required class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2 text-left">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">رمز عبور *</label>
                        <input type="password" name="password" required class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2 text-left">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-300 mb-1">یادداشت</label>
                        <textarea name="notes" rows="3" class="w-full bg-slate-900/50 border-slate-600 rounded-lg text-white p-2"></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('accounts.index') }}" class="px-4 py-2 bg-slate-700 rounded-lg">انصراف</a>
                        <button type="submit" class="px-4 py-2 bg-purple-600 rounded-lg">ذخیره</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>