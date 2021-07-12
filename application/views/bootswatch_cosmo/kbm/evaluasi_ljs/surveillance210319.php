<?php
// vars
$get_download = explode('?',$_SERVER['REQUEST_URI']);
$ruri = "{$uri}?".$get_download[1];

//// CHEK ABSENSI EVALUASI AKTIF ////
$CI =& get_instance();
$CI->load->model('m_app_config');
$absensi_evaluasi = $CI->m_app_config->get('absensi_evaluasi');
//////////////////////////////////////////////////////////

/// SHOW LIMIT
//print_r($resultset);
$data_selesai		='';
$data_sedang_kerja	='';
$data_belum_kerja	='';
$total_rows['selesai']=0;
$total_rows['sedang_kerja']=0;
$total_rows['belum_kerja']=0;
$total_rows['belum_absen']=0;
$total_rows['sudah_absen']=0;
foreach($resultset['data'] as $data){
	if(!$data['ljs_id']){
		$data_belum_kerja[] = $data;
		$total_rows['belum_kerja']++;
	}elseif($data['ljs_selesai']==0){
		$data_sedang_kerja[] = $data;
		$total_rows['sedang_kerja']++;
	}else{
		$data_selesai[]		 = $data;
		$total_rows['selesai']++;
	}
	
	if(!$data['waktu_absensi']){
		$data_belum_absen[] = $data;
		$total_rows['belum_absen']++;
	}
	else{
		$data_sudah_absen[] = $data;
		$total_rows['sudah_absen']++;
	}
}	
$title='';
if($this->input->get('selesai')){
	$title = " <font color='green'>Semua Peserta Selesai Mengerjakan</font>";
	$resultset['data'] = $data_selesai;
	$resultset['total_rows'] 	= $total_rows['selesai'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}
if($this->input->get('sedang_kerja')){
	$title = " <font color='orange'>Semua Peserta Sedang Mengerjakan</font>";
	$resultset['data'] = $data_sedang_kerja;
	$resultset['total_rows'] 	= $total_rows['sedang_kerja'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}
if($this->input->get('belum_kerja')){
	$title = " <font color='red'>Semua Belum Peserta Mengerjakan</font>";
	$resultset['data'] 			= $data_belum_kerja;
	$resultset['total_rows'] 	= $total_rows['belum_kerja'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}

if($this->input->get('sudah_absen')){
	$title = " <font color='green'>Semua Sudah Klik Absensi</font>";
	$resultset['data'] 			= $data_sudah_absen;
	$resultset['total_rows'] 	= $total_rows['sudah_absen'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}

if($this->input->get('belum_absen')){
	$title = " <font color='red'>Semua Belum Klik Absensi</font>";
	$resultset['data'] 			= $data_belum_absen;
	$resultset['total_rows'] 	= $total_rows['belum_absen'];
	$resultset['selected_rows'] = $resultset['total_rows'];
	$resultset['end']		 	= $resultset['total_rows'];
}

// fungsi
function display_absensi($row)
{
	if(isset($row['waktu_absensi'])){
		return ' <div>'.$row['waktu_absensi'].'</div> ';
	}else{
		return '<div style="color:red;"><b><i>Belum Absen</i></b></div> ';
	}
}

function display_status($row)
{
	if (!$row['ljs_id'])
		return '<div style="color:red;"><b><i>Belum Mengerjakan</i></b></div> ';

	if ($row['ljs_selesai']==0)
		return '<div style="color:orange;"><b><i>Sedang Mengerjakan</i></b></div> ';
	elseif (!$row['ljs_dikoreksi'])
		return ' <div style="color:purple;"><b><i>Selesai & Belum di koreksi</i></b></div> ';
	
	return ' <div style="color:green;"><b><i>Selesai</i></b></div> ';

}

function display_waktu_awal($row)
{
	if(isset($row['ljs_awal_waktu'])){
		$awal_pengerjaan 	= strtotime($row['ljs_awal_waktu']);
		$pengerjaan 		= strtotime($row['ljs_waktu']);
		$tambahan_waktu 	= $pengerjaan - $awal_pengerjaan ;
		if($tambahan_waktu>0){
			return ' <div>'.$row['ljs_awal_waktu'].'<br><i>Tambahan: '.$tambahan_waktu.'detik</i></div> ';
		}
		return ' <div>'.$row['ljs_awal_waktu'].'</div> ';
	}

}

function display_waktu_akhir($row)
{
	if(isset($row['ljs_dikoreksi'])){
		
		return ' <div>'.$row['ljs_dikoreksi'].'</div> ';
	}

}

function display_action($row,$evaluasi)
{
	if (!$row['ljs_id'])
		return '<div style="color:red;"><b>-</b></div> ';

	//if (!$row['ljs_dikoreksi'])
	if ($row['ljs_selesai']==0)
		return '<div align="right"><a href="'.base_url().'kbm/evaluasi_tool/force_finish/'.$evaluasi['id'].'/'.$row["ljs_id"].'/'.$row["siswa_id"].'" 
			onclick="return confirm(\'APAKAH ANDA YAKIN FORCE SELESAI ?\')" 
			class="btn btn-danger">Force Close</a> </div>';
	
	//return a("kbm/evaluasi_ljs/roleback?id={$row['ljs_id']}", 'Roleback<br>Pengerjaan', 'class="btn btn-primary" title="roleback pengerjaan siswa ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK ROLEBACK PERJAKAAN INI?\')"');
	return '<div align="right"><input id="clickMe" class="btn btn-primary" type="button" value="Roleback Pengerjaan" onclick="modelRoleback('.$row['ljs_id'].')" /> </div>';
}

function display_nilai($row)
{
	if (!$row['ljs_id'])
		return '<div style="color:red;"><b>-</b></div> ';

	if (!$row['ljs_dikoreksi'])
		return '<div style="color:red;"><b>-</b></div> ';

	return ' <div style="color:blue;"><b><i>' . formnil_angka($row['ljs_nilai']) . '</i></b></div> ';

}
// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Evaluasi'						 => 'kbm/evaluasi',
	"#{$evaluasi['id']}"			 => "kbm/evaluasi/id/{$evaluasi['id']}",
	'Ljs',
);

// pills link
$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Cek Terbaru',
		'uri'	 => $ruri,
		'attr'	 => 'title="Cek Terbaru" class="btn btn-primary"',
		'class'	 => 'active',
	);
	
if($this->input->get('detail_jawab')){
	$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Tampilan Ringkas',
		'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id'),
		'attr'	 => 'title="Tampilan Jawaban Ringkas" ',
	);

}else{
	$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Detail Jawaban',
		'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&detail_jawab=1",
		'attr'	 => 'title="Tampilan soal dan jawaban detail evaluasi" ',
	);
}

