@extends('admin.layouts.dashboard-datatables')
@section('page_title') Laboratory @endsection
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
            <table id="laboratory_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Info</th>
                        <th scope="header">Status</th>                        
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laboratories as $laboratory)
                    <tr>
                        <td>{{$laboratory->LaboratoryCompanyName}}</td>
                        <td>{{$laboratory->LaboratoryWebsite}}</td>
                        <td>{{$laboratory->LaboratoryInfo}}</td>                       
                        <td>
                            <!-- <input type="checkbox" class="laboratory_active_checkbox" data-UserID="{{$laboratory->user->UserID}}" name="checkbox_status_{{$laboratory->LaboratoryID}}" @if($laboratory->user->Status=='Active') checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
                            <input type="checkbox" class="user_status_checkbox" data-UserID="{{$laboratory->user->UserID}}" name="checkbox_status_{{$laboratory->UserID}}" @if($laboratory->user->Status=='Active') checked @endif data-update_url="{{route('admin.user.status.update',$laboratory->UserID)}}"  data-off-text="Inactive" data-on-text="Active">

                        </td>
                        <td>
                        <a href="{{route('admin.manage_profiles.laboratory.show',$laboratory->UserID)}}" class="btn btn-primary btn-sm">View Details</a>

                    </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    <th scope="header">Company Name</th>
                        <th scope="header">Website</th>
                        <th scope="header">Info</th>
                        <th scope="header">Status</th>                        
                        <th scope="header">Action</th>
                    </tr>
                </tfoot>
            </table>
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
<script src="{{asset('assets/admin/js/pages_js/laboratory.js')}}"></script>


@endsection