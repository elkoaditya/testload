<?php
// var

$xdat = ($row['id'] > 0) ? (array) json_decode($row['xdat'], TRUE) : array();
$foto_tersimpan = array_node($xdat, array('foto', 'full_path'));
$foto_terunggah = array_node($form, array('upload', 'full_path'));
$img_tersimpan = (!$foto_tersimpan OR !file_exists($foto_tersimpan)) ? NULL : array('src' => webpath($foto_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
$img_terunggah = (!$foto_terunggah OR !file_exists($foto_terunggah)) ? NULL : array('src' => webpath($foto_terunggah), 'class' => "thumbnail", 'title' => 'diupload');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Admin' => 'data/profil/admin',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/profil/admin/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Admin',
		'uri' => "data/profil/admin",
		'attr' => 'title="kembali ke daftar admin"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => 'Detail Admin',
			'uri' => "data/profil/admin/id/{$row['id']}",
			'attr' => 'title="kembali ke detail admin"',
	);

// input data

$input_umum = array(
		'nama' => array(
				'label' => 'Nama',
				'prefix',
				'type' => 'input',
				'name' => 'prefix',
				'id' => 'prefix',
				'class' => 'input input-mini',
				'placeholder' => 'gelar',
				'suffix' => array(
						array(
								'nama',
								'type' => 'input',
								'name' => 'nama',
								'id' => 'nama',
								'class' => 'input input-xlarge',
								'placeholder' => 'masukan nama lengkap',
						),
						'&nbsp;',
						array(
								'suffix',
								'type' => 'input',
								'name' => 'suffix',
								'id' => 'suffix',
								'class' => 'input input-medium',
								'placeholder' => 'gelar',
						),
				),
		),
		'gender' => array(
				'gender',
				'type' => 'dropdown',
				'name' => 'gender',
				'id' => 'gender',
				'label' => 'Gender',
				'options' => array('l' => 'Laki-laki', 'p' => 'Perempuan'),
		),
		'alamat' => array(
				'alamat',
				'type' => 'textarea',
				'name' => 'alamat',
				'id' => 'alamat',
				'class' => 'input input-xxlarge',
				'label' => 'Alamat',
				'rows' => 3,
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
);
$input_khusus = array(
		'aktif' => array(
				'name' => 'aktif',
				'id' => 'aktif',
				'value' => 1,
				'checked' => (bool) $row['aktif'],
		),
);
$input_akun = array(
		'email' => array(
				'email',
				'type' => 'input',
				'name' => 'email',
				'id' => 'email',
				'class' => 'input input-xlarge',
				'label' => 'Email',
				'placeholder' => 'masukan email aktif',
		),
		'username' => array(
				'username',
				'type' => 'input',
				'name' => 'username',
				'id' => 'username',
				'class' => 'input input-xlarge',
				'label' => 'Username',
		),
		'password' => array(
				//'password',
				'type' => 'password',
				'name' => 'password',
				'id' => 'password',
				'class' => 'input input-xlarge',
				'label' => 'Password',
		),
		'passconf' => array(
				//'password',
				'type' => 'password',
				'name' => 'passconf',
				'id' => 'passconf',
				'class' => 'input input-xlarge',
				'label' => 'Konfirm password',
		),
);

if (!$admin):
	$input_khusus['aktif']['disabled'] = 'true';
endif;

// foto
// buttons

if ($row['id'] > 0)
	$btn_back = a("data/profil/admin/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke profil admin', 'class="btn btn-info "');
else
	$btn_back = a("data/profil/admin", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar admin', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Admin')); ?>

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
					<h1>Form Admin</h1>
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
				echo '<legend>Aktivasi</legend>';
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"aktif\">Aktif</label>"
				. "<div class=\"controls\">"
				. "<label class=\"checkbox\">"
				. form_checkbox($input_khusus['aktif'])
				. "masih aktif dalam kegiatan sekolah"
				. "</label>"
				. "</div>"
				. "</div>" . NL;
				echo '</fieldset><br/><br/>';

// akun email pengguna baru

				if ($row['id'] == 0):
					echo '<fieldset>';
					echo '<legend>Akun Login</legend>';

					foreach ($input_akun as $inp):
						echo div('class="control-group"');
						echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
						echo div('class="controls"', form_cell($inp, $row));
						echo "</div>" . NL;
					endforeach;

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