<!DOCTYPE html>
<html>

<head>
  @include('head')
</head>

<body>
  <header class="header">
    @include('header')
  </header>
  <div class="container">
    <div class="row">
      <!-- Latest Posts -->
      <main class="posts-listing col-lg-8">
        <div class="container">
          <h3 class="h4 mb-4">Contact</h3>
          <hr>
          <div class="row">
            <div class="post col-xl-12">
              <form method="POST" action="/contact">
                @csrf
                <div class="card">
                  <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success mt-3">
                      {{ session('message') }}
                    </div>
                    @endif

                    <div class="form-group">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Full Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">E-mail</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Phone</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Message</label>
                      <textarea class="form-control" name="message" rows="5" required>{{ old('message') }}</textarea>
                      @error('message')
                      <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      {!! NoCaptcha::renderJs() !!}
                      {!! NoCaptcha::display() !!}
                      @if ($errors->has('g-recaptcha-response'))
                      <span class="help-block">
                        <div class="text-danger">{{ $errors->first('g-recaptcha-response') }}</div>
                      </span>
                      @endif
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Send</button>
                    <button type="reset" class="btn btn-light">Clear</button>

                  </div>
                </div>
              </form>
            </div>
          </div>
      </main>
      <aside class="col-lg-4">
      </aside>
    </div>
  </div>
  <!-- Page Footer-->
  <footer class="main-footer">
    @include('footer')
  </footer>
  <!-- JavaScript files-->
  @include('scripts')
</body>

</html>