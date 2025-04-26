<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <b class="jam">{{\App\Helpers\General::ubahDBKeTanggal(date('Y-m-d'))}}, <onload="timeJavascript()" id="output"></b>
        <div class="mdl-layout-spacer"></div>
        <div class="avatar-dropdown" id="icon">
            <span>{{ Auth::user()->name }}</span>
            @if(Auth::user()->profile_photo_path == null)
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{Auth::user()->email}}">
            @else
                <img src="{{ URL::asset(Auth::user()->profile_photo_path) }}" alt="{{Auth::user()->email}}">
            @endif
        </div>
        <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown"
            for="icon">
            <li class="mdl-list__item mdl-list__item--two-line">
                <span class="mdl-list__item-primary-content">
                    <span>{{ Auth::user()->username }}</span>
                    <span class="mdl-list__item-sub-title">{{ Auth::user()->email }}</span>
                </span>
            </li>
            <li class="list__item--border-top"></li>
            <a href="{{URL('/akun')}}">
                <li class="mdl-menu__item mdl-list__item">
                    <span class="mdl-list__item-primary-content">
                        <i class="material-icons mdl-list__item-icon">account_circle</i>
                        Akun
                    </span>
                </li>
            </a>
            <li class="list__item--border-top"></li>
            <a href="{{URL('/logout')}}">
                <li class="mdl-menu__item mdl-list__item">
                    <span class="mdl-list__item-primary-content">
                        <i class="material-icons mdl-list__item-icon text-color--secondary">exit_to_app</i>
                        Keluar
                    </span>
                </li>
            </a>
        </ul>
    </div>
</header>

<script type="text/javascript">
	window.setTimeout("timeJavascript()",1000);
    function timeJavascript()
	{     
        var dateNow = new Date().toLocaleTimeString("en-US",{timeZone: "Asia/Jakarta", hour12: false});
        setTimeout("timeJavascript()",1000);
        document.getElementById("output").innerHTML = dateNow;
	}
</script>