{{-- For submenu --}}
<ul class="menu-content">

  @if(isset($menu))
    @foreach($menu as $submenu)
      @php
        $roles = is_array($submenu["role"])
                        ? $submenu["role"]
                        : explode(',', $submenu["role"]);
      @endphp
      @if(array_search("guest", $roles) !== false or Auth::user() !== null and array_search(Auth::user()->role, $roles) !== false or Auth::user() !== null and Auth::user()->role === "admin")
        <li class="{{ $submenu["slug"] === Route::currentRouteName() ? 'active' : '' }}">
          <a href="{{isset($submenu["url"]) ? url($submenu["url"]):'javascript:void(0)'}}" class="d-flex align-items-center" target="{{isset($submenu["newTab"]) && $submenu["newTab"] === true  ? '_blank':'_self'}}">
            @if(isset($submenu["icon"]))
              <i data-feather="{{$submenu["icon"]}}"></i>
            @endif
            <span class="menu-item text-truncate">{{ __('locale.'.$submenu["name"]) }}</span>
          </a>
          @if (isset($submenu["SubMenu"]))
            @include('panels/submenu', ['menu' => $submenu["SubMenu"]])
          @endif
        </li>
      @endif
    @endforeach
  @endif
</ul>
