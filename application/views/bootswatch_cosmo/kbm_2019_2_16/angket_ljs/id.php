<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		"Nilai" => "kbm/angket_nilai/browse?angket_id={$angket['id']}",
		"LJS" => "kbm/angket_ljs/browse?angket_id={$angket['id']}",
		"#{$row['id']}",
);

// pills link

$pills_kiri['angket_browse'] = array(
		'label' => 'Daftar Angket',
		'uri' => "kbm/angket",
		'attr' => 'title="kembali ke daftar angket"',
);
$pills_kiri['angket_id'] = array(
		'label' => 'Detail Angket',
		'uri' => "kbm/angket/id/{$angket['id']}",
		'attr' => 'title="kembali ke detail angket"',
);



if ($user['role'] == 'siswa'):
	$pills_kanan = array(
			'jawab' => array(
					'label' => '<i class="icon-pencil"></i> Coba Lagi',
					'uri' => "kbm/angket_ljs/form/{$user['menilai_id']}?id={$angket['id']}",
					'attr' => 'title="beri catatan pada ini"',
					'class' => 'disabled',
			),
	);

	if ($siswa_ybs && $angket['#available']):
		$pills_kanan['jawab']['class'] = 'active';
	endif;

else:
	$pills_kanan = array(
			'koreksi' => array(
					'label' => '<i class="icon-ok"></i> Koreksi',
					'uri' => "kbm/angket_ljs/koreksi?id={$row['id']}",
					'attr' => 'title="koreksi poin jawaban ini"',
					'class' => 'disabled',
			),
	);

	if (($admin OR $author_ybs) && $angket['semester_id'] == $semaktif['id'] && !$angket['closed']):
		//$pills_kanan['koreksi']['class'] = 'active';
	endif;


endif;

$pills_kanan[] = array(
		'label' => '<i class="icon-print"></i> Cetak',
		'uri' => "kbm/angket_ljs/id/{$row['id']}?pdf=true",
		'attr' => 'title="cetak lembar jawaban ini"',
		'class' => 'active',
);

// tabel data
function display_menilai($row) {
		if($row['jenis_penilaian']=='penilaian_diri')
			return  "{$row['siswa_nama']}";
		elseif($row['jenis_penilaian']=='penilaian_sejawat')
			return  "{$row['menilai_siswa_nama']}";
}

$dset['Nama'] = array('siswa_nama');
if ($user['role'] == 'siswa')
{	$dset['Menilai Siswa'] = array(FALSE, 'display_menilai');	}
$dset['Kelas'] = 'kelas_nama';
$dset['Nilai'] = array('nilai');

if ($user['role'] != 'siswa' OR $angket['closed'])
	$dset['Skor Poin'] = array(
			'poin',
			'suffix' => array(
					' / ',
					'poin_max',
			),
	);


// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';

// pesan

if ($siswa_ybs && !$angket['closed'])
	alert_info('Untuk informasi poin skor dan kunci (pilihan ganda) tiap butir soal menunggu angket ditutup.');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Lembar Jawab Soal')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header alert-block">
					Lembar Jawab Soal :<br/>
					<h1><?php echo strtoupper($angket['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					.pengecoh{
						display: none;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pill;

				// data utama

				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label>"
					. "<div class=\"controls\">" . data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				foreach ($butir_result['data'] as $idx => $butir):
					soal_angket_prepjwb($butir);

					echo '<div class="well">';
					echo '<fieldset>';
					echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan"', $butir['pertanyaan']) . '<br/>';

					// poin

					if ($user['role'] != 'siswa' OR $angket['closed'])
						//echo "<div><b>Poin: </b>{$butir['jwb_poin']} / {$butir['poin_max']}</div>";
						echo "<div><b>Poin: </b>{$butir['jwb_poin']} </div>";

					// jawaban

					echo "<div><b>Jawaban:</b>";
					echo ul(array($butir['jwb_jawaban']));
					echo "</div>";

					// pilihan, bila ada

					if ($butir['pilihan'] && ($user['role'] != 'siswa' OR $angket['closed'] )):

						$kunci = (array) array_node($butir, 'pilihan', 'kunci', 'label');
						$pengecoh = (array) array_node($butir, 'pilihan', 'pengecoh');

						//echo "<div><b>Kunci:</b>";
						//echo ul($kunci);
						//echo "</div>";

						echo "<div>";
						echo "<div class=\"btn btn-info btn-small\" onClick=\"$('#pengecoh-{$butir['id']}').slideToggle(200);\">Pilihan</div>";
						echo ul($pengecoh, "id=\"pengecoh-{$butir['id']}\" class=\"pengecoh\"");
						echo "</div>";

					endif;

					echo '<fieldset>';
					echo "</div>";

				//dump($butir);

				endforeach;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>