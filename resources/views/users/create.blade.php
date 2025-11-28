@extends('layouts.app')
@section('content')
<h1>Create User</h1>
<form method="POST" action="{{ route('users.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required><br>

    <label>Roles</label>
    <select name="roles[]" multiple required>
        @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select><br>

    <button type="submit">Create</button>
</form>
@endsection
