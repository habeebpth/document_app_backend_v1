@extends('layouts.master')

@section('content')
<div style="max-width: 600px; margin: 0 auto; text-align: center;">

    <h1 style="margin-bottom: 20px;">Edit User</h1>

    <form method="POST" action="{{ route('users.update', $user->id) }}" 
          style="width: 100%; background: #f8f9fa; padding: 25px; border-radius: 10px;">
        @csrf
        @method('PUT')

        <input type="text" 
               name="name" 
               value="{{ $user->name }}" 
               placeholder="Name"
               required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="email" 
               name="email" 
               value="{{ $user->email }}" 
               placeholder="Email"
               required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="password" 
               name="password" 
               placeholder="Password (leave blank to keep current)"
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="password" 
               name="password_confirmation" 
               placeholder="Confirm Password"
               style="width: 100%; padding: 10px; margin-bottom: 15px;">


 
            <input type="text" name="mobile_number" 
            placeholder="Mobile Number"  
            maxlength="10"      value="{{ $user->mobile_number }}" 
            pattern="\d{10}"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"        
            style="width: 100%; padding: 10px; margin-bottom: 15px;">

            <!-- <label>WhatsApp Number</label> -->
            <input type="text" name="whatsapp_number"    
            value="{{ $user->whatsapp_number }}" 
            placeholder="WhatsApp Number" 
            maxlength="10"
            pattern="\d{10}"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"        
            style="width: 100%; padding: 10px; margin-bottom: 15px;">




        <label style="font-weight: bold; display: block; margin-bottom: 10px;">Roles</label>

        <select name="roles[]" 
                multiple 
                required
                style="width: 100%; padding: 10px; height: 120px; margin-bottom: 20px;">
            @foreach($roles as $role)
                <option value="{{ $role->name }}" 
                    {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>

       <div style="display: flex; justify-content: space-between; gap: 10px;">

        <!-- UPDATE BUTTON -->
        <button type="submit"
                style="flex: 1; padding: 12px; background: #007bff; color: #fff; 
                       border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
            Update
        </button>

        <!-- CANCEL BUTTON (close modal) -->
       <button type="button"
        onclick="window.location='{{ route('users.index') }}'"
        style="flex: 1; padding: 12px; background: #6c757d; color: #fff; 
               border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
    Cancel
</button>


    </div>

    </form>

</div>
@endsection
