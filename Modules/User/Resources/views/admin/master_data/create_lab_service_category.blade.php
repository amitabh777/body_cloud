@extends('admin.layouts.dashboard-datatables')

@section('page_title') Create Lab Service Category  @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lab Service Category</h3>
                </div>
                <!-- form start -->
                <form method="post" action="{{route('admin.master_data.lab_service_category.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="lab_service_category_name">Lab Service Category Name</label>
                            <input type="text" class="form-control" id="lab_service_category_name" name="LabServiceCategoryName" value="{{old('LabServiceCategoryName')}}" required>
                            @error('LabServiceCategoryName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lab_service_category_desc">Description</label>
                            <textarea name="LabServiceCategoryDesc" class="form-control" id="lab_service_category_desc" required></textarea>
                            @error('LabServiceCategoryDesc')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                        
                        <div class="form-group">
                            <label for="status">Status</label>
                            <div class="custom-control custom-switch custom-control custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input lab_service_category_status_checkbox" id="Status" checked name="Status" value="Active" >
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
        // $("#example1").DataTable({
        //   "responsive": true, "lengthChange": false, "autoWidth": false,
        // //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    

    });
</script>

@endsection