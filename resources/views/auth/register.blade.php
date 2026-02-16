<!-- Master Password -->
<div class="mt-4">
    <x-input-label for="master_password" :value="__('رمز اصلی (Master Password)')" />
    <x-text-input id="master_password" class="block mt-1 w-full"
                    type="password"
                    name="master_password"
                    required
                    minlength="8" />
    <p class="text-xs text-gray-500 mt-2">
        ⚠️ این رمز برای رمزنگاری اکانت‌های شما استفاده می‌شود. <strong>فراموشی آن = از دست دادن تمام داده‌ها!</strong>
    </p>
    <x-input-error :messages="$errors->get('master_password')" class="mt-2" />
</div>