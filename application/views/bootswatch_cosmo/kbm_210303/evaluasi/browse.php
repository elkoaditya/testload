<?php

// function
//print_r($resultset);
function display_nama_kesiswa($row)
{
	$set_metode = "form";
	 $a = $row['nama'];
	if (isset($row['evaluasi_terkoreksi'])):
		if($row['evaluasi_terkoreksi']):
			$a =  $row['nama'];
		endif;
	endif;
	
	//print_r($row);
	$trigger=0;
	if(isset($row['waktu_mulai_kerja']))
	{
		$trigger=1;
		if (($row['waktu_mulai_kerja'])&&($row['waktu_selesai_kerja']==NULL)){
			$trigger=1;
			$a .= '<div align="left">' . a("kbm/evaluasi_ljs/".$set_metode."?id={$row['id']}", '<i class="icon-pencil"></i> Lanjutkan Pengerjaan',
			'class="btn btn-warning" title="kerjakan evaluasi ini"') . '</div>';
		}
	}
	if($trigger==0){	
		$a .= '<div align="left">' . a("kbm/evaluasi_ljs/".$set_metode."?id={$row['id']}", '<i class="icon-pencil"></i> Kerjakan', 'class="btn btn-success" title="kerjakan evaluasi ini"') . '</div>';
	}
	
	return  $a;

}

function display_nama($row)
{
	// $a = a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'title="lihat detail evaluasi ' . (($row['published']) ? '"' : '(belum dipublikasikan)"')) . 
	// (($row['published']) ? '<div style="color:green;">(Terpublish)<div>' : '<div style="color:red;">*(belum dipublikasikan)<div>');
	 
	if($row['status']=='draft'){
		 $a = a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'title="lihat detail evaluasi (belum dipublikasikan)"').'<div style="color:red;">*(belum dipublikasikan)<div>';
	}elseif($row['status']=='published'){
		 $a = a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'title="lihat detail evaluasi" ').'<div style="color:green;">(TERPUBLISH)<div>';
	}elseif($row['status']=='closed'){
		 $a = a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'title="lihat detail evaluasi" ').'<div style="color:red;">(TUTUP)<div>';
	}
	
	if (isset($row['evaluasi_terkoreksi'])):
		if($row['evaluasi_terkoreksi']):
			$a =  $row['nama'];
		endif;
	endif;
	
	
	return  $a;

}

function display_mapel($row)
{
	$a =  $row['mapel_nama'];
	return  $a;
}

function display_kelas($row)
{
	$a =  $row['kelas_nama'];
	return  $a;
}

function display_author($row)
{
	$a =  $row['author_nama'];
		
	return  $a;
}

function display_nilai($row)
{
	///// set metode juli 2017
	$set_metode = "form";
	if($row['metode']== "upload"){
		$set_metode = "form2";
	}
	
	// HIDDEN NILAI
	if ($row['evaluasi_terkoreksi']):
		$a = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> ' . formnil_angka($row['evaluasi_nilai']) . '</b>'), 'title="lihat lembar jawaban"');
		//$a = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> CEK PENGERJAAN </b>'), 'title="lihat lembar jawaban"');
		/*
		if( (strpos(strtolower($row['tipe']),'ulangan')=== FALSE)&&(strpos(strtolower($row['tipe']),'ujian')=== FALSE)&&(strpos(strtolower($row['tipe']),'tryout')=== FALSE) )
			return '<div align="right">' . $a . '</div>';
		else
			return '<div align="right" style="color:#F00;"><b> Selesai </b></div>';*/
		
		
		//if( ($row['tipe']=='ulangan_akhir_semester') && (APP_SUBDOMAIN=='sma_jb_bali') )
		//{	return '<div align="right">' . $a . '</div>';	}
		
		if(strpos(strtolower($row['tipe']),'latihan')=== FALSE){
			if($row['show_kunci']==1){
				return a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> Selesai Cek LJS </b>'), 'title="lihat lembar jawaban"');
			}else{
				return '<div align="right" style="color:#F00;"><b> Selesai </b></div>';	
			}
		}
		
		else
		{	return '<div align="right">' . $a . '</div>';	}
		
	endif;

	if ($row['ljs_id'])
		return '<div align="right"><i>menunggu koreksi</i></div>';
/*
	if(isset($row['waktu_mulai_kerja']))
	{
		if (($row['waktu_mulai_kerja'])&&($row['waktu_selesai_kerja']==NULL))
			return '<div align="right">' . a("kbm/evaluasi_ljs/".$set_metode."?id={$row['id']}", '<i class="icon-pencil"></i> Lanjutkan Pengerjaan',
		'class="btn btn-warning" title="kerjakan evaluasi ini"') . '</div>';
	}
	return '<div align="right">' . a("kbm/evaluasi_ljs/".$set_metode."?id={$row['id']}", '<i class="icon-pencil"></i> Kerjakan', 'class="btn btn-success" title="kerjakan evaluasi ini"') . '</div>';
*/
	return "";
}

