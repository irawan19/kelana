<?php

namespace App\Helpers;
use Auth;
use Datetime;
use URL;
use App\Models\Penawaran;

class General 
{
	//Notifikasi
		public static function pesanErrorForm($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorform">'.$form_input.'</div>';
		}

		public static function pesanErrorFormFile($form_input='')
		{
			if($form_input != '')
				echo '<div class="errorformfile">'.$form_input.'</div>';
		}

		public static function pesanSuksesForm($form_input='')
		{
			if($form_input != '')
			{
				echo '<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						'.$form_input.'
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>';
			}
		}

		public static function pesanFlashErrorForm($form_input = '')
		{
			if ($form_input != '')
			{
				echo '<div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--12-col-phone">
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						'.$form_input.'
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>';
			}
		}

		public static function validForm($alert="")
		{
			if($alert != '')
				echo 'is-invalid';
		}
	//Notifikasi

	//Tombol
		public static function pencarian()
		{
			echo '<button class="btn btn-sm btn-primary" type="submit">
					<span class="cil-search"></span> Cari
				</button>';
		}

		public static function simpan($link = '')
		{
			echo  '<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-green pull-right" data-upgraded=",MaterialButton,MaterialRipple">
                 	    <i class="material-icons">add</i>
                 	    simpan
                 	</button>';
		}

		public static function edit($link) {
			echo '<a href="'.URL($link).'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-purple pull-right" data-upgraded=",MaterialButton,MaterialRipple">
                    	<i class="material-icons">border_color</i>
                	</a>';
		}

		public static function perbarui()
		{
			echo '<button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-purple" data-upgraded=",MaterialButton,MaterialRipple">
                	    <i class="material-icons">border_color</i>
                	    Perbarui
                	</button>';
		}

		public static function batal($link='')
		{
			echo '<a href="'.URL($link).'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-red" data-upgraded=",MaterialButton,MaterialRipple">
                	    <i class="material-icons">cancel</i>
                	    Batal
                	</a>';

		}

		public static function hapus($link = '', $label = '')
		{
			echo '<button type="button" class="showModalHapus mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-red pull-right" data-upgraded=",MaterialButton,MaterialRipple" data-link="' . URL($link) . '" data-nama="' . $label . '">
                    	<i class="material-icons">delete</i>
                    </button>';
		}

		public static function cetak($link) {
			echo '<a href="'.URL($link).'" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-green pull-right" data-upgraded=",MaterialButton,MaterialRipple">
                    	<i class="material-icons">print</i>
                	</a>';
		}
	//Tombol

    public static function ubahDBKeTanggal($tanggal = '')
    {
    	$data_bulan 	= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    	$pecah_tanggal	= explode('-', $tanggal);
    	$bulan 			= '';
    	if ($tanggal != '0000-00-00') {
    		for ($x = 1; $x <= 12; $x++) {
    			if (intval($pecah_tanggal[1]) == $x) {
    				$bulan = $x;
    				break;
    			}
    		}
    		return $pecah_tanggal[2] . ' ' . $data_bulan[$bulan] . ' ' . $pecah_tanggal[0];
    	} else
    		return General::ubahDBKeTanggal(date('Y-m-d'));
    }

    public static function ubahTanggalKeDB($tanggal = '')
    {
    	if ($tanggal != '') {
    		$data_bulan 		= array('', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des');
    		$pecah_tanggal  	= explode(' ', $tanggal);
    		$bulan 				= '';
    		for ($x = 1; $x <= 12; $x++) {
    			if ($pecah_tanggal[1] == $data_bulan[$x]) {
    				$bulan = $x;
    				break;
    			}
    		}
    		if ($bulan < 10)
    			$bulan = '0' . $bulan;

    		$result = $pecah_tanggal[2] . '-' . $bulan . '-' . $pecah_tanggal[0];
    		return $result;
    	} else
    		return '';
    }

	public static function ubahDBKeHarga($harga = 0)
	{
		$db_ke_harga = number_format($harga, 2, ',', '.');
		return $db_ke_harga;
	}

	public static function ubahHargaKeDB($harga = 0)
	{
		$harga_ke_db = preg_replace("/([^0-9\\.])/i", "", $harga);
		return $harga_ke_db;
	}


	public static function generateNoPenawaran()
	{
		$ambil_penawarans = Penawaran::select('no')
								->whereRaw('YEAR(created_at) = "'.date('Y').'"')
								->orderByRaw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(no,"/",1),"/",-1) AS SIGNED) desc')
								->first();
		if(!empty($ambil_penawarans))
		{
			$no 						= $ambil_penawarans->no;
			$explode_no 				= explode('/', $no);
			if(!empty($explode_no[1]))
			{
				$no_new 					= (int)$explode_no[1] + 1;
				$format_no_new 				= sprintf('%03d', $no_new);
				$format_penawarans_new 		= $format_no_new.' / PKG / I /'.date('Y').' - SP';
			}
			else
				$format_penawarans_new 		= '001 / PKG / I / '.date('Y').' - SP';
		}
		else
			$format_penawarans_new 		= '001 / PKG / I / '.date('Y').' - SP';

		return $format_penawarans_new;
	}
    
}