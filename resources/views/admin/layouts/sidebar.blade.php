<!-- Left sidebar menu start -->
<div class="ttr-sidebar">
    <div class="ttr-sidebar-wrapper content-scroll">
        <!-- side menu logo start -->
        <div class="ttr-sidebar-logo">
            <a href="#"><img alt="" src="{{asset('adminassets/images2/newlogo11.png')}}" width="160" height="10" style="margin-top:-12px;"></a>
            <!-- <div class="ttr-sidebar-pin-button" title="Pin/Unpin Menu">
                <i class="material-icons ttr-fixed-icon">gps_fixed</i>
                <i class="material-icons ttr-not-fixed-icon">gps_not_fixed</i>
            </div> -->
            <div class="ttr-sidebar-toggle-button">
                <i class="fas fa-arrow-left"></i>
            </div>
        </div>
        <!-- side menu logo end -->
        <!-- sidebar menu start -->
        <nav class="ttr-sidebar-navi">
            <ul>
                <li>
                    <a href="{{url('admin/account-head')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-calendar text-danger"></i></span>
                        <span class="ttr-label">Account Head</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/accounting')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-calendar text-danger"></i></span>
                        <span class="ttr-label">Accounting</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('airline-list')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-bars text-success"></i></span>
                        <span class="ttr-label">Airline List</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/bus')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-bus text-primary"></i></span>
                        <span class="ttr-label">Bus</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-dashboard text-danger"></i></span>
                        <span class="ttr-label">Dashborad</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/charges')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-money text-success"></i></span>
                        <span class="ttr-label">Expenses</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('invitation-detail')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-bars text-primary"></i></span>
                        <span class="ttr-label">ETPB List</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/gallery')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-image text-success"></i></span>
                        <span class="ttr-label">Gallery</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_gurdwara')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-home text-primary"></i></span>
                        <span class="ttr-label">Gurdwaras</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_gurdwaras')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-home text-success"></i></span>
                        <span class="ttr-label">Gurdwaras List</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/hotels')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-hotel text-secondary"></i></span>
                        <span class="ttr-label">Hotels</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/locations')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-location-dot text-primary"></i></span>
                        <span class="ttr-label">Locations</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/news')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-newspaper text-primary"></i></span>
                        <span class="ttr-label">News</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('blogs_admin')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-blog text-success"></i></span>
                        <span class="ttr-label">Blogs</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('page_banners')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-image text-primary"></i></span>
                        <span class="ttr-label">Page Banners</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('apply_packages')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-book text-primary"></i></span>
                        <span class="ttr-label">Packages</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/reports')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-book text-info"></i></span>
                        <span class="ttr-label">Reports</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('seasons')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-home text-secondary"></i></span>
                        <span class="ttr-label">Seasons</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('undertaking')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-newspaper text-dark"></i></span>
                        <span class="ttr-label">Undertaking Form</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/events')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-calendar text-primary"></i></span>
                        <span class="ttr-label">Upcoming Events</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('admin/users')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user text-dark"></i></span>
                        <span class="ttr-label">Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('visa')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user-group text-warning"></i></span>
                        <span class="ttr-label">Visa List</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('yatri-visa')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user text-success"></i></span>
                        <span class="ttr-label">Yatri Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('ids')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-id-card text-info"></i></span>
                        <span class="ttr-label">Yatri IDs</span>
                    </a>
                </li>
                <!--<li>-->
                <!--    <a href="{{route('apply_visa')}}" class="ttr-material-button">-->
                <!--        <span class="ttr-icon"><i class="fas fa-location-arrow text-warning" aria-hidden="true"></i></span>-->
                <!--        <span class="ttr-label">Visa</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{route('passport_nicop')}}" class="ttr-material-button">-->
                <!--        <span class="ttr-icon"><i class="fas fa-id-badge text-danger" aria-hidden="true"></i></span>-->
                <!--        <span class="ttr-label">Passport & NICOP</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{route('itenaries')}}" class="ttr-material-button">-->
                <!--        <span class="ttr-icon"><i class="fas fa-calendar text-danger" aria-hidden="true"></i></span>-->
                <!--        <span class="ttr-label">Itinerary</span>-->
                <!--    </a>-->
                <!--</li>-->
                <!--<li>-->
                <!--    <a href="{{url('admin/iternaries-list')}}" class="ttr-material-button">-->
                <!--        <span class="ttr-icon"><i class="fas fa-calendar text-danger"></i></span>-->
                <!--        <span class="ttr-label">Itineraries List</span>-->
                <!--    </a>-->
                <!--</li>-->
                {{-- <li>
                    <a href="#" class="ttr-material-button">
                        <span class="ttr-icon"><i class="ti-email"></i></span>
                        <span class="ttr-label">Mailbox</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="#" class="ttr-material-button"><span class="ttr-label">Mail Box</span></a>
                        </li>
                        <li>
                            <a href="#" class="ttr-material-button"><span class="ttr-label">Compose</span></a>
                        </li>
                        <li>
                            <a href="#" class="ttr-material-button"><span class="ttr-label">Mail Read</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="ttr-material-button">
                        <span class="ttr-icon"><i class="ti-calendar"></i></span>
                        <span class="ttr-label">Calendar</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="#" class="ttr-material-button"><span class="ttr-label">Basic Calendar</span></a>
                        </li>
                        <li>
                            <a href="#" class="ttr-material-button"><span class="ttr-label">List View</span></a>
                        </li>
                    </ul>
                </li> --}}
                {{-- <li>
                    <a href="bookmark.html" class="ttr-material-button">
                        <span class="ttr-icon"><i class="ti-bookmark-alt"></i></span>
                        <span class="ttr-label">Bookmarks</span>
                    </a>
                </li> --}}
                {{-- <li>
                    <a href="#" class="ttr-material-button">
                        <span class="ttr-icon"><i class="ti-comments"></i></span>
                        <span class="ttr-label">Review</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="ttr-material-button">
                        <span class="ttr-icon"><i class="ti-layout-accordion-list"></i></span>
                        <span class="ttr-label">Add listing</span>
                    </a>
                </li> --}}
                <li>
                    <a href="{{ url('/admin/profile') }}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user text-warning"></i></span>
                        <span class="ttr-label">My Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('admin_logout')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fa fa-sign-out"></i></span>
                        <span class="ttr-label">Logout</span>
                    </a>
                </li>
                <li class="ttr-seperate"></li>
            </ul>
            <!-- sidebar menu end -->
        </nav>
        <!-- sidebar menu end -->
    </div>
</div>
<!-- Left sidebar menu end -->
