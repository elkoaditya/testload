<?php

// vars
$get_download = explode('?',$_SERVER['REQUEST_URI']);
$ruri = "{$uri}?".$get_download[1];

// fungsi

function display_roleback($row)
{
	if (!$row['ljs_id'])
		return '<div style="color:red;"><b><i>kosong</b></div> ';

	if (!$row['ljs_dikoreksi'])
		return '<div style="color:green;"><b><i>Belum selesai</b></div> ';
	
	return a("kbm/evaluasi_ljs/roleback?id={$row['ljs_id']}", 'Roleback<br>Pengerjaan', 'class="btn btn-primary" title="roleback pengerjaan siswa ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK ROLEBACK PERJAKAAN INI?\')"');

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
		'Kelas'	 		=> 'kelas_nama',
		'Siswa'	 		=> 'siswa_nama',
		'Roleback'	 	=> array(FALSE, 'display_roleback'),
		
	),
);


$tampil_soal = 1;
while($tampil_soal <= $resultset['jml_soal']){
	
	/// JAWABAN SISWA
	if($this->input->get('detail_jawab')){
		$table['data']['No'.$tampil_soal] = array('soal_label'.$tampil_soal, 'formnil_angka');
	}else{
		$table['data']['No'.$tampil_soal] = array('soal_pilihan'.$tampil_soal, 'formnil_angka');
	}
	
	$tampil_soal++;
}

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

		<?php echo cosmo_js(); ?>

	<!--</body>
</html>-->


