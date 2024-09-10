<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo me-1">
        <img src="{{asset('assets/img/logo/wings.png')}}" alt="auth-tree" height="40">
      </span>
      <span class="app-brand-text demo menu-text fw-semibold ms-2">Wings Surya</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    @foreach ($menuData[0]->menu as $menu)

    @php
      // Get the current user's role
      $userRole = auth()->user()->userRole->id;
    @endphp

    {{-- Role-based menu item display --}}
    @if (($menu->slug === 'dashboard' || $menu->slug === 'penilaian') && ($userRole == '2' || $userRole == '3'))
        @php
          $canAccess = true;
        @endphp
    @elseif ($userRole == '1' && !in_array($menu->slug, ['dashboard', 'penilaian']))
        @php
          $canAccess = true;
        @endphp
    @else
        @php
          $canAccess = false;
        @endphp
    @endif

    @if ($canAccess)
      {{-- Adding active and open class if child is active --}}
      @php
        $activeClass = null;
        $currentRouteName = Route::currentRouteName();

        if ($currentRouteName === $menu->slug) {
            $activeClass = 'active';
        } elseif (isset($menu->submenu)) {
          if (is_array($menu->slug)) {
            foreach($menu->slug as $slug){
              if (str_contains($currentRouteName, $slug) && strpos($currentRouteName, $slug) === 0) {
                $activeClass = 'active open';
              }
            }
          } else {
            if (str_contains($currentRouteName, $menu->slug) && strpos($currentRouteName, $menu->slug) === 0) {
              $activeClass = 'active open';
            }
          }
        }
      @endphp

      {{-- Main menu --}}
      <li class="menu-item {{$activeClass}}">
        <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
          @isset($menu->icon)
          <i class="{{ $menu->icon }}"></i>
          @endisset
          <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
          @isset($menu->badge)
          <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
          @endisset
        </a>

        {{-- Submenu --}}
        @isset($menu->submenu)
        @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
        @endisset
      </li>
    @endif

    @endforeach
  </ul>
</aside>
