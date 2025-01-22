@extends('layouts.app')
@section('content')

    <div class="mdl-grid mdl-grid--no-spacing dashboard">
        <div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone mdl-cell--top">
            <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--6-col-phone">
                <div class="mdl-card mdl-shadow--2dp trending">
                    <div class="mdl-card__title">
                        <a class="anostyle" href="{{ URL('/barang') }}">
                            <h2 class="mdl-card__title-text">
                                Barang
                            </h2>
                        </a>
                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-card__subtitle-text">
                            <div class="mdl-layout-spacer"></div>
                                {{$total_barang}}
                        </div>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <ul class="mdl-list">
                            @php($no_barang = 1)
                            @foreach($barangs as $barang)
                                @if($no_barang == 1)
                                    <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$barang->nama}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @else
                                    <li class="mdl-list__item list__item--border-top">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$barang->nama}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @endif
                                @php($no_barang++)
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--6-col-phone">
                <div class="mdl-card mdl-shadow--2dp trending">
                    <div class="mdl-card__title">
                        <a class="anostyle" href="{{ URL('/supplier') }}">
                            <h2 class="mdl-card__title-text">
                                Supplier
                            </h2>
                        </a>
                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-card__subtitle-text">
                            <div class="mdl-layout-spacer"></div>
                                {{$total_supplier}}
                        </div>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <ul class="mdl-list">
                            @php($no_supplier = 1)
                            @foreach($suppliers as $supplier)
                                @if($no_supplier == 1)
                                    <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$supplier->nama}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @else
                                    <li class="mdl-list__item list__item--border-top">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$supplier->nama}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @endif
                                @php($no_supplier++)
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--6-col-phone">
                <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title">
                        <a class="anostyle" href="{{ URL('/penawaran') }}">
                            <h2 class="mdl-card__title-text">
                                Penawaran
                            </h2>
                        </a>
                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-card__subtitle-text">
                            <div class="mdl-layout-spacer"></div>
                                {{$total_penawaran}}
                        </div>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <ul class="mdl-list">
                            @php($no_penawaran = 1)
                            @foreach($penawarans as $penawaran)
                                @if($no_penawaran == 1)
                                    <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$penawaran->no}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @else
                                    <li class="mdl-list__item list__item--border-top">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$penawaran->no}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @endif
                                @php($no_penawaran++)
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--3-col-tablet mdl-cell--6-col-phone">
                <div class="mdl-card mdl-shadow--2dp trending">
                    <div class="mdl-card__title">
                        <a class="anostyle" href="{{ URL('/admin') }}">
                            <h2 class="mdl-card__title-text">
                                Admin
                            </h2>
                        </a>
                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-card__subtitle-text">
                            <div class="mdl-layout-spacer"></div>
                                {{$total_admin}}
                        </div>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <ul class="mdl-list">
                            @php($no_admin = 1)
                            @foreach($admins as $admin)
                                @if($no_admin == 1)
                                    <li class="mdl-list__item">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$admin->name}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @else
                                    <li class="mdl-list__item list__item--border-top">
                                        <span class="mdl-list__item-primary-content list__item-text">{{$admin->name}}</span>
                                        <span class="mdl-list__item-secondary-content">
                                            <i class="material-icons newlable" role="presentation">fiber_new</i>
                                        </span>
                                    </li>
                                @endif
                                @php($no_admin++)
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-card mdl-shadow--2dp employer-form">
            <div class="mdl-card mdl-shadow--2dp robot">
                <div class="mdl-card__title mdl-card--expand"></div>
                <div class="mdl-card__supporting-text">
                    <div class="center-align">
                        <p style="font-weight: bold; font-size: 20px; margin-bottom: 5px">Halo, {{Auth::user()->name}}</p>
                        <p style="font-size: 16px">Selamat Datang di halaman aplikasi {{ config('app.name', 'Laravel') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection