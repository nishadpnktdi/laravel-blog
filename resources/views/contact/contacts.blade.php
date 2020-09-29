@extends('admin.layout')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" />
</script>

<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Contacts</h4>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($contacts->count() < 1) <tr>
                    <td>No Data</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    @endif

                    @foreach($contacts as $contact)
                    <tr>
                      <td>{{$contact->name}}</td>
                      <td>{{$contact->email}}</td>
                      <td>{{$contact->phone}}</td>
                      <td>{{$contact->message}}</td>
                      <td>

                        <button type="button" data-id="{{ $contact->id }}" class="btn btn-danger delete-contact">
                          <i class="mdi mdi-delete"></i>Delete</button>
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
  $('.delete-contact').on('click', function() {
    swal({
        title: "Are you sure?",
        text: "Do you want to delete the entry?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

          let _that = $(this);
          $.ajax({
            url: '/contact/' + _that.data('id'),
            type: 'DELETE',
            data: {
              "_token": "{{ csrf_token() }}",
            },
            success: function(result) {
              swal("Entry successfully deleted!", {
                icon: "success",
                timer: 3000
              }).then(function(){
                location.reload();
              })
            }
          });
        }
      })
  });
</script>
@endpush