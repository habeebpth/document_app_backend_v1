@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Assign Roles to Users</h2>

    <div class="mb-3">
        <label>Select User</label>
        <select id="userSelect" class="form-control">
            <option value="">-- Select User --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3" id="rolesContainer" style="display:none;">
        <label>Roles</label>
        <select id="rolesSelect" class="form-control" multiple>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <button id="saveRolesBtn" class="btn btn-primary" style="display:none;">Save Roles</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function(){
    $('#rolesSelect').select2({placeholder:"Select roles"});

    $('#userSelect').change(function(){
        let userId = $(this).val();
        if(userId){
            $.get(`/admin/user-roles/${userId}`, function(data){
                $('#rolesSelect').val(data).trigger('change');
                $('#rolesContainer, #saveRolesBtn').show();
            });
        }else{
            $('#rolesContainer, #saveRolesBtn').hide();
        }
    });

    $('#saveRolesBtn').click(function(){
        let userId = $('#userSelect').val();
        let roles = $('#rolesSelect').val();

        $.ajax({
            url: `/admin/user-roles/${userId}`,
            type: 'POST',
            data: {
                roles: roles,
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                alert(res.message);
            }
        });
    });
});
</script>
@endsection
