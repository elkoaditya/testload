<?php
							
	$domain_pengumuman = array(
			//"demo",
			//"sma_smg3n", 
			//"sma_smg6n",
			"sma_smg8n", 
			//"sma_smg9n",
			//"sma_smg14n",									
			"smk_penerbangan",
			"sma-setiabudhi.fresto.co",
			//"smaterbang.fresto.co",
			//"smk_smg6n",
			
	);
	$pengumuman = 0;
	if (in_array(APP_SUBDOMAIN, $domain_pengumuman)){
		$pengumuman = 1;
	}
	
	$logo = NULL;

	//redirect(base_url()."/elibrary");
	
	if (APP_DOMAIN == 'localhost'):
		$logo = array(
				'src' => 'images/logo/theresiana_sma1.jpg',
				'width' => 280,
				'height' => 262,
		);
//sma_smg1n
	elseif (APP_SUBDOMAIN == 'sma_smg3n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/SMAN3SMG.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sma_smg6n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/SMAN6.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sma_smg8n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma8.jpg',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sma_smg9n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/Logo-sma-9-semarang.jpg',
				'width' => 120,
		);
	
	elseif (APP_SUBDOMAIN == 'sma_smg11n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo-sman11-smg.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sma_smg14n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo-sman14-smg.png',
				'width' => 180,
		);
	
	elseif (APP_SUBDOMAIN == 'smk_smg6n'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smkn6smg.jpg',
				'width' => 180,
		);
	///////////////////////////////////////////////////////////////////////////////////

	
	elseif (APP_SUBDOMAIN == 'smaissa1smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smasula_1_2.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smaterbang.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma-terang-bangsa.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smamichael.smg.fresto.co'):
		$logo = array(
				//'src' => 'images/logo/'.APP_SCOPE.'/Logo SMA santo michael.jpg',
				'src' => 'images/logo/'.APP_SCOPE.'/Logo SMA santo michael new.jpeg',
				'width' => 180,
		);
	
	elseif (APP_SUBDOMAIN == 'smk_penerbangan'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smk-penerbad.png',
				'width' => 180,
		);
	
	elseif (APP_SUBDOMAIN == 'sma_setiabudhi'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smknusaputera1.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_nusaputera.jpg',
				'width' => 180,
		);
	elseif (APP_SUBDOMAIN == 'smkpltarcisius-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smkpltarcisius.jpg',
				//'width' => 180,
		);
				
	elseif (APP_SUBDOMAIN == 'demo.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo fresto g2.png',
				
				
		);
	
	// SMP
	elseif (APP_SUBDOMAIN == 'smp_terbang'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smp_terbang.jpg',
				'width' => 180,
		);
		
	//// ADDITIONAL
	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co/revisi'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);
	endif;
	
	
	// cek device
	$device ='android';
	
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') !== false )
	{
		$device =  'windows';
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') !== false )
	{
		$device =  'android';
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone') !== false )
	{
		$device = 'iphone';
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad') !== false )
	{
		$device = 'ipad';
	}
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipod') !== false )
	{
		$device = 'ipod';
	}
	//echo $device;
	
	$data['xed']	= $this->input->get('xed');
	$data['zupe3r']	= $this->input->get('zupe3r');
	$data['exam']	= $this->input->get('exam');
	
	$exambrow = 0;
	$exambrow = 1;
	
	if($data['xed'] == '99a5efbfaae529aac650d642b3f05d73'){
		if($device ==  'android'){
			
			if($data['exam'] == 1){
				$exambrow = 1;
			}
		}else{
			$exambrow = 1;
		}
		
	}
	
	if(APP_SUBDOMAIN=='smaissa1smg'){
		
		$exambrow = 0;
		if($data['zupe3r'] == '25174ny543yn58y3487y984nc9'){
			
			if($data['exam'] == 1){
				$exambrow = 1;
			}
		
		}
	}
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login | <?php echo APP_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="FRESTO">

    <!-- Le styles -->
	<?php //echo link_tag("assets/bootstrap_2.3.2/css/bootstrap.css"); ?>
	<?php //echo link_tag("css/simple.css"); ?>
    <style type="text/css">
		body {
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
			background-image: url('<?php echo base_url("images/background/coe_hp_new.png"); ?>');
			background-position: center center;
			
			/*background-image: url('<?php echo base_url('images/ansa/bulan-1.jpg'); ?>');
			background-repeat: no-repeat;
			background-position: top center;*/
		}
	

		.form-signin {
			max-width: 100%;
			padding: 19px 29px 29px;
			margin: 0 auto 20px;
			/*background-color: #fff;
			border: 1px solid #e5e5e5;*/
			
			background-color: rgba(255, 255, 255, 0.7);
  
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
			box-shadow: 0 1px 2px rgba(0,0,0,.05);
			/*float: right;*/
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
			margin-bottom: 10px;
		}
		.form-signin input[type="text"],
		.form-signin input[type="password"] {
			font-size: 16px;
			height: auto;
			margin-bottom: 15px;
			padding: 7px 9px;
		}

		#container{
			margin-top: 20px;
		}

    </style>
	<?php echo link_tag("assets/bootstrap_2.3.2/css/bootstrap-responsive.css"); ?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
	<?php echo link_js("assets/bootstrap_2.3.2/js/html5shiv.js"); ?>
    <![endif]-->

	<!--</head>-->
	<?php $this->load->view("bootswatch_cosmo/-html-/head"); ?>
	
	<!-- Vendor CSS -->
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

	
		<?php echo link_js("assets/bootstrap_2.3.2/js/jquery.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-transition.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-alert.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-modal.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-dropdown.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-scrollspy.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-tab.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-tooltip.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-popover.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-button.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-collapse.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-carousel.js"); ?>
		<?php echo link_js("assets/bootstrap_2.3.2/js/bootstrap-typeahead.js"); ?>

	<body>

		<div class="container">
			<div align="center">
				
				<?php
				if($pengumuman==1){
					?>
				
				<div class="row" >
					<div class="span4">
				
				<?php
				}
				?>
						<table border="0" width="100%" cellspacing="5px">
					
							<tr>
								<td align="center">
									
									<?php

									$gets = (array) $this->input->get();
									$gets['redir'] = (string) $this->input->get_post('redir');
									echo form_opening($uri . array2qs($gets), 'class="form-signin"');
									?>
									<h3 class="form-signin-heading" align="center">
										<font color="#585858">
										<b><?php echo TITLE_LOGIN;?>
										</b>
									</h3>
									<?php
									if ($logo)
										echo div('align="center" id="logo"', img($logo));

									?>
									
									
									
									<div id="title">
										<h2 class="form-signin-heading" align="center">
											<font color="#585858">
												<b>Login<b>
											</font>
										</h2>
									</div>
									<?php echo alert_get(); ?>
									<div style="max-width:300px">
										<?php 
										if($exambrow == 1){ 
											//echo $exambrow;
											?>
											<input type="hidden" name="logint" value="ok">
											<?php 
										} ?>
										<input type="text" name="username" class="input-block-level" placeholder="ID Fresto">
										<input type="password" name="password" class="input-block-level" placeholder="Password">
										<!--<button class="btn btn-large btn-primary" type="submit">Sign in</button>-->
										<input id="submit" type="submit" name="submit" class="btn btn-success btn-block" value=" Sign in "/>
									</div>
									<?php echo form_close(); ?>
									<br>Selamat datang di <b>Fresto</b> learning system (<?=$exambrow?> <?=$device?> <?=$data['exam']?> )  
								</td>
							</tr>
						</table>
					
					<?php
					if($pengumuman==1){
					?>
				
				
					</div>
					
					
					<div class="span8" >
						
						<!-- //alumni -->
						<?php
							$domain_alumni = array(
									"smkn6smg.fresto.co",
							);
							if (in_array(APP_SUBDOMAIN, $domain_alumni)){
						?>
						
							<table border="0" width="80%" cellspacing="5px">
								<tr>
									<td align="center">
										<?php include('link_alumni.php');?>
									</td>
								</tr>
							</table>
						<?php
							}
							
							
						?>
						
					<!-- //Pengumuman Kelulusan -->
					
					
						<table border="0" width="100%" cellspacing="5px">
							<tr>
								<td align="center">
									<div class="form-signin">
									<?php include('pengumuman_kelulusan.php');?>
									</div>
								</td>
							</tr>
						</table>
					
					
					
					  
						<table border="0" width="100%" cellspacing="5px">
							<tr>
								<td align="center">
									<div class="form-signin">
									<?php include('pengumuman.php');?>
									</div>
								</td>
							</tr>
						</table>
					
					</div>
				</div>
				
				<?php
				}
				?>
			</div>
			<?php //$this->load->view("bootswatch_cosmo/-html-/content/footer"); ?>
		</div>

		<!-- /container -->

		<!-- Le javascript ================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->

		
		<script type="text/javascript">
			
			$('#title').addClass('animated zoomInDown');
			function delayAnimation () {
				var animatedEl = document.getElementById('title');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'animated tada';
					setTimeout(delayAnimation, 5000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation, 3000);
			
			 $('#logo').addClass('animated flip');
			function delayAnimation2 () {
				var animatedEl = document.getElementById('logo');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'animated rubberBand';
					setTimeout(delayAnimation2, 5000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation2, 5000);
			
			 $('#alert').addClass('animated flip');
			function delayAnimation3 () {
				var animatedEl = document.getElementById('alert');
				animatedEl.className = 'alert alert-danger';
				setTimeout(function () {
					animatedEl.className = 'alert alert-danger animated flipInX';
					setTimeout(delayAnimation3, 8000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation3, 7000);
			/*
			setTimeout(function(){
						 
                         $('#logo').addClass('animated');
						 $("#logo").removeClass("animated");
						 $("#logo").removeClass("flip");
                    }, 3000);*/
			
			//$('#logo').addClass('animated infinite tada');
		</script>
	 <!-- </body></html> -->
</html>