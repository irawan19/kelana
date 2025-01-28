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
                            <th class="mdl-data-table__cell--non-numeric">CP</th>
                            <th class="mdl-data-table__cell--non-numeric">Kontak CP</th>
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
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->cp }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $penawaran->kontak_cp }}</td>
                                        <td class="mdl-data-table__cell--non-numeric center-align">
                                            {{\App\Helpers\General::edit('penawaran/edit/'.$penawaran->id.'?page='.$penawarans->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric center-align">
                                            {{\App\Helpers\General::hapus('penawaran/hapus/'.$penawaran->id, $penawaran->nama)}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric center-align">
                                            {{\App\Helpers\General::cetak('penawaran/cetak/'.$penawaran->id)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
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
                                    <input class="mdl-textfield__input" type="text" id="cp" name="cp" value="{{ Request::old('cp') }}" />
                                    <label class="mdl-textfield__label" for="cp">CP</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('cp'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="kontak_cp" name="kontak_cp" value="{{ Request::old('kontak_cp') }}" />
                                    <label class="mdl-textfield__label" for="kontak_cp">Kontak CP</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('kontak_cp'))}}
                            </div>

                            @if(empty(Request::old('barangs_id')))
                                <div class="mdl-grid dynamicformbarang">
                                    <div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                        <label class="mdl-textfield__label" for="barangs_id">Merk</label>
                                        <select class="form-control select2" id="barangs_id" name="barangs_id[]">
                                            @foreach($barangs as $barang)
                                                <option value="{{ $barang->id_barangs }}" {{ Request::old('barangs_id.*') == $barang->id_barangs ? $select='selected' : $select='' }}>{{ $barang->nama_kategoris.' / '.$barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mdl-cell mdl-cell--5-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                        <input class="priceformat mdl-textfield__input" type="text" id="harga" name="harga[]" value="{{ Request::old('harga.*') == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga.*') }}" />
                                    </div>
                                    <div class="mdl-cell mdl-cell--1-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                        <button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">
                                            <i class="material-icons">create</i>
                                            <span class="mdl-button__ripple-container">
                                                <span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            @else
                                @php($get_total_form = count(Request::old('barangs_id')))
                                @for($total_form = 0; $total_form < $get_total_form; $total_form++)
                                    <div class="mdl-grid dynamicformbarang">
                                        <div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <label class="mdl-textfield__label" for="barangs_id">Merk</label>
                                            <select class="form-control select2" id="barangs_id" name="barangs_id[]">
                                                @foreach($barangs as $barang)
                                                    <option value="{{ $barang->id_barangs }}" {{ Request::old('barangs_id.'.$total_form) == $barang->id_barangs ? $select='selected' : $select='' }}>{{ $barang->nama_kategoris.' / '.$barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--5-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <input class="priceformat mdl-textfield__input" type="text" id="harga" name="harga[]" value="{{ Request::old('harga.'.$total_form) == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga.'.$total_form) }}" />
                                        </div>
                                        <div class="mdl-cell mdl-cell--1-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">
                                                <i class="material-icons">create</i>
                                                <span class="mdl-button__ripple-container">
                                                    <span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                            
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
                                    <input class="mdl-textfield__input" type="text" id="cp" name="cp" value="{{ Request::old('cp') == '' ? $edit_penawarans->cp : Request::old('cp') }}" />
                                    <label class="mdl-textfield__label" for="cp">CP</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('cp'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="kontak_cp" name="kontak_cp" value="{{ Request::old('kontak_cp') == '' ? $edit_penawarans->kontak_cp : Request::old('kontak_cp') }}" />
                                    <label class="mdl-textfield__label" for="kontak_cp">Kontak CP</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('kontak_cp'))}}
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" id="alamat" name="alamat" value="{{ Request::old('alamat') == '' ? $edit_penawarans->alamat : Request::old('alamat') }}" />
                                    <label class="mdl-textfield__label" for="alamat">Alamat</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('alamat'))}}
                            </div>

                            @if(empty(Request::old('barangs_id')))
                                @foreach($edit_penawaran_barangs as $penawaran_barang)
                                    <div class="mdl-grid dynamicformbarang">
                                        <div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <label class="mdl-textfield__label" for="barangs_id">Merk</label>
                                            <select class="form-control select2" id="barangs_id" name="barangs_id[]">
                                                @foreach($barangs as $barang)
                                                    @php($selected = '')
                                                    @if(Request::old('barangs_id') == '')
                                                        @if($barang->id_barangs == $penawaran_barang->barangs_id)
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @else
                                                        @if($barang->id == Request::old('barangs_id'))
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @endif
                                                    <option value="{{ $barang->id_barangs }}" {{ $selected }}>{{ $barang->nama_kategoris.' / '.$barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--5-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <input class="priceformat mdl-textfield__input" type="text" id="harga" name="harga[]" value="{{ Request::old('harga.*') == '' ? \App\Helpers\General::ubahDBKeHarga($penawaran_barang->harga) : Request::old('harga.*') }}" />
                                        </div>
                                        <div class="mdl-cell mdl-cell--1-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">
                                                <i class="material-icons">create</i>
                                                <span class="mdl-button__ripple-container">
                                                    <span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @php($get_total_form = count(Request::old('barangs_id')))
                                @for($total_form = 0; $total_form < $get_total_form; $total_form++)
                                    <div class="mdl-grid dynamicformbarang">
                                        <div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <label class="mdl-textfield__label" for="barangs_id">Merk</label>
                                            <select class="form-control select2" id="barangs_id" name="barangs_id[]">
                                                @foreach($barangs as $barang)
                                                    <option value="{{ $barang->id_barangs }}" {{ Request::old('barangs_id.'.$total_form) == $barang->id_barangs ? $select='selected' : $select='' }}>{{ $barang->nama_kategoris.' / '.$barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--5-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <input class="priceformat mdl-textfield__input" type="text" id="harga" name="harga[]" value="{{ Request::old('harga.'.$total_form) == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga.'.$total_form) }}" />
                                        </div>
                                        <div class="mdl-cell mdl-cell--1-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">
                                            <button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">
                                                <i class="material-icons">create</i>
                                                <span class="mdl-button__ripple-container">
                                                    <span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                @endfor
                            @endif

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
            var inputRowHTML    = '<div class="mdl-grid dynamicformbarang">'+
                                    '<div class="mdl-cell mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">'+
                                        '<label class="mdl-textfield__label" for="barangs_id">Merk</label>'+
                                        '<select class="form-control select2" id="barangs_id" name="barangs_id[]">'+
                                            @foreach($barangs as $barang)
                                                '<option value="{{ $barang->id_barangs }}" {{ Request::old("barangs_id.*") == $barang->id_barangs ? $select="selected" : $select="" }}>{{ $barang->nama_kategoris." / ".$barang->nama_merks." / ".$barang->nama_tipes." / ".$barang->nama_barangs }}</option>'+
                                            @endforeach
                                        '</select>'+
                                    '</div>'+
                                    '<div class="mdl-cell mdl-cell--5-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">'+
                                        '<input class="priceformat mdl-textfield__input" type="text" id="harga[]" name="harga[]" value="{{ Request::old("harga.*") == "" ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old("harga.*") }}" />'+
                                    '</div>'+
                                    '<div class="mdl-cell mdl-cell--1-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label is-dirty is-upgraded">'+
                                        '<button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">'+
                                            '<i class="material-icons">create</i>'+
                                            '<span class="mdl-button__ripple-container">'+
                                                '<span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>'+
                                            '</span>'+
                                        '</button>'+
                                    '</div>'+
                                '</div>';
            addButtonHTML       = '<button type="button" class="add-more mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-green" data-upgraded=",MaterialButton,MaterialRipple">'+
                                    '<i class="material-icons">create</i>'+
                                    '<span class="mdl-button__ripple-container">'+
                                        '<span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>'+
                                    '</span>'+
                                '</button>';
            removeButtonHTML    = '<button type="button" class="remove-input mdl-button mdl-js-button mdl-button--icon mdl-button--raised mdl-js-ripple-effect button--colored-red" data-upgraded=",MaterialButton,MaterialRipple">'+
                                    '<i class="material-icons">delete</i>'+
                                    '<span class="mdl-button__ripple-container">'+
                                        '<span class="mdl-ripple is-animating" style="width: 92.5097px; height: 92.5097px; transform: translate(-50%, -50%) translate(22px, 23px);"></span>'+
                                    '</span>'+
                                '</button>';

            $("body").on("click", ".add-more", function () {
                $(".dynamicformbarang").last().before(inputRowHTML);
                showAddRemoveIcon();
            });

            $("body").on("click", ".remove-input", function () {
                $(this).parent().parent().remove();
            });
        });

        function showAddRemoveIcon() {
            $('.dynamicformbarang').find(".add-more").after(removeButtonHTML);
            $('.dynamicformbarang').last().find(".remove-input").remove();

            $('.dynamicformbarang').find(".add-more").remove();
            $('.dynamicformbarang').last().find(".mdl-cell--1-col").append(addButtonHTML);

$('.priceformat').priceFormat({
            clearPrefix: true,
            allowNegative: true,
        });
        }
    </script>

@endsection