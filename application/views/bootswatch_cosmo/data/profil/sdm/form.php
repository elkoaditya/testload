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
	'Data'							 => 'data',
	'Profil'						 => 'data/profil',
	GURU_ALIAS . ' &amp; SDM'		 => 'data/profil/sdm',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/profil/sdm/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0)
	$pills[] = array(
		'label'	 => 'Kembali',
		'uri'	 => "data/profil/sdm/id/{$row['id']}",
		'attr'	 => 'title="kembali ke detail ' . strtolower(GURU_ALIAS) . '/sdm"',
	);
else
	$pills[] = array(
		'label'	 => 'Kembali',
		'uri'	 => "data/profil/sdm",
		'attr'	 => 'title="kembali ke tabel ' . strtolower(GURU_ALIAS) . ' dan sdm"',
	);

// input data

$input_umum = array(
	'nip'		 => array(
		'nip',
		'type'			 => 'input',
		'name'			 => 'nip',
		'id'			 => 'nip',
		'class'			 => 'input input-xlarge',
		'label'			 => 'N I P',
		'placeholder'	 => 'masukan NIP',
	),
	'nuptk'		 => array(
		'nuptk',
		'type'			 => 'input',
		'name'			 => 'nuptk',
		'id'			 => 'nuptk',
		'class'			 => 'input input-xlarge',
		'label'			 => 'N U P T K',
		'placeholder'	 => 'masukan NUPTK'
	),
	'nama'		 => array(
		'label'			 => 'Nama',
		'prefix',
		'type'			 => 'input',
		'name'			 => 'prefix',
		'id'			 => 'prefix',
		'class'			 => 'input input-mini',
		'style'			 => 'width : 2em;',
		'placeholder'	 => 'gelar',
		'suffix'		 => array(
			array(
				'nama',
				'type'			 => 'input',
				'name'			 => 'nama',
				'id'			 => 'nama',
				'class'			 => 'input input-xlarge',
				'style'			 => 'margin-right : 0.3em;',
				'placeholder'	 => 'masukan nama lengkap',
			),
			array(
				'suffix',
				'type'			 => 'input',
				'name'			 => 'suffix',
				'id'			 => 'suffix',
				'class'			 => 'input input-medium',
				'placeholder'	 => 'gelar',
			),
		),
	),
	'gender'	 => array(
		'gender',
		'type'		 => 'dropdown',
		'name'		 => 'gender',
		'id'		 => 'gender',
		'label'		 => 'Gender',
		'options'	 => array('l' => 'Laki-laki', 'p' => 'Perempuan'),
	),
	'alamat'	 => array(
		'alamat',
		'type'			 => 'textarea',
		'name'			 => 'alamat',
		'id'			 => 'alamat',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Alamat',
		'rows'			 => 3,
		'placeholder'	 => 'masukan alamat lengkap',
	),
	'kota'		 => array(
		'kota',
		'type'			 => 'input',
		'name'			 => 'kota',
		'id'			 => 'kota',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Kota',
		'placeholder'	 => 'masukan kota domisili',
	),
	'telepon'	 => array(
		'telepon',
		'type'			 => 'input',
		'name'			 => 'telepon',
		'id'			 => 'telepon',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Telepon',
		'placeholder'	 => 'masukan nomor telepon',
	),
);
$input_khusus = array(
	'jabatan_id' => array(
		'jabatan_id',
		'type'		 => 'dropdown',
		'name'		 => 'jabatan_id',
		'id'		 => 'jabatan_id',
		'options'	 => $this->m_option->jabatan(),
		'extra'		 => 'id="jabatan_id" class="input input-large select"',
	),
	'aktif'		 => array(
		'name'		 => 'aktif',
		'id'		 => 'aktif',
		'value'		 => 1,
		'checked'	 => (bool) $row['aktif'],
	),
	'mengajar'	 => array(
		'name'		 => 'mengajar',
		'id'		 => 'mengajar',
		'value'		 => 1,
		'checked'	 => (bool) $row['mengajar'],
	),
);
$input_akun = array(
	'email' => array(
		'email',
		'type'			 => 'input',
		'name'			 => 'email',
		'id'			 => 'email',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Email',
		'placeholder'	 => 'masukan email aktif',
	),
);

if (!$admin):
	//$input_umum['nip']['disabled'] = 'true';
	//$input_umum['nuptk']['disabled'] = 'true';
	$input_khusus['jabatan_id']['extra'] .= 'disabled="true"';
	$input_khusus['aktif']['disabled'] = 'true';

endif;

//if (!$admin or $semaktif['id'] > 0)
//	$input_khusus['mengajar']['disabled'] = 'true';
// foto
// buttons

if ($row['id'] > 0)
	$btn_back = a("data/profil/sdm/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke profil ' . strtolower(GURU_ALIAS) . ' / sdm', 'class="btn btn-info "');
else
	$btn_back = a("data/profil/sdm", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar ' . strtolower(GURU_ALIAS) . ' / sdm', 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form ' . (GURU_ALIAS) . ' / SDM')); ?>

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
					<h1>Form <?php echo GURU_ALIAS; ?>/SDM</h1>
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
				echo form_upload('foto') . '<br/>';
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

// profil pribadi

				echo '<fieldset>';
				echo '<legend>Profil Pribadi</legend>';

				foreach ($input_umum as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</div>" . NL;
				endforeach;

				echo '</fieldset><br/><br/>';

// lingkup kerja

				echo '<fieldset>';
				echo '<legend>Lingkup Kerja</legend>';
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"aktif\">Aktif</label>"
				. "<div class=\"controls\">"
				. "<label class=\"checkbox\">"
				. form_checkbox($input_khusus['aktif'])
				. "masih aktif dalam kegiatan sekolah"
				. "</label>"
				. "</div>"
				. "</div>" . NL;
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"mengajar\">Mengajar</label>"
				. "<div class=\"controls\">"
				. "<label class=\"checkbox\">"
				. form_checkbox($input_khusus['mengajar'])
				. "masih aktif mengajar di sekolah"
				. "</label>"
				. "</div>"
				. "</div>" . NL;
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"jabatan_id\">Jabatan</label>"
				. "<div class=\"controls\">"
				. form_cell($input_khusus['jabatan_id'], $row)
				. "</div>"
				. "</div>" . NL;
				echo '</fieldset><br/><br/>';

// akun email pengguna baru

				if ($row['id'] == 0):
					echo '<fieldset>';
					echo "<div class=\"control-group\">"
					. "<label class=\"control-label\" for=\"email\">Email</label>"
					. "<div class=\"controls\">"
					. form_cell($input_akun['email'], $row)
					. "</div></div>" . NL;
					echo '</fieldset><br/><br/>';

				endif;

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

<?php echo cosmo_js(); ?>

	</body>
</html>