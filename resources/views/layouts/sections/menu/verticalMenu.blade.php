<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <!-- ! Hide app brand if navbar-full -->
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- <img width="25" src="{{ asset('assets/img/favicon/favicon.svg') }}" alt="brand-logo" srcset=""> --}}
                @include('_partials.macros')
            </span>
            <span class="app-brand-text demo menu-text fw-bold text-capitalize ms-2">
                {{ config('app.locale') == 'en' ? "Najib" : "نجيب"  }}
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ trans('menu.dashboard') }}</span>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-collection"></i> --}}
                <i class='menu-icon bx bxs-dashboard'></i>
                <div>{{ trans('menu.dashboard') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard.sections.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.sections.index') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-collection"></i> --}}
                <i class='menu-icon bx bxs-school'></i>
                <div>{{ trans('menu.sections') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard.subjects.index') ? 'active' : '' }}">
          <a href="{{ route('dashboard.subjects.index') }}" class="menu-link">
              <i class='menu-icon bx bxs-book'></i>
              <div>{{ trans('menu.subjects') }}</div>
          </a>
      </li>
        <li class="menu-item {{ request()->routeIs('dashboard.levels.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.levels.index') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-collection"></i> --}}
                <i class='menu-icon  bx bxs-graduation'></i>
                <div>{{ trans('menu.levels') }}</div>
            </a>
        </li>
        {{-- <li class="menu-item {{ request()->routeIs('dashboard.level-subjects.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.level-subjects.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div>{{ trans('menu.level-subjects') }}</div>
            </a>
        </li> --}}
        <li class="menu-item {{ request()->routeIs('dashboard.coupons.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.coupons.index') }}" class="menu-link">
                {{-- <i class="menu-icon tf-icons bx bx-collection"></i> --}}
                <i class='menu-icon bx bxs-coupon'></i>
                <div>{{ trans('menu.coupons') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                <i class='menu-icon bx bxs-group'></i>
                <div>{{ trans('menu.users') }}</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('dashboard.courses.index') ? 'active' : '' }}">
            <a href="{{ route('dashboard.courses.index') }}" class="menu-link">
                <i class='menu-icon bx bxs-chalkboard'></i>
                <div>{{ trans('menu.courses') }}</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('dashboard.ads.index') ? 'active' : '' }}">
          <a href="{{ route('dashboard.ads.index') }}" class="menu-link">
              <i class='menu-icon bx bxs-megaphone'></i>
              <div>{{ trans('menu.ads') }}</div>
          </a>
      </li>

      <li class="menu-item {{ request()->routeIs('dashboard.notices.index') ? 'active' : '' }}">
        <a href="{{ route('dashboard.notices.index') }}" class="menu-link">
            <i class='menu-icon bx bxs-bell'></i>
            <div>{{ trans('menu.notices') }}</div>
        </a>
    </li>

    <li class="menu-item {{ request()->routeIs('dashboard.purchases.index') ? 'active' : '' }}">
      <a href="{{ route('dashboard.purchases.index') }}" class="menu-link">
          <i class='menu-icon bx bxs-purchase-tag'></i>
          <div>{{ trans('menu.purchases') }}</div>
      </a>
  </li>

  <li class="menu-item {{ request()->routeIs('dashboard.payments.index') ? 'active' : '' }}">
    <a href="{{ route('dashboard.payments.index') }}" class="menu-link">
        <i class='menu-icon bx bxs-wallet'></i>
        <div>{{ trans('menu.payments') }}</div>
    </a>
</li>

      <li class="menu-item {{ str_contains(request()->route()->getName(),'dashboard.documentation') ? 'active open' : '' }}">
        <a class="menu-link menu-toggle" >
            <i class="menu-icon tf-icons bx bxs-info-square"></i>
            <div>{{ trans('menu.documentation') }}</div>
        </a>


        <ul class="menu-sub">
          <li class="menu-item {{request()->routeIs('dashboard.documentation.policy') ? 'active' : ''}}">
            <a href="{{ route('dashboard.documentation.policy') }}" class="menu-link" >
                    <div>{{ trans('menu.policy') }}</div>
            </a>
          </li>

          <li class="menu-item {{request()->routeIs('dashboard.documentation.about') ? 'active' : ''}}">
            <a href="{{ route('dashboard.documentation.about') }}" class="menu-link" >
                    <div>{{ trans('menu.about') }}</div>
            </a>
          </li>
        </ul>
      </li>


</aside>
