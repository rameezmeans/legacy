<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="preloader">
            <div class="spinner-layer pl-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
        <p>Please wait...</p>
    </div>
</div>
<!-- #END# Page Loader -->
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<!-- #END# Overlay For Sidebars -->

<style>

   .nav-item {
       margin-top: -3px;
       top: 0px;
       position: relative !important;
       margin-right: 3px;
   }

   .notification {
       position: absolute;
       top: 0px;
       border: 1px solid red;
       right: 0px;
       font-size: 9px;
       background: #ffffff;
       color: #FFFFFF;
       min-width: 20px;
       padding: 0px 5px;
       height: 20px;
       border-radius: 10px;
       text-align: center;
       line-height: 19px;
       vertical-align: middle;
       display: block;
       color: black;
   }

   .navbar-nav>li>.dropdown-menu {
       margin-top: 0 !important;
   }
   .dropdown-menu {
       /*display: none;*/
       min-width: 300px;
       padding: 20px 13px;
       /*display: grid;*/
   }

   .dropdown-item{
       padding: 5px;

   }

    li.open>div.dropdown-menu-right{
        display: grid;

    }

   .dropdown-menu .dropdown-item:hover{

       background-color: #F44336;
       color: #FFFFFF;

   }

    a:hover{
        text-decoration: none;
    }





</style>

<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="/admin">{{ config('legacy.site_name') }}</a>
        </div> 
        <div class="collapse navbar-collapse" id="navbar-collapse">




            <ul class="nav navbar-nav navbar-right">

                <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification">{{ \App\Notification::where('approved', '=', 0)->count() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">

                        @if(App\Notification::all()->count() != 0)

                        @foreach(App\Notification::all() as $n)
                            @if(!$n->approved)
                                <a class="dropdown-item" href="{{ url('/').'/admin/notifications' }}">{{ \App\User::findOrfail( $n->editor_id )->name }} updated {{  ucfirst( $n->type ) }} for {{ \App\Event::findOrFail( $n->event_id )->name }}</a>
                            @endif
                        @endforeach
                            @else

                            <div>No Notifications</div>

                            @endif

                    </div>
                </li>

                <li>
                    <a href="/admin/profile" class="btn bg-blue waves-effect waves-light" style="padding: 5px 20px; text-transform: uppercase;">
                        {{ Auth::user()->name }} 
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="btn bg-black waves-effect waves-light" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="padding: 5px 20px; text-transform: uppercase;">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form> 
                </li>             
            </ul>
        </div>                        
    </div>
</nav>
<!-- #Top Bar --> 