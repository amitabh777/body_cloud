@extends('admin.layouts.dashboard-datatables')

@section('page_title') Lab Tests <a href="{{route('admin.master_data.lab_test.create')}}" class="btn btn-primary">Add</a> @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- <div class="card-header">
                    <h3 class="card-title">DataTable with minimal features & hover style</h3>
                </div> -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="lab_test_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Test Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($labTests as $labTest)
                    <tr>
                        <td>{{$labTest->LabTestName}}</td>
                        <td>{{$labTest->LabTestDesc}}</td>
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input lab_test_status_checkbox" id="lab_test_status_{{$labTest->LabTestID}}" @if($labTest->Status=='Active') checked @endif data-lab_test_id="{{$labTest->LabTestID}}" data-status_update_url="{{route('admin.master_data.lab_test.status.update',$labTest->LabTestID)}}">
                                <label class="custom-control-label" for="lab_test_status_{{$labTest->LabTestID}}"></label>
                            </div>
                        </td>
                        <td>
                            <!-- edit -->
                            <a href="{{route('admin.master_data.lab_test.edit',$labTest->LabTestID)}}" class="btn btn-primary btn-sm">Edit</a>
                            <!-- delete -->
                            <span class="btn btn-danger btn-sm lab_test-delete" data-lab_test_id="{{$labTest->LabTestID}}" data-url="{{route('admin.master_data.lab_test.destroy',['LabTestID'=>$labTest->LabTestID])}}">Delete</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </tfoot>
            </table>
            <!-- <button type="button" class="btn btn-success toastrDefaultSuccess">
                  Launch Success Toast
                </button> -->
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
<script src="{{asset('assets/admin/js/pages_js/lab_test.js')}}"></script>


@endsection