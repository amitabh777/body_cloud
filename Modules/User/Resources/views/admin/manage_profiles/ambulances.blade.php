@extends('admin.layouts.dashboard-datatables')

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
            <table id="ambulance_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                    <th scope="header">Contact Name</th>
                        <th scope="header">Ambulance Number</th>
                        <th scope="header">Hospital</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ambulances as $ambulance)
                    <tr>
                        <td>{{$ambulance->AmbulanceContactName}}</td>
                        <td>{{$ambulance->AmbulanceNumber}}</td>
                        <td>{{$ambulance->hospital?$ambulance->hospital->HospitalID:''}}</td>
                        <td>
                            <input type="checkbox" class="ambulance_active_checkbox" data-UserID="{{$ambulance->user->UserID}}" name="checkbox_status_{{$ambulance->AmbulanceID}}" @if($ambulance->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </td>
                        <td>
                        <a href="{{route('admin.manage_profiles.ambulance.show',$ambulance->UserID)}}" class="btn btn-primary btn-sm">View Details</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Contact Name</th>
                        <th scope="header">Ambulance Number</th>
                        <th scope="header">Hospital</th>
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

        $('#ambulance_datatable').DataTable({
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