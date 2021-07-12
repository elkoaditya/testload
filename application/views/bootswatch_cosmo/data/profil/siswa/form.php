<?php

// var

$xdat = ($row['id'] > 0) ? (array) json_decode($row['xdat'], TRUE) : array();
$foto_tersimpan = array_node($xdat, array('foto', 'full_path'));
$foto_terunggah = array_node($form, array('upload', 'full_path'));
$img_tersimpan = (!file_exists($foto_tersimpan)) ? NULL : array('src' => webpath($foto_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
$img_terunggah = (!file_exists($foto_terunggah)) ? NULL : array('src' => webpath($foto_terunggah), 'class' => "thumbnail", 'title' => 'diupload');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Data' => 'data',
	'Profil' => 'data/profil',
	'Siswa' => 'data/profil/siswa',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/profil/siswa/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
	'label' => 'Daftar Siswa',
	'uri' => "data/profil/siswa",
	'attr' => 'title="kembali ke tabel siswa"',
);

if ($row['id'] > 0)
	$pills[] = array(
		'label' => 'Detail Siswa',
		'uri' => "data/profil/siswa/id/{$row['id']}",
		'attr' => 'title="kembali ke detail siswa"',
	);

// input data

$input = array(
	'kesiswaan' => array(
		'nis' => array(
			'nis',
			'type' => 'input',
			'name' => 'nis',
			'id' => 'nis',
			'class' => 'input input-xxlarge',
			'label' => 'N I S',
			'placeholder' => 'masukan NIS',
		),
		'nisn' => array(
			'nisn',
			'type' => 'input',
			'name' => 'nisn',
			'id' => 'nisn',
			'class' => 'input input-xxlarge',
			'label' => 'N I S N',
			'placeholder' => 'masukan NISN'
		),
		'no_un' => array(
			'no_un',
			'type' => 'input',
			'name' => 'no_un',
			'id' => 'no_un',
			'class' => 'input input-xxlarge',
			'label' => 'Nomer U N',
			'placeholder' => 'masukan Nomer U N'
		),
		'pd_id_erapor' => array(
			'pd_id_erapor',
			'type' => 'input',
			'name' => 'pd_id_erapor',
			'id' => 'pd_id_erapor',
			'class' => 'input input-xxlarge',
			'label' => 'PD ID E-Rapor',
			'placeholder' => 'masukan PD ID E-Rapor'
		),
		'kelas_id' => array(
			'kelas_id',
			'label' => 'Kelas',
			'type' => 'dropdown',
			'name' => 'kelas_id',
			'id' => 'kelas_id',
			'options' => $this->m_option->kelas(),
			'extra' => 'id="kelas_id" class="input input-large select"',
		),
		'aktif' => array(
			'gender',
			'label' => 'Status Login',
			'type' => 'dropdown',
			'name' => 'aktif',
			'id' => 'aktif',
			'options' => array(
				1 => 'aktif',
			//0 => 'blokir login',
			),
			'extra' => 'id="aktif" class="input input-large select"',
		),
	),
	'masuk' => array(
		'masuk_jalur' => array(
			'masuk_jalur',
			'label' => 'Jalur',
			'type' => 'dropdown',
			'name' => 'masuk_jalur',
			'id' => 'masuk_jalur',
			'options' => array(
				'psb' => 'PSB',
				'pindah' => 'Pindahan',
				'lainnya' => 'Lainnya',
			),
			'extra' => 'id="masuk_jalur" class="input input-large select"',
		),
		'masuk_tgl' => array(
			'masuk_tgl',
			'date2tgl',
			'label' => 'Tanggal',
			'type' => 'input',
			'name' => 'masuk_tgl',
			'id' => 'masuk_tgl',
			'class' => 'input input-small tanggal',
			'placeholder' => 'tanggal masuk',
		),
	),
	'profil' => array(
		'nama' => array(
			'nama',
			'type' => 'input',
			'label' => 'Nama Lengkap',
			'name' => 'nama',
			'id' => 'nama',
			'class' => 'input input-xxlarge',
			'placeholder' => 'masukan nama lengkap',
		),
		'gender' => array(
			'gender',
			'label' => 'Gender',
			'type' => 'dropdown',
			'name' => 'gender',
			'id' => 'gender',
			'options' => array('l' => 'Laki-laki', 'p' => 'Perempuan'),
			'extra' => 'id="gender" class="input input-large select"',
		),
		'agama_id' => array(
			'agama_id',
			'label' => 'Agama',
			'type' => 'dropdown',
			'name' => 'agama_id',
			'id' => 'agama_id',
			'options' => $this->m_option->agama(),
			'extra' => 'id="agama_id" class="input input-medium select"',
		),
		'ttl' => array(
			'lahir_tempat',
			'label' => 'Tempat Tgl Lahir',
			'type' => 'input',
			'name' => 'lahir_tempat',
			'id' => 'lahir_tempat',
			'class' => 'input input-medium',
			'placeholder' => 'tempat',
			'suffix' => array(
				array(
					'lahir_tgl',
					'date2tgl',
					'type' => 'input',
					'name' => 'lahir_tgl',
					'id' => 'lahir_tgl',
					'class' => 'input input-small tanggal',
					'placeholder' => 'tanggal lahir',
				),
			),
		),
		'alamat' => array(
			'alamat',
			'type' => 'textarea',
			'name' => 'alamat',
			'id' => 'alamat',
			'class' => 'input input-xxlarge',
			'label' => 'Alamat',
			'rows' => 4,
			'placeholder' => 'masukan alamat lengkap',
		),
		'kota' => array(
			'kota',
			'type' => 'input',
			'name' => 'kota',
			'id' => 'kota',
			'class' => 'input input-xxlarge',
			'label' => 'Kota',
			'placeholder' => 'masukan kota domisili',
		),
		'telepon' => array(
			'telepon',
			'type' => 'input',
			'name' => 'telepon',
			'id' => 'telepon',
			'class' => 'input input-xxlarge',
			'label' => 'Telepon',
			'placeholder' => 'masukan nomor telepon',
		),
	),
	'baru' => array(
		'baru_sekolah_nama' => array(
			'baru_sekolah_nama',
			'type' => 'textarea',
			'name' => 'baru_sekolah_nama',
			'id' => 'baru_sekolah_nama',
			'rows' => 4,
			'class' => 'input input-xxlarge',
			'label' => 'Nama Sekolah Terbaru',
			'placeholder' => 'nama lengkap sekolah terbaru',
		),
		'baru_sekolah_tgl' => array(
			'baru_sekolah_tgl',
			'date2tgl',
			'label' => 'Tgl Masuk Sekolah Baru',
			'type' => 'input',
			'name' => 'baru_sekolah_tgl',
			'id' => 'baru_sekolah_tgl',
			'class' => 'input input-small tanggal',
			'placeholder' => 'Tgl Masuk Sekolah Baru',
		),
		'baru_sekolah_alamat' => array(
			'baru_sekolah_alamat',
			'type' => 'textarea',
			'name' => 'baru_sekolah_alamat',
			'rows' => 4,
			'id' => 'baru_sekolah_alamat',
			'class' => 'input input-xxlarge',
			'label' => 'Alamat Sekolah Terbaru',
			'placeholder' => 'alamat lengkap sekolah terbaru',
		), 
		'baru_kerja_nama' => array(
			'baru_kerja_nama',
			'type' => 'textarea',
			'name' => 'baru_kerja_nama',
			'id' => 'baru_kerja_nama',
			'rows' => 4,
			'class' => 'input input-xxlarge',
			'label' => 'Nama Pekerjaan Terbaru',
			'placeholder' => 'nama lengkap pekerjaan terbaru',
		),
		'baru_kerja_tgl' => array(
			'baru_kerja_tgl',
			'date2tgl',
			'label' => 'Tgl Masuk Pekerjaan Baru',
			'type' => 'input',
			'name' => 'baru_kerja_tgl',
			'id' => 'baru_kerja_tgl',
			'class' => 'input input-small tanggal',
			'placeholder' => 'Tgl Masuk Pekerjaan Baru',
		),
		'baru_kerja_alamat' => array(
			'baru_kerja_alamat',
			'type' => 'textarea',
			'name' => 'baru_kerja_alamat',
			'rows' => 4,
			'id' => 'baru_kerja_alamat',
			'class' => 'input input-xxlarge',
			'label' => 'Alamat Pekerjaan Terbaru',
			'placeholder' => 'alamat lengkap pekerjaan terbaru',
		), 
		'baru_ket' => array(
			'baru_ket',
			'type' => 'textarea',
			'name' => 'baru_ket',
			'rows' => 4,
			'id' => 'baru_ket',
			'class' => 'input input-xxlarge',
			'label' => 'Memo',
			'placeholder' => 'catatan terbaru',
		), 
	),
	'asal' => array(
		'asal_sekolah_nama' => array(
			'asal_sekolah_nama',
			'type' => 'textarea',
			'name' => 'asal_sekolah_nama',
			'id' => 'asal_sekolah_nama',
			'rows' => 4,
			'class' => 'input input-xxlarge',
			'label' => 'Nama',
			'placeholder' => 'nama lengkap sekolah asal',
		),
		'asal_sekolah_alamat' => array(
			'asal_sekolah_alamat',
			'type' => 'textarea',
			'name' => 'asal_sekolah_alamat',
			'rows' => 4,
			'id' => 'asal_sekolah_alamat',
			'class' => 'input input-xxlarge',
			'label' => 'Alamat',
			'placeholder' => 'alamat lengkap sekolah asal',
		),
		'asal_sekolah_jenjang' => array(
			'asal_sekolah_jenjang',
			'label' => 'Jenjang',
			'type' => 'dropdown',
			'name' => 'asal_sekolah_jenjang',
			'id' => 'asal_sekolah_jenjang',
			'extra' => 'id="asal_sekolah_jenjang" class="input input-large select"',
			'options' => array(
				'' => '',
				'sd' => 'Sekolah Dasar',
				'smp' => 'Sekolah Menengah Pertama',
				'sma' => 'Sekolah Menengah Atas',
				'smk' => 'Sekolah Menengah Kejuruan',
				'mi' => 'Madrasah Ibtidaiyah',
				'mt' => 'Madrasah Tsanawiyah',
				'ma' => 'Madrasah Aliyah',
			),
		),
		'asal_ijazah_no' => array(
			'asal_ijazah_no',
			'type' => 'input',
			'name' => 'asal_ijazah_no',
			'id' => 'asal_ijazah_no',
			'class' => 'input input-xxlarge',
			'label' => 'Nomor Ijazah',
			'placeholder' => 'nomor seri ijazah',
		),
		'asal_skhu_no' => array(
			'asal_skhu_no',
			'type' => 'input',
			'name' => 'asal_skhu_no',
			'id' => 'asal_skhu_no',
			'class' => 'input input-xxlarge',
			'label' => 'Nomor SKHU',
			'placeholder' => 'nomor seri skhu',
		),
		'asal_ijazah_tahun' => array(
			'asal_ijazah_tahun',
			'type' => 'input',
			'name' => 'asal_ijazah_tahun',
			'id' => 'asal_ijazah_tahun',
			'class' => 'input input-small',
			'label' => 'Tahun',
			'placeholder' => 'tahun ijazah',
		),
	),
	'keluarga' => array(
		'status_keluarga' => array(
			'status_keluarga',
			'type' => 'input',
			'name' => 'status_keluarga',
			'id' => 'status_keluarga',
			'class' => 'input input-xxlarge',
			'label' => 'Status',
			'placeholder' => 'status dalam keluarga',
		),
		'anak_ke' => array(
			'anak_ke',
			'type' => 'input',
			'name' => 'anak_ke',
			'id' => 'anak_ke',
			'class' => 'input input-mini',
			'label' => 'Anak ke',
			'placeholder' => 'nomor',
		),
		'ayah_nama' => array(
			'ayah_nama',
			'type' => 'input',
			'name' => 'ayah_nama',
			'id' => 'ayah_nama',
			'class' => 'input input-xxlarge',
			'label' => 'Nama Ayah',
			'placeholder' => 'nama lengkap ayah',
		),
		'ayah_pekerjaan' => array(
			'ayah_pekerjaan',
			'type' => 'input',
			'name' => 'ayah_pekerjaan',
			'id' => 'ayah_pekerjaan',
			'class' => 'input input-xxlarge',
			'label' => 'Pekerjaan Ayah',
			'placeholder' => 'PNS/swasta/wirausaha',
		),
		'ibu_nama' => array(
			'ibu_nama',
			'type' => 'input',
			'name' => 'ibu_nama',
			'id' => 'ibu_nama',
			'class' => 'input input-xxlarge',
			'label' => 'Nama Ibu',
			'placeholder' => 'nama lengkap ibu',
		),
		'ibu_pekerjaan' => array(
			'ibu_pekerjaan',
			'type' => 'input',
			'name' => 'ibu_pekerjaan',
			'id' => 'ibu_pekerjaan',
			'class' => 'input input-xxlarge',
			'label' => 'Pekerjaan Ibu',
			'placeholder' => 'PNS/swasta/wirausaha',
		),
		'ortu_alamat' => array(
			'ortu_alamat',
			'type' => 'textarea',
			'name' => 'ortu_alamat',
			'id' => 'ortu_alamat',
			'class' => 'input input-xxlarge',
			'rows' => 4,
			'label' => 'Alamat Orangtua',
			'placeholder' => 'alamat lengkap',
		),
		'ortu_telepon' => array(
			'ortu_telepon',
			'type' => 'input',
			'name' => 'ortu_telepon',
			'id' => 'ortu_telepon',
			'class' => 'input input-xxlarge',
			'label' => 'Telepon Orangtua',
			'placeholder' => 'nomor telepon aktif',
		),
		'wali_nama' => array(
			'wali_nama',
			'type' => 'input',
			'name' => 'wali_nama',
			'id' => 'wali_nama',
			'class' => 'input input-xxlarge',
			'label' => 'Nama Wali',
			'placeholder' => 'nama lengkap wali',
		),
		'wali_alamat' => array(
			'wali_alamat',
			'type' => 'textarea',
			'name' => 'wali_alamat',
			'id' => 'wali_alamat',
			'rows' => 4,
			'class' => 'input input-xxlarge',
			'label' => 'Alamat Wali',
			'placeholder' => 'alamat lengkap',
		),
		'wali_telepon' => array(
			'wali_telepon',
			'type' => 'input',
			'name' => 'wali_telepon',
			'id' => 'wali_telepon',
			'class' => 'input input-xxlarge',
			'label' => 'Telepon Wali',
			'placeholder' => 'nomor telepon aktif',
		),
		'wali_pekerjaan' => array(
			'wali_pekerjaan',
			'type' => 'input',
			'name' => 'wali_pekerjaan',
			'id' => 'wali_pekerjaan',
			'class' => 'input input-xxlarge',
			'label' => 'Pekerjaan Wali',
			'placeholder' => 'PNS/swasta/wirausaha',
		),
	),
);
$input['kesiswaan']['kelas_id']['options'][0] = '[alumni/non-aktif]';
$section = array(
	'kesiswaan' => 'Kesiswaan',
	'profil' => 'Profil Pribadi',
	'keluarga' => 'Informasi Keluarga',
	'asal' => 'Asal Sekolah Sebelumnya',
	'baru' => 'Status Terbaru',
	'masuk' => 'Pendaftaran Masuk Sekolah',
);

if (user_role('admin'))
{
	$input['kesiswaan']['aktif']['options'][0] = 'blokir login';
}

if ($edit_mode == 'baru-psb'):
//$input['kesiswaan']['kelas_id']['extra'] .= ' disabled="true"';

elseif ($edit_mode == 'baru-pindah'):
	//$input['kesiswaan']['kelas_id']['extra'] .= ' disabled="true"';
	$input['masuk']['masuk_jalur']['options'] = array(
		'pindah' => 'Pindahan',
		'lainnya' => 'Lainnya',
	);

elseif ($edit_mode == 'edit-baru'):
//$input['kesiswaan']['kelas_id']['extra'] .= ' disabled="true"';

elseif ($edit_mode == 'edit-masa_jeda'):
	$input['masuk']['masuk_jalur']['extra'] .= ' disabled="true"';

elseif ($edit_mode == 'edit-on_semester'):
	$input['kesiswaan']['kelas_id']['extra'] .= ' disabled="true"';
	$input['profil']['agama_id']['extra'] .= ' disabled="true"';
	$input['masuk']['masuk_jalur']['extra'] .= ' disabled="true"';

endif;

// buttons

if ($row['id'] > 0)
	$btn_back = a("data/profil/siswa/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke profil siswa', 'class="btn btn-info "');
else
	$btn_back = a("data/profil/siswa", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar siswa', 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Siswa')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.thumbnail{
				max-height: 100px;
				max-width: 75px;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Siswa</h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// foto profil

				echo '<fieldset>';
				echo '<legend>Foto Profil</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"foto\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('foto', '', 'class="input-upload"') . '<br/>';
				echo '<i>foto skala 3x4 atau yang mendekati. minimum 75x100 pixel.</i><br/><br/>';

				if ($img_tersimpan OR $img_terunggah)
					echo '<table border="0"><tr>';

				if ($img_tersimpan)
					echo tag('td', 'align="center"', img($img_tersimpan) . '<i>tersimpan</i>');

				if ($img_terunggah)
					echo tag('td', 'align="center"', img($img_terunggah) . '<i>diupload</i>');

				if ($img_tersimpan OR $img_terunggah)
					echo '</tr></table>';

				echo "</div>";
				echo "</div>" . NL;

				echo '</fieldset><br/><br/>';

				foreach ($input as $sec => $subinput):

					echo '<fieldset>';
					echo "<legend>{$section[$sec]}</legend>";

					foreach ($subinput as $inp):
						echo div('class="control-group"');
						echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
						echo div('class="controls"', form_cell($inp, $row));
						echo "</div>" . NL;
					endforeach;

					echo '</fieldset><br/><br/>';

				endforeach;

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> ';

				if ($admin && $row['id'] == 0)
					echo '<button type="submit" class="btn btn-success" name="ulang" value="yes"><i class="icon-save icon-white"></i> Simpan, tambah lagi</button> ';

				echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button>&nbsp; &nbsp; ';
				echo $btn_back;
				echo '</div>';
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

		?>

		<script type="text/javascript">

			$(function () {
				$('.tanggal').datepicker({
					dateFormat: 'dd-mm-yy',
					dayNamesMin: ['Mgg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
					gotoCurrent: true,
					changeMonth: true,
					changeYear: true
				});
			});

		</script>

	</body>
</html>