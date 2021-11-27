   <!--Footer-->
   <footer class="sticky-footer bg-dark text-gray-100 mt-auto">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; getThrills.com</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <a class="btn btn-primary" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
      </a>

     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
     </form>
    </div>
  </div>
</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{URL::asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{URL::asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{URL::asset('assets/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{URL::asset('assets/vendor/chart.js/Chart.min.js')}}"></script>


<!--Script for CK editor-->
<script src="{{URL::asset('ckeditor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
<script src="{{URL::asset('ckeditor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
<script src="{{URL::asset('assets/vendor/datetime-picker/bootstrap-datetimepicker.min.js')}}"></script>

<!-- Scripts for datatables -->
<script src="{{URL::asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/vendor/datatables/report/js/vfs_fonts.js')}}"></script>

<!--Jquery Validator.js-->
<script type="text/javascript" src="{{ asset('assets/vendor/jquery-validation-1.19.1/dist/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/jquery-validation-1.19.1/dist/additional-methods.min.js') }}"></script>

<!--Custom js-->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/validation.js') }}"></script>

{{-- Toggled Navbar on small --}}
<script>
  (function($) {
    var $window = $(window),
        $top = $('#page_top');
        $sidebar = $('#accordionSidebar');

        function resize() {
            if ($window.width() < 514) {
                return [ $top.addClass('sidebar-toggled'), $sidebar.addClass('toggled') ];
            }

            $top.removeClass('sidebar-toggled');
            $sidebar.removeClass('toggled');
        }
        $window
            .resize(resize)
            .trigger('resize');
        })(jQuery);

</script>
<script>
    $(document).ready(function(){
        $( document ).ajaxSend(function(elm, xhr, s){
         var csrf = $('meta[name="csrf_token"]').attr('content');
        if (s.type == "POST") {
            xhr.setRequestHeader('x-csrf-token', csrf);
        }
    });

    });

</script>

@stack('scripts')
</body>

</html>
