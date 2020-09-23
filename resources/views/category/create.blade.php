@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Categories</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($categories as $category)
                  <tr>
                    <td>{{$category->name}}</td>
                    <td>
                      <div class="button-group d-flex">
                        <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" id="editCategoryModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>

                        <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                          @csrf
                          @method('DELETE')

                          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
      <div class="col-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Create Category</h5>
            <form action="{{ route('category.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Category Name" required>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
@push('scripts')
<script type="text/javascript">
  $(".edit-category").click(function() {
    swal({
        text: 'Type new category name',
        content: "input",
        button: {
          text: "Update",
          closeModal: false,
        },
      })
      .then(name => {
        if (!name)
        return swal.close();
      
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: "PATCH",
          url: "category/" + id,
          data: {
            "_token": "{{ csrf_token() }}",
            "name": name
          },
          success: function(response) {
            console.log(response);
            swal({
              title: "Successfully updated",
              text: name,
              icon: "success",
            }).then(function() {
              location.reload();
            });
          },
          error: function() {
            swal({
              title: "Failed to update",
              text: name,
              icon: "error",
            })
          }
        });

      });
  });
</script>
@endpush