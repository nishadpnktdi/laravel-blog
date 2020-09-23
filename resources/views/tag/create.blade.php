@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-8 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
      <div class="col-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">New Post</h4>
            <form action="#" method="POST">
              @csrf
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
                <textarea class="form-control" name="content" rows="13" value="{{ old('content') }}"></textarea>
                @error('content')
                <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
              <button type="submit" class="btn btn-success mr-2">Publish</button>
              <button type="reset" class="btn btn-light">Clear</button>
            </form>
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
              <label>File upload</label>
              <input type="file" name="img[]" class="file-upload-default">
              <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                <span class="input-group-append">
                  <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                </span>
              </div>
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
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection