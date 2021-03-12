@extends('admin.layouts.dashboard-datatables')

@section('page_title') Patient Edit @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                </div>
                <!-- form start -->
                <form id="user_form" method="post" action="{{route('admin.manage_profiles.user.update',$patient->user->UserID)}}">
                    @csrf
                    @method('PATCH')                
                    <div class="card-body">
                        <div class="form-group">
                            <label for="UniqueID">UniqueID</label>
                            <input type="text" class="form-control" id="unique_id" value="{{$patient->user->UniqueID}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" placeholder="Enter address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="patient_status_checkbox" name="patient_status_checkbox" data-UserID="{{$patient->user->UserID}}" @if($patient->user->Status=='Active') checked @endif >
                                <label class="custom-control-label" for="patient_status_checkbox">Toggle this custom switch element</label>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Document Uploads</h3>
                </div>
                <form id="documents_upload_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="documents_upload">Document Types</label>
                            <select class="form-control select2bs4" style="width: 100%;">
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="documents_upload">Upload Documents</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="documents_upload">
                                    <label class="custom-file-label" for="documents_upload">Choose files</label>
                                </div>
                                <!-- <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profile Details</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="profile_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <input type="text" class="form-control" id="patient_name" placeholder="Enter patient name">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender: </label>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="gender" checked id="gender_male">
                                <label for="gender_male">Male</label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" name="gender" id="gender_female">
                                <label for="gender_female">Female</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>DOB:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Blood Group</label>
                            <select class="form-control select2bs4" style="width: 100%;">
                                <option selected="selected">Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="patient_height">Height</label>
                                <input type="text" class="form-control" id="patient_height" name="patient_height" placeholder="Enter patient height">
                            </div>
                            <div class="col-md-6">
                                <label for="patient_weight">Weight</label>
                                <input type="text" class="form-control" id="patient_weight" name="patient_weight" placeholder="Enter patient weight">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chronic_disease">Patient Chronic Disease</label>
                            <input type="text" class="form-control" id="chronic_disease" name="chronic_disease" placeholder="Enter patient chronic disease">
                        </div>
                        <div class="form-group">
                            <label for="permanent_medicine">Patient Permanent Medicines</label>
                            <input type="text" class="form-control" id="permanent_medicine" name="permanent_medicine" placeholder="Enter patient permanent medicines">
                        </div>
                        <div class="form-group">
                            <label for="permanent_medicine">Emergency Contact Number</label>
                            <input type="text" class="form-control" id="permanent_medicine" name="permanent_medicine" placeholder="Emergency contact number">
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image Upload</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image_upload">
                                    <label class="custom-file-label" for="profile_image_upload">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->

        </div>
    </div>

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