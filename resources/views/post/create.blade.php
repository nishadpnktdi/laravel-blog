@extends('admin.layout')

@prepend('styles')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
@endprepend

@section('content')
<form action="/post" method="POST" enctype="multipart/form-data">
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
              <h4 class="card-title">New Post</h4>

              <div class="form-group">
                <div class="form-group">
                  <label for="exampleFormControlInput1">Title</label>
                  <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                  @error('title')
                  <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <input type="hidden" class="form-control" name="author" placeholder="" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Content</label>
                <textarea class="form-control" name="content" rows="13" >{{ old('content') }}</textarea>
                @error('content')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-success mr-2">Publish</button>
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
                <!-- <div class="input-group col-xs-12"> -->
                  <input type="file" class="featured" name="image" value="{{ old('image') }}"/>
                  @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
                <!-- </div> -->
              </div>
              <h5 class="card-title">Category</h5>
              <div class="form-group">
                <select name="category" class="form-control mb-3 select-category">
                  @foreach ($categories as $category )
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                  <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                  @endforeach
                </select>
                @error('tags')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <h5 class="card-title">Gallery</h5>
              <div class="form-group">
                <input type="file" name="gallery[]" value="{{old('gallery')}}" class="gallery" multiple/>
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
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

<!-- include FilePond plugins -->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js"></script>

<!-- include FilePond jQuery adapter -->
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

<script>
  $(document).ready(function() {
    $('.select-category').select2();
    $('.select-tags-basic-multiple').select2();
  });
  $.fn.filepond.registerPlugin(FilePondPluginImagePreview);
  FilePond.registerPlugin(FilePondPluginFileEncode);

  // Turn input element into a pond
  $('.gallery').filepond({
    allowMultiple: true,
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/*'],
    allowFileEncode: true,
  });

  $('.featured').filepond({
    allowFileTypeValidation: true,
    acceptedFileTypes: ['image/*'],
    allowFileEncode: true,
  });
</script>
@endpush