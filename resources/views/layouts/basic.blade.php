<!DOCTYPE html>
<html>
    <!-- head Section -->
    @include('partials.head')
    <!-- head Section -->

    <body class="@yield('body-class')">
        
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PFMSNKW"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

        <!--header start-->
        @include('partials.header')
        <!--header end-->

        <!-- Include Content -->
		@yield('content')
		<!-- End of Content -->

        <!-- Footer Section -->
        @include('partials.footer')
        <!-- End of Footer Section -->
    </body>
</html>