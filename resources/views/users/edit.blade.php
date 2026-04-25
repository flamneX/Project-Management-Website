@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">

<div class="users-form-container">
    <div class="form-header">
        <h1>Edit user</h1>
        <p>Update user details.</p>
    </div>

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

        <div class="form-actions">
            <button type="submit" class="btn-submit">Save Changes</button>
            <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
