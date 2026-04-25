<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('viewAny', User::class);

        if ($user->role === 'admin') {
            $users = User::where('id', '!=', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            redirect('home');
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('create', User::class);

        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')],
            'password' => ['required', 'string', 'max:255', 'min:6', "same:confirm-password"],
            'role' => ['required']
        ], [
            'name.required' => 'The user name is required.',
            'email.required' => 'The user email is required.',
            'password.required' => "The user password is required.",
            'password.same' => "The confirmation password does not match.",
            'role.required' => 'The user role is required.',
        ]);

        $oUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Users created successfully.');
    }

    public function edit(User $oUser)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('update', $user);

        return view('users.edit', compact('oUser'));
    }

    public function update(Request $request, User $oUser)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($oUser->id)],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users')->ignore($oUser->id)],
            'role' => ['required'],
        ], [
            'name.required' => 'The user name is required.',
            'email.required' => 'The user email is required.',
            'role.required' => 'The user role is required',
        ]);

        $oUser->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $oUser)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('delete', $user);

        $oUser->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
