@extends('admin.layouts.dashboard-datatables')

@section('page_title') Create Lab Test @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lab Test</h3>
                </div>
                <!-- form start -->
                <form id="lab_test_form" method="post" action="{{route('admin.master_data.lab_test.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="lab_test_name">LabTest Name</label>
                            <input type="text" class="form-control" id="lab_test_name" name="LabTestName" value="{{old('LabTestName')}}" required>
                            @error('LabTestName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lab_test_desc">Description</label>
                            <textarea name="LabTestDesc" class="form-control" id="lab_test_desc"></textarea>
                            @error('LabTestDesc')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input lab_test_status_checkbox" id="Status" name="Status" value="Active" >
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
     

    });
</script>

@endsection