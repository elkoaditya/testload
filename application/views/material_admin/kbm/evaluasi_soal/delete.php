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
		
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}",
		"#{$row['id']}" => "kbm/evaluasi_soal/id/{$row['id']}",
		'#delete'
);
$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="zmdi zmdi-left"></i> Kembali ke detail evaluasi', 'class="btn btn-info  btn-sm m-b-5 m-r-5" id="back" ');

alert_info(div('align="center"', '<h3>Apakah Anda yakin akan menghapus soal ini???</h3>'));
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Hapus Soal Evaluasi')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>Hapus Soal Evaluasi</b></h2>
            </div>
            
            <div class="card">
            	<div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$row['id']}", $evaluasi['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $evaluasi['author_nama'];?></li>
                                <li>Mapel <?php echo $evaluasi['mapel_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                </div>
            	<div class="card-body card-padding">

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

				echo '<p class="f-500 m-b-15 c-black"><h4>Pertanyaan:</h4></p>';
				echo $row['pertanyaan'] . '<br/>';
				//echo '</div>';

				if ($row['pilihan']):

					echo "<div><b>Kunci:</b>";
					echo ul($row['pilihan']['kunci']);
					echo "</div>";

					echo "<div><b>Pengecoh:</b>";
					echo ul($row['pilihan']['pengecoh']);
					echo "</div>";

				endif;

				echo '<br/>';

				echo form_opening("{$uri}?id={$row['id']}", '');
				echo '<fieldset>';
				echo '<div >'
				. '<button type="submit" class="btn btn-danger btn-sm m-b-5 m-r-5" id="hapus"><i class="zmdi zmdi-delete"></i> HAPUS !</button> '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>
                </div>
                
			</div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>
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
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){delayAnimation('hapus','rubberBand')},5000);
setTimeout(function(){delayAnimation('back','rubberBand')},5200);

</script>


	</body>
</html>