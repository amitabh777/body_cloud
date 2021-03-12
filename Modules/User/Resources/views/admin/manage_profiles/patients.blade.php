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
                            <input type="checkbox" class="patient_status_checkbox" data-UserID="{{$patient->user->UserID}}" name="checkbox_status_{{$patient->PatientID}}" @if($patient->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </td>
                        <td>
                            <a href="{{route('admin.manage_profiles.patient.edit',$patient->PatientID)}}" class="btn btn-primary btn-sm">Edit</a>
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
<script>
    $(function() {
        // $("#example1").DataTable({
        //   "responsive": true, "lengthChange": false, "autoWidth": false,
        // //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $('#patient_datatable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });


    });


    // $("#example1").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>

@endsection