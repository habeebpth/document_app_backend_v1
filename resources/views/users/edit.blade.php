@extends('layouts.app')
@section('content')
<h1>Edit User</h1>
<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{ $user->name }}" required><br>
    <input type="email" name="email" value="{{ $user->email }}" required><br>
    <input type="password" name="password" placeholder="Password (leave blank to keep current)"><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password"><br>

    <label>Roles</label>
    <select name="roles[]" multiple required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}" 
                {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select><br>

    <button type="submit">Update</button>
</form>
@endsection
