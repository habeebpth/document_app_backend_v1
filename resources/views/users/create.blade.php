@extends('layouts.master')

@section('content')

<style>
    .create-user-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 25px;
        border-radius: 10px;
        background: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 25px;
    }

    .create-user-container input,
    .create-user-container select {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .create-user-container label {
        font-weight: bold;
        margin-bottom: 6px;
        display: block;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background: #0056b3;
    }
</style>

<div class="create-user-container">

    <h1>Create User</h1>

    <form method="POST" action="{{ route('users.store') }}">
        @csrf

        <label>Name</label>
        <input type="text" name="name" placeholder="Name" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" required>

        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

        <label>Roles</label>
        <select name="roles[]" multiple required>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="submit-btn">Create User</button>

    </form>

</div>

@endsection
