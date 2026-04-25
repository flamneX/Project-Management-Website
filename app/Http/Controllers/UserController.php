<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

    public function edit(User $oUser)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('update', $user);

        $project->load('users');

        $users = User::where('role', '!=', 'admin')
            ->orderBy('name')
            ->get(['id', 'name']);

        $assignedUserIds = $project->users->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'users', 'assignedUserIds'));
    }

    public function update(Request $request, Project $project)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Gate::authorize('update', $project);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:1000'],
            'users' => ['nullable', 'array'],
            'users.*' => ['exists:users,id'],
        ], [
            'title.required' => 'The project title is required.',
            'description.required' => 'The project description is required.',
            'users.*.exists' => 'One or more selected users do not exist.',
        ]);

        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        if (isset($validated['users'])) {
            $project->users()->sync($validated['users']);
        } else {
            $project->users()->detach();
        }

        return redirect()->route('projects.index', $project)
            ->with('success', 'Project updated successfully.');
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
