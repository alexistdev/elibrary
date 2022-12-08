<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rocker - Bootstrap 5 Admin Dashboard Template</title>
    <!-- Start : Header -->
    <x-rocker.header-layout />
    <!-- End : Header -->

</head>

<body>
<!--wrapper-->
<div class="wrapper">
    <!--Start: Sidebar -->
    <x-rocker.sidebar-layout />
    <!--End: Sidebar -->

    <!--start header -->
    <x-rocker.navbar />
    <!--end header -->
    <!--start page wrapper -->
    <div class="page-wrapper">
        {{$slot}}
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button-->
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

    <!--Start: Footer-->
    <x-rocker.footer-layout />
    <!--End: Footer-->
</div>
<!--end wrapper-->

<!-- Bootstrap JS -->

<!-- Start: Jlayout -->
<x-rocker.js-layout />
<!-- End: Jlayout -->
@stack('jsLayout')
</body>

</html>
