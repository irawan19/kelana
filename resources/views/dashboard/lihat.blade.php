@extends('layouts.app')
@section('content')

    <div class="mdl-grid mdl-grid--no-spacing dashboard">
        <div class="mdl-card mdl-shadow--2dp employer-form" action="#">
            <div class="mdl-card mdl-shadow--2dp robot">
                <div class="mdl-card__title mdl-card--expand"></div>
                <div class="mdl-card__supporting-text">
                    <div class="center-align">
                        <p style="font-weight: bold; font-size: 20px; margin-bottom: 5px">Halo, {{Auth::user()->name}}</p>
                        <p style="font-size: 16px">Selamat Datang di halaman dashboard {{ config('app.name', 'Laravel') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection