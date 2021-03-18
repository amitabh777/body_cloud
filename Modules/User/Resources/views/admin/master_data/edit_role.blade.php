@extends('admin.layouts.dashboard-datatables')

@section('page_title') Role Edit @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Role</h3>
                </div>
                <!-- form start -->
                <form method="post" action="{{route('admin.master_data.role.update',$role->RoleID)}}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" class="form-control" id="role_name" name="RoleName" value="{{old('RoleName',$role->RoleName)}}" required>
                            @error('RoleName')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role_slug">Role Slug</label>
                            <input type="text" class="form-control" id="role_slug" name="RoleSlug" value="{{old('RoleSlug',$role->RoleSlug)}}" required>
                            @error('RoleSlug')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>                       
                        <div class="form-group">
                            <label for="parent_role">Parent Role</label>
                            <select name="ParentRoleID" class="form-control">
                                @if($roles)
                                <option value="none">None</option>
                                @foreach($roles as $Role)
                                <option value="{{$Role->RoleID}}" @if($role->ParentRoleID==$Role->RoleID) selected @endif >{{$Role->RoleName}}</option>
                                @endforeach
                                @endif
                            </select>
                            @error('ParentRoleID')
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