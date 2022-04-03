{{-- For Horizontal submenu --}}
<ul class="dropdown-menu" style="left:auto">
  @if(isset($menu))
    @foreach($menu as $submenu)
      @php
        $custom_classes = "";
        if(isset($submenu["classlist"])) {
          $custom_classes = $submenu["classlist"];
        }
        $roles = is_array($submenu["role"])
                          ? $submenu["role"]
                          : explode(',', $submenu["role"]);
      @endphp
      @if(array_search("guest", $roles) !== false or Auth::user() !== null and array_search(Auth::user()->role, $roles) !== false or Auth::user() !== null and Auth::user()->role === "admin")
        <li

                class="{{ $custom_classes }}{{ (isset($submenu["SubMenu"])) ? 'dropdown dropdown-submenu' : '' }} {{ $submenu["slug"] === Route::currentRouteName() ? 'active' : '' }}" @if(isset($submenu["SubMenu"])){{'data-menu=dropdown-submenu'}}@endif>
          <a href="{{isset($submenu["url"]) ? url($submenu["url"]):'javascript:void(0)'}}" class="dropdown-item {{ (isset($submenu["SubMenu"])) ? 'dropdown-toggle' : '' }} d-flex align-items-center"
             {{ (isset($submenu["SubMenu"])) ? 'data-toggle=dropdown' : '' }} target="{{isset($submenu["newTab"]) && $submenu["newTab"] === true  ? '_blank':'_self'}}">
            @if (isset($submenu["icon"]))
              <i data-feather="{{ $submenu["icon"] }}"></i>
            @endif
            <span>{{ __('locale.'.$submenu["name"]) }}</span>
          </a>
          @if (isset($submenu["SubMenu"]))
            @include('panels/horizontalSubmenu', ['menu' => $submenu["SubMenu"]])
          @endif
        </li>
      @endif
    @endforeach
  @endif
</ul>
