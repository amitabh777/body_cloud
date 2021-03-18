@extends('admin.layouts.dashboard-datatables')

@section('page_title') Insurance Categoriess <a href="{{route('admin.master_data.insurance_category.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="insurance_category_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($insuranceCategories as $insuranceCategory)
                    <tr>
                        <td>{{$insuranceCategory->InsuranceCategoryName}}</td>
                        <td>{{$insuranceCategory->InsuranceCategoryDesc}}</td>                        
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input insurance_category_status_checkbox" id="insurance_category_status_{{$insuranceCategory->InsuranceCategoryID}}" @if($insuranceCategory->Status=='Active') checked @endif data-insurance_category_id="{{$insuranceCategory->InsuranceCaegoryID}}" data-status_update_url="{{route('admin.master_data.insurance_category.status.update',$insuranceCategory->InsuranceCategoryID)}}">
                                <label class="custom-control-label" for="insurance_category_status_{{$insuranceCategory->InsuranceCategoryID}}"></label>
                            </div>
                        </td>
                        <td>
                        <!-- edit -->
                        <a href="{{route('admin.master_data.insurance_category.edit',$insuranceCategory->InsuranceCategoryID)}}" class="btn btn-primary btn-sm">Edit</a>
                        <!-- delete -->
                        <span class="btn btn-danger btn-sm insurance_category-delete" data-insurance_category_id="{{$insuranceCategory->InsuranceCategoryID}}" data-url="{{route('admin.master_data.insurance_category.destroy',['InsuranceCategoryID'=>$insuranceCategory->InsuranceCategoryID])}}">Delete</span>

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
<script src="{{asset('assets/admin/js/pages_js/insurance_category.js')}}"></script>


@endsection