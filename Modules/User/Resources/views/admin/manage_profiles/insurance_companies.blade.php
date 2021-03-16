@extends('admin.layouts.dashboard-datatables')
@section('page_title') Insurance Company @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div> -->
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="insurance_company_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Company Info</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insuranceCompanies as $insuranceCompany)
                    <tr>
                        <td>{{$insuranceCompany->InsuranceCompanyName}}</td>
                        <td>{{$insuranceCompany->InsuranceCompanyWebsite}}</td>
                        <td>{{$insuranceCompany->InsuranceCompanyInfo}}</td>
                        <td>
                            <input type="checkbox" class="insurance_company_active_checkbox" data-UserID="{{$insuranceCompany->user->UserID}}" name="checkbox_status_{{$insuranceCompany->insuranceCompanyID}}" @if($insuranceCompany->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success">
                        </td>
                        <td>
                        <a href="{{route('admin.manage_profiles.insurance_company.show',$insuranceCompany->UserID)}}" class="btn btn-primary btn-sm">View Details</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Company Info</th>
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

        $('#insurance_company_datatable').DataTable({
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