@extends('layouts.app')
@section('content')pagination-custom

    <div class="mdl-grid ui-tables">
        <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Barang</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
					@if (Session::get('setelah_simpan.alert') == 'sukses')
						{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					@endif
					@if (Session::get('setelah_simpan.alert') == 'error')
						{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
					@endif

                    <div class="mdl-card__actions">
                        <form method="GET" action="{{ URL('barang/cari') }}">
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
                            <th class="mdl-data-table__cell--non-numeric">Kategori</th>
                            <th class="mdl-data-table__cell--non-numeric">Merk</th>
                            <th class="mdl-data-table__cell--non-numeric">Tipe</th>
                            <th class="mdl-data-table__cell--non-numeric">Nama</th>
                            <th class="mdl-data-table__cell--non-numeric">Harga Jual</th>
                            <th class="mdl-data-table__cell--non-numeric">Harga Beli</th>
                            <th class="mdl-data-table__cell--non-numeric">Stok</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Edit</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Hapus</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$barangs->isEmpty())
                                @php($no = 1)
                                @foreach($barangs as $barang)
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $no++ }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $barang->nama_kategoris }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $barang->nama_merks }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $barang->nama_tipes }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $barang->nama_barangs }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ \App\Helpers\General::ubahDBKeHarga($barang->harga_jual) }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ \App\Helpers\General::ubahDBKeHarga($barang->harga_beli) }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $barang->stok }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::edit('barang/edit/'.$barang->id_barangs.'?page='.$barangs->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            {{\App\Helpers\General::hapus('barang/hapus/'.$barang->id_barangs, $barang->nama_barangs)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
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
                        {{ $barangs->appends(Request::except('page'))->links('vendor.pagination.custom') }}
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
                        <form action="{{ URL('barang/prosestambah') }}" class="form" method="POST">
                            {{ csrf_field() }}
                            <div class="form__article">
                                <div class="mdl-grid">
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <label class="mdl-textfield__label" for="kategoris_id">Kategori</label>
                                        <select class="form-control select2" id="kategoris_id" name="kategoris_id">
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" {{ Request::old('kategoris_id') == $kategori->id ? $select='selected' : $select='' }}>{{ $kategori->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <label class="mdl-textfield__label" for="tipes_id">Tipe</label>
                                        <select class="form-control select2" id="tipes_id" name="tipes_id">
                                            @foreach($tipes as $tipe)
                                                <option value="{{ $tipe->id_tipes }}" {{ Request::old('tipes_id') == $tipe->id_tipes ? $select='selected' : $select='' }}>{{ $tipe->nama_merks .' - '. $tipe->nama_tipes }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') }}" autofocus />
                                        <label class="mdl-textfield__label" for="nama">Nama</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input priceformat" type="text" id="harga_jual" name="harga_jual" value="{{ Request::old('harga_jual') == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga_jual') }}" />
                                        <label class="mdl-textfield__label" for="harga_jual">Harga Jual</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('harga_jual'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input priceformat" type="text" id="harga_beli" name="harga_beli" value="{{ Request::old('harga_beli') == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga_beli') }}" />
                                        <label class="mdl-textfield__label" for="harga_beli">Harga Beli</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('harga_beli'))}}
                                    <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="number" id="stok" name="stok" value="{{ Request::old('stok') }}" />
                                        <label class="mdl-textfield__label" for="stok">Stok</label>
                                    </div>
                                    {{\App\Helpers\General::pesanErrorForm($errors->first('stok'))}}
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
                        <form action="{{ URL('barang/prosesedit/'.$edit_barangs->id) }}" class="form" method="POST">
                            {{ csrf_field() }}
                            @method('PATCH')
                                <div class="mdl-grid">
                                    <div class="form__article">
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <label class="mdl-textfield__label" for="kategoris_id">Kategori</label>
                                            <select class="form-control select2" id="kategoris_id" name="kategoris_id">
                                                @foreach($kategoris as $kategori)
                                                    @php($selected = '')
                                                    @if(Request::old('kategoris_id') == '')
                                                        @if($kategori->id == $edit_barangs->kategoris_id)
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @else
                                                        @if($kategori->id == Request::old('kategoris_id'))
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @endif
                                                    <option value="{{ $kategori->id }}" {{ $selected }}>{{ $kategori->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <label class="mdl-textfield__label" for="tipes_id">Tipe</label>
                                            <select class="form-control select2" id="tipes_id" name="tipes_id">
                                                @foreach($tipes as $tipe)
                                                    @php($selected = '')
                                                    @if(Request::old('tipes_id') == '')
                                                        @if($tipe->id == $edit_barangs->tipes_id)
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @else
                                                        @if($tipe->id == Request::old('tipes_id'))
                                                            @php($selected = 'selected')
                                                        @endif
                                                    @endif
                                                    <option value="{{ $tipe->id_tipes }}" {{ $selected }}>{{ $tipe->nama_merks .' - '. $tipe->nama_tipes }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="text" id="nama" name="nama" value="{{ Request::old('nama') == '' ? $edit_barangs->nama : Request::old('nama') }}" autofocus />
                                            <label class="mdl-textfield__label" for="nama">Nama</label>
                                        </div>
                                        {{\App\Helpers\General::pesanErrorForm($errors->first('nama'))}}
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input priceformat" type="text" id="harga_jual" name="harga_jual" value="{{ Request::old('harga_jual') == '' ? \App\Helpers\General::ubahDBKeHarga($edit_barangs->harga_jual) : Request::old('harga_jual') }}" autofocus />
                                            <label class="mdl-textfield__label" for="harga_jual">Harga Jual</label>
                                        </div>
                                        {{\App\Helpers\General::pesanErrorForm($errors->first('harga_jual'))}}
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input priceformat" type="text" id="harga_beli" name="harga_beli" value="{{ Request::old('harga_beli') == '' ? \App\Helpers\General::ubahDBKeHarga($edit_barangs->harga_beli) : Request::old('harga_beli') }}" autofocus />
                                            <label class="mdl-textfield__label" for="harga_beli">Harga Beli</label>
                                        </div>
                                        {{\App\Helpers\General::pesanErrorForm($errors->first('harga_beli'))}}
                                        <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                            <input class="mdl-textfield__input" type="number" id="stok" name="stok" value="{{ Request::old('stok') == '' ? $edit_barangs->stok : Request::old('stok') }}" />
                                            <label class="mdl-textfield__label" for="stok">Stok</label>
                                        </div>
                                        {{\App\Helpers\General::pesanErrorForm($errors->first('stok'))}}
                                    </div>
                                </div>
                            </div>
                            <div class="mdl-card__actions right-align">
                                @if(request()->session()->get('halaman') != '')
                                    @php($link_batal = request()->session()->get('halaman'))
                                @else
                                    @php($link_batal = URL('barang'))
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