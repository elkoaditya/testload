<?php

// function

function display_nama($row) {
	return a("kbm/vidcall/id/{$row['id']}", $row['nama'], 'title="lihat vidcall"');
}

function display_kepada($row) {
	$kepada='';
	if($row['tampil_guru']==1){
		$kepada .= ' GURU';
	}
	
		$row['kelas_nama'] = str_replace(",", ", ", $row['kelas_nama']);
		$kepada .= '<br> SISWA ['.$row['kelas_nama'].']';
	
	return $kepada;
}

function display_tanggal_publish($row) {
	return tglwaktu($row['tanggal_publish']);
}

function display_tanggal_tutup($row) {
	return tglwaktu($row['tanggal_tutup']);
}

function display_aksi($row) {
	$aksi = a("kbm/vidcall/form?id={$row['id']}", '<i class="icon-edit"></i> Edit', 'class="btn btn-warning" title="edit vidcall"');
	$aksi .= "&nbsp&nbsp";
	$aksi .= a("kbm/vidcall/hapus/{$row['id']}", '<i class="icon-trash"></i> Hapus', 'class="btn btn-danger" title="hapus vidcall"');
	return $aksi;
}
// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'vidcall',
);

// pills link

$pills_kanan['tambah'] = array(
		'label' => '<i class="icon-star"></i> Buat Video Call Baru',
		'uri' => "kbm/vidcall/form",
		'attr' => 'title="tambah vidcall baru"',
		'class' => 'disabled',
);

if (($user['role'] == 'admin') || ($user['role'] == 'sdm'))
	$pills_kanan['tambah']['class'] = 'active';

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
				'title' => 'ketikan kata kunci pencarian',
		),
		
		'author_id' => array(
				'author_id',
				'type' => 'dropdown',
				'name' => 'author_id',
				'id' => 'author_id',
				'extra' => 'class="input-medium select"',
		),
		
		'tanggal_publish' => array(
				'tanggal_publish',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_publish',
				'id' 	=> 'tanggal_publish',
				'class' => 'input input-medium tgl',
				'placeholder' => 'tanggal publish',
		),
		'tanggal_tutup' => array(
				'tanggal_tutup',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_tutup',
				'id' 	=> 'tanggal_tutup',
				'class' => 'input input-medium tgl',
				'placeholder' => 'tanggal tutup',
		),
);

// pagination
/*
if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 4,
		'num_links' => 5,
		'next_link' => '???',
		'prev_link' => '???',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => $this->d['uri'],
		'full_tag_open' => '<div class="pagination"><ul>',
		'full_tag_close' => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
		'cur_tag_open' => '<li class="active"><a href="#">',
		'cur_tag_close' => '</a></li>',
		'num_tag_open' => '<li>',
		'num_tag_close' => '</li>',
		'first_tag_open' => '<li>',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li>',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li>',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li>',
		'prev_tag_close' => '</li>',
);
$this->md->paging($resultset, $pagination);
*/
// tabel data

$table = array(
		'show_header' => TRUE,
		'pagination_link' => TRUE,
		'show_stat' => FALSE,
		'show_number' => TRUE,
		'row_action' => FALSE,
		'row_link' => FALSE,
		'jquery' => FALSE,
		'table_properties' => array(
				'id' => 'tabel-vidcall',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Vidcall' 		=> array(FALSE, 'display_nama'),
				'Kepada' 			=> array(FALSE, 'display_kepada'),
				'Tanggal Publish' 	=> array(FALSE, 'display_tanggal_publish'),
				'Tanggal Tutup' 	=> array(FALSE, 'display_tanggal_tutup'),
				'Pembuat' 			=> array('author_nama'),
				'Aksi' 				=> array(FALSE, 'display_aksi'),
		),
		
);

// bars

$bar_pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;';

if ($view):
	$input['author_id']['options'] = $this->m_option->sdm('author');
	$input['mapel_id']['options'] = $this->m_option->mapel('mapel');

	//$bar_pencarian .= form_cell($input['author_id'], $request) . '&nbsp;';
	$bar_pencarian .= form_cell($input['tanggal_publish'], $request) . '&nbsp;';
	//$bar_pencarian .= form_cell($input['tanggal_tutup'], $request) . '&nbsp;';
