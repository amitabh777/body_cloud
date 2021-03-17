@extends('admin.layouts.dashboard-datatables')

@section('page_title') Document Types <a href="{{route('admin.master_data.document_types.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="document_types_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documentTypes as $documentType)
                    <tr>
                        <td>{{$documentType->DocumentTypeName}}</td>
                        <td>{{$documentType->DocumentTypeDesc}}</td>                        
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input docuemnt_type_status_checkbox" id="document_type_status_{{$documentType->DocumentTypeID}}" @if($documentType->Status=='Active') checked @endif data-document_type_id="{{$documentType->DocumentTypeID}}" data-status_update_url="{{route('admin.master_data.document_type.status.update',$documentType->DocumentTypeID)}}">
                                <label class="custom-control-label" for="document_type_status_{{$documentType->DocumentTypeID}}"></label>
                            </div>
                        </td>
                        <td>
                        <a href="{{route('admin.master_data.document_type.edit',$documentType->DocumentTypeID)}}" class="btn btn-primary btn-sm">Edit</a>
                        <span class="btn btn-danger btn-sm bloodgroup-delete" data-DocumentTypeID="{{$documentType->DocumentTypeID}}" data-url="{{route('admin.master_data.document_type.destroy',['DocumentTypeID'=>$documentType->DocumentTypeID])}}">Delete</span>

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
<script src="{{asset('assets/admin/js/pages_js/document_type.js')}}"></script>


@endsection