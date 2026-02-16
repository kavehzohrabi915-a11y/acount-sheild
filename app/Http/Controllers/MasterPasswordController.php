<?php

namespace App\Http\Controllers;

use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MasterPasswordController extends Controller
{
    private EncryptionService $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }

    public function show(Request $request)
    {
        return view('auth.master-password', [
            'redirect' => $request->get('redirect', route('dashboard'))
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'master_password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!$this->encryptionService->verifyMasterPassword($request->master_password, $user->master_key_hash)) {
            throw ValidationException::withMessages([
                'master_password' => 'رمز اصلی نادرست است.',
            ]);
        }

        $encryptionKey = $this->encryptionService->decryptUserKey(
            $user->encryption_key, 
            $request->master_password
        );

        if (!$encryptionKey) {
            throw ValidationException::withMessages([
                'master_password' => 'خطا در رمزگشایی.',
            ]);
        }

        session(['encryption_key' => $encryptionKey]);

        return redirect($request->get('redirect', route('dashboard')));
    }
}