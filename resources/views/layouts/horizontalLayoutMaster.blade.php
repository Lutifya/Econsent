<?php
{{-- dd($configData) --}}
?>

<body class="horizontal-layout horizontal-menu {{$configData['horizontalMenuType']}} {{ $configData['showMenu'] === true ? '' : '1-column' }}
{{ $configData['blankPageClass'] }} {{ $configData['bodyClass'] }}
{{ $configData['footerType'] }}" data-menu="horizontal-menu"
      data-col="{{ $configData['showMenu'] === true ? '' : '1-column' }}" data-open="hover"
      data-layout="{{ ($configData['theme'] === 'light') ? '' : $configData['layoutTheme'] }}"
      style="{{ $configData['bodyStyle'] }}" data-framework="laravel" data-asset-path="{{ asset('/')}}">


{{--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.5/build/heatmap.min.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--    const config = {--}}
{{--        container: document.documentElement,--}}
{{--    };--}}
{{--    const heatmap = h337.create(config);--}}
{{--    // Set data here--}}
{{--</script>--}}


<!-- Hotjar Tracking Code for https://82.223.202.39/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2992690,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>

<!-- BEGIN: Header-->
{{-- Include Navbar --}}
@include('panels.navbar')

{{-- Include Sidebar --}}
@if((isset($configData['showMenu']) && $configData['showMenu'] === true))
    @include('panels.horizontalMenu')
@endif

<!-- BEGIN: Content-->
<div class="app-content content {{ $configData['pageClass'] }}">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    @if(($configData['contentLayout']!=='default') && isset($configData['contentLayout']))
        <div class="content-area-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
            <div class="{{ $configData['sidebarPositionClass'] }}">
                <div class="sidebar">
                    {{-- Include Sidebar Content --}}
                    @yield('content-sidebar')
                </div>
            </div>
            <div class="{{ $configData['contentsidebarClass'] }}">
                <div class="content-wrapper">
                    <div class="content-body">
                        {{-- Include Page Content --}}
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content-wrapper {{ $configData['layoutWidth'] === 'boxed' ? 'container p-0' : '' }}">
            {{-- Include Breadcrumb --}}
            @if($configData['pageHeader'] == true)
                @include('panels.breadcrumb')
            @endif

            <div class="content-body">

                {{-- Include Page Content --}}
                @yield('content')

            </div>
        </div>
    @endif

</div>
<!-- End: Content-->

@if($configData['blankPage'] == false && isset($configData['blankPage']))
    {{--  @include('content/pages/customizer')--}}

    {{--  @include('content/pages/buy-now')--}}
@endif

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

{{-- include footer --}}
@include('panels/footer')

{{-- include default scripts --}}
@include('panels/scripts')

<script type="text/javascript">
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14
                , height: 14
            });
        }
    })

</script>
</body>

</html>
