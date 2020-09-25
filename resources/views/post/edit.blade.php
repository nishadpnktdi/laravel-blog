@extends('admin.layout')

@section('content')
<form action="/post/{{$post->id}}" method="POST" enctype="multipart/form-data">
  @method('PATCH')
  @csrf
  <div class="row">
    <div class="col-md-8 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12 stretch-card">
          <div class="card">
            <div class="card-body">
              @if (session('message'))
              <div class="alert alert-success mt-3">
                {{ session('message') }}
              </div>
              @endif
              <h4 class="card-title">Edit Post</h4>
              <div class="form-group">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Title</label>
                  <input type="text" class="form-control" name="title" value="{{ $post->title }}">
                  @error('title')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <input type="hidden" class="form-control" name="author" placeholder="" value="{{ $post->user_id }}">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Content</label>
                <textarea class="form-control" name="content" rows="13" value="{{ old('content') }}">{{ $post->content }}</textarea>
                @error('content')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-success mr-2">Update</button>
              <button type="reset" class="btn btn-light">Clear</button>
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
              <h5 class="card-title">Featured Image</h5>
              <div class="form-group">
                <div class="input-group col-xs-12">
                  <input type="file" name="image" class="dropify" data-default-file="/images/{{ $post->featured_image }}" />
                </div>


              </div>
              <h5 class="card-title">Category</h5>
              <div class="form-group">
                <select name="category" class="form-control mb-3 select-category">
                  <?php $selected = $post->category_id ?>
                  @foreach ($categories as $category )
                  <option value="{{ $category->id }}" {{ $selected == $category->id ? 'selected="selected"' : '' }}>{{ $category->name }}</option>
                  @endforeach
                </select>
                @error('category')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <h5 class="card-title">Tags</h5>
              <div class="form-group select2 js-example-basic-multiple">
                <select name="tags[]" class="form-control select-tags-basic-multiple" multiple="multiple">
                  @foreach ($tags as $tag )
                  <option value="{{ $tag->id }}" {{ $selectedTags->contains($tag->id) ? 'selected':'' }}>{{ $tag->name }}</option>
                  @endforeach
                </select>
                @error('tags')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js" integrity="sha512-hJsxoiLoVRkwHNvA5alz/GVA+eWtVxdQ48iy4sFRQLpDrBPn6BFZeUcW4R4kU+Rj2ljM9wHwekwVtsb0RY/46Q==" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('.select-category').select2();
    $('.select-tags-basic-multiple').select2();
    $('.dropify').dropify();
  });
</script>
@endpush