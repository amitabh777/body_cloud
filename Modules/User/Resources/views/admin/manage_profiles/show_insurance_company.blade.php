@extends('admin.layouts.dashboard-datatables')

@section('page_title') Laboratory @endsection
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
                            <span>{{$insuranceCompany->user->UniqueID}}</span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <span>{{$insuranceCompany->user->Email}}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <span>{{$insuranceCompany->user->Phone}}</span>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <span>{{$insuranceCompany->user->Addres}}</span>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input patient_status_checkbox" id="Status" name="Status" value="Active" data-UserID="{{$insuranceCompany->user->UserID}}" @if($insuranceCompany->user->Status=='Active') checked @endif >
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
                            <label for="doctor_name">Company Name: </label>
                            <span>{{$insuranceCompany->InsuranceCompanyName}}</span>
                        </div>

                        <div class="form-group">
                            <label>Info: </label>
                            <p>{{$insuranceCompany->InsuranceCompanyInfo}}</p>
                        </div>
                        <div class="form-group">
                            <label>Company Website: </label>
                            <span>{{$insuranceCompany->InsuranceCompanyWebsite}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_account_no">Bank Account No</label>
                            <span>{{$insuranceCompany->InsuranceCompanyBankAccountNo}}</span>
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <span>{{$insuranceCompany->InsuranceCompanyBankName}}</span>
                        </div>                      
                        <div class="form-group">
                            <label for="profile_image_upload">Profile Image</label>
                            <div>
                                @if($insuranceCompany->InsuranceCompanyProfileImage!=null)
                                <img src="{{asset('storage/'.$insuranceCompany->InsuranceCompanyProfileImage)}}" width="200" height="150" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
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