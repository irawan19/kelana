<div class="mdl-layout__drawer">
    <header>kelana</header>
    <div class="scroll__wrapper" id="scroll__wrapper">
        <div class="scroller" id="scroller">
            <div class="scroll__container" id="scroll__container">
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == '' || Request::segment(1) == 'dashboard' ? 'current' : '' }}" href="{{ URL('/') }}">
                        <i class="material-icons" role="presentation">dashboard</i>
                        Dashboard
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'kategori' ? 'current' : '' }}" href="{{URL('/kategori')}}">
                        <i class="material-icons" role="presentation">label</i>
                        Kategori
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'merk' ? 'current' : '' }}" href="{{URL('/merk')}}">
                        <i class="material-icons" role="presentation">toll</i>
                        Merk
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'tipe' ? 'current' : '' }}" href="{{URL('/tipe')}}">
                        <i class="material-icons" role="presentation">person</i>
                        Tipe
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'supplier' ? 'current' : '' }}" href="{{URL('/supplier')}}">
                        <i class="material-icons">account_box</i>
                        Supplier
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'barang' ? 'current' : '' }}" href="{{URL('/barang')}}">
                        <i class="material-icons">list</i>
                        Barang
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'supplier-barang' ? 'current' : '' }}" href="{{URL('/supplier-barang')}}">
                        <i class="material-icons">attach_money</i>
                        Supplier Barang
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'penawaran' ? 'current' : '' }}" href="{{URL('/penawaran')}}">
                        <i class="material-icons">book</i>
                        Penawaran
                    </a>
                    <a class="mdl-navigation__link mdl-navigation__link--{{ Request::segment(1) == 'admin' ? 'current' : '' }}" href="{{URL('/admin')}}">
                        <i class="material-icons">supervisor_account</i>
                        Admin
                    </a>
                    <div class="mdl-layout-spacer"></div>
                    <hr>
                    <a class="mdl-navigation__link" href="{{URL('/logout')}}">
                        <i class="material-icons" role="presentation">exit_to_app</i>
                        Keluar
                    </a>
                </nav>
            </div>
        </div>
        <div class='scroller__bar' id="scroller__bar"></div>
    </div>
</div>