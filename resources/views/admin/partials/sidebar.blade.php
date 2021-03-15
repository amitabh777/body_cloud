<?php

use Illuminate\Support\Facades\Route;

$route = Route::currentRouteName();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="../../index3.html" class="brand-link">
    <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('public/assets/admin/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <!-- <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div> -->
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.dashboard.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="../../index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../../index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard v3</p>
              </a>
            </li> -->
          </ul>
        </li>
        <li class="nav-item menu-open2">
          <a href="#" class="nav-link active1">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Manage Profiles
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.patient.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>Patient <span class="badge badge-info right">2</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.doctor.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>Doctor</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.hospital.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>Hospital</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.ambulance.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>Ambulance</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.laboratory.index')}}" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
                <p>Laboratory</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.manage_profiles.insurance_company.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Insurance Company</p>
              </a>
            </li>           
          </ul>
        </li>

       
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <form method="post" action="{{route('logout')}}">
              @csrf
              <button type="submit" class="btn btn-primary">Logout</button>
            </form>
          </a>

        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>