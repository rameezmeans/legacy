

<section>
     <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <!-- <div class="user-info">
            <div class="info-container">
                <div class="name" aria-haspopup="true" aria-expanded="false"> <a href="/admin/profile">{{ Auth::user()->name }}</a></div>
                <div class="email">{{ Auth::user()->email }}</div> 
            </div>
        </div> -->
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li <?php echo Request::segment(1) == '' ? '' : 'class="active"' ?>>
                    <a href="/admin">
                        <i class="material-icons">home</i>
                        <span>Home</span>
                    </a>
                </li>
                <li <?php echo Request::segment(2) == 'users' ? 'class="active"' : '' ?>>
                    <a href="/admin/users">
                        <i class="material-icons">person</i>
                        <span>Users</span>
                    </a>
                </li>

                <li <?php echo Request::segment(2) == 'orders' ? 'class="active"' : '' ?>>
                    <a href="/admin/orders">
                        <i class="material-icons">shopping_cart</i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li <?php echo Request::segment(2) == 'events' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i style="margin-top: 10px;" class="fa fa-calendar"></i>
                        <span>Event Pages</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/events">Event Pages</a>
                        </li>
                        <li>
                            <a href="/admin/general_instructions">General Instructions</a>
                        </li>
                        <li>
                            <a href="/admin/notifications">Notifications</a>
                        </li>

                        <li>
                            <a href="/admin/email_templates">Email Templates</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'products' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">directions_boat</i>
                        <span>Yacht</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/products">Yacht</a>
                        </li>
                        <li>
                            <a href="/admin/products/create">Add New</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'locations' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">location_on</i>
                        <span>Locations</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/locations">Locations</a>
                        </li>
                        <li>
                            <a href="/admin/locations/create">Add New</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'foods' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">restaurant</i>
                        <span>Food Catering</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/foods">Food Catering</a>
                        </li>
                        <li>
                            <a href="/admin/foods/create">Add New</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'beverages' ? 'class="active"' : ''?> <?php echo Request::segment(2) == 'bottles' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">local_bar</i>
                        <span>Beverage Service</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/beverages">Bars</a>
                        </li>
                        <li>
                            <a href="/admin/beverages/create">Add New Bar</a>
                        </li>
                        <li>
                            <a href="/admin/bottles">Bottles</a>
                        </li>
                        <li>
                            <a href="/admin/bottles/create">Add New Bottle</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'addons' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                       <i class="material-icons">more</i>
                        <span>Add-ons</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/addons">Add-ons</a>
                        </li>
                        <li>
                            <a href="/admin/addons/create">Add New</a>
                        </li>
                    </ul>
                </li>                
                <li <?php echo Request::segment(2) == 'pprices' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">attach_money</i>
                        <span>Price Setting</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/pprices">Products Prices</a>
                        </li>
                        <li>
                            <a href="/admin/pprices/create">Add New</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'coupons' ? 'class="active"' : '' ?>>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">card_giftcard</i>
                        <span>Coupons Setting</span>
                    </a>
                    <ul class="ml-menu">
                        <li>
                            <a href="/admin/coupons">Coupons List</a>
                        </li>
                        <li>
                            <a href="/admin/coupons/create">Add New</a>
                        </li>
                    </ul>
                </li>
                <li <?php echo Request::segment(2) == 'dbookings' ? 'class="active"' : '' ?>>
                    <a href="/admin/dbookings" >
                        <i class="material-icons">no_encryption</i>
                        <span>Disable Booking</span>
                    </a> 
                </li>
                <li <?php echo Request::segment(2) == 'contacts' ? 'class="active"' : '' ?>>
                    <a href="/admin/contacts" >
                        <i class="material-icons">contacts</i>
                        <span>Leads</span>
                    </a> 
                </li>
                <li <?php echo Request::segment(2) == 'settings' ? 'class="active"' : '' ?>>
                    <a href="/admin/settings" >
                        <i class="material-icons">build</i>
                        <span>Setting</span>
                    </a> 
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2017 <a href="javascript:void(0);">{{ config('legacy.site_name') }}</a>.
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
    </aside>
    <!-- #END# Right Sidebar -->
</section>
