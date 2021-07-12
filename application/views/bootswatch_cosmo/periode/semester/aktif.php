<?php
// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Periode' => 'periode',
		'Semester' => 'periode/semester',
		"Aktif",
);

// pills link

$pills = array();

if ($admin):

	// belum pernah memulai semester, opsi inisiasi/startup

	if (!$semester_terakhir):
		$pills[] = array(
				'label' => '<i class="icon-play-circle"></i>Startup Semester Baru',
				'uri' => "periode/semester/form",
				'attr' => 'title="mengawali semester"',
		);

	elseif (!$semaktif['akhir']):

		// dalam masa jeda, opsi roling semester baru

		$pills[] = array(
				'label' => '<i class="icon-play"></i>Mulai Semester Baru',
				'uri' => "periode/semester/form",
				'attr' => 'title="mengawali semester"',
		);

	else:

		// dalam masa semester berjalan, deteksi akhir semester

		$akhir = date_create($semaktif['akhir']);

		if ($akhir):
			$akhir->modify("-1 month");
			$limit = $akhir->getTimestamp();

			if ($limit <= $time):
				$pills[] = array(
						'label' => '<i class="icon-stop"></i>Tutup Semester Ini',
						'uri' => "periode/semester/tutup",
						'attr' => 'title="tutup semester"',
				);

			endif;

		else:
			alert_error('Tak dapat mendeteksi akhir semester');

		endif;

	endif;

endif;

// data tabel
$term = ucfirst($semaktif['term']);
$dset[$term] = array(
		'nama',
		'ucfirst',
		'suffix' => array(
				'&nbsp; ',
				'ta_nama',
		)
);
$dset['Berakhir'] = array('akhir', 'tgl');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Semester Aktif')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Semester Aktif</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				echo alert_get();
				echo pills($pills);
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $semaktif) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';
				echo pills($pills);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>