function display_nilai_token_enable($row)
{
	
	// HIDDEN NILAI
	if ($row['evaluasi_terkoreksi']):
		$a = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> ' . formnil_angka($row['evaluasi_nilai']) . '</b>'), 'title="lihat lembar jawaban"');
		
		
		if( (strpos(strtolower($row['tipe']),'ulangan')=== FALSE)&&(strpos(strtolower($row['tipe']),'ujian')=== FALSE)&&(strpos(strtolower($row['tipe']),'tryout')=== FALSE) )
			return '<div align="right">' . $a . '</div>';
		else
			return '<div align="right" style="color:#F00;"><b> Selesai </b></div>';
	endif;

	if ($row['ljs_id'])
		return '<div align="right"><i>menunggu koreksi</i></div>';

	if(isset($row['waktu_mulai_kerja']))
	{
		if (($row['waktu_mulai_kerja'])&&($row['waktu_selesai_kerja']==NULL))
			return '<div align="right"><input id="clickMe" class="btn btn-warning" type="button" value=" Lanjutkan Pengerjaan" onclick="modelToken('.$row['id'].')" /> </div>';
	}
	return '<div align="right"><input id="clickMe" class="btn btn-success" type="button" value="Kerjakan" onclick="modelToken('.$row['id'].')" /> </div>';

}

function display_bentuk($pilihan_jml)
{
	return ($pilihan_jml > 1) ? 'pilihan' : 'uraian';

}

function display_status($status)
{
	if($status=='draft')
	{	$cetak = '<div style="color:orange;">Racik</div>';	}
	else if($status=='published')
	{	$cetak = '<div style="color:green;">Terpublish</div>';	}
	else if($status=='closed')
	{	$cetak = '<div style="color:red;">Tutup</div>';		}
	else if($status=='deleted')
	{	$cetak = 'Hapus';		}

	return $cetak;

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Evaluasi',
);

// pills link

$pills = array();

if ($mengajar_list):
	$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Susun Evaluasi Baru',
		'uri'	 => "kbm/evaluasi/form?pelajaran_id={$request['pelajaran_id']}",
		'attr'	 => 'title="tambah evaluasi baru"',
		'class'	 => 'active'
	);
	
	if(APP_SUBDOMAIN == 'demo.fresto.co'){
		$pills[] = array(
			'label'	 => '<i class="icon-plus"></i>Evaluasi MODE UPLOAD Baru',
			'uri'	 => "kbm/evaluasi/form_upload?pelajaran_id={$request['pelajaran_id']}",
			'attr'	 => 'title="tambah evaluasi MODE UPLOAD baru"',
			'class'	 => 'active'
		);
	}
endif;

// input filter/pencarian

