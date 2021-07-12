<?php

$img_sample = array(
	"1.jpg",
	"2.jpg",
	"3.jpg",
	"4.jpg",
	"5.jpg",
	"6.jpg",
);
$warna=array(
		'class="btn bgm-cyan"', 
		'class="btn bgm-teal"',
		'class="btn bgm-amber"',
		'class="btn bgm-orange"',
		'class="btn bgm-deeporange"',
		'class="btn bgm-red"',
		'class="btn bgm-pink"',
		'class="btn bgm-lightblue"',
		'class="btn bgm-indigo"',
		'class="btn bgm-lime"',
		'class="btn bgm-lightgreen"',
		'class="btn bgm-green"',
		'class="btn bgm-purple"',
		'class="btn bgm-deeppurple"',
		);
		

$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";


?>
<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Evaluasi Belajar')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">
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
        
            <div class="block-header">
                <h2 id="title_page"><b>Statistik Hasil Evaluasi:</b></h2>
				
            </div>
			<div class="card">
                <div class="card-header">
                    <h2> <b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$evaluasi['id']}", $evaluasi['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]);
							echo (($evaluasi['published']) ? '' : ' <div style="color:red">(Belum Dipublikasikan)</div>'); ?></b>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $evaluasi['author_nama'];?></li>
                                <li>Mapel <?php echo $evaluasi['mapel_nama'];?></li>
                                <li>Pelajaran <?php echo $evaluasi['pelajaran_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
			</div>

            <?php
				echo alert_get();
				?>

				<div align="center">

					<div id="jgraph-pie"></div>

					<div id="jgraph-bar"></div>

				</div>
			
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

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


<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );
        
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

</script>
	</body>
</html>