<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EncryptionService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'master_password' => ['required', 'string', 'min:8', 'different:password'],
        ]);

        // سرویس رمزنگاری
        $encryptionService = new EncryptionService();

        // ساخت کلید رمزنگاری برای کاربر
        $userKey = $encryptionService->generateUserKey();
        
        // رمزنگاری کلید با رمز اصلی
        $encryptedUserKey = $encryptionService->encryptUserKey($userKey, $request->master_password);

        // ساخت کاربر
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'master_key_hash' => $encryptionService->hashMasterPassword($request->master_password),
            'encryption_key' => $encryptedUserKey,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ذخیره کلید رمزنگاری در session
        session(['encryption_key' => $userKey]);

        return redirect(route('dashboard', absolute: false));
    }
}