@extends('admin.layout')

@prepend('styles')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endprepend

@section('content')

<form action="/post/{{$post->id}}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PATCH')
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
                <textarea class="form-control" name="content" rows="25" value="{{ old('content') }}">{{ $post->content }}</textarea>
                @error('content')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="align-left">
                <button type="submit" class="btn btn-success mr-2">Update</button>
                <button type="reset" class="btn btn-light">Clear</button>
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

              <h5 class="card-title">Featured Image</h5>
              <div class="form-group">
                <!-- <div class="input-group col-xs-12"> -->
                <input type="file" name="image" class="featured" />
                <!-- </div> -->
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
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

              <h5 class="card-title">Gallery</h5>
              <div class="form-group">
                <input type="file" name="gallery[]" class="gallery" multiple/>
                @error('image')
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

<!-- include FilePond library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.21.1/filepond.js" integrity="sha512-c1kUDsNxHP2kTWUnCJf3O2hxZtiat1gKM43+Wsh868L+9tt2jdiSS54afmvqvXj/hawS+EK20M+kLAobrMg4iA==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/filepond/4.21.1/filepond.css" integrity="sha512-iqR58XVp+K0AENSCrB/aQjHOlGyj6qRAWJzbwlkKAPMyjJaoabEoqqVIA4ox3hfgTyVBqDLQKz6NsiI2lYtTCg==" crossorigin="anonymous" />

<!-- include FilePond plugins -->
<script src="https://cdn.jsdelivr.net/npm/filepond-plugin-image-preview@4.6.4/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script>
  $(document).ready(function() {
    $('.select-category').select2();
    $('.select-tags-basic-multiple').select2();

  // First register any plugins
  $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
  $.fn.filepond.registerPlugin(FilePondPluginFileEncode);

  
  $('.featured').filepond({
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/*'],
    files: [{
      source: "{{$post->getFirstMediaUrl('featuredImage', 'thumb')}}",
    }],
    allowFileEncode: true,
  });

  $('.gallery').filepond({
    allowMultiple: true,
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/*'],
    allowFileEncode: true,
    files: [
      @foreach ($post->getMedia('gallery') as $image)
        {
        source: '{{$image->getUrl()}}'
        },
      @endforeach
    ],
  });
  
  });
</script>
@endpush