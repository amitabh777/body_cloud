@extends('admin.layouts.dashboard-datatables')

@section('page_title') Patients @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div> -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="patient_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Gender</th>
                        <th scope="header">DOB</th>
                        <th scope="header">Weight</th>
                        <th scope="header">Height</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>{{$patient->PatientName}}</td>
                        <td>{{$patient->PatientGender}}</td>
                        <td>{{$patient->PatientDOB}}</td>
                        <td>{{$patient->PatientWeight}} kg</td>
                        <td>{{$patient->PatientHeight}} cm</td>
                        <td>
                            <!-- <input type="checkbox" class="user_status_checkbox" data-UserID="{{$patient->user->UserID}}" name="checkbox_status_{{$patient->PatientID}}" @if($patient->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                            <input type="checkbox" class="user_status_checkbox" data-UserID="{{$patient->user->UserID}}" name="checkbox_status_{{$patient->UserID}}" @if($patient->user->Status=='Active') checked @endif data-update_url="{{route('admin.user.status.update',$patient->UserID)}}"  data-off-text="Inactive" data-on-text="Active">

                        </td>
                        <td>
                            <!-- <a href="{{route('admin.manage_profiles.patient.edit',$patient->UserID)}}" class="btn btn-primary btn-sm">Edit</a> -->
                            <a href="{{route('admin.manage_profiles.patient.show',$patient->UserID)}}" class="btn btn-primary btn-sm">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Gender</th>
                        <th scope="header">DOB</th>
                        <th scope="header">Weight</th>
                        <th scope="header">Height</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </tfoot>
            </table>
            <!-- <button type="button" class="btn btn-success toastrDefaultSuccess">
                  Launch Success Toast
                </button> -->
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->

@endsection


@section('script')
<script src="{{asset('assets/admin/js/pages_js/patient.js')}}"></script>
<script>
    $(function() {
        // $('#patient_datatable').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": true,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": true,
        //     "responsive": true,
        // });

        // $("input[data-bootstrap-switch]").each(function() {
        //     $(this).bootstrapSwitch('state', $(this).prop('checked'));
        // });


        // $("input[data-bootstrap-switch]").change(function(){
        //     console.log('tefdsf');
        //   //$(this).bootstrapSwitch('state', $(this).prop('checked'));
        // });

        // $('.patient_status_checkbox').click(function() {
        //     if ($(this).prop("checked") == true) {
        //         console.log("Checkbox is checked.");
        //     } else if ($(this).prop("checked") == false) {
        //         console.log("Checkbox is unchecked.");
        //     }
        // });

    //     $('.toastrDefaultSuccess').click(function() {
    //   toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    // });

    // $("input[data-bootstrap-switch]").each(function(){
    //   $(this).bootstrapSwitch('state', $(this).prop('checked'));
    // });

  

    });



    // $("#example1").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

@endsection