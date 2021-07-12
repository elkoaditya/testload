<?php

// function

function display_jadwal($row)
{
	$cfg = array(
		'show_header'		 => FALSE,
		'pagination_link'	 => FALSE,
		'show_stat'			 => FALSE,
		'show_number'		 => FALSE,
		'row_action'		 => FALSE,
		'row_link'			 => FALSE,
		'jquery'			 => FALSE,
		'table_properties'	 => array(
			'id'	 => 'tabel-jadwal',
			'class'	 => 'table table-bordered table-striped table-hover',
		),
		'empty_message'		 => '<i>kosong</i>',
		'data'				 => array(
			'Kelas'		 => 'kelas_nama',
			'Mulai'		 => 'evaluasi_mulai',
			'Ditutup'	 => 'evaluasi_ditutup',
		),
	);
	return ds_table($cfg, $row['kelas_result']);

}

function display_metode($row)
{
	$row['metode'] = str_replace("_"," ",$row['metode']);
	return ucfirst($row['metode']);
}

function display_tipe($row)
{
	$row['tipe'] = str_replace("_"," ",$row['tipe']);
	if($row['tipe'] == 'latihan'){
		return ucfirst($row['tipe'])." <span style='color:#F00;'>(NILAI TAMPIL DI SISWA)</span>" . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');
	}else{
		return ucfirst($row['tipe'])." <span style='color:#00F;'>(NILAI TIDAK TAMPIL DI SISWA)</span>" . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');
	}
}

function display_nama_kd($n)
{
	//return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
	return ($n =='' OR $n =='nama' ) ? "-" : "{$n}";

}

function display_soal_jml($n, $total)
{
	//return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
	return ($n == 0 OR $n =='' OR $total < $n) ? "<i>semua pertanyaan</i>" : "{$n} pertanyaan";

}

function display_bobot_nilai($n)
{
	//return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
	return ($n == 0 OR $n =='bobot_nilai' ) ? "-" : "{$n}";

}

function display_soal_siswa($row)
{
	return ( ($row['soal_jml'] > 0 && $row['soal_jml'] < $row['soal_total']) ? $row['soal_jml'] : $row['soal_total']) . " pertanyaan";

}

function display_ljs_max($n)
{
	return ($n == 0) ? '<i>tidak dibatasi</i>' : "{$n} kali";

}

// komponen

$this->load->helper('dataset');

// hak akses & user scope
//print_r($row);
$author_ybs = (($user['id'] == $row['author_id'])||($user['id'] == $row['pelajaran_guru_id']));
$editable = (($author_ybs OR $admin) && $row['semester_id'] == $semaktif['id'] && !$row['closed']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Evaluasi'						 => 'kbm/evaluasi',
	"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
	'label'	 => 'Daftar Evaluasi',
	'uri'	 => "kbm/evaluasi",
	'attr'	 => 'title="kembali ke daftar evaluasi"',
);
$pills_kanan = array();

if ($user['role'] == 'siswa'):

	// pills khusus siswa

	$pills_kanan = array(
		'jawab'	 => array(
			'label'	 => '<i class="icon-pencil"></i> Kerjakan !',
			'uri'	 => "kbm/evaluasi_ljs/form?id={$row['id']}",
			'attr'	 => 'title="kerjakan soal evaluasi ini"',
			'class'	 => 'disabled',
		),
		'ljs'	 => array(
			'label'	 => '<i class="icon-file-alt"></i> LJS',
			'uri'	 => "kbm/evaluasi_ljs/id/{$row['ljs_id']}",
			'attr'	 => 'title="lihat lembar hasil pengerjaan"',
			'class'	 => 'disabled',
		),
	);

	if ($row['#available'] && ($row['evaluasi_terkoreksi'] OR ! $row['ljs_id'])):
		$pills_kanan['jawab']['class'] = 'active';
	endif;

	if ($row['ljs_id']):
		$pills_kanan['ljs']['class'] = 'active';
	endif;

