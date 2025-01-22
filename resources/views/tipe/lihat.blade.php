@extends('layouts.app')
@section('content')

    <div class="mdl-grid ui-tables">
        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Tipe</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
					@if (Session::get('setelah_simpan.alert') == 'sukses')
						{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					@endif
					@if (Session::get('setelah_simpan.alert') == 'error')
						{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
					@endif

                    <div class="mdl-card__actions">
                        <form method="GET" action="{{ URL('tipe/cari') }}">
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
                            <th class="mdl-data-table__cell--non-numeric">Merk</th>
                            <th class="mdl-data-table__cell--non-numeric">Nama</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Edit</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Hapus</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$tipes->isEmpty())
                                @php($no = 1)
                                @foreach($tipes as $tipe)
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $no++ }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $tipe->nama_merks }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $tipe->nama_tipes }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::edit('tipe/edit/'.$tipe->id_tipes.'?page='.$tipes->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::hapus('tipe/hapus/'.$tipe->id_tipes, $tipe->nama_tipes)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="mdl-card__actions">
                        {{ $tipes->appends(Request::except('page'))->links('vendor.pagination.custom') }}
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
                        <form action="{{ URL('tipe/prosestambah') }}" class="form" method="POST">
                            {{ csrf_field() }}
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="merks_id">Merk</label>
                                    <select class="form-control select2" id="merks_id" name="merks_id">
                                        @foreach($merks as $merk)
                                            <option value="{{ $merk->id }}" {{ Request::old('merks_id') == $merk->id ? $select='selected' : $select='' }}>{{ $merk->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') }}" autofocus />
                                    <label class="mdl-textfield__label" for="nama">Nama</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
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
                        <form action="{{ URL('tipe/prosesedit/'.$edit_tipes->id) }}" class="form" method="POST">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="merks_id">Merk</label>
                                    <select class="form-control select2" id="merks_id" name="merks_id">
                                        @foreach($merks as $merk)
                                            @php($selected = '')
                                            @if(Request::old('merks_id') == '')
                                                @if($merk->id == $edit_tipes->merks_id)
                                                    @php($selected = 'selected')
                                                @endif
                                            @else
                                                @if($merk->id == Request::old('merks_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
                                            <option value="{{ $merk->id }}" {{ $selected }}>{{ $merk->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') == '' ? $edit_tipes->nama : Request::old('nama') }}" autofocus />
                                    <label class="mdl-textfield__label" for="nama">Nama</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
                            </div>
                            <div class="mdl-card__actions right-align">
                                @if(request()->session()->get('halaman') != '')
                                    @php($link_batal = request()->session()->get('halaman'))
                                @else
                                    @php($link_batal = URL('tipe'))
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