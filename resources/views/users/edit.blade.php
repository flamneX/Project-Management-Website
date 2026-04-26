@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">

<div class="users-form-container">

    <div class="form-header">
        <h1>Edit User</h1>
        <p>Update user details.</p>
    </div>

    @if(session('success'))
        <div style="margin-bottom:15px; padding:10px; background:#d4edda; color:#155724; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error-alert">
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.update', $oUser) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">User Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $oUser->name) }}" required placeholder="e.g. Bob">
        </div>
        <div class="form-group">
            <label for="email">User Email</label>
            <input id="email" type="text" name="email" value="{{ old('email', $oUser->email) }}" required placeholder="e.g. bob@example.com">
        </div>

        @if ($user->id != $oUser->id)
        <div class="form-group">
            <label>User Role</label>
            <div class="users-checkboxes">
                <div class="user-checkbox">
                    <input id="admin" type="radio" name="role" value="admin" {{ (string)($oUser->role) === 'admin' ? 'checked' : '' }} required>
                    <label for="admin">Admin</label>
                </div>
                <div class="user-checkbox">
                    <input id="user" type="radio" name="role" value="user" {{ (string)($oUser->role) === 'user' ? 'checked' : '' }}>
                    <label for="user">User</label>
                </div>
            </div>
        </div>
        @else
            <input type="radio" name="role" value="{{ $oUser->role }}" checked hidden>
        @endif

        <div class="form-actions">
            <button type="submit" class="btn-submit">Save Changes</button>
            <a href="{{ route('users.updatePassword', $oUser) }}" class="btn-password">Update Password</a>
            <a href="{{ route(($user->role === 'admin') ? 'users.index' : 'home') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
