<!DOCTYPE html>
<html lang="en">

<!-- Include head -->
@include('admin.partials.head')
<!-- End of head -->

<body class="theme-red">

    <!--header start-->
    @include('admin.partials.header')
    <!--header end-->

    <!-- Include navigation -->
    @include('admin.partials.navigation')
    <!-- End of navigation -->
    
    <section class="content">
        <div class="container-fluid">            
                 <!-- Include Flash Messages -->
                @include('admin.partials.flash-messages')
                <!-- End of Flash Messages -->

                <!-- Include Content -->
                @yield('content')
                <!-- End of Content --> 
        </div>
    </section> 

    <!-- Include header navigation -->
    @include('admin.partials.footer')
    <!-- End of include header navigation --> 
    
</body>
</html>