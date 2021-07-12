<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}",
		"#{$row['id']}" => "kbm/evaluasi_soal/id/{$row['id']}",
		'#ganti_kunci'
);
$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');

$input = array(
		'nilai_bonus' => array(
				'nilai_bonus',
				'label' => '<b>Nilai Bonus</b>',
				'type' => 'dropdown',
				'name' => 'nilai_bonus',
				'id' => 'nilai_bonus',
				'extra' => 'class="input-large select" id="nilai_bonus"',
				'options' => array(
					0 => 'TIDAK',
					1 => 'YA',
				),
		),
		'ganti_kunci' => array(
				'ganti_kunci',
				'label' => '<b>Ganti Kunci</b>',
				'type' => 'dropdown',
				'name' => 'ganti_kunci',
				'id' => 'ganti_kunci',
				'extra' => 'class="input-large select" id="ganti_kunci"',
				'options' => array(
					'Kunci',
					1 => 'Pengecoh 1',
					2 => 'Pengecoh 2',
					3 => 'Pengecoh 3',
					4 => 'Pengecoh 4',
				),
		),
	);
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
					Ganti Kunci Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
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

				

				echo form_close();
				if ($row['pilihan']):

					echo "<div><b>Kunci:</b>";
					echo ul($row['pilihan']['kunci']);
					echo "</div>";

					echo "<div><b>Pengecoh:</b>";
					//echo ul($row['pilihan']['pengecoh']);
					echo "<ul>";
					
					$no_pengecoh=0;
					foreach($row['pilihan']['pengecoh'] as $pengecoh){
						$no_pengecoh++;
						echo "<li><b>Pengecoh ".$no_pengecoh." =</b><br>".$pengecoh."</li>";
					}
					echo "<ul>";
					echo "</div>";

				endif;

				echo '<br/>';

				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				
				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;
				
				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-trash icon-white"></i> OK </button> '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			<!--</div>-->

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>


	</body>
</html>