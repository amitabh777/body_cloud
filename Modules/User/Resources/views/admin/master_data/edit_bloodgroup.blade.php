@extends('admin.layouts.dashboard-datatables')

@section('page_title') Bloodgroup Edit @endsection
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
                <form id="user_form" method="post" action="{{route('admin.manage_profiles.user.update',$doctor->user->UserID)}}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="UniqueID">UniqueID</label>
                            <input type="text" class="form-control" id="unique_id" value="{{$doctor->user->UniqueID}}" disabled>
                            <input type="hidden" class="form-control" id="UserID" value="{{$doctor->user->UserID}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="Email" class="form-control" id="Email" value="{{$doctor->user->Email}}" placeholder="Enter email">
                            @error('Email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="Phone" name="Phone" value="{{$doctor->user->Phone}}" placeholder="Enter phone">
                            @error('Phone')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="Address" name="Address" value="{{$doctor->user->Address}}" placeholder="Enter address">fsdfsd</textarea>
                            @error('Address')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$doctor->user->UserID}}" @if($doctor->user->Status=='Active') checked @endif >
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
                <form id="profile_form" method="post" action="{{route('admin.manage_profiles.doctor.update',['UserID'=>$doctor->UserID])}}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="doctor_name">Doctor Name</label>
                            <input type="text" class="form-control" id="doctor_name" name="DoctorName" value="{{old('DoctorName',$doctor->DoctorName)}}" placeholder="Enter doctor name" required>
                            @error('DoctorName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label for="gender" class="col-sm-2">Gender: </label>
                            <div class="col-sm-10">
                                <div class="icheck-success d-inline">
                                    <input type="radio" name="DoctorGender" value="Male" id="gender_male" @if($doctor->DoctorGender=='Male') checked @endif>
                                    <label for="gender_male">Male</label>
                                </div>
                                <div class="icheck-info d-inline">
                                    <input type="radio" name="DoctorGender" value="Female" id="gender_female" @if($doctor->DoctorGender=='Female') checked @endif>
                                    <label for="gender_female">Female</label>
                                </div>
                            </div>
                            @error('DoctorGender')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">DOB:</label>
                            <div class="col-sm-10">
                                <input type="date" name="DoctorDOB" class="form-control" value="{{old('DoctorDOB',date('Y-m-d',strtotime($doctor->DoctorDOB)))}}" min="1950-01-01" max="2050-12-31" />
                            </div>
                            @error('DoctorDOB')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Hospital</label>
                            <select class="form-control select2bs4" id="hospital_id" name="HospitalID" style="width: 100%;">
                                <option value="none">-----Select-----</option>
                                @foreach($hospitals as $hospital)
                                <option @if($doctor->HospitalID==$hospital->HospitalID) selected="selected" @endif value="{{$hospital->HospitalID}}">{{$hospital->HospitalName}}</option>
                                @endforeach
                            </select>
                            @error('HospitalID')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="doctor_website">Doctor Website</label>
                            <input type="text" class="form-control" id="doctor_website" name="DoctorWebsite" value="{{old('DoctorWebsite',$doctor->DoctorWebsite)}}" placeholder="Enter doctor website">
                            @error('DoctorWebsite')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_account_no">Bank Account No</label>
                            <input type="text" class="form-control" id="bank_account_no" name="DoctorBankAccountNo" value="{{old('DoctorBankAccountNo',$doctor->DoctorBankAccountNo)}}" placeholder="Enter doctor bank account no">
                            @error('DoctorBankAccountNo')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Doctor Bank Name</label>
                            <input type="text" class="form-control" id="bank_name" name="DoctorBankName" value="{{old('DoctorBankName',$doctor->DoctorBankName)}}" placeholder="Enter doctor bank name">
                            @error('DoctorBankName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                     
                        <div class="form-group">
                            <label for="min_reservation_charge">Min reservation charge</label>
                            <input type="text" class="form-control" id="min_reservation_charge" name="DoctorMinReservationCharge" placeholder="Minimum reservation charge" value="{{old('DoctorMinReservationCharge',$doctor->DoctorMinReservationCharge)}}">
                            @error('DoctorMinReservationCharge')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image Upload</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image_upload" name="DoctorProfileImage">
                                    <label class="custom-file-label" for="profile_image_upload">Choose file</label>
                                </div>
                                <!-- <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div> -->
                            </div>
                            <span id="selected_profile_image">{{$doctor->DoctorProfileImage}}</span>
                            @error('DoctorProfileImage')
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