<!-- jQuery -->
<script src="{{asset('assets/admin/js/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/admin/js/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset('assets/admin/js/overlayScrollbars/jquery.overlayScrollbars.min.js')}}"></script>

<!-- InputMask -->
<script src="{{asset('assets/admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>

<!-- Bootstrap Switch -->
<script src="{{asset('assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('assets/admin/plugins/select2/js/select2.full.min.js')}}"></script>

<!-- date-range-picker -->
<script src="{{asset('assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Toastr -->
<script src="{{asset('assets/admin/plugins/toastr/toastr.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('assets/admin/js/dist/adminlte.min.js')}}"></script>

<!-- Custom js access on all admin pages -->
<script src="{{asset('assets/admin/js/custom.js')}}"></script>

<script>
  //Initialize Select2 Elements
  $('.select2').select2();

  //Initialize Select2 Elements
  $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //  //Date range picker
    //  $('#reservationdate').datetimepicker({
    //     format: 'L'
    // });
    
    // //Datemask dd/mm/yyyy
    // $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    // //Datemask2 mm/dd/yyyy
    // $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

   
    // //Date range picker
    // $('#reservation').daterangepicker()
    // //Date range picker with time picker
    // $('#reservationtime').daterangepicker({
    //   timePicker: true,
    //   timePickerIncrement: 30,
    //   locale: {
    //     format: 'MM/DD/YYYY hh:mm A'
    //   }
    // })

</script>
