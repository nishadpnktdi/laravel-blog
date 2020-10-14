<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Dropify -->

<!-- plugins:js -->
<!-- <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script> -->
<!-- <script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script> -->
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('admin/js/shared/off-canvas.js') }}"></script>
<script src="{{ asset('admin/js/shared/misc.js') }}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('admin/js/demo_1/dashboard.js') }}"></script>
<!-- End custom js for this page-->
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

@if(auth()->user()->role == 'admin')
    <script>


    $(document).ready(function() {
    function sendMarkRequest(id = null) {
        return $.ajax({
            method: 'POST',
            url:"/mark-as-read",
            data: {
                "_token": "{{ csrf_token() }}",
                id,
                },
                success: function(result) {
                    console.log('success');
                  },
                  error: function(data) {
                    console.log('failed');
                  }
                })
    }

        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.preview-item').remove();
            });
        });

        $('#mark-all').click(function() {
            let request = sendMarkRequest();
            request.done(() => {
                $('div.preview-item').remove();
                $('.count').remove();

                $('.preview-list').append('<p class="mb-0 font-weight-medium float-left">No new notifications</p>');
                $('.preview-list').append('<p class="mb-0 font-weight-medium float-left"></p>');
                $('.preview-list').append('<a class="dropdown-item preview-item"></a>');
            })
        });
    });
    </script>
@endif