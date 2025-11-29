@extends('layouts.master')

@section('styles')

<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Documents List</h5>
        <button class="btn btn-success" id="createNewDoc">Add Document</button>
      </div>


  <div class="card-body">
    <table id="documents-table" class="table table-bordered table-striped align-middle nowrap w-100">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Category</th>
          <th>Subject</th>
          <th>Title</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>


  </div>
</div>

<!-- Document Modal -->

<div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="documentForm">
        @csrf
        <input type="hidden" id="document_id" name="document_id">

    <div class="modal-header">
      <h5 class="modal-title">Document</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Date</label>
          <input type="date" name="date" id="date" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Category</label>
          <select name="category_id" id="category_id" class="form-control" required>
            <option value="">Select</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label>Subject</label>
          <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="col-md-6 mb-3">
          <label>Title</label>
          <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="col-md-12 mb-3">
          <label>Description</label>
          <textarea name="description" id="description" class="form-control" rows="5"></textarea>
        </div>

        <div class="col-md-12 mb-3">
          <label>Content</label>
          <textarea name="content" id="content" class="form-control" rows="5"></textarea>
        </div>

       <div class="col-md-6 mb-3">
    <label>Image File</label>
    <input type="file" name="file_1" id="file_1" class="form-control">

    <div id="file1_preview" class="mt-2"></div>
</div>

<div class="col-md-6 mb-3">
    <label>PDF File</label>
    <input type="file" name="file_2" id="file_2" class="form-control">

    <div id="file2_preview" class="mt-2"></div>
</div>


        @php
    $selectedTags = $selectedTags ?? [];
@endphp
<div class="mb-3">
    <label>Tags</label>

    <div id="tag-list" class="d-flex flex-wrap gap-2">
        @foreach($tags as $tag)
            <span class="tag-chip px-3 py-1 border rounded-pillss
                {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}"
                data-id="{{ $tag->id }}">
                {{ $tag->name }}
            </span>
        @endforeach
    </div>

    <input type="hidden" name="tags" id="tags_input" value="{{ json_encode($selectedTags) }}">
</div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary" id="saveDocBtn">Save</button>
    </div>
  </form>
</div>


  </div>
</div>

<style>
.tag-chip {
    cursor: pointer;
    transition: 0.2s;
}
.tag-chip.selected {
    background-color: #0d6efd;
    color: #00ffc8ff;
    border-color: #0a58ca;
}
</style>
@endsection



@push('scripts')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script>
$(function () {

    // --------------------------
    // CKEditor Initialize
    // --------------------------
    let descriptionEditor, contentEditor;
    ClassicEditor.create(document.querySelector('#description'))
        .then(editor => descriptionEditor = editor)
        .catch(error => console.error(error));

    ClassicEditor.create(document.querySelector('#content'))
        .then(editor => contentEditor = editor)
        .catch(error => console.error(error));


    // --------------------------
    // CSRF Setup
    // --------------------------
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });


    // --------------------------
    // DataTable
    // --------------------------
    let table = $('#documents-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('documents.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'date', name: 'date' },
            { data: 'category', name: 'category' },
            { data: 'subject', name: 'subject' },
            { data: 'title', name: 'title' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });


    // --------------------------
    // TAG SELECTION LOGIC
    // --------------------------
    function initTags(selected = []) {
        let selectedTagIds = selected.map(String);

        $('#tag-list .tag-chip').each(function () {
            $(this).toggleClass('selected', selectedTagIds.includes($(this).data('id').toString()));
        });

        $('#tags_input').val(JSON.stringify(selectedTagIds));
    }

    $('#tag-list').on('click', '.tag-chip', function () {
        $(this).toggleClass('selected');

        let ids = $('#tag-list .tag-chip.selected').map(function () {
            return $(this).data('id');
        }).get();

        $('#tags_input').val(JSON.stringify(ids));
    });


    // --------------------------
    // CREATE DOCUMENT (RESET FORM)
    // --------------------------
    $('#createNewDoc').click(function () {

        $('#documentForm')[0].reset();

        descriptionEditor.setData('');
        contentEditor.setData('');

        initTags([]);

        $('#file1_preview').html('');
        $('#file2_preview').html('');

        $('#document_id').val('');

        $('#documentModal').modal('show');
    });


    // --------------------------
    // EDIT DOCUMENT
    // --------------------------
    $('body').on('click', '.editDocBtn', function () {
        let id = $(this).data('id');

        $.get(`/documents/${id}/edit`, function (data) {

            $('#document_id').val(data.document.id);
            $('#date').val(data.document.date);
            $('#category_id').val(data.document.category_id);
            $('#subject').val(data.document.subject);
            $('#title').val(data.document.title);

            descriptionEditor.setData(data.document.description || '');
            contentEditor.setData(data.document.content || '');

            initTags(data.selectedTags || []);

            // ---- FILE 1 PREVIEW ----
            if (data.document.file_1) {
                $('#file1_preview').html(`
                    <a href="/storage/${data.document.file_1}"
                       target="_blank"
                       class="btn btn-sm btn-info mt-2">
                        View File 1
                    </a>
                `);
            } else {
                $('#file1_preview').html('');
            }

            // ---- FILE 2 PREVIEW ----
            if (data.document.file_2) {
                $('#file2_preview').html(`
                    <a href="/storage/${data.document.file_2}"
                       target="_blank"
                       class="btn btn-sm btn-info mt-2">
                        View File 2
                    </a>
                `);
            } else {
                $('#file2_preview').html('');
            }

            $('#documentModal').modal('show');
        });
    });


    // --------------------------
    // SAVE DOCUMENT
    // --------------------------
    $('#documentForm').submit(function (e) {
        e.preventDefault();

        let id = $('#document_id').val();
        let url = id ? `/documents/${id}` : "{{ route('documents.store') }}";

        let formData = new FormData(this);

        if (id) formData.append('_method', 'PUT');

        formData.set('description', descriptionEditor.getData());
        formData.set('content', contentEditor.getData());

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,

            success: function (res) {
                $('#documentModal').modal('hide');
                table.ajax.reload(null, false);
                Swal.fire('Success', res.message, 'success');
            },

            error: function (err) {
                Swal.fire('Error', err.responseJSON?.message || 'Something went wrong.', 'error');
            }
        });
    });


    $('body').on('click', '.deleteDocBtn', function () {
    let id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will delete the document permanently.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then(result => {

        if (result.isConfirmed) {

            $.ajax({
                url: `/documents/${id}`,
                type: 'POST',     // <---- IMPORTANT
                data: { 
                    _method: 'DELETE',  // <---- IMPORTANT
                    _token: $('meta[name="csrf-token"]').attr('content')
                },

                success: function () {
                    table.ajax.reload(null, false);
                    Swal.fire('Deleted!', 'Document deleted successfully', 'success');
                }
            });
        }
    });
});

});
</script>


@endpush
