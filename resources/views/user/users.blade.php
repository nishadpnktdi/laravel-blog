@extends('admin.layout')

@section('content')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" class="form-control" name="name" value="{{ old('name') }}">
          @error('name')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" value="{{ old('email') }}">
          @error('email')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Password</label>
          <input type="password" class="form-control" name="password" value="{{ old('password') }}">
          @error('password')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="form-group">
          <label for="email">Confirm passowrd</label>
          <input type="password" class="form-control" name="confirm-password" value="{{ old('confirm-passoword') }}">
          @error('confirm-password')
          <div class="text-danger">{{ $message }}</div>
          @enderror
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Create</button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div id="delete-message" class="d-none alert alert-danger"></div>
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Users</h4>
              <!-- <a href=""> -->
              <div class="pb-4">
                <button type="button" class="btn btn-primary btn-fw btn-rounded" data-toggle="modal" data-target="#exampleModal">Create User</button>
              </div>
              <!-- </a> -->
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="data-table" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Profile photo</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($users->count() < 1) <tr>
                    <td>No Data</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    @endif

                    @foreach($users as $user)
                    <tr>
                      <td><img class="rounded-0" src="/storage/{{$user->profile_photo_path}}" /></td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->role}}</td>
                      <td>
                        <a href="/post/{{ $user->id }}/edit" class="card-link">
                          <button type="button" class="btn btn-dark">
                            <i class="mdi mdi-pencil"></i>Edit</button>
                        </a>

                        @can('isAdmin')
                        <button type="button" data-id="{{ $user->id }}" class="btn btn-danger delete-user">
                          <i class="mdi mdi-delete"></i>Delete</button>
                        @endcan
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
</div>

@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('#data-table').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "autoWidth": true,
      "processing": true,
      "pageLength": 10,
      "fnDrawCallback": function(oSettings) {

        $('.delete-user').on('click', function() {
          swal({
              title: "Are you sure?",
              text: "Do you want to delete the user?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {

                let _that = $(this);
                $.ajax({
                  url: '/user/' + _that.data('id'),
                  type: 'DELETE',
                  data: {
                    "_token": "{{ csrf_token() }}",
                  },
                  success: function(result) {
                    swal("User successfully deleted!", {
                      icon: "success",
                      timer: 3000
                    }).then(function() {
                      location.reload();
                    })
                  },
                  error: function(data) {
                    swal({
                      title: "Unable to delete!",
                      text: data.responseJSON['errors']['name'][0],
                      icon: "error",
                    })
                  }
                });
              }
            })
        });
      }
    });
  });
</script>
@endpush