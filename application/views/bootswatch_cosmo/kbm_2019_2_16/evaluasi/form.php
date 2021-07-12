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
		
		'metode' => array(
				'metode',
				'label' => 'Metode',
				'type' => 'dropdown',
				'name' => 'metode',
				'id' => 'metode',
				'extra' => 'class="input-large select" id="metode"',
				'options' => array(
						'input' => 'input standart',
						'input_cepat' => 'input cepat',
						//'upload' => 'upload',
				),
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

$evaluasi_mulai = (array) $this->input->post('evaluasi_mulai');
$evaluasi_ditutup = (array) $this->input->post('evaluasi_ditutup');
$evaluasi_durasi 	= (array) $this->input->post('evaluasi_durasi');
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
				echo '<thead><tr><td>Kelas</td><td>Mulai</td><td>Selsai</td><td>Durasi</td></tr></thead>';
				echo "<tbody class=\"\">";

				foreach ($kelas_jadwal as $kelas):
					$kid = (int) $kelas['id'];
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
					
					foreach ($kelas['pelajaran_list'] as $pid)
						$_class .= " pelajaran-{$pid}";

					echo "<tr class=\"{$_class}\">";
					echo "<td>{$kelas['nama']}</td>";
					echo '<td>' . form_cell($i_mulai, $kelas) . '</td>';
					echo '<td>' . form_cell($i_ditutup, $kelas) . '</td>';
					echo '<td>' . form_cell($i_durasi, $kelas) . '</td>';
					echo '</tr>';

				endforeach;

				echo "</tbody>";
				echo '</table>';

				echo '</fieldset>';

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
		?>

		<script type="text/javascript">
			$(function() {
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
			});
		</script>

	</body>
</html>