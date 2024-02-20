<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-bold">E-Leaflet</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item">
            <a href="{{ route('home') }}"
                class="menu-link {{ request()->route()->getName() === 'home' ? 'active' : '' }}">
                <i class="menu-icon tf-icons ti ti-color-swatch"></i>
                <div data-i18n="Email">Dashboard</div>
            </a>
        </li>
        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('leaflets.index') }}"
                class="menu-link {{ request()->route()->getName() === 'leaflets.index' ? 'active' : '' }}">
                <i class="menu-icon tf-icons ti ti-color-swatch"></i>
                <div data-i18n="Email">Leaflet</div>
            </a>
            <a href="{{ route('m_unit.index') }}"
                class="menu-link {{ request()->route()->getName() === 'm_unit.index' ? 'active' : '' }}">
                <i class="menu-icon tf-icons ti ti-color-swatch"></i>
                <div data-i18n="Email">Unit</div>
            </a>
        </li>
    </ul>
</aside>
