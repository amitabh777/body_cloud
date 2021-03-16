@extends('admin.layouts.dashboard-datatables')

@section('page_title') Doctors @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <!-- /.card -->

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="doctor_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Gender</th>
                        <th scope="header">DOB</th>
                        <th scope="header">Hospital</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>{{$doctor->DoctorName}}</td>
                        <td>{{$doctor->DoctorGender}}</td>
                        <td>{{$doctor->DoctorDOB}}</td>
                        <td>{{$doctor->hospital?$doctor->hospital->HospitalName:''}}</td>
                       
                        <td>
                            <!-- <input type="checkbox" class="doctor_status_checkbox" data-UserID="{{$doctor->user->UserID}}" name="checkbox_status_{{$doctor->UserID}}" @if($doctor->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                            <input type="checkbox" class="user_status_checkbox" data-UserID="{{$doctor->user->UserID}}" name="checkbox_status_{{$doctor->UserID}}" @if($doctor->user->Status=='Active') checked @endif data-update_url="{{route('admin.user.status.update',$doctor->UserID)}}"  data-off-text="Inactive" data-on-text="Active">

                        </td>
                        <td>
                        <!-- <a href="{{route('admin.manage_profiles.doctor.edit',$doctor->UserID)}}" class="btn btn-primary btn-sm">Edit</a> -->
                        <a href="{{route('admin.manage_profiles.doctor.show',$doctor->UserID)}}" class="btn btn-primary btn-sm">View Details</a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Gender</th>
                        <th scope="header">DOB</th>
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
<script src="{{asset('assets/admin/js/pages_js/doctor.js')}}"></script>


@endsection