<style>
    @media print 
    {
        @page
        {
            size: A4;
        }
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
    }
    table
    {
        border-collapse : collapse;
        font-size       : 14px;
    }
    .page {
        page-break-before: always;
    }
    .page:first-child {
        page-break-before: avoid;
    }
    .nowraptable{
		white-space: nowrap;
	}
    header {
        text-align: center;
        position: relative;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    header img {
        width: 150px;
        position: absolute;
        top: 0;
        left: 0;
    }
    header h1, header p {
        font-weight: bold;
    }
    header h1 {
        margin: 5px 0;
        font-size: 1.8rem;
        text-transform: uppercase;
    }
    header p {
        margin: 2px 0;
        font-size: 0.8rem;
    }
    .right-align {
        text-align: right;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    table, th, td {
        border: 1px solid #000;
    }
    th {
        padding: 10px;
        text-align: center;
        background-color: #007bff;
        font-style: italic;
    }
    td {
        padding: 10px;
        text-align: left;
    }
    td:nth-child(3), td:nth-child(5) {
        font-weight: bold;
    }
    .notext{
        margin-bottom: -10px;
    }
    .namatext{
        margin-top: -10px;
        margin-bottom:-45px;
    }
    .perusahaantext{
        margin-bottom:-30px;
    }
    .ditempattext{
        margin-bottom:-10px;
    }
    .kondisipenawarantext{
        margin-top:-10px;
        margin-bottom: 0px;
    }
    .notestext{
        margin-bottom:0px;
    }
    .notesdetailtext{
        margin-top:-10px;
        margin-bottom: 10px;
    }
    .cptext{
        margin-bottom: -10px;
    }
    .tandatangan{
        width: 128px;
    }
    .footer{
        margin-left: 30px;
    }
    .direkturtext{
        margin-top:-10px;
        margin-left: 35px;
    }
    .center-align{
        text-align:center;
    }
    .textheader{
        margin-left:70px;
    }
</style>
<div class="page">
    <header>
        <img src="{{ public_path('template/images/logo.png') }}" alt="Logo PT. Putra Kelana Gemilang">
        <div class="textheader">
            <h1>PT. PUTRA KELANA GEMILANG</h1>
            <p>Medical and Hospital equipment supplier</p>
            <p>Jl. Magelang-Kopeng, Plumbon RT 003 RW 001, Banyuurip, Tegalrejo, Kab. Magelang</p>
            <p>EMAIL: ptputrakelanagemilan@gmail.com * (0293) 3199717</p>
        </div>
    </header>

    <section>
        <p class="right-align">Magelang, 10 Januari 2025</p>
        <p class="notext">No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$penawaran->no}}</p>
        <p>Hal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Surat Penawaran</p>
        <p>Kepada Yth,<br>
        <p class="namatext"><strong>{{$penawaran->nama}}</strong><p><br>
        <p class="perusahaantext"><strong>{{$penawaran->perusahaan}}</strong><p><br>
        <p class="ditempattext">{{$penawaran->alamat}}</p>
        <p>di Tempat</p>
        <p>Dengan hormat,</p>
        <p>Pada kesempatan yang baik ini kami dari PT. PUTRA KELANA GEMILANG, bermaksud mengajukan penawaran produk sebagai berikut:</p>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Description</th>
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @if(!$penawaran_barangs->isEmpty())
                    @php($no = 1)
                    @foreach($penawaran_barangs as $penawaran_barang)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $penawaran_barang->nama_barangs }}</td>
                            <td>{{ $penawaran_barang->nama_merks }}</td>
                            <td>{{ $penawaran_barang->nama_tipes }}</td>
                            <td>{{ \App\Helpers\General::ubahDBKeHarga($penawaran_barang->harga) }}</td>
                        </tr>
                        @php($no++)
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="center-align">Tidak ada data ditampilkan</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <p class="kondisipenawarantext">Kondisi Penawaran :</p>
        {!! nl2br($penawaran->kondisi) !!}
        <p class="notestext">Catatan :</p>
        {!! nl2br($penawaran->catatan) !!}

        <p class="cptext">CP: {{$penawaran->cp}} ({{$penawaran->kontak_cp}})</p>
        <p>Demikian surat penawaran ini kami sampaikan, atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.</p>
    </section>

    <div class="footer">
        <img src="{{ public_path('template/images/logo.png') }}" class="tandatangan" alt="Tanda Tangan">
        <p><u>Aji Wahyu Wibowo</u></p>
        <p class="direkturtext">Direktur</p>
    </div>
</div>

<!-- <script type="text/javascript">window.onload=function(){window.print();setTimeout(function(){window.close(window.location = "{{URL('penawaran')}}");}, 1);}</script> -->