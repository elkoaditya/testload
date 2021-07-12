<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Admin')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>HOME</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
			
			<div class="card" id="table">
							
							<div class="col-sm-6 col-md-12" id="evaluasi">
								<a href="<?php echo base_url("kbm/evaluasi"); ?>" >
									<div class="mini-charts-item bgm-deeporange">
										<div class="clearfix">
											<div class="chart " >
												<img src="<?php echo base_url("images/logo_material_admin");?>/write.png" width="65" alt="">
											</div>
											<div class="count">
												<small>pengerjaan</small>
												<h2>EVALUASI</h2>
											</div>
										</div>
									</div>
								</a>
                            </div>
							
							<div class="col-sm-6 col-md-12" id="materi">
								<a href="<?php echo base_url("kbm/materi"); ?>" >
									<div class="mini-charts-item bgm-purple">
										<div class="clearfix">
											<div class="chart ">
												<img src="<?php echo base_url("images/logo_material_admin");?>/read.png" width="65" alt="">
											</div>
											<div class="count">
												<small>baca</small>
												<h2>MATERI</h2>
											</div>
										</div>
									</div>
								</a>
                            </div>
							
							<div class="col-sm-6 col-md-12" id="siswa">
								<a href="<?php echo base_url("data/profil/siswa"); ?>" >
									<div class="mini-charts-item bgm-amber">
										<div class="clearfix">
											<div class="chart ">
												<img src="<?php echo base_url("images/logo_material_admin");?>/student.png" width="65" alt="">
											</div>
											<div class="count">
												<small>daftar</small>
												<h2>SISWA</h2>
											</div>
										</div>
									</div>
								</a>
                            </div>
							
							
							<div class="col-sm-6 col-md-12" id="sdm">
								<a href="<?php echo base_url("data/profil/sdm"); ?>" >
									<div class="mini-charts-item bgm-lightblue">
										<div class="clearfix">
											<div class="chart ">
												<img src="<?php echo base_url("images/logo_material_admin");?>/teacher.png" width="65" alt="">
											</div>
											<div class="count">
												<small>daftar</small>
												<h2>GURU/PEGAWAI</h2>
											</div>
										</div>
									</div>
								</a>
                            </div>
							
							
							
							
							
			</div>
		</div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

<?php
	$array_animated = array('evaluasi', 'materi', 'siswa', 'sdm' );
?>
<script type="text/javascript">

setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
<?php
$time_fadeInUp	= 700; 
$time_fulse		= 2400;
foreach($array_animated as $animated)
{
?>
	setTimeout(function(){nowAnimation('<?=$animated?>','fadeInUp')},<?=$time_fadeInUp?>);
	setTimeout(function () {
		$("#<?=$animated?>").removeClass("animated");
		$("#<?=$animated?>").removeClass("fadeInUp");
		
		setTimeout(function(){delayAnimation('<?=$animated?>','pulse')}, <?=$time_fulse?>);// i see 2.4s is your animation duration
	}, 4000);
<?php
	$time_fadeInUp	= $time_fadeInUp + 200;
	$time_fulse		= $time_fulse + 300;
}?>


setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s

////table

</script>

	</body>
</html>