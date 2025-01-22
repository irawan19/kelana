@extends('layouts.app')
@section('content')pagination-custom

    <div class="mdl-grid ui-tables">
        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Admin</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
					@if (Session::get('setelah_simpan.alert') == 'sukses')
						{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					@endif
					@if (Session::get('setelah_simpan.alert') == 'error')
						{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
					@endif

                    <div class="mdl-card__actions">
                        <form method="GET" action="{{ URL('admin/cari') }}">
                            @csrf
                            <div class="input-group">
                                <input class="form-control" id="input2-group2" type="text" name="cari_kata" placeholder="Cari" value="{{$hasil_kata}}">
                                <span class="input-group-append">
                                    <button class="btn btn-primary" type="submit"> Cari</button>
                                </span>
                            </div>
                        </form>
                    </div>

                    <table class="mdl-data-table mdl-js-data-table stripped-table">
                        <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">No</th>
                            <th class="mdl-data-table__cell--non-numeric">Nama</th>
                            <th class="mdl-data-table__cell--non-numeric">Username</th>
                            <th class="mdl-data-table__cell--non-numeric">Email</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Edit</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Hapus</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$admins->isEmpty())
                                @php($no = 1)
                                @foreach($admins as $admin)
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $no++ }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $admin->name }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $admin->username }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $admin->email }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::edit('admin/edit/'.$admin->id.'?page='.$admins->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::hapus('admin/hapus/'.$admin->id, $admin->name)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mdl-card__actions">
                        {{ $admins->appends(Request::except('page'))->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                @if (Request::segment(2) != 'edit')
                    <div class="mdl-card__title">
                        <h1 class="mdl-card__title-text">Tambah</h1>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <form action="{{ URL('admin/prosestambah') }}" class="form" method="POST">
                            {{ csrf_field() }}
                            <div class="form__article">
                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ Request::old('name') }}" autofocus />
                                        <label class="mdl-textfield__label" for="name">Nama</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('name'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="username" name="username" value="{{ Request::old('username') }}" />
                                        <label class="mdl-textfield__label" for="username">Username</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('username'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="email" id="email" name="email" value="{{ Request::old('email') }}" />
                                        <label class="mdl-textfield__label" for="email">Email</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('email'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="password" id="password" name="password" value="{{ Request::old('password') }}" />
                                        <label class="mdl-textfield__label" for="password">Password</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('password'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="password" id="email" name="password_confirmation" value="{{ Request::old('password_confirmation') }}" />
                                        <label class="mdl-textfield__label" for="password_confirmation">Konfirmasi Password</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('password_confirmation'))}}
                                </div>
                            </div>
                            <div class="mdl-card__actions">
                                {{\App\Helpers\General::simpan()}}
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mdl-card__title">
                        <h1 class="mdl-card__title-text">Edit</h1>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <form action="{{ URL('admin/prosesedit/'.$edit_admins->id) }}" class="form" method="POST">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="form__article">
                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ Request::old('name') == '' ? $edit_admins->name : Request::old('name') }}" autofocus />
                                        <label class="mdl-textfield__label" for="name">Nama</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('name'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="username" name="username" value="{{ Request::old('username') == '' ? $edit_admins->username : Request::old('username') }}" autofocus />
                                        <label class="mdl-textfield__label" for="username">Username</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('username'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="email" id="email" name="email" value="{{ Request::old('email') == '' ? $edit_admins->email : Request::old('email') }}" autofocus />
                                        <label class="mdl-textfield__label" for="email">Email</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('email'))}}
                                    <span class="text_info">Kosongi password dan konfirmasi password jika tidak ingin mengubah:</span>
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="password" id="password" name="password" value="{{ Request::old('password') }}" autofocus />
                                        <label class="mdl-textfield__label" for="password">Password</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('password'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="password" id="email" name="password_confirmation" value="{{ Request::old('password_confirmation') }}" />
                                        <label class="mdl-textfield__label" for="password_confirmation">Konfirmasi Password</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('password_confirmation'))}}
                                </div>
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
                @endif
            </div>
        </div>
    </div>

@endsection