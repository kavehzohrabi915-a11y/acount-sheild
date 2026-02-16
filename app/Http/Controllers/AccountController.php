<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private EncryptionService $encryptionService;

    public function __construct(EncryptionService $encryptionService)
    {
        $this->middleware(['auth', 'master.password']);
        $this->encryptionService = $encryptionService;
    }

    public function index()
    {
        $user = Auth::user();
        $encryptionKey = session('encryption_key');

        $accounts = $user->accounts()->latest()->get()->map(function ($account) use ($encryptionKey) {
            $data = $account->getSensitiveData($encryptionKey);
            return [
                'id' => $account->id,
                'site_name' => $account->site_name,
                'category' => $account->category,
                'site_url' => $account->site_url,
                'username' => $data['username'] ?? '',
                'password' => $data['password'] ?? '',
                'notes' => $data['notes'] ?? '',
                'created_at' => $account->created_at,
                'updated_at' => $account->updated_at,
            ];
        });

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'category' => 'required|in:social,email,bank,work,shopping,other',
            'site_url' => 'nullable|url|max:500',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $encryptionKey = session('encryption_key');

        $account = new Account([
            'user_id' => Auth::id(),
            'site_name' => $validated['site_name'],
            'category' => $validated['category'],
            'site_url' => $validated['site_url'],
        ]);

        $account->setSensitiveData([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'notes' => $validated['notes'] ?? '',
        ], $encryptionKey);

        $account->save();

        return redirect()->route('accounts.index')->with('success', 'اکانت ذخیره شد.');
    }

    public function edit(Account $account)
    {
        $this->authorize('update', $account);
        $encryptionKey = session('encryption_key');
        $data = $account->getSensitiveData($encryptionKey);

        $account->username = $data['username'] ?? '';
        $account->password = $data['password'] ?? '';
        $account->notes = $data['notes'] ?? '';

        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, Account $account)
    {
        $this->authorize('update', $account);

        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'category' => 'required|in:social,email,bank,work,shopping,other',
            'site_url' => 'nullable|url|max:500',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:500',
            'notes' => 'nullable|string',
        ]);

        $encryptionKey = session('encryption_key');

        $account->update([
            'site_name' => $validated['site_name'],
            'category' => $validated['category'],
            'site_url' => $validated['site_url'],
        ]);

        $account->setSensitiveData([
            'username' => $validated['username'],
            'password' => $validated['password'],
            'notes' => $validated['notes'] ?? '',
        ], $encryptionKey);

        $account->save();

        return redirect()->route('accounts.index')->with('success', 'اکانت به‌روزرسانی شد.');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'اکانت حذف شد.');
    }
}