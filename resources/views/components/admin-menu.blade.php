<!-- Admin Menu -->
<div class="admin-menu">
    <!-- Logo -->
    <div class="logo crancy-sidebar-padding pd-right-0">
        <a class="crancy-logo" href="">
            <img src="{{ URL::asset('assets/img/logo/favicon.png') }}" width="60" height="60" alt="#" />
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
                @php
                   $role = auth()->user()->roles()->first()->name; 

                   $routeForRole = match ($role) {
                       'admin' => route('admin.root'),
                       'manajer' => route('manajer.root'),
                       'staff' => route('staff.root'),
                       'akuntan' => route('akuntan.root'),
                   };

                   $hasRole = request()->routeIs($role . '.root');
                @endphp

                <li class="pb-2">
                    <a class="collapsed links px-2 {{ $hasRole ? 'active-bg' : '' }}" href="{{ $routeForRole }}">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-square fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium">Dashboard</span>
                        </span>
                    </a>
                </li>

                @hasanyrole('admin|akuntan|manajer')
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-note fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium">Pengguna</span>
                        </span>
                    </a>
                </li>
            
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-package fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium"> Kategori<span>
                        </span>
                    </a>
                </li>

                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-package fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium"> Produk</span>
                        </span>
                    </a>
                </li>   
            
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-notebook fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium"> T Pengeluran</span>
                        </span>
                    </a>
                </li>
            
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-note fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium">Master Bonus</span>
                        </span>
                    </a>
                </li>
            
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-note fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium">Asign Bonus</span>
                        </span>
                    </a>
                </li>
            
                <li class="pb-2">
                    <a class="collapsed links px-2" href="#">
                        <span class="menu-bar__text d-flex">
                            <i class="ph ph-note fs-4 me-2"></i>
                            <span class="menu-bar__name fs-6 fw-medium">Penjualan</span>
                        </span>
                    </a>
                </li>
            @endhasanyrole

            @role('staff')
            <li class="pb-2">
                <a class="collapsed links px-2" href="#">
                    <span class="menu-bar__text d-flex">
                        <i class="ph ph-note fs-4 me-2"></i>
                        <span class="menu-bar__name fs-6 fw-medium">Pengguna</span>
                    </span>
                </a>
            </li>

            <li class="pb-2">
                <a class="collapsed links px-2" href="#">
                    <span class="menu-bar__text d-flex">
                        <i class="ph ph-notebook fs-4 me-2"></i>
                        <span class="menu-bar__name fs-6 fw-medium"> T Pengeluran</span>
                    </span>
                </a>
            </li>

            <li class="pb-2">
                <a class="collapsed links px-2" href="#">
                    <span class="menu-bar__text d-flex">
                        <i class="ph ph-note fs-4 me-2"></i>
                        <span class="menu-bar__name fs-6 fw-medium">Master Bonus</span>
                    </span>
                </a>
            </li>

            <li class="pb-2">
                <a class="collapsed links px-2" href="#">
                    <span class="menu-bar__text d-flex">
                        <i class="ph ph-note fs-4 me-2"></i>
                        <span class="menu-bar__name fs-6 fw-medium">Asign Bonus</span>
                    </span>
                </a>
            </li>

            <li class="pb-2">
                <a class="collapsed links px-2" href="#">
                    <span class="menu-bar__text d-flex">
                        <i class="ph ph-note fs-4 me-2"></i>
                        <span class="menu-bar__name fs-6 fw-medium">Penjualan</span>
                    </span>
                </a>
            </li>
            @endrole
            </ul>
        </div>
        <!-- End Nav Menu -->
    </div>
</div>
