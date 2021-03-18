@extends('admin.layouts.dashboard-datatables')

@section('page_title') User Roles <a href="{{route('admin.master_data.role.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="bloodgroups_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Roles as $role)
                    <tr>
                        <td>{{$Role->Role Name}}</td>
                        <td>{{$Role->}}</td>                        
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input bloodgroup_status_checkbox" id="bloodgroup_status_{{$Roles->BloodGroupID}}" @if($Roles->Status=='Active') checked @endif data-bloodgroup_id="{{$Roles->BloodGroupID}}" data-status_update_url="{{route('admin.master_data.bloodgroup.status.update',$Roles->BloodGroupID)}}">
                                <label class="custom-control-label" for="bloodgroup_status_{{$Roles->BloodGroupID}}"></label>
                            </div>
                        </td>
                        <td>
                        <a href="{{route('admin.master_data.roles.edit',$Roles->BloodGroupID)}}" class="btn btn-primary btn-sm">Edit</a>
                        <span class="btn btn-danger btn-sm role-delete" data-RoleID="{{$Roles->RoleID}}" data-url="{{route('admin.master_data.roles.destroy',['BloodGroupID'=>$Roles->BloodGroupID])}}">Delete</span>

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
<script src="{{asset('assets/admin/js/pages_js/bloodgroup.js')}}"></script>


@endsection