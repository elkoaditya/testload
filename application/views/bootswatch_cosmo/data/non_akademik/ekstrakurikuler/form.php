<?php
// hak akses & user scope
//
//$admin = cfguc_admin('akses', 'data', 'akademik', 'kelas');
//
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Non-Akademik' => 'data/non_akademik',
		'Ekstrakurikuler' => 'data/non_akademik/ekstrakurikuler',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/non_akademik/ekstrakurikuler/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => '<i class="icon-table"></i>Tabel Ekstrakurikuler',
		'uri' => "data/non_akademik/ekstrakurikuler",
		'attr' => 'title="kembali ke tabel ekstrakurikuler"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => '<i class="icon-list-alt"></i>Detail Ekstrakurikuler',
			'uri' => "data/non_akademik/ekstrakurikuler/id/{$row['id']}",
			'attr' => 'title="kembali ke detail ekstrakurikuler"',
	);

// input data

$input_1 = array(
		'nama' => array(
				'nama',
				'label' => 'Nama',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xlarge',
		),
);
$input_2 = array(
		'aktif' => array(
				'name' => 'aktif',
				'id' => 'aktif',
				'value' => 1,
				'checked' => (bool) $row['aktif'],
		),
);
$input_3 = array(
		'pembina_id' => array(
				'pembina_id',
				'label' => 'Pembina',
				'type' => 'dropdown',
				'name' => 'pembina_id',
				'id' => 'pembina_id',
				'options' => 'opsi_pembina',
				'extra' => 'id="pembina_id"',
		),
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("data/non_akademik/ekstrakurikuler/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail ekstrakurikuler', 'class="btn btn-info "');
else
	$btn_back = a("data/non_akademik/ekstrakurikuler", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel kelas', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Ekstrakurikuler')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Ekstrakurikuler</h1>
				</div>

				<?php
				echo alert_get();
				echo pills($pills);
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// detail kelas

				echo '<fieldset>';

				foreach ($input_1 as $inp):
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
					. form_checkbox($input_2['aktif'])
					. "masih aktif untuk kegiatan sekolah"
					. "</label></div></div>" . NL;
				endif;

				foreach ($input_3 as $inp):
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