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
                <form id="user_form">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="UniqueID">UniqueID</label>
                            <span>{{$patient->user->UniqueID}}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <span>{{$patient->user->Email}}</span>
                          
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <span>{{$patient->user->Phone}}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <span>{{$patient->user->Addres}}</span>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$patient->user->UserID}}" @if($patient->user->Status=='Active') checked @endif >
                                <label class="custom-control-label" for="Status">Active/Inactive</label>
                            </div>                          
                        </div>
                    </div>
                </form>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Documents Uploads</h3>
                </div>
                <form id="documents_upload_form" action="{{route('admin.manage_documents.upload')}}" method="post" enctype="multipart/form-data">
                @csrf
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
                                    <input type="file" class="custom-file-input" id="documents_upload" name="DocumentFiles">
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
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="patient_name">Patient Name</label>
                            <span>{{$patient->PatientName}}</span>
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
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">DOB:</label>
                           <span>{{$patient->PatientDOB}}</span>
                        </div>
                        <div class="form-group">
                            <label>Blood Group: </label>
                            <span>{{$patient->bloodgroup->BloodGroupName}}</span>                           
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="patient_height">Height(cm)</label>
                                <span>{{$patient->PatientHeight}}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="patient_weight">Weight(kg)</label>
                                <span>{{$patient->PatientHeight}}</span>
                            </div>                          
                        </div>
                        <div class="form-group">
                            <label for="chronic_disease">Patient Chronic Disease </label>
                            <span>{{$patient->PatientChronicDisease}}</span>
                        </div>
                        <div class="form-group">
                            <label for="permanent_medicine">Patient Permanent Medicines</label>
                            <span>{{$patient->PatientPermanentMedicines}}</span>
                        </div>
                        <div class="form-group">
                            <label for="emergency_contact_number">Emergency Contact Number</label>
                            <span>{{$patient->EmergencyContactNo}}</span>
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image</label>
                            <img src="{{asset('storage/'.$patient->)}}"  />
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