else:

	///// vars untuk metode yang baru juli 2017
	$set_form = "form";
	if($row['metode'] == "upload"){
		$set_form = "form2";
	}
	
	
	// pilss khusus tutor dan admin
	$pills_kanan = array(
		'edit'		 => array(
			'label'	 => '<i class="icon-edit"></i> Edit',
			'uri'	 => "kbm/evaluasi/form?id={$row['id']}",
			'attr'	 => 'title="ubah data siswa ini"',
			'class'	 => 'disabled',
		),
		'download'		 => array(
			'label'	 => '<i class="icon-download"></i> Download Soal+Kunci',
			'uri'	 => "kbm/evaluasi/pdf?evaluasi_id={$row['id']}&kunci=1",
			'attr'	 => 'title="download soal+kunci" target="_blank"',
			'class'	 => 'disabled',
		),
		
		'simulasi'	 => array(
			'label'	 => '<i class="icon-pencil"></i> Simulasi',
			'uri'	 => "kbm/evaluasi_ljs/".$set_form."?id={$row['id']}&simulasi=ok",
			'attr'	 => 'title="simulasi pengerjaan evaluasi ini"',
			'class'	 => 'disabled',
		),
		'publish'	 => array(
			'label'	 => '<i class="icon-magic"></i> Publikasikan',
			'uri'	 => "kbm/evaluasi/publish?id={$row['id']}",
			'attr'	 => 'title="publikasikan soal evaluasi ini ke semua siswa/peserta"',
			'class'	 => 'disabled',
		),
		'tutup'		 => array(
			'label'	 => '<i class="icon-ban-circle"></i> Tutup',
			'uri'	 => "kbm/evaluasi/tutup?id={$row['id']}",
			'attr'	 => 'title="tutup evaluasi ini"',
			'class'	 => 'disabled',
		),
		'delete'	 => array(
			'label'	 => '<i class="icon-trash"></i> Hapus',
			'uri'	 => "kbm/evaluasi/delete?id={$row['id']}",
			'attr'	 => 'title="hapus evaluasi ini"',
			'class'	 => 'disabled',
		),
		'reuse'	 	=> array(
			'label'	 => '<i class="icon-refresh"></i> Reuse',
			'uri'	 => "kbm/evaluasi/reuse/{$row['id']}",
			'attr'	 => 'title="gunakan evaluasi ini untuk pelajaran lain"',
			'class'	 => 'disabled',
		),
		/*
		  'download' => array(
		  'label' => '<i class="icon-download"></i> Download',
		  'uri' => "kbm/evaluasi/download/{$row['id']}",
		  'attr' => 'title="download laporan lengkap evaluasi ini"',
		  'class' => 'disabled',
		  ),
		 *
		 */
	);
	$pills_link = array(
		'soal'		 => array(
			'label'	 => '<i class="icon-list-ol"></i> Butir Soal',
			'uri'	 => "kbm/evaluasi_soal/browse?evaluasi_id={$row['id']}",
			'attr'	 => 'title="lihat semua butir soal evaluasi ini"',
			'class'	 => 'disabled',
		),
		'nilai'		 => array(
			'label'	 => '<i class="icon-certificate"></i> Daftar Nilai & Keikutsertaan',
			'uri'	 => "kbm/evaluasi_nilai/browse?evaluasi_id={$row['id']}",
			'attr'	 => 'title="lihat semua nilai hasil evaluasi ini"',
			'class'	 => 'disabled',
		),
		'ljs'		 => array(
			'label'	 => '<i class="icon-file-alt"></i> Daftar LJS',
			'uri'	 => "kbm/evaluasi_ljs/browse?evaluasi_id={$row['id']}",
			'attr'	 => 'title="lihat semua lembar jawab hasil evaluasi ini"',
			'class'	 => 'disabled',
		),
		'statistik'	 => array(
			'label'	 => '<i class="icon-bar-chart"></i> Statistik',
			'uri'	 => "kbm/evaluasi_nilai/statistik?evaluasi_id={$row['id']}",
			'attr'	 => 'title="statistik grafik hasil evaluasi ini"',
			'class'	 => 'disabled',
		),
		'kartu_soal' => array(
			'label'	 => '<i class="icon-download"></i> Kartu Soal',
			'uri'	 => "kbm/evaluasi/kartu_soal?evaluasi_id={$row['id']}",
			'attr'	 => 'title="download kartu soal" target="_blank"',
			'class'	 => 'disabled',
		),
		
	);

	
	if ($editable){
		
		$pills_kanan['edit']['class'] 		= 'active';
		$pills_kanan['download']['class'] 	= 'active';
		$pills_kanan['reuse']['class'] 		= 'active';
		
		$pills_link['soal']['class'] 		= '';
		$pills_link['kartu_soal']['class'] 	= '';
	}

	//if (($row['soal_total'] > 0) && ($admin OR $user['id'] == $row['author_id']) && ($row['tipe'] != "penilaian_siswa1")):
	if (($row['soal_total'] > 0) && (($user['role'] == 'admin')||($user['role'] == 'sdm')) && ($row['tipe'] != "penilaian_siswa1")):
		$pills_kanan['simulasi']['class'] = 'active';
		//$pills_link['soal']['class'] = '';
	endif;


	//if (($row['soal_total'] > 0 && !$row['published']) && ($admin OR $user['id'] == $row['author_id']))
	if (($row['soal_total'] > 0 && !$row['published']) && (($user['role'] == 'admin')||($user['role'] == 'sdm')) )
		$pills_kanan['publish']['class'] = 'active';

	if ($row['published'] && !$row['closed'] && $editable)
		$pills_kanan['tutup']['class'] = 'active';

	// JIKA STATUS TUTUP
	if ($row['status']=='closed'){
		$pills_kanan['tutup'] = array(
			'label'	 => '<i class="icon-ok-circle"></i> Buka',
			'uri'	 => "kbm/evaluasi/buka?id={$row['id']}",
			'attr'	 => 'title="buka kembali evaluasi ini"',
			'class'	 => 'active',
		);
	}
	
	if (in_array($row['status'], array('draft', 'closed')) && !$row['nilai_kolom_id'])
		$pills_kanan['delete']['class'] = 'active';

	if ($row['published']):
		$pills_link['nilai']['class'] = '';
		$pills_link['statistik']['class'] = '';
	endif;

	//if ($row['siswa_menjawab'] > 0)
		$pills_link['ljs']['class'] = '';