$input = array(
	'term'			 => array(
		'term',
		'placeholder'	 => 'pencarian',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-small',
	),
	'semester_id'	 => array(
		'semester_id',
		'type'		 => 'dropdown',
		'name'		 => 'semester_id',
		'id'		 => 'semester_id',
		'options'	 => $this->m_option->semester('semester'),
		'extra'		 => 'class="input-large select"',
	),
	'pelajaran_id'	 => array(
		'pelajaran_id',
		'type'		 => 'dropdown',
		'name'		 => 'pelajaran_id',
		'id'		 => 'pelajaran_id',
		'options'	 => array('' => 'pelajaran'),
		'extra'		 => 'class="input-large select"',
	),
	'author_id'		 => array(
		'author_id',
		'type'		 => 'dropdown',
		'name'		 => 'author_id',
		'id'		 => 'author_id',
		'options'	 => array('' => 'author'),
		'extra'		 => 'class="input-large select"',
	),
	'mapel_id'		 => array(
		'mapel_id',
		'type'		 => 'dropdown',
		'name'		 => 'mapel_id',
		'id'		 => 'mapel_id',
		'options'	 => $this->m_option->mapel('mapel'),
		'extra'		 => 'class="input-medium select"',
	),
	'tglwaktu'		=> array(
		'tglwaktu',
		'type' 			=> 'input',
		'name'		 	=> 'tglwaktu',
		'class' 		=> 'input input-medium tglwaktu',
		'placeholder' 	=> 'publish',
		'title' 		=> 'isikan tanggal-jam mulai ',
	),
	'status'		=> array(
		'status',
		'type'		 => 'dropdown',
		'name'		 => 'status',
		'id'		 => 'status',
		'options' => array(
						'' 	=> 'tampil semua',
						'draft' 	=> 'belum terpublish',
						'published' => 'terpublish',
						'closed' 	=> 'tutup',
				),
		'extra'		 => 'class="input-medium select"',
	),
	'status_pengerjaan'		=> array(
		'status_pengerjaan',
		'type'		 => 'dropdown',
		'name'		 => 'status_pengerjaan',
		'id'		 => 'status_pengerjaan',
		'options' => array(
						'' 	=> 'tampil semua',
						'belum' 	=> 'belum dikerjakan / belum selesai',
						'selesai' 	=> 'sudah selesai',
				),
		'extra'		 => 'class="input-medium select"',
	),
	'urutan'		=> array(
		'urutan',
		'type'		 => 'dropdown',
		'name'		 => 'urutan',
		'id'		 => 'urutan',
		'options' => array(
						'dibuat' 		=> 'URUT TERAKHIR DIBUAT ',
						'abjad_asc' 	=> 'URUT ABJAD A-Z ',
						'abjad_desc' 	=> 'URUT ABJAD Z-A ',
				),
		'extra'		 => 'class="input-medium select"',
	),
	'urutan_siswa'		=> array(
		'urutan',
		'type'		 => 'dropdown',
		'name'		 => 'urutan',
		'id'		 => 'urutan',
		'options' => array(
						'waktu' 		=> 'URUT WAKTU MULAI',
						'abjad_asc' 	=> 'URUT ABJAD A-Z ',
						'abjad_desc' 	=> 'URUT ABJAD Z-A ',
				),
		'extra'		 => 'class="input-medium select"',
	),
	
);

if ($user['role'] == 'admin'):
	$input['author_id']['options'] = $this->m_option->sdm('author');
	$input['pelajaran_id']['options'] = $this->m_option->pelajaran('pelajaran');

else:
	$input['pelajaran_id']['options'] = $this->m_option->pelajaran_user('pelajaran', 'evaluasi');

endif;

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
	'base_url'			 => $this->d['uri'],
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
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		//'Tipe'							 => array('tipe', 'ucfirst'),
		'Nama Evaluasi'					 => array(FALSE, 'display_nama'),
		'Bentuk'						 => array('pilihan_jml', 'display_bentuk'),
		'<div align="right">KKM</div>'	 => array(
			'kkm',
			'formnil_angka',
			'prefix' => '<div align="right">',
			'suffix' => '</div>',
		),
	),
	/*'grouping'			 => array(
		'column' => array('semester_id', 'pelajaran_nama'),
	),*/
);



	
if ($user['role'] == 'siswa'):
	$table['data']['Nama Evaluasi'] = array(FALSE, 'display_nama_kesiswa');
	
	$table['data']['<div align="center">Mapel</div>'] = array(FALSE, 'display_mapel');

	$table['data']['<div align="center">Pembuat</div>'] = array(FALSE, 'display_author');

	if($token=='enable'){
		
		$table['data']['<div align="right">#</div>'] = array(FALSE, 'display_nilai_token_enable');
	}else{
		$table['data']['<div align="right">#</div>'] = array(FALSE, 'display_nilai');
	}
	$table['data']['Mulai'] = array('evaluasi_mulai', 'tglwaktu');
	$table['data']['Berakhir'] = array('evaluasi_ditutup', 'tglwaktu');
	$table['data']['Durasi'] = array('evaluasi_durasi', 'waktu');
	/*if($token=='enable'){
		$table['data']['<div align="right">Nilai</div>'] = array(FALSE, 'display_nilai_token_enable');
	}else{
		$table['data']['<div align="right">Nilai</div>'] = array(FALSE, 'display_nilai');
	}*/
	$table['data']['Dikerjakan'] = array('ljs_last', 'date2tgl');
	/*$table['grouping']['title'] = array(
		'<span class="title">',
		array('mapel_nama', 'strtoupper'),
		'</span> &nbsp; ',
		'<span class="desc">',
		'[', 'pelajaran_nama', ']&nbsp; ', array('semester_nama', 'ucwords'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
		'</span>',
	);*/

