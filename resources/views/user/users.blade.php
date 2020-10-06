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
        <form id="create-user">
          @csrf
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" required>
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm password</label>
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('confirm-passoword') }}" required>
            @error('confirm-password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary create-user">Create</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <form class="edit-user" id="update-user-form" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="profile-image">Profile Image</label>
            <div class="input-group col-xs-12">
              <input type="file" name="image" id="image" class="dropify" data-height="200" />
            </div>
            @error('image')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" name="role" id="role" value="{{ old('role') }}" required>
              <option value="admin">Admin</option>
              <option value="editor">Editor</option>
              <option value="author">Author</option>
            </select>
            @error('role')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}">
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" value="{{ old('confirm-passoword') }}">
            @error('confirm-password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary save-user">Save</button>
      </div>
    </div>
  </div>
</div>


@if($errors->any())
<script>
  $(window).on('load', function() {
    $('#exampleModal').modal('show');
  })
</script>
@endif

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
                      <td><img class="rounded-0" src="{{isset($user['profile_photo_path']) ? '/storage/'.$user['profile_photo_path'] : asset('frontend/img/user.svg')}}" /></td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>{{$user->role}}</td>
                      <td>
                        @can('isAdmin')
                        <button type="button" data-id="{{ $user->id }}" class="btn btn-dark edit-user">
                          <i class="mdi mdi-pencil"></i>Edit</button>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q==" crossorigin="anonymous"></script>
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

        $('.delete-user').click(function() {

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
                      text: data.responseJSON['errors'][1][0],
                      icon: "error",
                    })
                  }
                });
              }
            })
        });
      }
    });

    $('.create-user').click(function() {
      $.ajax({
        url: '/user',
        type: 'POST',
        data: $("#create-user").serialize(),
        success: function(result) {
          swal("User created successfully!", {
            icon: "success",
            timer: 3000
          }).then(function() {
            location.reload();
          })
        },
        error: function(data) {
          var err = '';
          for (e in data.responseJSON['errors']) {
            err += data.responseJSON['errors'][e] + '\n';
          }
          swal({
            title: "Unable to create user!",
            icon: "error",
            text: err,
          })
        }

      });

    });

    $('.edit-user').click(function() {
      $.ajax({
        url: '/user/' + $(this).data('id') + '/edit',
        type: 'GET',
        success: function(result) {

          var name = result.name;
          var email = result.email;
          var password = result.password;
          var role = result.role;
          var profile_image = result.profile_photo_path;

          $("#name").val(name);
          $("#email").val(email);
          $("#password").val(password);
          $('#role').val(role).selected;
          $('.dropify').dropify({
            defaultFile: '/storage/' + profile_image
          });

          $('#edit-user-modal').modal('show');

          var drEvent = $('#image').dropify();
          drEvent = drEvent.data('dropify');
          drEvent.resetPreview();
          drEvent.clearElement();
          drEvent.settings.defaultFile = '/storage/' + profile_image;
          drEvent.destroy();
          drEvent.init();
          $('.dropify#image').dropify({
            defaultFile: '/storage/' + profile_image,
          });

          $('.save-user').click(function() {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
              }
            });
            name  = $("#name").val();
            email = $("#email").val();
            password = $("#password").val();
            role = $("#role").val();
            image = $("#image").val();

            let myForm = document.querySelector('form');
            let formData = new FormData();            
            formData.append('name' , name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('role', role);
            // formData.append('image', image);
            console.log(formData.entries);

            $.ajax({
              type: "PATCH",
              url: "/user/" + result.id,
              enctype: 'multipart/form-data',
              processData: false,
              // contentType: false,
              data: formData,
              success: function(response) {
                console.log(response);
                swal({
                  title: "User successfully updated",
                  icon: "success",
                  timer: 5000
                }).then(function() {
                  // location.reload();
                });
              },
              error: function(data) {
                var err = '';
                for (e in data.responseJSON['errors']) {
                  err += data.responseJSON['errors'][e] + '\n';
                }
                swal({
                  title: "Unable to update user!",
                  icon: "error",
                  text: err,
                })
              }
            });

          })

        },
        error: function(data) {
          console.log(data);
        }

      });

    });


  });
</script>
@endpush