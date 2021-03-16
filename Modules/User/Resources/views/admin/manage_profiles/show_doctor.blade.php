@extends('admin.layouts.dashboard-datatables')

@section('page_title') Doctor @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
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
                            <span>{{$doctor->user->UniqueID}}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <span>{{$doctor->user->Email}}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <span>{{$doctor->user->Phone}}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <span>{{$doctor->user->Addres}}</span>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$doctor->user->UserID}}" @if($doctor->user->Status=='Active') checked @endif >
                                <label class="custom-control-label" for="Status">Active/Inactive</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Documents</h3>
                </div>
                @if($doctor->documents)
                    @foreach($doctor->documents as $document)
                        <a href="{{asset('storage/'.$document->DocumentFile)}}" target="__blank">{{$document->documentType->DocumentTypeName}}</a>
                    @endforeach
                @endif
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Medical Sectors</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($doctorSectors)
                        @foreach($doctorSectors as $sector)
                        <span class="badge badge-info">{{$sector->sector->MedicalSectorName}}</span>
                        @endforeach
                        @endif

                    </div>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- expereinces -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Experiences</h3>
                </div>
               
                <div class="card-body">
                    <div class="form-group">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Institute</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($doctor->experiences)
                                @foreach($doctor->experiences as $experience)
                                <tr>
                                    <td>{{$experience->Institute}}</td>
                                    <td>{{$experience->ExperienceFrom}}</td>
                                    <td>{{$experience->ExperienceTo}}</td>
                                </tr>
                                @endforeach
                                @endif


                        </table>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Profile Details</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="doctor_name">Doctor Name</label>
                            <span>{{$doctor->DoctorName}}</span>
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
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">DOB:</label>
                            <span>{{$doctor->DoctorDOB}}</span>
                        </div>
                        <div class="form-group">
                            <label>Hospital: </label>
                            @if($doctor->hospital)
                            <span>{{$doctor->hospital->HospitalName}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="doctor_website">Doctor Website</label>
                            <span>{{$doctor->DoctorWebsite}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_account_no">Bank Account No</label>
                            <span>{{$doctor->DoctorBankAccountNo}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Doctor Bank Name</label>
                            <span>{{$doctor->DoctorBankName}}</span>
                        </div>
                        <div class="form-group">
                            <label for="min_reservation_charge">Min reservation charge</label>
                            <span>{{$doctor->DoctorMinReservationCharge}}</span>
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image</label>
                            <div>
                                @if($doctor->DoctorProfileImage!=null)
                                <img src="{{asset('storage/'.$doctor->DoctorProfileImage)}}" width="200" height="150" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
            <!-- /.card -->

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Specialization</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($specializations)
                        @foreach($specializations as $specialization)
                        <span class="badge badge-info">{{$specialization->sector->MedicalSectorName}}</span>
                        @endforeach
                        @endif

                    </div>
                </div>
                <!-- /.card-body -->
            </div>
<!-- Awards -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Awards</h3>
                </div>
               
                <div class="card-body">
                    <div class="form-group">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Award Name</th>
                                    <th scope="col">For</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if($doctor->awards)
                                @foreach($doctor->awards as $award)
                                <tr>
                                    <td>{{$award->AwardName}}</td>
                                    <td>{{$award->AwardFor}}</td>
                                   
                                </tr>
                                @endforeach
                                @endif


                        </table>

                    </div>
                </div>
                <!-- /.card-body -->
            </div>

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

        $("#profile_image_upload").change(function() {
            $('#selected_profile_image').html(this.value);
        });
        //Date range picker
        // $('#patient_dob').datetimepicker({
        //     format: 'L'
        // });

    });
</script>

@endsection