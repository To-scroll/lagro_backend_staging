<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="">

<head>
    <meta charset="utf-8" />
    <title>Dashboard | LAGRO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard Template" name="description" />
    <meta content="LAGRO" name="author" />
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('public/logo/logo_red4.png')}}">
    <link href="{{asset('assets/admin/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
  
    <!-- jsvectormap css -->
    <link href="{{asset('assets/admin/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{asset('assets/admin/js/layout.js')}}"></script>

 
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('assets/admin/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/admin/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
    
    <!-- Font Awesome 5 CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">  <!--for this also i coulnt find the file -->

   
    
    <link href="{{ asset('assets/admin/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/responsive.bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    
    <link href="{{ asset('assets/admin/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/admin/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!--<link href="{{ asset('assets/admin/css/summernote.min.css') }}" rel="stylesheet" type="text/css" /> ==== not woking becouse needs icons for summernote -->
    <link href="{{ asset('assets/admin/css/select2.min.css') }}" rel="stylesheet" type="text/css" />


 
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/dropzone/dropzone.css') }}"  type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/filepond/filepond.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
    <link rel="stylesheet" href="{{asset('assets/admin/libs/dropzone/dropzone.css')}}" type="text/css" />
    <!-- Filepond css -->
    <link rel="stylesheet" href="{{asset('assets/admin/libs/filepond/filepond.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css')}}">
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css" >
 

    @yield('styles') 

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.includes.admin.header')

<!-- /.modal -->
        <!-- ========== App Menu ========== -->
        @include('layouts.includes.admin.sidebar')
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                   
                    @yield('content')
                  
                   
                </div>
                <!-- container-fluid -->
            </div>
           
            <!-- End Page-content -->

            @include('layouts.includes.admin.footer')
        </div>

        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>





   
   
   
    <script src="{{ asset('assets/admin/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/sweetalert2.all.min.js') }}"></script>

    
    <!--datatable js-->
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/summernote.min.js') }}"></script>  
    <script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>

    <!-- JAVASCRIPT -->
    <script src="{{asset('assets/admin/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('assets/admin/js/plugins.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{asset('assets/admin/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Vector map-->
    <script src="{{asset('assets/admin/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!--Swiper slider js-->
    <script src="{{asset('assets/admin/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- Dashboard init -->
    <script src="{{asset('assets/admin/js/pages/dashboard-ecommerce.init.js')}}"></script>
    <script src="{{asset('assets/admin/libs/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pages/ecommerce-product-details.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('assets/admin/js/app.js')}}"></script>
    
    <script src="{{asset('assets/admin/js/pages/datatables.init.js')}}"></script>
    <script src="{{ asset('assets/admin/js/pages/select2.init.js') }}"></script>
      


    <script src="{{ asset('assets/admin/libs/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ asset('assets/admin/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <!--<script src="{{ asset('assets/admin/js/pages/ecommerce-product-create.init.js')}}"></script>-->
    <script src="{{ asset('assets/admin/js/dropzone.min.js') }}"></script>

    <!-- filepond js -->
    <script src="{{asset('assets/admin/libs/filepond/filepond.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js')}}"></script>
    <script src="{{asset('assets/admin/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js')}}"></script>
    
    <!--<script src="{{asset('assets/admin/js/pages/form-file-upload.init.js')}}"></script>-->

       <script>
           $(document).ready(function () {
    $(document)
        .ajaxStart(function () {
            $("#preloader").fadeIn(600);
        })
        .ajaxStop(function () {
            $("#preloader").fadeOut(100);
        });
});

       </script> 
    @yield('scripts')
</body>

</html>