endif;

// pills wali belum terpikir krn blm ada implementasi login
//
//
// informasi evaluasi

$detail['umum'] = array(
	'Pelajaran'	 => array(
		'mapel_nama', 'ucwords',
		'suffix' => array(
			'<div class="subinfo">',
			'pelajaran_nama',
			' oleh ',
			'author_nama',
			'.&nbsp; ',
			'semester_nama',
			' ',
			'ta_nama',
			'</div>',
		),
	),
	'Metode'	 => array(FALSE, 'display_metode'),
	'Tipe'		 => array(FALSE, 'display_tipe'),
	'Bentuk'	 => array('pilihan_jml', array('Uraian', 'error', 'Pilihan 2 opsi', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
	
	
);

if ($user['role'] == 'siswa'):
	$detail['tambahan'] = array(
		//'Jumlah Soal'		 => array(FALSE, 'display_soal_siswa'),
		//'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
	);

else:
	$detail['tambahan'] = array(
		//'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $row['soal_total']),
		'KKM'		 					=> 'kkm',
		'Jumlah Pembagian Nilai Per KD'	=> 'jml_kd',
		'Tambah Kop'		 			=> 'kop',
		'Masuk Kisi - Kisi'		 			=> array('kisi_kisi', 
					array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')
				),
		'Pakai Webcam'		 			=> array('show_webcam', 
					array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')
				),
		'Tambah Soal Isian Singkat'		=> array('plus_isian', 
					array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')
				),
		'Tambah Soal Uraian'		 	=> array('plus_uraian', 
					array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')
				),
		'Tampilkan Kunci Setelah Selesai Evaluasi' => array('show_kunci', array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')),
		
		//'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
		'Acak Soal'			 	=> array('soal_acak', array('<span style="color:#F00;">TIDAK</span>', '<span style="color:#00F;">YA</span>')),
	);

endif;

// table
$_COOKIE['evaluasi_id'] = $row['id'];

function display_webcam($row, $user){
	return '<a href='.VIDCALL.'/'.APP_SCOPE.'_kelas_'.$row['kelas_id'].'#config.disableDeepLinking=true&userInfo.displayName="'.$user['nama'].'" class="btn btn-success" target="_blank" title="webcam pengerjaan"> WebCam</a>';
}
function display_surveillance($row)
{
	return a("/kbm/evaluasi_ljs/surveillance?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id']."&detail_jawab=1", 'SURVEILLANCE', 'class="btn btn-success" title="memata-matai pengerjaan"');
}
function display_recalculation($row)
{
	return a("/kbm/evaluasi_tool/recalculation?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id']."", 'RECALCULATION', 'class="btn btn-success" title="kalkulasi ulang nilai"');
}
function display_soal($row)
{
	return a("/kbm/evaluasi/pdf?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id'], 'DOWNLOAD SOAL', 'class="btn btn-success" title="cetak soal PDF" target="_blank"');
}

function display_nilai($row)
{
	return a("/kbm/evaluasi_nilai/download?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id'], 'DOWNLOAD NILAI', 'class="btn btn-success" title="cetak nilai EXCEL" target="_blank"');
}

function display_recal_nilai($row)
{
	return a("/kbm/evaluasi_tool/recal_dl_nilai?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id']."", 'DOWNLOAD NILAI', 'class="btn btn-success" title="kalkulasi ulang nilai"');
}

$table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-jadwal',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<i>kosong</i>',
	'data'				 => array(
		'Kelas'					 	=> 'kelas_nama',
		'Mulai'		 				=> array('evaluasi_mulai', 'tglwaktu'),
		'Selesai'				 	=> array('evaluasi_ditutup', 'tglwaktu'),
		'Durasi'	 				=> array('evaluasi_durasi', 'waktu'),
		'Limit Akses'	 			=> array('limit_akses', 'waktu'),
	),
);
if ($user['role'] != 'siswa'):
	
	$table['data']['Soal'] 						= array(FALSE, 'display_soal');
	if($row['published']){
		//$table['data']['Nilai'] = array(FALSE, 'display_nilai');
		$table['data']['Kalkulasi & Dl Nilai'] = array(FALSE, 'display_recal_nilai');
		$table['data']['WebCam Pekerjaan']	= array(FALSE, 'display_webcam', $user);
		$table['data']['Memata-matai Pekerjaan']	= array(FALSE, 'display_surveillance');
		//$table['data']['Kalkulasi Ulang Nilai']	= array(FALSE, 'display_recalculation');
	}
endif;

if ($user['role'] != 'siswa' && $row['published']):
	/*$table['data']['<div align="right">Pengerjaan</div>'] = array(
		'siswa_menjawab',
		'prefix' => '<div align="right">',
		'suffix' => array(
			' / ',
			'siswa_total',
			'</div>',
		),
	);
	$table['data']['<div align="right">Rata-Rata Nilai</div>'] = array(
		'rata2_nilai',
		'prefix' => '<div align="right">',
		'suffix' => '</div>',
	);*/
endif;

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
	. pills($pills_kiri, 'class="nav nav-pills pull-left"')
	. pills($pills_kanan, 'class="nav nav-pills pull-right"');

if ($user['role'] != 'siswa')
	$bar_pills .= pills($pills_link, 'class="nav nav-pills pull-right"');

$bar_pills .= '</td></tr></table></div>';

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Evaluasi #{$row['id']}")); ?>
	<?php echo cosmo_js(); ?>
	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Evaluasi (<?php echo ($row['tipe']); ?>):<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em;
						color: black;
					}
					.subinfo{
						font-size: .8em;
						opacity: .7;
						line-height: .9em;
					}
					#detail-tambahan{
						display: none;
					}
				</style>

				<?php

				echo alert_get();
				echo $bar_pills;

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Informasi Umum</legend>';

				$row['kop'] = str_replace('<img src="/','<img src="'.base_url(),$row['kop']);
				$row['kop'] = str_replace('<img src="../../','<img src="'.base_url(),$row['kop']);
				
				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				///  audio /////////////
				if($row['audio']!='')
				{
					///////////////// AUDIO ///////////////////////
					echo "<h2> Player Sound (LISTENING SECTION)</h2>";
					//// FOR PC ////
					echo $this->load->view(THEME.'/kbm/evaluasi_ljs/audio',$row,TRUE);
				
					echo"<br><br>";	
				}
				
				// opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';
				//echo '<legend>Keterangan Tambahan</legend>';

				foreach ($detail['tambahan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// jadwal pelaksanaan

				echo '<br/><br/><div class="form-horizontal"><fieldset>';
				echo '<legend>Jadwal Pelaksanaan</legend>';
				// echo "<pre>";
				// print_r($row['kelas_result']);
				// echo "</pre>";
				echo ds_table($table, $row['kelas_result'], $user);
				echo '</fieldset></div><br/>';

				// info tambahan
				/*
				 * bila siswa => nilai ybs
				 * else:
				 * bila belum publish => daftar soal
				 * setelahnya muncul daftar nilai
				 */

				if ($user['role'] == 'siswa'):
				//$this->load->view(THEME . "/{$uri}/siswa", $this->d);

				elseif (!$row['published']):
					//if ($admin OR ( $user['id'] == $row['author_id'])):
					if (($user['role'] == 'admin')||($user['role'] == 'sdm')):
						if ($row['metode'] == "upload"):
							$this->load->view(THEME . "/{$uri}/soal2", $this->d);
						else:
							if( ($row['plus_isian']==1) || ($row['plus_uraian']==1) ){
								$this->load->view(THEME . "/{$uri}/bobot_nilai", $this->d);
							}
							
							if ($row['tipe'] == "penilaian_siswa1"):
								$this->load->view(THEME . "/{$uri}/soal_penilaian", $this->d);
							elseif ($row['metode'] == "upload_dokumen_soal"):
								$this->load->view(THEME . "/{$uri}/soal_upload_dokumen", $this->d);
							else:
								$this->load->view(THEME . "/{$uri}/soal", $this->d);
							endif;
							
						endif;
					endif;
				else:
					if( ($row['plus_isian']==1) || ($row['plus_uraian']==1) ){
						$this->load->view(THEME . "/{$uri}/bobot_nilai", $this->d);
					}
					
					if ($row['tipe'] == "penilaian_siswa1"):
						$this->load->view(THEME . "/{$uri}/nilai_penilaian", $this->d);
					else:
						$this->load->view(THEME . "/{$uri}/nilai", $this->d);
					endif;
				endif;

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<script type="text/javascript">
			$(function () {
				$('#cmd-detail-tambahan').click(function () {
					$('#detail-tambahan').slideToggle(200);
				});
			});
		</script>

	<!--</body>
</html>-->