$request_uri = explode('?',$_SERVER['REQUEST_URI']);
$get_request_uri='';
if(isset($request_uri[1])){
	$get_request_uri = $request_uri[1];
}
$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Download',
		'uri'	 => "kbm/evaluasi_ljs/download_surveillance?".$get_request_uri,
		'attr'	 => 'title="download Excel urutan jawaban evaluasi" ',
	);

$pills2[] = array(
	'label'	 => '<i class="icon-check"></i>Selesai Mengerjakan',
	'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&selesai=1",
	'attr'	 => 'title="Tampilan yang Selesai Mengerjakan"',
	'class'	 => 'active',
);
$pills2[] = array(
	'label'	 => '<i class="icon-edit"></i>Sedang Mengerjakan',
	'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&sedang_kerja=1",
	'attr'	 => 'title="Tampilan yang Sedang Mengerjakan" ',
	'class'	 => 'active',
);
$pills2[] = array(
	'label'	 => '<i class="icon-thumbs-down"></i>Belum Mengerjakan',
	'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&belum_kerja=1",
	'attr'	 => 'title="Tampilan yang Belum Mengerjakan" ',
	'class'	 => 'active',
);


if($absensi_evaluasi=='enable'){
	$pills3[] = array(
		'label'	 => '<i class="icon-tag"></i>Belum Absen',
		'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&belum_absen=1",
		'attr'	 => 'title="Tampilan yang Belum Absen" ',
		'class'	 => 'active',
	);
	
	$pills3[] = array(
		'label'	 => '<i class="icon-tag"></i>Sudah Absen',
		'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&sudah_absen=1",
		'attr'	 => 'title="Tampilan yang Sudah Absen" ',
		'class'	 => 'active',
	);
}

