@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">

<div class="users-form-container">
    <div class="form-header">
        <h1>Create user</h1>
        <p>Create new user.</p>
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

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="name">User Name</label>
            <input id="name" type="text" name="name" value="" required placeholder="e.g. Bob">
        </div>

        <div class="form-group">
            <label for="email">User Email</label>
            <input id="email" type="text" name="email" value="" required placeholder="e.g. bob@example.com">
        </div>

        <div class="form-group">
            <label for="password">User Password</label>
            <input id="password" type="password" name="password" value="" required>
        </div>

        <div class="form-group">
            <label for="confirm-password">Confirm User Password</label>
            <input id="confirm-password" type="password" name="confirm-password" value="" required>
        </div>

        <div class="form-group">
            <label>User Role</label>
            <div class="users-checkboxes">
                <div class="user-checkbox">
                    <input id="admin" type="radio" name="role" value="admin" required >
                    <label for="admin">Admin</label>
                </div>
                <div class="user-checkbox">
                    <input id="user" type="radio" name="role" value="user" >
                    <label for="user">User</label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Create User</button>
            <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
