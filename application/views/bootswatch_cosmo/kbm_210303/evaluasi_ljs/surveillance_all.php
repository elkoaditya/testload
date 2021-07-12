<?php

// vars
$get_download = explode('?',$_SERVER['REQUEST_URI']);
$ruri = "{$uri}?".$get_download[1];

// fungsi
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

function display_roleback($row)
{
	if (!$row['ljs_id'])
		return '<div style="color:red;"><b>-</b></div> ';

	//if (!$row['ljs_dikoreksi'])
	if ($row['ljs_selesai']==0)
		return '<div style="color:red;"><b>-</b></div> ';
	
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
		'uri'	 => "kbm/evaluasi_ljs/surveillance?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id'),
		'attr'	 => 'title="Kembali ke tampilan evaluasi" ',
	);

}else{
	$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Detail Jawaban',
		'uri'	 => "kbm/evaluasi_ljs/surveillance?evaluasi_id={$evaluasi['id']}&kelas_id=".$this->input->get('kelas_id')."&detail_jawab=1",
		'attr'	 => 'title="Kembali ke tampilan evaluasi" ',
	);
}





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
		//'Kelas'	 		=> 'kelas_nama',
		'Siswa'	 		=> 'siswa_nama',
		'Nilai'	 		=> array(FALSE, 'display_nilai'),
		'Status'	 	=> array(FALSE, 'display_status'),
		'Roleback'	 	=> array(FALSE, 'display_roleback'),
		'Nilai'	 		=> array(FALSE, 'display_nilai'),
		'Mulai'	=> array(FALSE, 'display_waktu_awal'),
		'Akhir'	=> array(FALSE, 'display_waktu_akhir'),
	),
);

 

$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. '<b>TERAKHIR CEK<br> <h3>'.date("Y-m-d H:i:s").'</h3></b>'
	
	. form_close()
	. '</div>';

	

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal Evaluasi {$evaluasi['id']}")); ?>

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
					Surveillance Pengerjaan Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
				</div>

				<?php

				echo alert_get();
				echo $bar;
				
				echo ds_table($table, $resultset);
				

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


