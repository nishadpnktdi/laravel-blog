@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div id="delete-message" class="d-none alert alert-danger"></div>
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Posts</h4>
              <a href="/post/create">
                <div class="pb-4">
                  <button type="button" class="btn btn-primary btn-fw btn-rounded">New Post</button>
                </div>
              </a>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="data-table" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Featured Image</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publishing date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($posts->count() < 1) <tr>
                    <td>No Data</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                    @endif

                    @foreach($posts as $post)
                    <tr>
                      <td><img class="rounded-0" src="/images/{{$post->featured_image}}" /></td>
                      <td>{{$post->title}}</td>
                      <td>{{$post->user->name}}</td>
                      <td>{{$post->user->id}}</td>
                      <td>{{$post->created_at}}</td>
                      <td>
                        <a href="/post/{{ $post->id }}/edit" class="card-link">
                          <button type="button" class="btn btn-dark">
                            <i class="mdi mdi-pencil"></i>Edit</button>
                        </a>

                        @can('isAdmin')
                        <button type="button" data-id="{{ $post->id }}" class="btn btn-danger delete-blog">
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
        $('.delete-blog').on('click', function() {
          let _that = $(this);
          $.ajax({
            url: '/post/' + _that.data('id'),
            type: 'DELETE',
            data: {
              "_token": "{{ csrf_token() }}",
            },
            success: function(result) {
              // Do something with the result
              $('#delete-message').removeClass('d-none');
              $('#delete-message').html(result.message);
              if (result.post_count == 0)
                _that.closest('tr').html(`<td>No Data</td><td></td><td></td><td></td><td></td>`);
              else
                _that.closest('tr').remove();

              setTimeout(function() {
                $('#delete-message').remove();
              }, 5000);
            }
          });
        });
      }
    });
  });
</script>
@endpush