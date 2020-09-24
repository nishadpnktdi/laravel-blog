@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <h4 class="card-title mb-0">Posts</h4>
              <a href="/post/create"><button type="button" class="btn btn-primary btn-fw btn-rounded">New Post</button></a>
            </div>
            <div class="table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>Featured Image</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Publishing date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($post as $post)
                  <tr>
                    <td><img class="rounded-0" src="images/{{$post->featured_image}}"/></td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->is_published}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>
                      <a href="/post/{{ $post->id }}/edit" class="card-link">
                        <button type="button" class="btn btn-dark">
                          <i class="mdi mdi-pencil"></i>Edit</button>
                      </a>

                      <a class="card-link delete-blog" data-id="{{ $post->id }}" href="">
                        <button type="button" class="btn btn-danger">
                          <i class="mdi mdi-delete"></i>Delete</button>
                        </a>
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
    $('.delete-blog').on('click', function() {
        let _that = $(this);
        $.ajax({
            url: '/blogs/' + _that.data('id'),
            type: 'DELETE',
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(result) {
                // Do something with the result
                $('#delete-message').removeClass('d-none');
                $('#delete-message').html(result.message);
                _that.closest('.col-md-4').remove();
            }
        });
    });
</script>
@endpush