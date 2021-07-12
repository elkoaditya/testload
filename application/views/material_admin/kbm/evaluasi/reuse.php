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

$btn_back = '<div class="col-sm-12">';
$btn_back .= a("kbm/evaluasi/id/{$row['id']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke detail evaluasi', 'id="back" 
				class="btn bgm-gray btn-sm m-b-15"');
$btn_back .= '</div>';

$detail['umum'] = array(
	'Pelajaran' => array(
		'mapel_nama', 'ucwords',
		'suffix' => array(
			'<div class="subinfo">',
			'pelajaran_nama',
			' oleh ',
			'author_nama',
			'.&nbsp; ',
			'semester_nama',
			' ',
			'ta_nama',
			'</div>',
		),
	),
);

$input['umum'] = array(
	'pelajaran_id' => array(
		'pelajaran_id',
		'type'		 => 'dropdown',
		'name'		 => 'pelajaran_id',
		'id'		 => 'pelajaran_id',
		'label'		 => 'Pelajaran',
		'extra'		 => 'class="form-control" id="pelajaran_id"',
		'options'	 => 'opsi_pelajaran',
	),
);

$bentuk_menjawab = array('Uraian', 'error', 'error', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi');
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Guru')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>GUNAKAN KEMBALI EVALUASI</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
            <div class="card">
                <div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'id="title_evaluasi" title="lihat evaluasi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $row['author_nama'];?></li>
                                <li>Mapel <?php echo $row['mapel_nama'];?></li>
								<li>Bentuk <?php echo $bentuk_menjawab[$row['pilihan_jml']];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
                <div class="card-body card-padding">
					<?php
					echo $btn_back;
                    // tombol konfirm
    
                    echo form_opening("{$uri}/{$row['id']}", '');
    
                    // input umum
    
                    echo'
                        <p class="c-black f-500 m-b-20">Digunakan kembali pada :</p>
						<div class="col-sm-5">
							<div class="form-group">
								<div class="fg-line">
									<div class="select">';
							foreach ($input['umum'] as $inp):
								echo form_cell($inp, $row);
							endforeach;
					echo'				
									</div>
								</div>
							</div>
						</div>';

				
				// form button

				echo '<button type="submit" id="tambah" class="btn btn-success btn-sm m-b-5"><i class="zmdi zmdi-airplane"></i> GUNAKAN !</button> <br/><br/>';

				echo form_close();
				?>
                </div>
             </div>
		</div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

<script type="text/javascript">
   
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s


setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_evaluasi','rubberBand')},3000);
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);

setTimeout(function(){delayAnimation('back','rubberBand')},4000);
</script>