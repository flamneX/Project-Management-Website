@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">

<div class="users-form-container">
    <div class="form-header">
        <h1>Update Password</h1>
        <p>Set new password for user.</p>
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

    <form method="POST" action="{{ route('users.savePassword', $oUser) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="password">New Password</label>
            <input id="password" type="password" name="password" value="" required placeholder="Password">
        </div>

        <div class="form-group">
            <label for="confirm-password">Confirm User Password</label>
            <input id="confirm-password" type="password" name="confirm-password" value="" required placeholder="Password Confirmation">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">Update Password</button>
            <a href="{{ route('users.edit', $oUser) }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
