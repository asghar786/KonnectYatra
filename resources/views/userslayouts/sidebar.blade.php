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
            <ul>
                <li>
                    <a href="{{route('user_dashboard')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-home text-danger"></i></span>
                        <span class="ttr-label">Dashborad</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user_visa')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fa fa-plane text-primary"></i></span>
                        <span class="ttr-label">Visa</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("user/all-packages") }}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-book text-info"></i></span>
                        <span class="ttr-label">Add Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("user/bookings") }}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-book text-success"></i></span>
                        <span class="ttr-label">Yatri Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('yatri-list')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user-group text-primary"></i></span>
                        <span class="ttr-label">Yatri's List</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user-profile')}}" class="ttr-material-button">
                        <span class="ttr-icon"><i class="fas fa-user text-success"></i></span>
                        <span class="ttr-label">My Profile</span>
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
