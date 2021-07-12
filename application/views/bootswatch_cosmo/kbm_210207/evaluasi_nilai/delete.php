<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$eval['id']}" => "kbm/evaluasi/id/{$eval['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$eval['id']}",
		"#{$row['id']}" => "kbm/evaluasi_soal/id/{$row['id']}",
);
$btn_back = a("kbm/evaluasi_soal/browse?evaluasi_id={$eval['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar pertanyaan', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Soal Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$eval['id']}", strtoupper($eval['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}

					.well{
						margin-bottom: 40px;
					}
					.well .legend{
						font-size: 0.8em;
						opacity: 0.8;
						margin: 10px 10px 25px 10px;
					}
					.opsi{
						width: 360px;
						min-height: 100px;
						margin: 20px;
					}
					#pengecoh-list .opsi{
						float: left;
					}
				</style>

				<?php
				alert_info(div('align="center"', '<h3>Apakah Anda yakin akan menghapus soal ini???</h3>'));
				echo alert_get();
				echo '<div class="well">';
				echo '<div class"legend"><b>Gambar:</b></div>';

				if ($row['gambar']):
					$gambar = json_decode($row['gambar'], TRUE);
					if (isset($gambar['full_path']) && file_exists($gambar['full_path'])):
						echo img($gambar['full_path']);
					else:
						echo '-';
					endif;
				else:
					echo '-';
				endif;

				echo '<br/><br/>';

				echo '<div class"legend"><b>Pertanyaan:</b></div>';
				echo $row['pertanyaan'] . '<br/><br/>';

				if ($eval['pilihan_jml'] > 1):
					$attr = 'class="opsi label label-info"';

					echo '<div class"legend"><b>Kunci:</b></div>';
					echo div($attr, $row['pilihan']['kunci']);

					echo '<div class"legend"><b>Pengecoh:</b></div>';
					echo '<table border="0"><tr><td>';
					echo '<div id="pengecoh-list">';

					foreach ($row['pilihan']['pengecoh'] as $pengecoh):
						echo div($attr, $pengecoh);

					endforeach;

					echo '</div>';
					echo '</td></tr></table>';
					echo '</div>';

				endif;

				echo '</div>';

				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-danger"><i class="icon-trash icon-white"></i> HAPUS ??</button> '
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