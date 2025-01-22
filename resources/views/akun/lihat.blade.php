@extends('layouts.app')
@section('content')

    <div class="mdl-card mdl-shadow--2dp employer-form">
        <div class="mdl-card__title">
            <h2>Akun</h2>
        </div>

        <div class="mdl-card__supporting-text">
			@if (Session::get('setelah_simpan.alert') == 'sukses')
				{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
			@endif
			@if (Session::get('setelah_simpan.alert') == 'error')
				{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
			@endif
            <form action="{{ URL('akun/prosesedit') }}" class="form" method="POST">
                {{ csrf_field() }}
                @method('PATCH')
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ Request::old('name') == '' ? Auth::user()->name : Request::old('name') }}" autofocus />
                        <label class="mdl-textfield__label" for="name">Nama</label>
                    </div>
                    {{\App\Helpers\General::pesanErrorForm($errors->first('name'))}}
                </div>
                <div class="mdl-grid">
                   <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                       <input class="mdl-textfield__input" type="text" id="username" name="username" value="{{ Request::old('username') == '' ? Auth::user()->username : Request::old('username') }}" autofocus />
                       <label class="mdl-textfield__label" for="username">Username</label>
                   </div>
                </div>
                {{\App\Helpers\General::pesanErrorForm($errors->first('username'))}}
                <div class="mdl-grid">
                   <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                       <input class="mdl-textfield__input" type="email" id="email" name="email" value="{{ Request::old('email') == '' ? Auth::user()->email : Request::old('email') }}" autofocus />
                       <label class="mdl-textfield__label" for="email">Email</label>
                   </div>
                   {{\App\Helpers\General::pesanErrorForm($errors->first('email'))}}
                   <span class="text_info">Kosongi password dan konfirmasi password jika tidak ingin mengubah:</span>
                </div>
                <div class="mdl-grid">
                   <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                       <input class="mdl-textfield__input" type="password" id="password" name="password" value="{{ Request::old('password') }}" autofocus />
                       <label class="mdl-textfield__label" for="password">Password</label>
                   </div>
                   {{\App\Helpers\General::pesanErrorForm($errors->first('password'))}}
                </div>
                <div class="mdl-grid">
                   <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                       <input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation" value="{{ Request::old('password_confirmation') }}" />
                       <label class="mdl-textfield__label" for="password_confirmation">Konfirmasi Password</label>
                   </div>
                   {{\App\Helpers\General::pesanErrorForm($errors->first('password_confirmation'))}}
                </div>
                <div class="mdl-card__actions right-align">
                    @if(request()->session()->get('halaman') != '')
                        @php($link_batal = request()->session()->get('halaman'))
                    @else
                        @php($link_batal = URL('admin'))
                    @endif
                    {{\App\Helpers\General::batal($link_batal)}}
                    {{\App\Helpers\General::perbarui()}}
                </div>
            </form>
        </div>
    </div>

@endsection()