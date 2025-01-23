@extends('layouts.app')
@section('content')

    <div class="mdl-grid ui-tables">
        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Penawaran</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
					@if (Session::get('setelah_simpan.alert') == 'sukses')
						{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					@endif
					@if (Session::get('setelah_simpan.alert') == 'error')
						{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
					@endif

                    <div class="mdl-card__actions">
                        <form method="GET" action="{{ URL('penawaran/cari') }}">
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
                            <th class="mdl-data-table__cell--non-numeric">Perusahaan</th>
                            <th class="mdl-data-table__cell--non-numeric">Alamat</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Edit</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Hapus</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$penawarans->isEmpty())
                                @foreach($penawarans as $penawaran)
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->no }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->nama }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->perusahaan }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->alamat }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::edit('penawaran/edit/'.$penawaran->id.'?page='.$penawarans->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::hapus('penawaran/hapus/'.$penawaran->id, $penawaran->nama)}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::cetak('penawaran/cetak/'.$penawaran->id)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
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
                        {{ $penawarans->appends(Request::except('page'))->links('vendor.pagination.custom') }}
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
                        <form action="{{ URL('penawaran/prosestambah') }}" class="form" method="POST">
                            {{ csrf_field() }}
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') }}" autofocus />
                                    <label class="mdl-textfield__label" for="nama">Nama</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="perusahaan" name="perusahaan" value="{{ Request::old('perusahaan') }}" />
                                    <label class="mdl-textfield__label" for="perusahaan">Perusahaan</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('perusahaan'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="alamat" name="alamat" value="{{ Request::old('alamat') }}" />
                                    <label class="mdl-textfield__label" for="alamat">Alamat</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('alamat'))}}
                            </div>


                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <label class="mdl-textfield__label" for="barangs_id">Merk</label>
                                        <select class="form-control select2" id="barangs_id" name="barangs_id">
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->id_barangs }}" {{ Request::old('barangs_id') == $barang->id_barangs ? $select='selected' : $select='' }}>{{ $barang->nama_kategoris.'/'.$barang->nama_merks.'/'.$barang->nama_tipes.'/'.$barang->nama_barangs }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="harga" name="harga" value="{{ Request::old('harga') == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga') }}" />
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
                        <form action="{{ URL('penawaran/prosesedit/'.$edit_penawarans->id) }}" class="form" method="POST">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input readonly class="readonlycolor mdl-textfield__input" type="text" id="no" name="no" value="{{ Request::old('no') == '' ? $edit_penawarans->no : Request::old('no') }}" />
                                    <label class="mdl-textfield__label" for="no">No</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('no'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') == '' ? $edit_penawarans->nama : Request::old('nama') }}" />
                                    <label class="mdl-textfield__label" for="nama">Nama</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="perusahaan" name="perusahaan" value="{{ Request::old('perusahaan') == '' ? $edit_penawarans->perusahaan : Request::old('perusahaan') }}" />
                                    <label class="mdl-textfield__label" for="perusahaan">Perusahaan</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('perusahaan'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="alamat" name="alamat" value="{{ Request::old('alamat') == '' ? $edit_penawarans->alamat : Request::old('alamat') }}" />
                                    <label class="mdl-textfield__label" for="alamat">Alamat</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('alamat'))}}
                            </div>
                            <div class="mdl-card__actions right-align">
                                @if(request()->session()->get('halaman') != '')
                                    @php($link_batal = request()->session()->get('halaman'))
                                @else
                                    @php($link_batal = URL('penawaran'))
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

    <script>
        var addButtonHTML, removeButtonHTML;
        $(document).ready(function () {
            var inputRowHTML = '<div class="row form-input"><input type="text" /> <input type="button" class="add-more" value="+" /></div>';
            addButtonHTML = '<input type="button" class="add-more" value="+" />';
            removeButtonHTML = '<input type="button" class="remove-input" value="-" />';

            $("body").on("click", ".add-more", function () {
                $(".form-input").last().before(inputRowHTML);
                showAddRemoveIcon();
            });

            $("body").on("click", ".remove-input", function () {
                $(this).parent().remove();
            });
        });

        function showAddRemoveIcon() {
            $('.form-input').find(".add-more").after(removeButtonHTML);
            $('.form-input').last().find(".remove-input").remove();

            $('.form-input').find(".add-more").remove();
            $('.form-input').last().append(addButtonHTML);
        }
    </script>

@endsection