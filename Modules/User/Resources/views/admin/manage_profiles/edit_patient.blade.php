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
                            <input type="hidden" class="form-control" id="UserID" value="{{$patient->user->UserID}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="Email" class="form-control" id="Email" value="{{$patient->user->Email}}" placeholder="Enter email">
                            @error('Email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="Phone" name="Phone" value="{{$patient->user->Phone}}" placeholder="Enter phone">
                            @error('Phone')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="Address" name="Address" value="{{$patient->user->Address}}" placeholder="Enter address">fsdfsd</textarea>
                            @error('Address')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$patient->user->UserID}}" @if($patient->user->Status=='Active') checked @endif >
                                <label class="custom-control-label" for="Status">Active/Inactive</label>
                            </div>
                            @error('Status')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
                    <h3 class="card-title">Documents Uploads</h3>
                </div>
                <form id="documents_upload_form">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="documents_upload">Document Types</label>
                            <select class="form-control select2bs4" id="document_type_id" name="DocumentTypeID" style="width: 100%;">
                               @foreach($documentTypes as $documentType)
                                <option value="{{$documentType->documentTypeID}}">{{$documentType->DocumentTypeName}}</option>
                                @endforeach
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
                <form id="profile_form" method="post" action="{{route('admin.manage_profiles.patient.update',['UserID'=>$patient->UserID])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <input type="text" class="form-control" id="patient_name" name="PatientName" value="{{old('PatientName',$patient->PatientName)}}" placeholder="Enter patient name">
                            @error('PatientName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-sm-2">Gender: </label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="PatientGender" value="Male" id="gender_male" @if($patient->PatientGender=='Male') checked @endif>
                                    <label for="gender_male">Male</label>
                                </div>
                                <div class="icheck-info d-inline">
                                    <input type="radio" name="PatientGender" value="Female" id="gender_female" @if($patient->PatientGender=='Female') checked @endif>
                                    <label for="gender_female">Female</label>
                                </div>
                            </div>
                            @error('PatientGender')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">DOB:</label>
                            <div class="col-sm-10">
                                <input type="date" name="PatientDOB" class="form-control" value="{{old('PatientDOB',date('Y-m-d',strtotime($patient->PatientDOB)))}}" min="1950-01-01" max="2050-12-31" />
                            </div>

                            <!-- <div class="input-group date" id="patient_dob" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" name="PatientDOB" value="1991/03/03" data-target="#patient_dob" />
                                <div class="input-group-append" data-target="#patient_dob" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div> -->
                            @error('PatientDOB')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Blood Group</label>
                            <select class="form-control select2bs4" id="bloodgroup_id" name="BloodGroupID" style="width: 100%;">
                                <option value="none">-----Select-----</option>
                                @foreach($bloodGroups as $bloodGroup)
                                <option @if($patient->BloodGroupID==$bloodGroup->BloodGroupID) selected="selected" @endif value="{{$bloodGroup->BloodGroupID}}">{{$bloodGroup->BloodGroupName}}</option>
                                @endforeach
                            </select>
                            @error('BloodGroupID')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="patient_height">Height(cm)</label>
                                <input type="text" class="form-control" id="patient_height" name="PatientHeight" value="{{old('PatientHeight',$patient->PatientHeight)}}" placeholder="Enter patient height">
                            </div>
                            <div class="col-md-6">
                                <label for="patient_weight">Weight(kg)</label>
                                <input type="text" class="form-control" id="patient_weight" name="PatientWeight" value="{{old('PatientWeight',$patient->PatientWeight)}}" placeholder="Enter patient weight">
                            </div>
                            @error('PatientHeight')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            @error('PatientWeight')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="chronic_disease">Patient Chronic Disease</label>
                            <input type="text" class="form-control" id="chronic_disease" name="PatientChronicDisease" value="{{old('PatientChronicDisease',$patient->PatientChronicDisease)}}" placeholder="Enter patient chronic disease">
                            @error('PatientChronicDisease')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="permanent_medicine">Patient Permanent Medicines</label>
                            <textarea id="permanent_medicine" name="PatientPermanentMedicine" class="form-control" cols="3" rows="">{{$patient->PatientPermanentMedicines}}</textarea>
                            @error('PatientPermanentMedicine')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="emergency_contact_number">Emergency Contact Number</label>
                            <input type="text" class="form-control" id="emergency_contact_number" name="EmergencyContactNo" placeholder="Emergency contact no" value="{{old('EmergencyContactNo',$patient->EmergencyContactNo)}}">
                            @error('EmergencyContactNo')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image Upload</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image_upload" name="PatientProfileImage">
                                    <label class="custom-file-label" for="profile_image_upload">Choose file</label>
                                </div>
                                <!-- <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div> -->
                            </div>
                            <span id="selected_profile_image">{{$patient->PatientProfileImage}}</span>
                            @error('PatientProfileImage')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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

        $("#profile_image_upload").change(function(){
            $('#selected_profile_image').html(this.value);
        });
        //Date range picker
        // $('#patient_dob').datetimepicker({
        //     format: 'L'
        // });

    });
</script>

@endsection