@extends('admin.layouts.dashboard-datatables')
@section('page_title') Hospitals @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div> -->
                <!-- /.card-header -->

            </div>
            <!-- /.card -->

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="hospital_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Hospital Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Contact Person</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hospitals as $hospital)
                    <tr>
                        <td>{{$hospital->HospitalName}}</td>
                        <td>{{$hospital->HospitalWebsite}}</td>
                        <td>{{$hospital->HospitalContactName}}</td>
                        <td>
                            <!-- <input type="checkbox" class="hospital_status_checkbox" data-UserID="{{$hospital->user->UserID}}" name="checkbox_status_{{$hospital->HospitalID}}" @if($hospital->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                            <input type="checkbox" class="user_status_checkbox" data-UserID="{{$hospital->user->UserID}}" name="checkbox_status_{{$hospital->UserID}}" @if($hospital->user->Status=='Active') checked @endif data-update_url="{{route('admin.user.status.update',$hospital->UserID)}}"  data-off-text="Inactive" data-on-text="Active">

                        </td>
                        <td>
                        <a href="{{route('admin.manage_profiles.hospital.show',$hospital->UserID)}}" class="btn btn-primary btn-sm">View Details</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Hospital Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Contact Person</th>
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
<script src="{{asset('assets/admin/js/pages_js/hospital.js')}}"></script>

@endsection