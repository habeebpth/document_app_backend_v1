<?php $__env->startSection('content'); ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tag List</h5>
        <button class="btn btn-success" id="createNewTag">Add Tag</button>
      </div>

  <div class="card-body">
    <table id="tags-table" class="table table-bordered table-striped align-middle nowrap w-100">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>


  </div>
</div>

<!-- Tag Modal -->

<div class="modal fade" id="tagModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="tagForm">
        <?php echo csrf_field(); ?>
        <input type="hidden" id="tag_id" name="tag_id">

    <div class="modal-header">
      <h5 class="modal-title">Tag</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary" id="saveTagBtn">Save</button>
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
  let table = $('#tags-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: "<?php echo e(route('tags.index')); ?>",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ]
  });

  // Add new tag
  $('#createNewTag').click(function () {
    $('#tagForm')[0].reset();
    $('#tag_id').val('');
    $('#tagModal').modal('show');
  });

  // Submit form (Add/Edit)
  $('#tagForm').on('submit', function (e) {
    e.preventDefault();
    let id = $('#tag_id').val();
    let url = id ? `/tags/${id}` : "<?php echo e(route('tags.store')); ?>";

    $.ajax({
      url: url,
      type: 'POST',
      data: $(this).serialize() + (id ? '&_method=PUT' : ''),
      success: function (res) {
        $('#tagModal').modal('hide');
        $('#tagForm')[0].reset();
        table.ajax.reload(null, false);
        Swal.fire('Success', res.message || 'Tag saved successfully', 'success');
      },
      error: function (xhr) {
        let msg = xhr.responseJSON?.message || 'Something went wrong.';
        Swal.fire('Error', msg, 'error');
      }
    });
  });

  // Edit tag
  $('body').on('click', '.editTagBtn', function () {
    let id = $(this).data('id');
    $.get(`/tags/${id}/edit`, function (data) {
      $('#tag_id').val(data.id);
      $('#name').val(data.name);
      $('#tagModal').modal('show');
    }).fail(function () {
      Swal.fire('Error!', 'Failed to fetch tag details.', 'error');
    });
  });

  // Delete tag
  $('body').on('click', '.deleteTagBtn', function () {
    let id = $(this).data('id');
    Swal.fire({
      title: 'Are you sure?',
      text: 'This will delete the tag permanently.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `/tags/${id}`,
          type: 'DELETE',
          data: { _token: $('meta[name="csrf-token"]').attr('content') },
          success: function () {
            table.ajax.reload(null, false);
            Swal.fire('Deleted!', 'Tag deleted successfully.', 'success');
          },
          error: function () {
            Swal.fire('Error!', 'Unable to delete tag.', 'error');
          }
        });
      }
    });
  });

});
</script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/tags/index.blade.php ENDPATH**/ ?>