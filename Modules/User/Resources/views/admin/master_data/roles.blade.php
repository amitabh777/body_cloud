@extends('admin.layouts.dashboard-datatables')

@section('page_title') Roles <a href="{{route('admin.master_data.role.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="roles_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Role Name</th>
                        <th scope="header">Slug</th>
                        <th scope="header">Parent Role</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$role->RoleName}}</td>
                        <td>{{$role->RoleSlug}}</td>
                        <td>
                           {{$role->parentRole?$role->parentRole->RoleName:''}}
                        </td>
                        <td>
                            <a href="{{route('admin.master_data.role.edit',$role->RoleID)}}" class="btn btn-primary btn-sm">Edit</a>
                            <span class="btn btn-danger btn-sm role-delete" data-roleID="{{$role->RoleID}}" data-url="{{route('admin.master_data.role.destroy',['RoleID'=>$role->RoleID])}}">Delete</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="header">Role Name</th>
                        <th scope="header">Slug</th>
                        <th scope="header">Parent Role</th>
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
<script src="{{asset('assets/admin/js/pages_js/role.js')}}"></script>


@endsection