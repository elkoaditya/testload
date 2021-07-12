<?php

// function
//print_r($resultset);


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
	'Jadwal',						
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
	'kelas_id'		 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
	'tanggal_awal'		=> array(
		'tanggal_awal',
		'type' 			=> 'input',
		'name'		 	=> 'tanggal_awal',
		'class' 		=> 'input input-medium tanggal_awal',
		'placeholder' 	=> 'awal',
		'title' 		=> 'awal tanggal',
	),
	'tanggal_akhir'		=> array(
		'tanggal_akhir',
		'type' 			=> 'input',
		'name'		 	=> 'tanggal_akhir',
		'class' 		=> 'input input-medium tanggal_akhir',
		'placeholder' 	=> 'akhir',
		'title' 		=> 'akhir tanggal',
	),
	'status'		=> array(
		'status',
		'type'		 => 'dropdown',
		'name'		 => 'status',
		'id'		 => 'status',
		'options' => array(
						'' 	=> 'semua',
						'draft' 	=> 'racik',
						'published' => 'terpublish',
						'closed' 	=> 'tutup',
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



$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['pelajaran_id'], $request) . '&nbsp;'
	. form_cell($input['semester_id'], $request) . '&nbsp;'
	. form_cell($input['kelas_id'], $request) . '&nbsp;';

if ($admin):
	$bar .= form_cell($input['author_id'], $request) . '&nbsp;';
	
endif;

$bar .= form_cell($input['tanggal_awal'], $request) . '&nbsp;';
$bar .= form_cell($input['tanggal_akhir'], $request) . '&nbsp;';

if ($user['role'] != 'siswa'):
	$bar .= form_cell($input['status'], $request) . '&nbsp;';
endif;


$bar .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"'). ' '
	. form_close()
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
					<h1>Jadwal Evaluasi</h1>
				</div>

				<?php

				echo alert_get();
				echo $bar;
				//echo ds_table($table, $resultset);
				
				echo'<table class="table table-bordered table-striped table-hover">';
				
				$kelas_list = $kelas['data'];
				
				//// head
				echo'<thead><tr>
					<td class=" t-head my-widget-header">#</td>';
				
				foreach($kelas_list as $kl){
					if(isset($_GET['kelas_id'])){
						if($_GET['kelas_id']>0){
							if($_GET['kelas_id']==$kl['id']){
								echo'<td class=" t-head my-widget-header">'.$kl['nama'].'</td>';
							}
						}else{
							echo'<td class=" t-head my-widget-header">'.$kl['nama'].'</td>';
						}
					}else{
						echo'<td class=" t-head my-widget-header">'.$kl['nama'].'</td>';
					}
				}
				
				echo'</tr></thead>';
				////////////
				
				//// body
				$no=0;
				$exptglwaktu = explode("-", $_GET['tanggal_awal']);
				$tanggal_awal = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
				
				$exptglwaktu = explode("-", $_GET['tanggal_akhir']);
				$tanggal_akhir = $exptglwaktu[2]."-".$exptglwaktu[1]."-".$exptglwaktu[0];
				
				$tanggal_cek = $tanggal_awal;
				while($tanggal_cek<=$tanggal_akhir){
					
					echo'<tbody id="table-'.$no.'" class="t-row"><tr>
						<td style="min-width: 100px" id="table-'.$no.'-tgl" class="t-data my-state-default table-'.$no.'">'.tgl($tanggal_cek).'</td>';
					
					$kelas_list = $kelas['data'];
					foreach($kelas_list as $kl){
						
						$cetak=0;
						if(isset($_GET['kelas_id'])){
							if($_GET['kelas_id']>0){
								if($_GET['kelas_id']==$kl['id']){
									$cetak=1;
								}
							}else{
								$cetak=1;
							}
						}else{
							$cetak=1;
						}
						
						if($cetak==1){
							echo'<td style="min-width: 150px" id="table-'.$no.'-'.$kl['id'].'" class="t-data my-state-default table-'.$no.'">';
							
							$evaluasi = $resultset['data'];
							$jam_awal = $tanggal_cek." 00:00";
							$jam_akhir = $tanggal_cek." 23:59";
							
							foreach($evaluasi as $data_eval){
								if( ($data_eval['kelas_id'] == $kl['id']) &&  ($data_eval['evaluasi_mulai'] >= $jam_awal) && ($data_eval['evaluasi_mulai'] <= $jam_akhir) ){
									
									echo '<div class="well">';
									$uri_eval = base_url()."kbm/evaluasi";
									echo '<a href="'.$uri_eval.'/id/'.$data_eval['id'].'">'.$data_eval['nama'].'</a><br>';
									echo '<b>Mapel</b><br>'.$data_eval['mapel_nama'].'<br>';
									echo '<b>Pembuat</b><br>'.$data_eval['author_nama'].'<br>';
									echo '<b>Jam</b><br>'.tglwaktu($data_eval['evaluasi_mulai']).' <br>sampai<br> '.tglwaktu($data_eval['evaluasi_ditutup']).'<br>';
									echo '<b>Durasi</b><br>'.$data_eval['evaluasi_durasi'].'<br>';
									echo '<b>Bentuk</b><br>'.display_bentuk($data_eval['pilihan_jml']).'<br>';
									echo '<b>Status</b><br>'.display_status($data_eval['status']).'';
									echo '</div>';
									
									
								}
							}
							
							echo'</td>';
						}
					}
					
					echo'</tr></thead>';
					
					/// NEXT day
					$datetime = new DateTime($tanggal_cek);
					$datetime->modify('+1 day');
					$tanggal_cek = $datetime->format('Y-m-d');
				}
				
				echo'</table>';
				
				//print_r($resultset['data']);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php 
			
			
			echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
			echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
			addon('timepicker'); 
		?>

	<!--</body>
</html>-->

<script type="text/javascript">
	$(function() {
		
		$('.tanggal_awal').datepicker({dateFormat: "dd-mm-yy"});
		$('.tanggal_akhir').datepicker({dateFormat: "dd-mm-yy"});
	});
</script>