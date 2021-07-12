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
);
$input['kesiswaan']['kelas_id']['options'][0] = '[alumni/non-aktif]';
$section = array(
	'baru' => 'Status Terbaru',
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