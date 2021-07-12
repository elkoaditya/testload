<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		'Soal' => "kbm/angket_soal/browse?angket_id={$angket['id']}",
		"#{$row['id']}" => "kbm/angket_soal/id/{$row['id']}",
		'#delete'
);
$btn_back = a("kbm/angket/id/{$angket['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail angket', 'class="btn btn-info "');

alert_info(div('align="center"', '<h3>Apakah Anda yakin akan menghapus soal ini???</h3>'));
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
					Hapus Soal Angket:
					<h1><?php echo a("kbm/angket/id/{$angket['id']}", strtoupper($angket['nama']), 'title="kembali ke halaman angket"'); ?></h1>
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
				echo alert_get();

				echo '<div class"legend"><b>Pertanyaan:</b></div>';
				echo $row['pertanyaan'] . '<br/>';
				echo '</div>';

				if ($row['pilihan']):
					/*
					echo "<div><b>Kunci:</b>";
					echo ul($row['pilihan']['kunci']);
					echo "</div>";

					echo "<div><b>Pengecoh:</b>";
					*/
					echo "<div><b>Pilihan:</b>";
					echo ul($row['pilihan']['pengecoh']);
					echo "</div>";
					
					echo "<div><b>Nilai:</b>";
					$i	= 1;
					while($i<=count($row['pilihan']['pengecoh']))
					{
						echo ul(array($row['poin_'.$i]));
						$i++;
					}
					echo "</div>";

				endif;

				echo '<br/>';

				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
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