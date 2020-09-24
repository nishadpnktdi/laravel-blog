@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Tags</h4>
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
                  @foreach ($tags as $tag)
                  <tr>
                    <td>{{$tag->name}}</td>
                    <td>
                      <div class="button-group d-flex">
                        <button type="button" class="btn btn-sm btn-primary mr-1 edit-tag" data-toggle="modal" id="editTagModal" data-id="{{ $tag->id }}" data-name="{{ $tag->name }}">Edit</button>

                        <form action="{{ route('tag.destroy', $tag->id) }}" method="POST">
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
            <h5 class="card-title">Create Tag</h5>
            <form action="{{ route('tag.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Tag Name" required>
              </div>
              @error('name')
              <div class="text-danger">{{ $message }}</div>
              @enderror

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
  $(".edit-tag").click(function() {
    swal({
        title: 'Type new Tag name',
        content: {
          element: 'input',
          attributes: {
            placeholder: $(this).data('name')
          }
        },
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
          url: "tag/" + id,
          data: {
            "_token": "{{ csrf_token() }}",
            "name": name
          },
          success: function(response) {
            console.log(response);
            swal({
              title: "Successfully updated",
              icon: "success",
              timer: 5000
            }).then(function() {
              location.reload();
            });
          },
          error: function(data) {
            swal({
              title: "Failed to update",
              text: data.responseJSON['errors']['name'][0],
              icon: "error",
            })
          }
        });

      });
  });
</script>
@endpush