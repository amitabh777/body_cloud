 <!-- Content Header (Page header) -->
 <section class="content-header">
   <div class="container-fluid">
     <div class="row">
       <div class="col-sm-6 position-sticky sticky-top1 fixed-top1">
         @if(session('status')=='success')
         <div class="alert alert-success" role="alert">
           Success! {{session('message')}}
         </div>
         @endif
         @if(session('status')=='failed')
         <div class="alert alert-danger" role="alert">
           Failed! {{session('message')}}
         </div>
         @endif
       </div>
     </div>
     <div class="row mb-2">
       <div class="col-sm-6">
         <h1>@yield('page_title')</h1>
       </div>
       <div class="col-sm-6">
         <ol class="breadcrumb float-sm-right">
           <li class="breadcrumb-item"><a href="#">Home</a></li>
           <li class="breadcrumb-item"><a href="#">Layout</a></li>
           <li class="breadcrumb-item active">Fixed Layout</li>
         </ol>
       </div>
     </div>
   </div><!-- /.container-fluid -->
 </section>