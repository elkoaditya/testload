<?php
// vars

if ($post_request && $error):
	$row['kelas_list'] = (array) $this->input->post('kelas_list');
endif;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Pelajaran' => 'data/akademik/pelajaran',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/pelajaran/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Pelajaran',
		'uri' => "data/akademik/pelajaran",
		'attr' => 'title="kembali ke tabel pelajaran"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => 'Detail Pelajaran',
			'uri' => "data/akademik/pelajaran/id/{$row['id']}",
			'attr' => 'title="kembali ke detail pelajaran"',
	);

// input data

$input = array(
		'id' => array(
				'kode' => array(
						'kode',
						'type' => 'input',
						'name' => 'kode',
						'id' => 'kode',
						'class' => 'input input-xlarge',
						'label' => 'Kode',
				),
				'nama' => array(
						'nama',
						'label' => 'Nama',
						'type' => 'input',
						'name' => 'nama',
						'id' => 'nama',
						'class' => 'input input-xlarge',
				),
				'mapel_id' => array(
						'mapel_id',
						'label' => 'Mapel',
						'type' => 'dropdown',
						'name' => 'mapel_id',
						'id' => 'mapel_id',
						'extra' => 'id="mapel_id" class="input input-large select"',
						'options' => $this->m_option->mapel(),
				),
				'guru_id' => array(
						'guru_id',
						'label' => GURU_ALIAS . ' pengajar',
						'type' => 'dropdown',
						'name' => 'guru_id',
						'id' => 'guru_id',
						'extra' => 'id="guru_id" class="input input-large select"',
						'options' => $this->m_option->guru(),
				),
				'kategori_id' => array(
						'kategori_id',
						'label' => 'Kategori',
						'type' => 'dropdown',
						'name' => 'kategori_id',
						'id' => 'kategori_id',
						'extra' => 'id="kategori_id" class="input input-large select"',
						'options' => $this->m_option->kategori_mapel(),
				),
				'kurikulum_id' => array(
						'kurikulum_id',
						'label' => 'Kurikulum',
						'type' => 'dropdown',
						'name' => 'kurikulum_id',
						'id' => 'kurikulum_id',
						'extra' => 'id="kurikulum_id" class="input input-medium select"',
						'options' => $this->m_option->kurikulum(),
				),
		),
		'sifat' => array(
				'aktif' => array(
						'name' => 'aktif',
						'id' => 'aktif',
						'value' => 1,
						'checked' => (bool) $row['aktif'],
				),
				'teori' => array(
						'name' => 'teori',
						'id' => 'teori',
						'value' => 1,
						'checked' => (bool) $row['teori'],
				),
				'praktek' => array(
						'name' => 'praktek',
						'id' => 'praktek',
						'value' => 1,
						'checked' => (bool) $row['praktek'],
				),
		),
		'peserta' => array(
				'agama_id' => array(
						'agama_id',
						'label' => 'Khusus agama',
						'type' => 'dropdown',
						'name' => 'agama_id',
						'id' => 'agama_id',
						'extra' => 'id="agama_id" class="input input-medium select"',
						'options' => $this->m_option->agama(TRUE),
				),
				'kelas' => array(
						'name' => 'kelas_list',
						'div_list' => array(),
						'float' => FALSE,
						'caption' => FALSE,
						'div_item' => array(),
						'value' => (array) set_value('kelas_list[]', $row['kelas_list']),
						'options' => $this->m_option->kelas(),
				),
		),
);
/*
if ($row['id'] > 0):
	$input['id']['kategori_id']['extra'] .= 'disabled="true" style="color: gray;"';
	$input['id']['mapel_id']['extra'] .= 'disabled="true" style="color: gray;"';
endif;
*/
// button

if ($row['id'] > 0)
	$btn_back = a("data/akademik/pelajaran/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail pelajaran', 'class="btn btn-info "');
else
	$btn_back = a("data/akademik/pelajaran", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel pelajaran', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Pelajaran')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Pelajaran</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';
				echo '<legend>Informasi Umum</legend>';

				// info umum 1 : kode, nama, kategori, mapel

				foreach ($input['id'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				// info umum 4 : bentuk pelajaran

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"aktif\">Bentuk pelajaran</label>"
				. "<div class=\"controls\">"
				. "<label class=\"checkbox\">"
				. form_checkbox($input['sifat']['teori'])
				. "teori"
				. "</label>"
				. "<label class=\"checkbox\">"
				. form_checkbox($input['sifat']['praktek'])
				. "praktek"
				. "</label></div></div>" . NL;

				// info umum 2 : keaktifan

				if ($row['id'] > 0):
					echo "<div class=\"control-group\">"
					. "<label class=\"control-label\" for=\"aktif\">Aktif</label>"
					. "<div class=\"controls\">"
					. "<label class=\"checkbox\">"
					. form_checkbox($input['sifat']['aktif'])
					. "masih aktif untuk kegiatan belajar"
					. "</label></div></div>" . NL;
				endif;

				echo '</fieldset>';

				// input peserta pelajaran :  kelas a, agama

				echo '<fieldset>';
				echo '<legend>Peserta Pelajaran</legend>';

				echo "<div class=\"control-group\">";
				echo "<label class=\"control-label\">Agama</label>";
				echo "<div class=\"controls\">";
				echo form_cell($input['peserta']['agama_id'], $row);
				echo "</div></div>" . NL;

				echo "<div class=\"control-group\">";
				echo "<label class=\"control-label\">Kelas</label>";
				echo "<div class=\"controls\">";
				echo form_checklist($input['peserta']['kelas']);
				echo "</div></div>" . NL;

				// form button

				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="submit" class="btn btn-success" name="ulang" value="true"><i class="icon-save icon-white"></i> Simpan, tambah lagi</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>