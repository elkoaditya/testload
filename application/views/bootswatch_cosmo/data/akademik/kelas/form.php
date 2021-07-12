<?php
// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kelas' => 'data/akademik/kelas',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/kelas/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Kelas',
		'uri' => "data/akademik/kelas",
		'attr' => 'title="kembali ke tabel kelas"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => 'Detail Kelas',
			'uri' => "data/akademik/kelas/id/{$row['id']}",
			'attr' => 'title="kembali ke detail kelas"',
	);

// input data

$input = array(
		'umum' => array(
				'nama' => array(
						'nama',
						'label' => 'Nama',
						'type' => 'input',
						'name' => 'nama',
						'id' => 'nama',
						'class' => 'input input-xlarge',
				),
				'wali_id' => array(
						'wali_id',
						'label' => 'Wali kelas',
						'type' => 'dropdown',
						'name' => 'wali_id',
						'id' => 'wali_id',
						'extra' => 'id="wali_id" class="input-xlarge select"',
						'options' => $this->m_option->guru(),
				),
		),
		'tambahan' => array(
				'jurusan_id' => array(
						'jurusan_id',
						'label' => 'Jurusan',
						'type' => 'dropdown',
						'name' => 'jurusan_id',
						'id' => 'jurusan_id',
						'extra' => 'id="jurusan_id" class="input-xlarge select"',
						'options' => $this->m_option->jurusan(),
				),
				'grade' => array(
						'grade',
						'label' => 'Grade',
						'type' => 'dropdown',
						'name' => 'grade',
						'id' => 'grade',
						'extra' => 'id="grade" class="input-medium select"',
						'options' => $this->m_option->grade(),
				),
				'kurikulum_id' => array(
						'kurikulum_id',
						'label' => 'Kurikulum',
						'type' => 'dropdown',
						'name' => 'kurikulum_id',
						'id' => 'kurikulum_id',
						'extra' => 'id="kurikulum_id" class="input input-large select"',
						'options' => $this->m_option->kurikulum(),
				),
				'gurubk_id' => array(
						'gurubk_id',
						'label' => 'Bimbingan Konseling',
						'type' => 'dropdown',
						'name' => 'gurubk_id',
						'id' => 'gurubk_id',
						'extra' => 'id="gurubk_id" class="input-xlarge select"',
						'options' => $this->m_option->guru(TRUE),
				),
		),
		'checkbox' => array(
				'aktif' => array(
						'name' => 'aktif',
						'id' => 'aktif',
						'value' => 1,
						'checked' => (bool) $row['aktif'],
				),
		),
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("data/akademik/kelas/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail kelas', 'class="btn btn-info "');
else
	$btn_back = a("data/akademik/kelas", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel kelas', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Kelas</h1>
				</div>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

// detail kelas

				echo '<fieldset>';
				echo '<legend>Informasi Umum</legend>';

				foreach ($input['umum'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				if ($row['id'] > 0):
					echo "<div class=\"control-group\">"
					. "<label class=\"control-label\" for=\"aktif\">Aktif</label>"
					. "<div class=\"controls\">"
					. "<label class=\"checkbox\">"
					. form_checkbox($input['checkbox']['aktif'])
					. "masih aktif untuk kegiatan sekolah"
					. "</label></div></div>" . NL;
				endif;

				echo '</fieldset><br/>';
				echo '<fieldset>';
				echo '<legend>Keterangan</legend>';

				foreach ($input['tambahan'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset><br/><br/>';

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

		<?php echo cosmo_js(); ?>

	</body>
</html>