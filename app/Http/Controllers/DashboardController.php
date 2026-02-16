<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $encryptionKey = session('encryption_key');

        if (!$encryptionKey) {
            return redirect()->route('master-password.show');
        }

        $stats = [
            'total' => $user->accounts()->count(),
            'social' => $user->accounts()->where('category', 'social')->count(),
            'bank' => $user->accounts()->where('category', 'bank')->count(),
            'weak' => 0,
        ];

        // شمارش رمزهای ضعیف
        $accounts = $user->accounts()->get();
        foreach ($accounts as $account) {
            $data = $account->getSensitiveData($encryptionKey);
            $password = $data['password'] ?? '';
            if ($this->isWeakPassword($password)) {
                $stats['weak']++;
            }
        }

        return view('dashboard', compact('stats'));
    }

    private function isWeakPassword(string $password): bool
    {
        $score = 0;
        if (strlen($password) > 8) $score++;
        if (strlen($password) > 12) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score++;

        return $score < 2;
    }
}