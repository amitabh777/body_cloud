@extends('admin.layouts.dashboard-datatables')

@section('page_title') Hospital @endsection
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
                            <span>{{$hospital->user->UniqueID}}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <span>{{$hospital->user->Email}}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <span>{{$hospital->user->Phone}}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <span>{{$hospital->user->Addres}}</span>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$hospital->user->UserID}}" @if($hospital->user->Status=='Active') checked @endif >
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
                <div class="card-body">
                @if($hospital->documents)
                    @foreach($hospital->documents as $document)
                        <a href="{{asset('storage/'.$document->DocumentFile)}}" target="__blank">{{$document->documentType->DocumentTypeName}}</a></br>
                    @endforeach
                @endif
                </div>
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
                            <label for="doctor_name">Hospital Name</label>
                            <span>{{$hospital->HospitalName}}</span>
                        </div>

                        <div class="form-group">
                            <label>Hospital Info: </label>
                            <p>{{$hospital->HospitalInfo}}</p>
                        </div>
                        <div class="form-group">
                            <label>Contact person: </label>
                            <span>{{$hospital->HospitalContactName}}</span>
                        </div>
                        <div class="form-group">
                            <label for="doctor_website">Hospital Website</label>
                            <span>{{$hospital->HospitalWebsite}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_account_no">Bank Account No</label>
                            <span>{{$hospital->HospitalBankAccountNo}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <span>{{$hospital->HospitalBankName}}</span>
                        </div>
                        <div class="form-group">
                            <label for="min_reservation_charge">Min reservation charge</label>
                            <span>{{$hospital->HospitalMinReservationCharge}}</span>
                        </div>
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image</label>
                            <div>
                                @if($hospital->HospitalProfileImage!=null)
                                <img src="{{asset('storage/'.$hospital->HospitalProfileImage)}}" width="200" height="150" />
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
                    <h3 class="card-title">Medical Sectors</h3>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        @if($hospitalSectors)
                        @foreach($hospitalSectors as $hospitalSector)
                        <span class="badge badge-info">{{$hospitalSector->sector->MedicalSectorName}}</span>
                        @endforeach
                        @endif

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