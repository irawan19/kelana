<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <div class="mdl-layout-spacer"></div>
        <div class="avatar-dropdown" id="icon">
            <span>{{ Auth::user()->username }}</span>
            @if(Auth::user()->profile_photo_path == null)
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{Auth::user()->email}}">
            @else
                <img rc="{{ URL::asset(Auth::user()->profile_photo_path) }}" alt="{{Auth::user()->email}}">
            @endif
        </div>
        <ul class="mdl-menu mdl-list mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp account-dropdown"
            for="icon">
            <li class="mdl-list__item mdl-list__item--two-line">
                <span class="mdl-list__item-primary-content">
                    <span class="material-icons mdl-list__item-avatar"></span>
                    <span>{{ Auth::user()->username }}</span>
                    <span class="mdl-list__item-sub-title">{{ Auth::user()->email }}</span>
                </span>
            </li>
            <li class="list__item--border-top"></li>
            <li class="mdl-menu__item mdl-list__item">
                <span class="mdl-list__item-primary-content">
                    <i class="material-icons mdl-list__item-icon">account_circle</i>
                    Akun
                </span>
            </li>
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