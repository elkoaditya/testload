<?php
//audio
if(isset($row['audio']))
{
	$suara_tersimpan = $row['audio'];
	$sound_tersimpan = (!file_exists($suara_tersimpan)) ? NULL : array('src' => webpath($suara_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
}else{
	$sound_tersimpan = "";
}
// vars

if ($row['id'] == 0 && !$post_request)
	$row['pelajaran_id'] = $this->input->get_post('pelajaran_id');

if ($row['id'] > 0 && !$row['soal_jml'])
	$row['soal_jml'] = NULL;

if ($row['id'] > 0 && !$row['ljs_max'])
	$row['ljs_max'] = NULL;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input['umum'] = array(
		'nama' => array(
				'nama',
				'label' => 'Nama / Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
				'placeholder' => 'isikan nama/judul kompetensi evaluasi',
				'title' => 'nama/kompetensi',
		),
		// 'pelajaran_id' => array(
				// 'pelajaran_id',
				// 'type' => 'dropdown',
				// 'name' => 'pelajaran_id',
				// 'id' => 'pelajaran_id',
				// 'label' => 'Pelajaran',
				// 'extra' => 'class="input-large select" id="pelajaran_id"',
				// 'options' => 'opsi_pelajaran',
		// ),
		
		
		'tipe' => array(
				'tipe',
				'label' => 'Tipe',
				'type' => 'dropdown',
				'name' => 'tipe',
				'id' => 'tipe',
				'extra' => 'class="input-large select" id="tipe"',
				'options' => array(
						'latihan' => 'Latihan',
						'ulangan' => 'Ulangan',
						'ulangan_tengah_semester' => 'Ulangan Tengah Semester',
						'ulangan_akhir_semester' => 'Ulangan Akhir Semester',
						'tryout' => 'TryOut',
						'remidi' => 'Remidi',
						'tugas' => 'Tugas',
						'praktek' => 'Praktek',
						'penilaian_siswa1' => 'Penilaian Siswa',
				),
		),
		'metode' => array(
				'metode',
				'label' => 'Metode',
				'type' => 'dropdown',
				'name' => 'metode',
				'id' => 'metode',
				'extra' => 'class="input-large select" id="metode"',
				'options' => array(
						
						'opsi_tampil_ABC' => 'Opsi Tampil Huruf A B C',
						'opsi_tanpa_ABC' => 'Opsi Tanpa Huruf A B C',
						'upload_dokumen_soal' => 'Upload Dokumen Soal',
				),
		),
		'pilihan_jml' => array(
				'pilihan_jml',
				'label' => 'Bentuk Soal',
				'type' => 'dropdown',
				'name' => 'pilihan_jml',
				'id' => 'pilihan_jml',
				'extra' => 'class="input-large select" id="pilihan_jml"',
				'options' => array(
						'Uraian',
						2 => 'Pilihan Ganda : 2 opsi',
						3 => 'Pilihan Ganda : 3 opsi',
						4 => 'Pilihan Ganda : 4 opsi',
						5 => 'Pilihan Ganda : 5 opsi',
				),
		),
		'kkm' => array(
				'kkm',
				'label' => 'KKM',
				'type' => 'input',
				'name' => 'kkm',
				'id' => 'kkm',
				'class' => 'input input-large',
				'placeholder' => 'nilai minimal tuntas',
				'title' => 'kriteria ketuntasan minimal',
		),
		'jml_kd' => array(
				'jml_kd',
				'label' => 'Jumlah Pembagian Nilai Per KD',
				'type' => 'dropdown',
				'name' => 'jml_kd',
				'id' => 'jml_kd',
				'extra' => 'class="input-large select" id="pilihan_jml"',
				'options' => array(
						1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5",
						6 => "6", 7 => "7", 8 => "8", 9 => "9", 10 => "10",
						
						11 => "11", 12 => "12", 13 => "13", 14 => "14", 15 => "15",
						16 => "16", 17 => "17", 18 => "18", 19 => "19", 20 => "20",
						
						21 => "21", 22 => "22", 23 => "23", 24 => "24", 25 => "25",
						26 => "26", 27 => "27", 28 => "28", 29 => "29", 30 => "30",
				),
		),
		'kop' => array(
				'kop',
				'label' => 'Tambah Kop',
				'type' => 'textarea',
				'name' => 'kop',
				'id' => 'kop',
				'class' => 'input tinymce_soal',
				'style' => 'height: 200px;',
		),
		// 'show_webcam' => array(
				// 'show_webcam',
				// 'label' => 'Pakai Webcam',
				// 'type' => 'checkbox',
				// 'name' => 'show_webcam',
				// 'id' => 'show_webcam',
				// 'value' => 1,
				// 'checked' => (bool) ($row['show_webcam']),
				// 'style' => 'margin: 10px 10px 14px 0;',
		// ),
		// 'plus_uraian' => array(
				// 'plus_uraian',
				// 'label' => 'Tambah Uraian',
				// 'type' => 'checkbox',
				// 'name' => 'plus_uraian',
				// 'id' => 'plus_uraian',
				// 'value' => 1,
				// 'checked' => (bool) ($row['plus_uraian']),
				// 'style' => 'margin: 10px 10px 14px 0;',
		// ),
		// 'show_kunci' => array(
				// 'show_kunci',
				// 'label' => 'Tampilkan Kunci Setelah Selesai Evaluasi',
				// 'type' => 'checkbox',
				// 'name' => 'show_kunci',
				// 'id' => 'show_kunci',
				// 'value' => 1,
				// 'checked' => (bool) ($row['show_kunci']),
				// 'style' => 'margin: 10px 10px 14px 0;',
		// ),
);
$input['checkbox'] = array(
		// 'soal_acak' => array(
				// 'name' => 'soal_acak',
				// 'id' => 'soal_acak',
				// 'value' => 1,
				// 'checked' => (bool) ($row['soal_acak']),
				// 'style' => 'margin: 10px 10px 14px 0;',
		// ),
);
$input['opsi'] = array(
		'soal_jml' => array(
				'soal_jml',
				'label' => 'Jumlah Soal Tampil',
				'type' => 'input',
				'name' => 'soal_jml',
				'id' => 'soal_jml',
				'class' => 'input input-large',
				'placeholder' => 'semua',
				'title' => 'jumlah soal yang tampil untuk dikerjakan siswa',
				'suffix' => '<div class="subinfo">*jika kosong atau o (nol) berarti semua butir soal ditampilkan.</div>',
		),
		'ljs_max' => array(
				'ljs_max',
				'label' => 'Kesempatan mencoba',
				'type' => 'input',
				'name' => 'ljs_max',
				'id' => 'ljs_max',
				'class' => 'input input-large',
				'placeholder' => 'tidak terbatas',
				'title' => 'jumlah maksimal untuk mengerjakan soal',
				'suffix' => '<div class="subinfo">**jika kosong atau o (nol) berarti kesempatan mencoba tidak dibatasi.</div>',
		),
);

// setup mode edit
$input['opsi']['ljs_max']['disabled'] = 'true';

// if (!$modit['aturan']):
	$input['umum']['tipe']['extra'] .= ' disabled="true"';
	// $input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
	// $input['opsi-cek']['soal_acak']['disabled'] = 'true';
	// $input['opsi']['ljs_max']['disabled'] = 'true';
// endif;

// if (!$modit['pelajaran']):
	// $input['umum']['pelajaran_id']['extra'] .= ' disabled="true"';
// endif;

// if (!$modit['bentuk']):
	// $input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
// endif;

// buttons
$row['id'] = 0;
if ($row['id'] == 0 OR $author_ybs)
	$input['pelajaran_id']['options'] = $this->m_option->ajaran_user();
else
	$input['pelajaran_id']['options'][$row['pelajaran_id']] = $row['pelajaran_nama'];


if ($row['id'] > 0)
	$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info "');
else
	$btn_back = a("kbm/evaluasi", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');
 
$i_mulai = array(
		'type' => 'input',
		'class' => 'input input-medium waktu',
		'placeholder' => 'hh:ii',
		'title' => 'isikan durasi pengerjaan',
);
$i_selesai = array(
		'type' => 'input',
		'class' => 'input input-medium waktu',
		'placeholder' => 'hh:ii',
		'title' => 'isikan durasi pengerjaan',
); 

$evaluasi_mulai = (array) $this->input->post('evaluasi_mulai');
$evaluasi_ditutup = (array) $this->input->post('evaluasi_ditutup');
$evaluasi_mulai 	= (array) $this->input->post('evaluasi_mulai');
$limit_akses 		= (array) $this->input->post('limit_akses');


$array_hari = array(
	1 => 'Senin',
	'Selasa',
	'Rabu',
	'Kamis',
	'Jumat',
	'Sabtu',
	'Minggu'
);
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Evaluasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Evaluasi</h1>
				</div>

				<style>
					#detail-tambahan{
						display: none;
					}
					.subinfo{
						font-size: 0.8em;
						opacity: 0.8;
						font-style: italic;
					}
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"'); 
// jadwal evaluasi

				echo '<fieldset>';
				echo '<legend>Jadwal Pelaksanaan</legend>';
				?>
				<div class="tabbable"> <!-- Only required for left/right tabs -->
				  <ul class="nav nav-pills">
					 
					<?php 
						for ($set_jadwal_seminggu = 1; $set_jadwal_seminggu <= 7; $set_jadwal_seminggu++) {
							
						$tab_class = "";
						if($set_jadwal_seminggu == 1){
							$tab_class = 'class="active"';
						}
					?>
							<li><a href="#tab_hari<?php echo $set_jadwal_seminggu;?>" <?php echo $tab_class;?>data-toggle="tab">Hari <?php echo $array_hari[$set_jadwal_seminggu];?></a></li>
					<?php 
						}
					?>
				  </ul>
				</div>
				   
				<div class="tab-content"> 
					<?php 
						for ($set_jadwal_seminggu = 1; $set_jadwal_seminggu <= 7; $set_jadwal_seminggu++) {
							
							$tab_pane = "tab-pane";
							if($set_jadwal_seminggu == 1){
								$tab_pane = "tab-pane active";
							}
						?>  
							<div class="<?php echo $tab_pane;?>" id="tab_hari<?php echo $set_jadwal_seminggu;?>"> 
								<?php 
									echo '<table id="table-jadwal" class="table table-bordered table-striped table-hover">';
									echo '<thead><tr><td>Kelas</td><td>Mulai</td><td>Selesai</td><td>Durasi</td><td>Limit Akses</td></tr></thead>';
									echo "<tbody class=\"\">";
 
									$i_mulai['id'] = "evaluasi_mulai-{$set_jadwal_seminggu}";
									$i_mulai['name'] = "evaluasi_mulai[{$set_jadwal_seminggu}]";  
									 
									$i_selesai['id'] = "evaluasi_selesai-{$set_jadwal_seminggu}";
									$i_selesai['name'] = "evaluasi_selesai[{$set_jadwal_seminggu}]";
									$i_selesai['value'] = datefix('', 'H:i'); 
									
									for($set_jadwal_sehari = 1; $set_jadwal_sehari <=4; $set_jadwal_sehari++){
										$_class = " pelajaran-{$set_jadwal_sehari}";

										echo "<tr class=\"{$_class}\">";
										echo "<td>{$array_hari[$set_jadwal_seminggu]} Jam ke-{$set_jadwal_sehari}</td>";
										echo '<td>' . form_cell($i_mulai) . '</td>';  
										echo '<td>' . form_cell($i_selesai) . '</td>';  
										echo '</tr>';  
									} 
									
									echo "</tbody>";
									echo '</table>';

								?>
							</div>
						<?php 
						}
					?> 
				</div>
					
				
				<?php 
				 
// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		addon('timepicker');
		addon('tinymce');
		?>

		<script type="text/javascript">

		var json_kelas_id = <?php echo $json_kelas_id?>;
		
			document.getElementById("ljs_max").value = 1;
			if(document.getElementById("pilihan_jml").value == 0){
				 document.getElementById("plus_uraian").checked = false;
				 $("#plus_uraian").attr("disabled", true);
			}
			 
			function updateInput(fieldname,vals){
				document.getElementById(fieldname).value = vals; 
			}
			$(function() {    
				$('#evaluasi_mulai_global').on('change', function() { 
					var vals = $(this).val();  
					for (var i = 0; i < json_kelas_id.length; i++) {
						updateInput('evaluasi_mulai-'+json_kelas_id[i],vals); 
					} 
					
				});
				$('#evaluasi_ditutup_global').on('change', function() { 
					var vals = $(this).val();  
					for (var i = 0; i < json_kelas_id.length; i++) {
						updateInput('evaluasi_ditutup-'+json_kelas_id[i],vals); 
					} 
					
				});
				$('#evaluasi_mulai_global').on('change', function() { 
					var vals = $(this).val();  
					for (var i = 0; i < json_kelas_id.length; i++) {
						updateInput('evaluasi_mulai-'+json_kelas_id[i],vals); 
					} 
					
				});
				$('#limit_akses_global').on('change', function() { 
					var vals = $(this).val();  
					for (var i = 0; i < json_kelas_id.length; i++) {
						updateInput('limit_akses-'+json_kelas_id[i],vals); 
					} 
					
				});
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
				$("#pelajaran_id").change(function() {
					pid = $(this).val();
					$('.kelas-jadwal').slideUp(100);
					$('.pelajaran-' + pid).slideDown(100);
				});
				$("#pelajaran_id").change();
				$('.tglwaktu').datetimepicker({dateFormat: "yy-mm-dd"});
				$('.waktu').timepicker({
					dateFormat: "yy-mm-dd",
					beforeShow: function( input ) {
							setTimeout(function () {
								$(input).datepicker("widget").find(".ui-datepicker-current").hide();
								
							}, 1 );
						}
						
					});
						
				$("#pilihan_jml").change(function() {
					pilihan_jml = $(this).val();
					if(pilihan_jml==0){
						document.getElementById("plus_uraian").checked = false;
						 $("#plus_uraian").attr("disabled", true);
					}else{
						$("#plus_uraian").attr("disabled", false);
					}
				});
			});
			
			
		</script>

	</body>
</html>