<?php
// vars

$ruri = "{$uri}?angket_id={$request['angket_id']}";

// fungsi
// komponen
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		'Nilai' => "kbm/angket_nilai/browse?angket_id={$angket['id']}",
		'#statistik',
);

// input filter/pencarian

$input = array(
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->kelas_angket($angket['id'], 'kelas'),
		),
);

$bar_search = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. form_hidden('angket_id', $request['angket_id'])
			. form_cell($input['kelas_id'], $request) . '&nbsp;'
			. form_submit('cari', 'Filter', 'class="btn btn-success"') . ' '
			. a($ruri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal Angket {$angket['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

		<style>
			#jgraph-pie{
				width: 640px;
				height: 480px;
			}
			#jgraph-bar{
				width: 640px;
				height: 480px;
			}
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Statistik Hasil Angket:
					<h1><?php echo a("kbm/angket/id/{$angket['id']}", strtoupper($angket['nama']), 'title="kembali ke halaman angket"'); ?></h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_search;
				?>

				<div align="center">

					<div id="jgraph-pie"></div>

					<div id="jgraph-bar"></div>

				</div>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");

		$jqplot['plugins'] = array('barRenderer.min', 'pieRenderer.min', 'categoryAxisRenderer.min', 'pointLabels.min');
		addon('jqplot', $jqplot);
		?>

		<script type="text/javascript">
			$(function() {

				var jf_pie = <?php echo json_encode($pie); ?>;
				var plot1 = jQuery.jqplot('jgraph-pie', [jf_pie],
								{
									seriesDefaults: {
										// Make this a pie chart.
										renderer: jQuery.jqplot.PieRenderer,
										rendererOptions: {
											// Put data labels on the pie slices.
											// By default, labels show the percentage of the slice.
											showDataLabels: true
										}
									},
									legend: {show: true, location: 'e'}
								}
				);

				// bar
				$.jqplot.config.enablePlugins = true;
				var jf_bar = <?php echo json_encode($bar); ?>;
				var bar_ticks = ['0', '&le;10', '&le;20', '&le;30', '&le;40', '&le;50', '&le;60', '&le;70', '&le;80', '&le;90', '&le;100'];

				plot2 = $.jqplot('jgraph-bar', [jf_bar], {
					// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
					animate: !$.jqplot.use_excanvas,
					seriesDefaults: {
						renderer: $.jqplot.BarRenderer,
						pointLabels: {show: true}
					},
					axes: {
						xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer,
							ticks: bar_ticks
						}
					},
					highlighter: {show: false}
				});

			});
		</script>

	</body>
</html>