$pills2[] = array(
	'label'	 => '<i class="icon-star"></i>Tampilkan Semua',
	'uri'	 => $uri."?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id'),
	'attr'	 => 'title="Kembali ke tampilan evaluasi" ',
	'class'	 => 'active',
);







// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 4,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => $uri,
	'full_tag_open'		 => '<div class="pagination"><ul>',
	'full_tag_close'	 => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
	'cur_tag_open'		 => '<li class="active"><a href="#">',
	'cur_tag_close'		 => '</a></li>',
	'num_tag_open'		 => '<li>',
	'num_tag_close'		 => '</li>',
	'first_tag_open'	 => '<li>',
	'first_tag_close'	 => '</li>',
	'last_tag_open'		 => '<li>',
	'last_tag_close'	 => '</li>',
	'next_tag_open'		 => '<li>',
	'next_tag_close'	 => '</li>',
	'prev_tag_open'		 => '<li>',
	'prev_tag_close'	 => '</li>',
);
$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-nilai',
		'class'	 => 'table table-responsive table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Kelas'	 		=> 'kelas_nama',
		'Siswa'	 		=> 'siswa_nama',	
	),
);

/////////////////////////////////
if($absensi_evaluasi == 'enable'){
	$table['data']['Absensi']	= array(FALSE, 'display_absensi') ;
}
//////////////////////////////////////

$table['data']['Nilai']	 	= array(FALSE, 'display_nilai');
$table['data']['Status']	= array(FALSE, 'display_status');
$table['data']['Action']	= array(FALSE, 'display_action', $evaluasi);
$table['data']['Mulai']		= array(FALSE, 'display_waktu_awal');
$table['data']['Akhir']		= array(FALSE, 'display_waktu_akhir');


$tampil_soal = 1;
while($tampil_soal <= $resultset['jml_soal']){
	
	/// JAWABAN SISWA
	
	
	if($this->input->get('detail_jawab')){
		$table['data']['Soal No'.$tampil_soal] = array('soal_pertanyaan'.$tampil_soal);
		$table['data']['Jawab No'.$tampil_soal] = array('soal_label'.$tampil_soal, 'formnil_angka');
		$table['data']['Point No'.$tampil_soal] = array('soal_point'.$tampil_soal, 'formnil_angka');
		$table['data']['Status No'.$tampil_soal] = array('soal_status'.$tampil_soal);
	}else{
		$table['data']['Jawab No'.$tampil_soal] = array('soal_pilihan'.$tampil_soal, 'formnil_angka');
	}
	
	
	
	$tampil_soal++;
}


$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. '<div><ul class="nav nav-pills pull-left"><b>TERAKHIR CEK<br> <h3>'.date("Y-m-d H:i:s").'</h3></b> </ul></div>'

	. pills($pills2, 'class="nav nav-pills pull-right"');
	
if(isset($pills3)){
	$bar .= pills($pills3, 'class="nav nav-pills pull-left"')
		."<br><br><br>";
}

$bar .= "<br><br><br><br>"
		.form_close()
	. '</div>';

	

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Surveillance Evaluasi {$evaluasi['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.listing-group {
				margin: 20px 0 10px 0;
			}
			.listing-group .title {
				font-size: 1.4em;
				color: black;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					
					<b>Surveillance Pengerjaan Evaluasi:<?=$title?></b>
					<?php
					$title2 = strtoupper($evaluasi['nama']);
					
					if(isset($_GET['kelas_id'])){
						if($_GET['kelas_id'] > 0){
							$title2 = strtoupper($evaluasi['kelas_result']['data'][$_GET['kelas_id']]['kelas_nama'])." : ".strtoupper($evaluasi['nama']);	
						}
					}?>
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", $title2 , 'title="kembali ke halaman evaluasi"'); ?></h1>
					
				</div>

				<?php

				echo alert_get();
				echo $bar;
				
				echo ds_table($table, $resultset, $evaluasi);
			//	print_r($resultset);

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php 
		echo cosmo_js();
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		$this->load->view (THEME .'/kbm/evaluasi_ljs/modal_roleback'); ?>
	<!--</body>
</html>-->


