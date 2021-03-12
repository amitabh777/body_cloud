@extends('admin.layouts.dashboard-datatables')
@section('page_title') Laboratory @endsection
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
            <table id="laboratory_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Info</th>
                        <th scope="header">Status</th>                        
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laboratories as $laboratory)
                    <tr>
                        <td>{{$laboratory->LaboratoryCompanyName}}</td>
                        <td>{{$laboratory->LaboratoryWebsite}}</td>
                        <td>{{$laboratory->LaboratoryInfo}}</td>                       
                        <td>
                            <input type="checkbox" class="laboratory_active_checkbox" data-UserID="{{$laboratory->user->UserID}}" name="checkbox_status_{{$laboratory->LaboratoryID}}" @if($laboratory->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm">Edit</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Info</th>
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

        $('#laboratory_datatable').DataTable({
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