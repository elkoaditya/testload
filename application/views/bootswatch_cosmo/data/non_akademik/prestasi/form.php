<?php
// hak akses & user scope
//
//$admin = cfguc_admin('akses', 'data', 'akademik', 'kelas');
//

// vars
$url_data	= 'data/non_akademik/prestasi';
$url_nilai	= 'nilai/prestasi';

// breadcrumbs
$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Non-Akademik' => 'data/non_akademik',
		'Prestasi' => 'data/non_akademik/prestasi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/non_akademik/prestasi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

$pills[] = array(
		'label' => '<i class="icon-table"></i>Tabel Prestasi',
		'uri' => "data/non_akademik/prestasi",
		'attr' => 'title="kembali ke tabel prestasi"',
);

if ($row['id'] > 0)
	$pills[] = array(
			'label' => '<i class="icon-list-alt"></i>Detail Prestasi',
			'uri' => "data/non_akademik/prestasi/id/{$row['id']}",
			'attr' => 'title="kembali ke detail prestasi"',
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
		'kegiatan_prestasi_id' => array(
				'kegiatan_prestasi_id',
				'label' => 'Kegiatan Prestasi',
				'type' => 'dropdown',
				'name' => 'kegiatan_prestasi_id',
				'id' => 'kegiatan_prestasi_id',
				'options' => 'opsi_kegiatan_prestasi',
				'extra' => 'id="kegiatan_prestasi_id"',
		),
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("data/non_akademik/prestasi/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail prestasi', 'class="btn btn-info "');
else
	$btn_back = a("data/non_akademik/prestasi", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel kelas', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Prestasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Prestasi</h1>
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
				//. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				//. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				//. $btn_back
				.'<button type="submit" class="btn btn-success input-xxlarge" name="redir" value="data_prestasi">'
				.'			<i class="icon-save icon-white"></i> Simpan &AMP; kembali ke Data-Prestasi</button>'
				.'		&nbsp; &nbsp;'
				.a($url_data, ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke data prestasi', 'class="btn btn-info input-xlarge "')
				.'		<br/><br/>'
				.'		<button type="submit" class="btn btn-success input-xxlarge" name="redir" value="nilai_prestasi">'
				.'			<i class="icon-save icon-white"></i> Simpan &AMP; kembali ke Nilai-Prestasi </button>'
				.'&nbsp; &nbsp;'
				.a($url_nilai, ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke nilai prestasi', 'class="btn btn-info input-xlarge "')
				
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