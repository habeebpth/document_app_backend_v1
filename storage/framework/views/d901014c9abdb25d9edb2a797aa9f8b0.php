<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Category List</h5>
        <button class="btn btn-success" id="createNew">Add Category</button>
      </div>

      <div class="card-body">
        <table id="categories-table" class="table table-bordered table-striped align-middle nowrap w-100">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="categoryForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="category_id" name="category_id">

        <div class="modal-header">
          <h5 class="modal-title">Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status2" class="form-control" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(function () {

  // CSRF token setup
  $.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  // Initialize DataTable
  let table = $('#categories-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: "<?php echo e(route('categories.index')); ?>",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ]
  });

  // Add new category
  $('#createNew').click(function () {
    $('#categoryForm')[0].reset();
    $('#category_id').val('');
    $('#categoryModal').modal('show');
  });

  // Submit form (Add/Edit)
  $('#categoryForm').on('submit', function (e) {
    e.preventDefault();
    let id = $('#category_id').val();
    let url = id ? `/categories/${id}` : "<?php echo e(route('categories.store')); ?>";

    $.ajax({
      url: url,
      type: 'POST',
      data: $(this).serialize() + (id ? '&_method=PUT' : ''),
      success: function (res) {
        $('#categoryModal').modal('hide');
        $('#categoryForm')[0].reset();
        table.ajax.reload(null, false);
        Swal.fire('Success', res.message || 'Category saved successfully', 'success');
      },
      error: function (xhr) {
        let msg = xhr.responseJSON?.message || 'Something went wrong.';
        Swal.fire('Error', msg, 'error');
      }
    });
  });

  // Edit category
  $('body').on('click', '.editBtn', function () {
    let id = $(this).data('id');
    $.get(`/categories/${id}/edit`, function (data) {
      $('#category_id').val(data.id);
      $('#name').val(data.name);
      $('#status').val(data.status);
      $('#categoryModal').modal('show');
    }).fail(function () {
      Swal.fire('Error!', 'Failed to fetch category details.', 'error');
    });
  });

  // Delete category
  $('body').on('click', '.deleteBtn', function () {
    let id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This will delete the category permanently.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/categories/${id}`,
          type: 'DELETE',
          data: { _token: $('meta[name="csrf-token"]').attr('content') },
          success: function () {
            table.ajax.reload(null, false);
            Swal.fire('Deleted!', 'Category deleted successfully.', 'success');
          },
          error: function () {
            Swal.fire('Error!', 'Unable to delete category.', 'error');
          }
        });
      }
    });
  });

});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/categories/index.blade.php ENDPATH**/ ?>