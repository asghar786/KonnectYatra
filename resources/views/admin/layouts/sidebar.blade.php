<!-- Left sidebar menu start -->
<div class="ttr-sidebar">
    <div class="ttr-sidebar-wrapper content-scroll">
        <!-- side menu logo start -->
        <div class="ttr-sidebar-logo">
            <a href="#"><img alt="" src="{{asset('adminassets/images2/newlogo11.png')}}" width="160" height="10" style="margin-top:-12px;"></a>
            <div class="ttr-sidebar-toggle-button">
                <i class="fas fa-arrow-left"></i>
            </div>
        </div>
        <!-- side menu logo end -->
        <!-- sidebar menu start -->
        <nav class="ttr-sidebar-navi">
            @php
                $current = url()->current();
                // Active when the URL matches exactly OR the current page is a sub-page of it
                // (e.g. admin/news -> admin/news/create). Trailing-slash guard avoids
                // false matches like /visa matching /visa-form.
                $isCur = function ($url) use ($current) {
                    $url = rtrim($url, '/');
                    return $current === $url || \Illuminate\Support\Str::startsWith($current, $url . '/');
                };
                // A group is open/highlighted when any of its children is active.
                $groupOpen = function (array $urls) use ($isCur) {
                    foreach ($urls as $u) { if ($isCur($u)) return true; }
                    return false;
                };
            @endphp
            <ul>
                <!-- Dashboard -->
                <li class="{{ $isCur(route('dashboard')) ? 'show' : '' }}">
                    <a href="{{route('dashboard')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-dashboard text-danger"></i></span>
                        <span class="ttr-label">Dashboard</span>
                    </a>
                </li>

                <!-- Analytics -->
                <li class="{{ $isCur(route('analytics')) ? 'show' : '' }}">
                    <a href="{{route('analytics')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-chart-line text-success"></i></span>
                        <span class="ttr-label">Analytics</span>
                    </a>
                </li>

                <!-- Bookings & Yatris -->
                @php $open = $groupOpen([route('yatri-visa'), route('visa'), route('ids'), route('airline-list'), route('invitation-detail'), route('undertaking'), url('admin/reports')]); @endphp
                <li class="{{ $open ? 'show' : '' }}">
                    <a href="javascript:void(0);" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-users text-success"></i></span>
                        <span class="ttr-label">Bookings &amp; Yatris</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul @if($open) style="display:block;" @endif>
                        <li class="{{ $isCur(route('yatri-visa')) ? 'show' : '' }}"><a href="{{route('yatri-visa')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-user text-success"></i></span><span class="ttr-label">Yatri Bookings</span></a></li>
                        <li class="{{ $isCur(route('visa')) ? 'show' : '' }}"><a href="{{route('visa')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-user-group text-warning"></i></span><span class="ttr-label">Visa List</span></a></li>
                        <li class="{{ $isCur(route('ids')) ? 'show' : '' }}"><a href="{{route('ids')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-id-card text-info"></i></span><span class="ttr-label">Yatri IDs</span></a></li>
                        <li class="{{ $isCur(route('airline-list')) ? 'show' : '' }}"><a href="{{route('airline-list')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-bars text-success"></i></span><span class="ttr-label">Airline List</span></a></li>
                        <li class="{{ $isCur(route('invitation-detail')) ? 'show' : '' }}"><a href="{{route('invitation-detail')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-bars text-primary"></i></span><span class="ttr-label">ETPB List</span></a></li>
                        <li class="{{ $isCur(route('undertaking')) ? 'show' : '' }}"><a href="{{route('undertaking')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-newspaper text-dark"></i></span><span class="ttr-label">Undertaking Form</span></a></li>
                        <li class="{{ $isCur(url('admin/reports')) ? 'show' : '' }}"><a href="{{url('admin/reports')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-book text-info"></i></span><span class="ttr-label">Reports</span></a></li>
                    </ul>
                </li>

                <!-- Packages & Travel -->
                @php $open = $groupOpen([route('apply_packages'), route('seasons'), url('admin/hotels'), url('admin/bus'), url('admin/locations'), route('admin_gurdwara'), route('admin_gurdwaras')]); @endphp
                <li class="{{ $open ? 'show' : '' }}">
                    <a href="javascript:void(0);" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-suitcase text-primary"></i></span>
                        <span class="ttr-label">Packages &amp; Travel</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul @if($open) style="display:block;" @endif>
                        <li class="{{ $isCur(route('apply_packages')) ? 'show' : '' }}"><a href="{{route('apply_packages')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-book text-primary"></i></span><span class="ttr-label">Packages</span></a></li>
                        <li class="{{ $isCur(route('seasons')) ? 'show' : '' }}"><a href="{{route('seasons')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-home text-secondary"></i></span><span class="ttr-label">Seasons</span></a></li>
                        <li class="{{ $isCur(url('admin/hotels')) ? 'show' : '' }}"><a href="{{url('admin/hotels')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-hotel text-secondary"></i></span><span class="ttr-label">Hotels</span></a></li>
                        <li class="{{ $isCur(url('admin/bus')) ? 'show' : '' }}"><a href="{{url('admin/bus')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-bus text-primary"></i></span><span class="ttr-label">Bus</span></a></li>
                        <li class="{{ $isCur(url('admin/locations')) ? 'show' : '' }}"><a href="{{url('admin/locations')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-location-dot text-primary"></i></span><span class="ttr-label">Locations</span></a></li>
                        <li class="{{ $isCur(route('admin_gurdwara')) ? 'show' : '' }}"><a href="{{route('admin_gurdwara')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-home text-primary"></i></span><span class="ttr-label">Gurdwaras</span></a></li>
                        <li class="{{ $isCur(route('admin_gurdwaras')) ? 'show' : '' }}"><a href="{{route('admin_gurdwaras')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-home text-success"></i></span><span class="ttr-label">Gurdwaras List</span></a></li>
                    </ul>
                </li>

                <!-- Accounts -->
                @php $open = $groupOpen([url('admin/account-head'), url('admin/accounting'), url('admin/charges')]); @endphp
                <li class="{{ $open ? 'show' : '' }}">
                    <a href="javascript:void(0);" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-calculator text-danger"></i></span>
                        <span class="ttr-label">Accounts</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul @if($open) style="display:block;" @endif>
                        <li class="{{ $isCur(url('admin/account-head')) ? 'show' : '' }}"><a href="{{url('admin/account-head')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-calendar text-danger"></i></span><span class="ttr-label">Account Head</span></a></li>
                        <li class="{{ $isCur(url('admin/accounting')) ? 'show' : '' }}"><a href="{{url('admin/accounting')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-calendar text-danger"></i></span><span class="ttr-label">Accounting</span></a></li>
                        <li class="{{ $isCur(url('admin/charges')) ? 'show' : '' }}"><a href="{{url('admin/charges')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-money text-success"></i></span><span class="ttr-label">Expenses</span></a></li>
                    </ul>
                </li>

                <!-- Website Content -->
                @php $open = $groupOpen([url('admin/news'), route('blogs_admin'), route('page_banners'), url('admin/gallery'), url('admin/events')]); @endphp
                <li class="{{ $open ? 'show' : '' }}">
                    <a href="javascript:void(0);" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-newspaper text-primary"></i></span>
                        <span class="ttr-label">Website Content</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul @if($open) style="display:block;" @endif>
                        <li class="{{ $isCur(url('admin/news')) ? 'show' : '' }}"><a href="{{url('admin/news')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-newspaper text-primary"></i></span><span class="ttr-label">News</span></a></li>
                        <li class="{{ $isCur(route('blogs_admin')) ? 'show' : '' }}"><a href="{{route('blogs_admin')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-blog text-success"></i></span><span class="ttr-label">Blogs</span></a></li>
                        <li class="{{ $isCur(route('page_banners')) ? 'show' : '' }}"><a href="{{route('page_banners')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-image text-primary"></i></span><span class="ttr-label">Page Banners</span></a></li>
                        <li class="{{ $isCur(url('admin/gallery')) ? 'show' : '' }}"><a href="{{url('admin/gallery')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-image text-success"></i></span><span class="ttr-label">Gallery</span></a></li>
                        <li class="{{ $isCur(url('admin/events')) ? 'show' : '' }}"><a href="{{url('admin/events')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-calendar text-primary"></i></span><span class="ttr-label">Upcoming Events</span></a></li>
                    </ul>
                </li>

                <!-- Settings -->
                @php $open = $groupOpen([url('admin/users'), url('/admin/profile'), route('integrations'), route('subscribers')]); @endphp
                <li class="{{ $open ? 'show' : '' }}">
                    <a href="javascript:void(0);" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-cog text-secondary"></i></span>
                        <span class="ttr-label">Settings</span>
                        <span class="ttr-arrow-icon"><i class="fa fa-angle-down"></i></span>
                    </a>
                    <ul @if($open) style="display:block;" @endif>
                        <li class="{{ $isCur(url('admin/users')) ? 'show' : '' }}"><a href="{{url('admin/users')}}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-user text-dark"></i></span><span class="ttr-label">Users</span></a></li>
                        <li class="{{ $isCur(route('integrations')) ? 'show' : '' }}"><a href="{{ route('integrations') }}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-plug text-info"></i></span><span class="ttr-label">Integrations</span></a></li>
                        <li class="{{ $isCur(route('subscribers')) ? 'show' : '' }}"><a href="{{ route('subscribers') }}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-envelope text-success"></i></span><span class="ttr-label">Subscribers</span></a></li>
                        <li class="{{ $isCur(url('/admin/profile')) ? 'show' : '' }}"><a href="{{ url('/admin/profile') }}" class="ttr-material-button"><span class="ttr-icon"><i class="fas fa-user text-warning"></i></span><span class="ttr-label">My Profile</span></a></li>
                    </ul>
                </li>

                <!-- Logout -->
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
