@extends('admin.layouts.dashboard-datatables')

@section('page_title') Lab Service Categories <a href="{{route('admin.master_data.lab_service_category.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="lab_service_categories_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($labServiceCategories as $labServiceCategory)
                    <tr>
                        <td>{{$labServiceCategory->LabServiceCategoryName}}</td>
                        <td>{{$labServiceCategory->LabServiceCategoryDesc}}</td>
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input lab_service_category_status_checkbox" id="lab_service_category_status_{{$labServiceCategory->LabServiceCategoryID}}" @if($labServiceCategory->Status=='Active') checked @endif data-lab_service_category_id="{{$labServiceCategory->LabServiceCategoryID}}" data-status_update_url="{{route('admin.master_data.lab_service_category.status.update',$labServiceCategory->LabServiceCategoryID)}}">
                                <label class="custom-control-label" for="lab_service_category_status_{{$labServiceCategory->LabServiceCategoryID}}"></label>
                            </div>
                        </td>
                        <td>
                            <!-- edit -->
                            <a href="{{route('admin.master_data.lab_service_category.edit',$labServiceCategory->LabServiceCategoryID)}}" class="btn btn-primary btn-sm">Edit</a>
                            <!-- delete -->
                            <span class="btn btn-danger btn-sm lab_service_category-delete" data-lab_service_category_id="{{$labServiceCategory->LabServiceCategoryID}}" data-url="{{route('admin.master_data.lab_service_category.destroy',['categoryId'=>$labServiceCategory->LabServiceCategoryID])}}">Delete</span>
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
<script src="{{asset('assets/admin/js/pages_js/lab_service_category.js')}}"></script>


@endsection