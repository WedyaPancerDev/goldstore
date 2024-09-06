<!-- Admin Menu -->
<div class="admin-menu">
    <!-- Logo -->
    <div class="logo crancy-sidebar-padding pd-right-0">
        <a class="crancy-logo" href="">
            <img class="crancy-logo__main" src="{{ URL::asset('assets/img/favicon.svg') }}" width="40" height="40"
                alt="#" />
        </a>
        <div id="crancy__sicon" class="crancy__sicon close-icon">
            <img src="{{ URL::asset('assets/img/arrow-icon.svg') }}" />
        </div>
    </div>

    <!-- Main Menu -->
    <div class="admin-menu__one crancy-sidebar-padding mg-top-20">
        <h4 class="admin-menu__title">Menu</h4>
        <!-- Nav Menu -->
        <div class="menu-bar">
            <ul id="CrancyMenu" class="menu-bar__one crancy-dashboard-menu">
                <li>
                    <a class="collapsed" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-square fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6">Dashboard</span>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="collapsed" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-cube fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6">Transaction</span>
                        </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- End Nav Menu -->
    </div>

    <div class="crancy-sidebar-padding pd-btm-40">
        <h4 class="admin-menu__title">Help</h4>
        <div class="menu-bar">
            <ul class="menu-bar__one crancy-dashboard-menu" id="CrancyMenu">
                <li>
                    <a class="collapsed" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-sign-out fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6">Logout</span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>