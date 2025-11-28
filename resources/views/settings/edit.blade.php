@extends('layouts.master')

@section('content')
<div class="container">
    <h3>Company Settings</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $setting->company_name ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Company Address</label>
            <textarea name="company_address" class="form-control">{{ old('company_address', $setting->company_address ?? '') }}</textarea>
        </div>

     <div class="mb-3">
    <label>Phone Number</label>
    <input type="text" id="phone_number"
           name="phone_number"
           class="form-control"
           maxlength="10"
           value="{{ old('phone_number', $setting->phone_number ?? '') }}">
</div>

        <div class="mb-3">
            <label>Company Logo</label>
            <input type="file" name="company_logo" class="form-control">
           @if(!empty($setting->company_logo))
    <img src="{{ asset('storage/settings/' . basename($setting->company_logo)) }}" style="height: auto;
    width: 100px;">
@endif

        </div>


        
        <div class="mb-3">
            <label>Background Image</label>
            <input type="file" name="background_image" class="form-control">
            @if(!empty($setting->background_image))
                <img src="{{ asset('storage/settings/' . basename($setting->background_image)) }}" alt="Background" style="height: auto;
    width: 100px; margin-top:10px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>

<script>
document.getElementById('phone_number').addEventListener('input', function () {
    // Allow only digits
    this.value = this.value.replace(/[^0-9]/g, '');

    // Limit to 10 digits
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});
</script>
@endsection
