@extends('layouts.app')
@section('content')

    <div class="mdl-grid ui-tables">
        <div class="mdl-cell mdl-cell--9-col-desktop mdl-cell--8-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title">
                    <h1 class="mdl-card__title-text">Supplier Barang</h1>
                </div>
                <div class="mdl-card__supporting-text no-padding">
					@if (Session::get('setelah_simpan.alert') == 'sukses')
						{{ App\Helpers\General::pesanSuksesForm(Session::get('setelah_simpan.text')) }}
					@endif
					@if (Session::get('setelah_simpan.alert') == 'error')
						{{ App\Helpers\General::pesanFlashErrorForm(Session::get('setelah_simpan.text')) }}
					@endif

                    <div class="mdl-card__actions">
                        <form method="GET" action="{{ URL('supplier-barang/cari') }}">
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
                            <th class="mdl-data-table__cell--non-numeric">Telepon</th>
                            <th class="mdl-data-table__cell--non-numeric">Alamat</th>
                            <th class="mdl-data-table__cell--non-numeric">Kategori</th>
                            <th class="mdl-data-table__cell--non-numeric">Merk</th>
                            <th class="mdl-data-table__cell--non-numeric">Tipe</th>
                            <th class="mdl-data-table__cell--non-numeric">Barang</th>
                            <th class="mdl-data-table__cell--non-numeric">Harga Beli</th>
                            <th class="mdl-data-table__cell--non-numeric">Harga Jual</th>
                            <th class="mdl-data-table__cell--non-numeric">Stok</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Edit</th>
                            <th class="mdl-data-table__cell--non-numeric" width="100px">Hapus</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!$supplier_barangs->isEmpty())
                                @php($no = 1)
                                @foreach($supplier_barangs as $supplier_barang)
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $no++ }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->nama_suppliers }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->telepon_suppliers }}</td>
                                        <td class="mdl-data-table__cell--non-numeric" style="white-space:wrap !important">{{ $supplier_barang->alamat_suppliers }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->nama_kategoris }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->nama_merks }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->nama_tipes }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->nama_barangs }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ \App\Helpers\General::ubahDBKeHarga($supplier_barang->harga_beli) }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ \App\Helpers\General::ubahDBKeHarga($supplier_barang->harga_jual) }}</td>
                                        <td class="mdl-data-table__cell--non-numeric">{{ $supplier_barang->stok }}</td>
                                        <td class="mdl-data-table__cell--non-numeric center-align">
                                            {{\App\Helpers\General::edit('supplier-barang/edit/'.$supplier_barang->id_supplier_barangs.'?page='.$supplier_barangs->currentPage())}}
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric center-align">
                                            {{\App\Helpers\General::hapus('supplier-barang/hapus/'.$supplier_barang->id_supplier_barangs, $supplier_barang->nama)}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="13" class="center-align">Tidak ada data ditampilkan</td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
								    <td style="display:none"></td>
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
                        {{ $supplier_barangs->appends(Request::except('page'))->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mdl-cell mdl-cell--3-col-desktop mdl-cell--4-col-tablet mdl-cell--12-col-phone">
            <div class="mdl-card mdl-shadow--2dp">
                @if (Request::segment(2) != 'edit')
                    <div class="mdl-card__title">
                        <h1 class="mdl-card__title-text">Tambah</h1>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <form action="{{ URL('supplier-barang/prosestambah') }}" class="form" method="POST">
                            {{ csrf_field() }}
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="suppliers_id">Supplier</label>
                                    <select class="form-control select2" id="suppliers_id" name="suppliers_id">
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ Request::old('suppliers_id') == $supplier->id ? $select='selected' : $select='' }}>{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="barangs_id">Barang</label>
                                    <select class="form-control select2" id="barangs_id" name="barangs_id">
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id_barangs }}" {{ Request::old('barangs_id') == $barang->id_barangs ? $select='selected' : $select='' }}>{{ $barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input priceformat" type="text" id="harga_beli" name="harga_beli" value="{{ Request::old('harga_beli') == '' ? \App\Helpers\General::ubahDBKeHarga(0) : Request::old('harga_beli') }}" />
                                    <label class="mdl-textfield__label" for="harga_beli">Harga Beli</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('harga_beli'))}}
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
                        <form action="{{ URL('supplier-barang/prosesedit/'.$edit_supplier_barangs->id) }}" class="form" method="POST">
                            {{ csrf_field() }}
                            @method('PATCH')
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="suppliers_id">Supplier</label>
                                    <select class="form-control select2" id="suppliers_id" name="suppliers_id">
                                        @foreach($suppliers as $supplier)
                                            @php($selected = '')
                                            @if(Request::old('suppliers_id') == '')
                                                @if($supplier->id == $edit_supplier_barangs->suppliers_id)
                                                    @php($selected = 'selected')
                                                @endif
                                            @else
                                                @if($supplier->id == Request::old('suppliers_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
                                            <option value="{{ $supplier->id }}" {{ $selected }}>{{ $supplier->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <label class="mdl-textfield__label" for="barangs_id">Barang</label>
                                    <select class="form-control select2" id="barangs_id" name="barangs_id">
                                        @foreach($barangs as $barang)
                                            @php($selected = '')
                                            @if(Request::old('barangs_id') == '')
                                                @if($barang->id_barangs == $edit_supplier_barangs->barangs_id)
                                                    @php($selected = 'selected')
                                                @endif
                                            @else
                                                @if($barang->id_barangs == Request::old('barangs_id'))
                                                    @php($selected = 'selected')
                                                @endif
                                            @endif
                                            <option value="{{ $barang->id_barangs }}" {{ $selected }}>{{ $barang->nama_merks.' / '.$barang->nama_tipes.' / '.$barang->nama_barangs }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mdl-grid">
                                <div class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input priceformat" type="text" id="harga_beli" name="harga_beli" value="{{ Request::old('harga_beli') == '' ? \App\Helpers\General::ubahDBKeHarga($edit_supplier_barangs->harga_beli) : Request::old('harga_beli') }}" />
                                    <label class="mdl-textfield__label" for="harga_beli">Harga Beli</label>
                                </div>
                                {{\App\Helpers\General::pesanErrorForm($errors->first('harga_beli'))}}
                            </div>
                            <div class="mdl-card__actions right-align">
                                @if(request()->session()->get('halaman') != '')
                                    @php($link_batal = request()->session()->get('halaman'))
                                @else
                                    @php($link_batal = URL('supplier-barang'))
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