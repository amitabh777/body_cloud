@extends('admin.layouts.dashboard-datatables')

@section('page_title') Medical Sectors <a href="{{route('admin.master_data.medical_sector.create')}}" class="btn btn-primary">Add</a> @endsection
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
            <table id="medical_sectors_datatable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="header">Name</th>
                        <th scope="header">Description</th>
                        <th scope="header">Status</th>
                        <th scope="header">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicalSectors as $medicalSector)
                    <tr>
                        <td>{{$medicalSector->MedicalSectorName}}</td>
                        <td>{{$medicalSector->MedicalSectorDesc}}</td>                        
                        <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input medical_sector_status_checkbox" id="medical_sector_status_{{$medicalSector->MedicalSectorID}}" @if($medicalSector->Status=='Active') checked @endif data-medical_sector_id="{{$medicalSector->MedicalSectorID}}" data-status_update_url="{{route('admin.master_data.medical_sector.status.update',$medicalSector->MedicalSectorID)}}">
                                <label class="custom-control-label" for="medical_sector_status_{{$medicalSector->MedicalSectorID}}"></label>
                            </div>
                        </td>
                        <td>
                        <!-- edit -->
                        <a href="{{route('admin.master_data.medical_sector.edit',$medicalSector->MedicalSectorID)}}" class="btn btn-primary btn-sm">Edit</a>
                        <!-- delete -->
                        <span class="btn btn-danger btn-sm medical_sector-delete" data-medical_sector_id="{{$medicalSector->MedicalSectorID}}" data-url="{{route('admin.master_data.medical_sector.destroy',['MedicalSectorID'=>$medicalSector->MedicalSectorID])}}">Delete</span>
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
<script src="{{asset('assets/admin/js/pages_js/medical_sector.js')}}"></script>


@endsection