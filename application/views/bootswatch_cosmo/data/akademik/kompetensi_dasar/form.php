<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Akademik' => 'data/akademik',
		'Kompetensi Dasar' => 'data/akademik/kompetensi_dasar',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/akademik/kompetensi_dasar/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => 'Daftar Kompetensi Dasar',
		'uri' => "data/akademik/kompetensi_dasar",
		'attr' => 'title="kembali ke tabel Kompetensi Dasar"',
);

// input data

$input = array(
		'id' => array(
			
			'kurikulum_id' => array(
					'kurikulum_id',
					'label' => 'Kurikulum',
					'type' => 'dropdown',
					'name' => 'kurikulum_id',
					'id' => 'kurikulum_id',
					'extra' => 'id="kurikulum_id" class="input input-medium select"',
					'options' => $this->m_option->kurikulum(),
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
			'mapel_id' => array(
					'mapel_id',
					'label' => 'Mapel',
					'type' => 'dropdown',
					'name' => 'mapel_id',
					'id' => 'mapel_id',
					'extra' => 'id="mapel_id" class="input input-large select"',
					'options' => $this->m_option->mapel(),
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
			'kode' => array(
						'kode',
						'label' => 'Kode',
						'type' => 'dropdown',
						'name' => 'kode',
						'id' => 'kode',
						'extra' => 'id="kode" class="input-medium select"',
						'options' => array(
								'KD1' => 'KD1',
								'KD2' => 'KD2',
								'KD3' => 'KD3',
								'KD4' => 'KD4',
								'KD5' => 'KD5',
								'KD6' => 'KD6',
								'KD7' => 'KD7',
								'KD8' => 'KD8',
								'KD9' => 'KD9',
								'KD10' => 'KD10',
								'KD11' => 'KD11',
								'KD12' => 'KD12',
								'KD13' => 'KD13',
								'KD14' => 'KD14',
								'KD15' => 'KD15',
								'KD16' => 'KD16',
								'KD17' => 'KD17',
								'KD18' => 'KD18',
								'KD19' => 'KD19',
								'KD20' => 'KD20',
						),
				),
				/*
			'kode' => array(
					'kode',
					'type' => 'input',
					'name' => 'kode',
					'id' => 'kode',
					'class' => 'input input-xlarge',
					'label' => 'Kode',
			),*/
			'nama' => array(
					'nama',
					'label' => 'Nama',
					'type' => 'input',
					'name' => 'nama',
					'id' => 'nama',
					'class' => 'input input-xxlarge',
			),
			'kode_erapor_teori' => array(
					'kode_erapor_teori',
					'label' => 'ID KD E-Rapor Pengetahuan',
					'type' => 'input',
					'name' => 'kode_erapor_teori',
					'id' => 'kode_erapor_teori',
					'class' => 'input input-xxlarge',
			),
			'kode_erapor_praktek' => array(
					'kode_erapor_praktek',
					'label' => 'ID KD E-Rapor Ketrampilan',
					'type' => 'input',
					'name' => 'kode_erapor_praktek',
					'id' => 'kode_erapor_praktek',
					'class' => 'input input-xxlarge',
			),
		),
);

// buttons

$btn_back = a("data/akademik/kompetensi_dasar", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel Kompetensi Dasar', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Kompetensi Dasar')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Kompetensi Dasar</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';
/*
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"kode\">Kode KD</label>"
				. "<div class=\"controls\">"
				. form_cell($input['kode'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nama\">Nama KD</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nama'], $row)
				. "</div></div>" . NL;

				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"nourut\">Urutan</label>"
				. "<div class=\"controls\">"
				. form_cell($input['nourut'], $row)
				. "</div></div>" . NL;
				*/
				foreach ($input['id'] as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;
				
				// form button

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