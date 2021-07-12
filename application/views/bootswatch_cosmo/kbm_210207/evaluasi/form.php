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
		'pelajaran_id' => array(
				'pelajaran_id',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'label' => 'Pelajaran',
				'extra' => 'class="input-large select" id="pelajaran_id"',
				'options' => 'opsi_pelajaran',
		),
		
		
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
		'show_webcam' => array(
				'show_webcam',
				'label' => 'Pakai Webcam',
				'type' => 'checkbox',
				'name' => 'show_webcam',
				'id' => 'show_webcam',
				'value' => 1,
				'checked' => (bool) ($row['show_webcam']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
		'plus_uraian' => array(
				'plus_uraian',
				'label' => 'Tambah Uraian',
				'type' => 'checkbox',
				'name' => 'plus_uraian',
				'id' => 'plus_uraian',
				'value' => 1,
				'checked' => (bool) ($row['plus_uraian']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
		'show_kunci' => array(
				'show_kunci',
				'label' => 'Tampilkan Kunci Setelah Selesai Evaluasi',
				'type' => 'checkbox',
				'name' => 'show_kunci',
				'id' => 'show_kunci',
				'value' => 1,
				'checked' => (bool) ($row['show_kunci']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
);
$input['checkbox'] = array(
		'soal_acak' => array(
				'name' => 'soal_acak',
				'id' => 'soal_acak',
				'value' => 1,
				'checked' => (bool) ($row['soal_acak']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
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

if (!$modit['aturan']):
	//$input['umum']['tipe']['extra'] .= ' disabled="true"';
	$input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
	$input['opsi-cek']['soal_acak']['disabled'] = 'true';
	$input['opsi']['ljs_max']['disabled'] = 'true';
endif;

if (!$modit['pelajaran']):
	$input['umum']['pelajaran_id']['extra'] .= ' disabled="true"';
endif;

if (!$modit['bentuk']):
	$input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
endif;

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info "');
else
	$btn_back = a("kbm/evaluasi", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');

$i_mulai = array(
		'type' => 'input',
		'class' => 'input input-medium tglwaktu',
		'placeholder' => 'yyyy-mm-dd hh:ii',
		'title' => 'isikan tanggal-jam mulai ',
);
$i_ditutup = array(
		'type' => 'input',
		'class' => 'input input-medium tglwaktu',
		'placeholder' => 'yyyy-mm-dd hh:ii',
		'title' => 'isikan tanggal-jam selesai',
);
$i_durasi = array(
		'type' => 'input',
		'class' => 'input input-medium waktu',
		'placeholder' => 'hh:ii',
		'title' => 'isikan durasi pengerjaan',
);
$i_limit = array(
		'type' => 'input',
		'class' => 'input input-medium waktu',
		'placeholder' => 'hh:ii',
		'title' => 'isikan waktu limit akses soal',
);

$evaluasi_mulai = (array) $this->input->post('evaluasi_mulai');
$evaluasi_ditutup = (array) $this->input->post('evaluasi_ditutup');
$evaluasi_durasi 	= (array) $this->input->post('evaluasi_durasi');
$limit_akses 		= (array) $this->input->post('limit_akses');
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
				echo '<fieldset>';

				echo '<legend>Informasi Umum</legend>';

// input umum

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				///// audio //////////////////
				echo '<fieldset>';
				echo '<legend>Upload Sound</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"audio\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('audio', '', 'class="input-upload"') . '<br/>';
				echo '<i>Audio untuk Listening Section</i><br/><br/>';
				if ($sound_tersimpan )
				{
					echo '<table border="0"><tr>';
					echo tag('td', 'align="center"', "File <br/>".base_url().$row['audio'] . ' <br/><i>tersimpan</i>');
					echo '</tr></table>';
				}
				echo "</div>";
				echo "</div>" . NL;

				echo '</fieldset><br/><br/>';
				
				// input opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"checkbox\">Acak Soal</label>";
				echo div('class="controls"');
				echo "<label class=\"checkbox\" for=\"soal_acak\">"
				. form_checkbox($input['checkbox']['soal_acak'])
				. " acak soal yang tampil ke siswa</label>";
				echo '</div>';
				echo "</div>" . NL;

				foreach ($input['opsi'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach; 
				echo '</fieldset></div><br/><br/>';

// jadwal evaluasi

				echo '<fieldset>';

				
				echo '<legend>Jadwal Pelaksanaan</legend>';

				echo '<table id="table-jadwal" class="table table-bordered table-striped table-hover">';
				echo '<thead><tr><td>Kelas</td><td>Mulai</td><td>Selsai</td><td>Durasi</td><td>Limit Akses</td></tr></thead>';
				echo "<tbody class=\"\">";

				$kelas_id = array();
				foreach ($kelas_jadwal as $kelas):
					$kid = (int) $kelas['id'];
					$kelas_id[] = $kid;
					$_class = 'kelas-jadwal kelas-' . $kelas['id'];
					$i_mulai['id'] = "evaluasi_mulai-{$kelas['id']}";
					$i_mulai['name'] = "evaluasi_mulai[{$kelas['id']}]";
					$i_mulai['value'] = (array_key_exists($kid, $evaluasi_mulai) && $post_request) ? $evaluasi_mulai[$kid] : $kelas['evaluasi_mulai'];
					$i_mulai['value'] = datefix($i_mulai['value'], 'Y-m-d H:i');
					
					$i_ditutup['id'] = "evaluasi_ditutup-{$kelas['id']}";
					$i_ditutup['name'] = "evaluasi_ditutup[{$kelas['id']}]";
					$i_ditutup['value'] = (array_key_exists($kid, $evaluasi_ditutup) && $post_request) ? $evaluasi_ditutup[$kid] : $kelas['evaluasi_ditutup'];
					$i_ditutup['value'] = datefix($i_ditutup['value'], 'Y-m-d H:i');

					$i_durasi['id'] = "evaluasi_durasi-{$kelas['id']}";
					$i_durasi['name'] = "evaluasi_durasi[{$kelas['id']}]";
					$i_durasi['value'] = (array_key_exists($kid, $evaluasi_durasi) && $post_request) ? $evaluasi_durasi[$kid] : $kelas['evaluasi_durasi'];
					$i_durasi['value'] = datefix($i_durasi['value'], 'H:i');
					
					$i_limit['id'] = "limit_akses-{$kelas['id']}";
					$i_limit['name'] = "limit_akses[{$kelas['id']}]";
					$i_limit['value'] = (array_key_exists($kid, $limit_akses) && $post_request) ? $limit_akses[$kid] : $kelas['limit_akses'];
					$i_limit['value'] = datefix($i_limit['value'], 'H:i');
					 
					
					foreach ($kelas['pelajaran_list'] as $pid)
						$_class .= " pelajaran-{$pid}";

					echo "<tr class=\"{$_class}\">";
					echo "<td>{$kelas['nama']}</td>";
					echo '<td>' . form_cell($i_mulai, $kelas) . '</td>';
					echo '<td>' . form_cell($i_ditutup, $kelas) . '</td>';
					echo '<td>' . form_cell($i_durasi, $kelas) . '</td>';
					echo '<td>' . form_cell($i_limit, $kelas) . '</td>';
					echo '</tr>';
					 
				endforeach;
				echo "</tbody>";
				echo '</table>';

				echo '</fieldset>';
				$json_kelas_id = json_encode($kelas_id);
				
					echo '<legend align="center"> ATAU </legend>';
				
				// if($user['id'] === 11){
					 
					$i_mulai['id'] = "evaluasi_mulai_global";
					$i_mulai['name'] = "evaluasi_mulai_global"; 
					$i_mulai['value'] = datefix('', 'Y-m-d H:i');
					
					$i_ditutup['id'] = "evaluasi_ditutup_global";
					$i_ditutup['name'] = "evaluasi_ditutup_global"; 
					$i_ditutup['value'] = datefix('', 'Y-m-d H:i');

					$i_durasi['id'] = "evaluasi_durasi_global";
					$i_durasi['name'] = "evaluasi_durasi_global"; 
					$i_durasi['value'] = datefix('', 'H:i'); 
					$i_durasi['extra'] = 'onchange="updateInput(this.value)"';  
					
					$i_limit['id'] = "limit_akses_global";
					$i_limit['name'] = "limit_akses_global"; 
					$i_limit['value'] = datefix('', 'H:i'); 
					$i_limit['extra'] = 'onchange="updateInput(this.value)"'; 
					
					echo '<legend>Jadwal Pelaksanaan (Global)</legend>';
					
					echo '<table id="table-jadwal" class="table table-bordered table-striped table-hover">';
					echo '<thead><tr><td> ____ </td><td>Mulai</td><td>Selsai</td><td>Durasi</td><td>Limit Akses</td></tr></thead>';
					echo "<tbody class=\"\">";
					
					echo "<tr class=\"kelas-jadwals\">";
					echo "<td> </td>";
					
					
					echo '<td>' . form_cell($i_mulai, '') . '</td>';
					echo '<td>' . form_cell($i_ditutup, '') . '</td>';
					echo '<td>' . form_cell($i_durasi, '') . '</td>';
					echo '<td>' . form_cell($i_limit, '') . '</td>';
					echo '</tr>';
					
					echo "</tbody>";
					echo '</table>';

					echo '<br/><br/>';
				// }
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
				$('#evaluasi_durasi_global').on('change', function() { 
					var vals = $(this).val();  
					for (var i = 0; i < json_kelas_id.length; i++) {
						updateInput('evaluasi_durasi-'+json_kelas_id[i],vals); 
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