endif;

$bar_pencarian .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Video Call')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

		<style>
			.record-group .title {
				font-size: 1.4em;
				color: black;
				vertical-align: baseline;
				line-height: 2em;
			}
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Video Call</h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_pencarian;
				//echo ds_table($table, $resultset);
				?>
				<div class="tabbable"> <!-- Only required for left/right tabs -->
				  <ul class="nav nav-pills">
					
					<?php
					$active_tab = 'class="active"';
					if (($user['role'] == 'admin') || ($user['role'] == 'sdm')){ ?>
						<li <?=$active_tab?>><a href="#tab_sendiri" data-toggle="tab">Edit Video Call</a></li>
					<?php
						$active_tab = '';
					}
					?>
					
					<li <?=$active_tab?>><a href="#tab_sekolah" data-toggle="tab">Daftar Video Call</a></li>
					<!--<li><a href="#tab_guru" data-toggle="tab">Video Call dari Guru</a></li>-->
					
				  </ul>
				  <div class="tab-content">
					
					<!--
					<div class="tab-pane" id="tab_guru">
					  
						<?php
						$jumlah=0;
						foreach($resultset_guru['data'] as $vidcall){
							$jumlah++;
							
							?>
							<a href="<?=base_url()?>kbm/vidcall/id/<?=$vidcall['id']?>">
							<div class="well well-small" >
								
							  <div style="margin-top:8px;">
								<h4><b><?=$vidcall['nama']?> </b></h4>
								<h4><b>Mulai  <?=tglwaktu($vidcall['tanggal_publish'])?> </b></h4>
							  </div>
							  <p>Oleh <?=$vidcall['author_nama']?></p>
							</div>
							</a>
							<?php
						}
						if($jumlah==0){
							?>
							<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>
							<?php
						}
						?>
					</div>-->
					
					<?php
					$active_tab = "active";
					if (($user['role'] == 'admin') || ($user['role'] == 'sdm')){ ?>
						<div class="tab-pane <?=$active_tab?>" id="tab_sendiri">
						  <?php echo ds_table($table, $resultset_sendiri); ?>
						</div>
					<?php
						$active_tab = "";
					}
					?>
					
					<div class="tab-pane <?=$active_tab?>" id="tab_sekolah">
						<?php
						$jumlah=0;
						foreach($resultset_sekolah['data'] as $vidcall){
							$jumlah++;
							$jenis_brand="";
							if($vidcall['jenis_brand']==1){
								$jenis_brand = "ZOOM";
							}elseif($vidcall['jenis_brand']==2){
								$jenis_brand = "JITSI";
							}
							?>
							<a href="<?=base_url()?>kbm/vidcall/id/<?=$vidcall['id']?>">
							<div class="well well-small" >
								
							  <div style="margin-top:8px;">
								<h4><b>VIDEO CALL  <?=$jenis_brand?> </b></h4>
								<h4><b><?=$vidcall['nama']?> </b></h4>
								<!--<h4><b>Mulai  <?=tglwaktu($vidcall['tanggal_publish'])?> ,durasi <?=$vidcall['durasi']?> menit</b></h4>-->
								<h4><b>Mulai  <?=tglwaktu($vidcall['tanggal_publish'])?> ,Berakhir <?=tglwaktu($vidcall['tanggal_tutup'])?></b></h4>
							  </div>
							  <p>Oleh <?=$vidcall['author_nama']?></p>
							</div>
							</a>
							<?php
						}
						if($jumlah==0){
							?>
							<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>
							<?php
						}
						?>
						
					</div>
					
					
				  </div>
				</div>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php 
		echo cosmo_js(); 
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		addon('timepicker');
		?>

	<script type="text/javascript">
		$(function() {
			$('.tgl').datepicker({dateFormat: "yy-mm-dd"});
		});
	</script>
	</body>
</html>