else:
	//$table['data']['<div align="center">Status</div>'] = array('status', 'display_status');
	
	//$table['data']['<div align="center">Buat</div>'] = array('registered', 'tglwaktu');
	$table['data']['<div align="center">Kelas</div>'] = array(FALSE, 'display_kelas');
	$table['data']['<div align="center">Publish</div>'] = array('published', 'tglwaktu');
	
	/*$table['data']['<div align="right">Pengerjaan</div>'] = array(
		'siswa_menjawab',
		'prefix' => '<div align="right">',
		'suffix' => array(
			' / ',
			'siswa_total',
			'</div>',
		),
	);*/
	/*$table['data']['<div align="right">Rata-Rata Nilai</div>'] = array(
		'rata2_nilai',
		'formnil_angka',
		'prefix' => '<div align="right">',
		'suffix' => '</div>',
	);*/
	
	$table['grouping']['column'] = array('semester_id', 'pelajaran_nama');
	$table['grouping']['title'] = array(
		'<span class="title">',
		array('pelajaran_nama', 'strtoupper'),
		'</span> &nbsp; ',
		'<span class="desc">',
		'[', 'mapel_nama', ']&nbsp; ', array('semester_nama', 'ucwords'), ' ', 'ta_nama', '. Oleh ', 'author_nama', '.',
		'</span>',
	);


endif;

$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['pelajaran_id'], $request) . '&nbsp;'
	. form_cell($input['semester_id'], $request) . '&nbsp;';

if ($admin):
	$bar .= form_cell($input['author_id'], $request) . '&nbsp;';
	$bar .= form_cell($input['tglwaktu'], $request) . '&nbsp;';
endif;

if ($user['role'] != 'siswa'):
	$bar .= form_cell($input['status'], $request) . '&nbsp;';
	$bar .= form_cell($input['urutan'], $request) . '&nbsp;';
else:
	$bar .= form_cell($input['status_pengerjaan'], $request) . '&nbsp;';
	$bar .= form_cell($input['urutan_siswa'], $request) . '&nbsp;';
endif;



$uri_jadwal = 'kbm/evaluasi_tool/jadwal?tanggal_awal='.date("d-m-Y").'&tanggal_akhir='.date("d-m-Y");

$bar .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"'). ' ';
	
if ($user['role'] != 'siswa'){
	$bar .= a($uri_jadwal, 'Lihat Jadwal', 'class="btn btn-primary"');
}
	
$bar .= form_close()
	. '</div>';

?>

<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Evaluasi Belajar')); ?>
	<?php
		echo cosmo_js(); 
	?>
	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.record-group {
				margin: 16px 0 7px 0;
			}
			.record-group .title {
				font-size: 1.4em;
				color: black;
				vertical-align: baseline;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Evaluasi Belajar</h1>
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
			if($token=='enable'){
				$this->load->view (THEME .'/kbm/evaluasi/modal_token');
			}
			
			echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
			echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
			addon('timepicker'); 
		?>

	<!--</body>
</html>-->

<script type="text/javascript">
	$(function() {
		
		$('.tglwaktu').datepicker({dateFormat: "dd-mm-yy"});
	});
</script>