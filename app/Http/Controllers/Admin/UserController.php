<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\InteractsWithResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    use InteractsWithResource;

    public function index(): View
    {
        $items = User::orderBy('name')->paginate(15);

        return view('admin.users.index', compact('items'));
    }

    public function create(): View
    {
        return view('admin.users.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['superadmin', 'admin', 'editor'])],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['required', 'boolean'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['avatar'] = $this->storeFile($request, 'avatar', 'avatars');

        User::create($data);

        return redirect()->route('panel.users.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.form', ['item' => $user]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['superadmin', 'admin', 'editor'])],
            'avatar' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['required', 'boolean'],
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['avatar'] = $this->storeFile($request, 'avatar', 'avatars', $user->avatar);

        $user->update($data);

        return redirect()->route('panel.users.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->id === $user->id) {
            return redirect()->route('panel.users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('panel.users.index')->with('success', 'Admin berhasil dihapus.');
    }
}
