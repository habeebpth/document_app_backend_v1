

<?php $__env->startSection('styles'); ?>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" rel="stylesheet">

<style>
    /* MODAL OVERLAY */
    #roleModal {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.55);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* MODAL BOX – SMALL / CENTERED */
    #roleModal .modal-content {
        width: 300px;
        background: #fff;
        padding: 20px 25px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* INPUT FULL WIDTH INSIDE MODAL */
    #roleModal input {
        width: 100%;
        margin-top: 8px;
        margin-bottom: 15px;
    }

    .modal-button-group {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
    }

    .create-btn {
        background: #007bff;
        padding: 10px 20px;
        color: #fff;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .create-btn:hover {
        background: #0056b3;
    }

    .delete-btn {
        background: #dc3545;
        padding: 6px 12px;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .delete-btn:hover {
        background: #a11928;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Roles List</h5>
        <button class="btn btn-success" id="btnAddRole">Add New Role</button>
      </div>

      <div class="card-body">
        <table id="roles-table" class="table table-bordered table-striped align-middle nowrap w-100">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Role Name</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="roleModal">
    <div class="modal-content" style="width: 400px; margin: 0 auto; top: 90px; padding: 25px;height:250px;">
        <h3 id="modalTitle">Add Role</h3>

        <input type="hidden" id="role_id">

        <label>Role Name</label>
        <input type="text" id="role_name" class="form-control" placeholder="Enter Role Name">

       <div class="modal-button-group" style="margin-top:20px; display: flex; justify-content: center; gap: 20px;">
    <button id="saveRole" class="create-btn">Save</button>
    <button id="closeModal" class="delete-btn">Close</button>
</div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {

    // --------------------------
    // CSRF Setup
    // --------------------------
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // --------------------------
    // DataTable
    // --------------------------
    let table = $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "<?php echo e(route('roles.index')); ?>",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    const modal = document.getElementById("roleModal");

    // --------------------------
    // OPEN CREATE MODAL
    // --------------------------
    $('#btnAddRole').click(function() {
        $('#modalTitle').text("Add Role");
        $('#role_id').val("");
        $('#role_name').val("");
        modal.style.display = "flex";
    });

    // --------------------------
    // CLOSE MODAL
    // --------------------------
    $('#closeModal').click(function() {
        modal.style.display = "none";
    });

    // --------------------------
    // SAVE ROLE (CREATE + UPDATE)
    // --------------------------
    $('#saveRole').click(function() {
        let id = $('#role_id').val();
        let name = $('#role_name').val();

        if(name === "") {
            Swal.fire("Error", "Role name is required", "error");
            return;
        }

        const url = id ? `/roles/${id}` : `/roles`;
        const method = id ? "PUT" : "POST";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name: name,
                _method: method,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data.status) {
                    modal.style.display = "none";
                    table.ajax.reload(null, false);
                    Swal.fire("Success", data.message, "success");
                }
            },
            error: function(err) {
                Swal.fire('Error', err.responseJSON?.message || 'Something went wrong.', 'error');
            }
        });
    });

    // --------------------------
    // EDIT ROLE
    // --------------------------
    $('body').on('click', '.editRole', function() {
        let id = $(this).data('id');

        $.get(`/roles/${id}/edit`, function(role) {
            $('#modalTitle').text("Edit Role");
            $('#role_id').val(role.id);
            $('#role_name').val(role.name);
            modal.style.display = "flex";
        });
    });

    // --------------------------
    // DELETE ROLE
    // --------------------------
    $('body').on('click', '.deleteRole', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "This role will be deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel"
        }).then(result => {
            if(result.isConfirmed) {
                $.ajax({
                    url: `/roles/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        table.ajax.reload(null, false);
                        Swal.fire("Deleted", data.message, "success");
                    },
                    error: function(err) {
                        Swal.fire('Error', err.responseJSON?.message || 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/roles/index.blade.php ENDPATH**/ ?>