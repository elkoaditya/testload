<?php
	
	$pengumuman = 0;
	
	$logo = array(
			'src' => 'images/logo/'.APP_SCOPE.'/ganesha.png',
			'width' => 180,
	);
	
	
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
	
	//cek
	$app_baru = 1;
	/*if( ((date("H:i")>="06.35")&&(date("H:i")<"09.10"))||
		((date("H:i")>="09.10")&&(date("H:i")<"11.05"))||
		((date("H:i")>="11.05")&&(date("H:i")<="23.59"))||
		((date("H:i")>="00.00")&&(date("H:i")<"06.35")) ){
		$xed 	= MD5(date('d'))."K0aqp1as34df.".MD5(date('dmY')).".AYe21".MD5(MD5(date('Y')).date('H')).".ok.".MD5(date('dY').date('mY'))."laowf235";
		$zupe3r = date("idHYmi") ;
	}*/
	if( (date("H:i")>="06.35")||
		//((date("H:i")>="06.35")&&(date("H:i")<"09.10"))||
		//((date("H:i")>="09.10")&&(date("H:i")<"11.05"))||
		//((date("H:i")>="11.05")&&(date("H:i")<="23.59"))||
		((date("H:i")>="00.00")&&(date("H:i")<"06.35")) ){
		$xed = MD5(date('d'))."K0aqp1as34df.".MD5(date('dmY')).".AYe21".MD5(MD5(date('Y')).date('H')).".ok.".MD5(date('dY').date('mY'))."laowf235";
		$zupe3r = date("idHYmi") ;
	}else{
		$xed	='';
		$zupe3r ='';
	}
	
	if($data['xed'] == $xed){
		
		if($data['exam'] == 1){
			$exambrow = 1;
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
    <meta name="author" content="Fredy & Risto">

    <!-- Le styles -->
		<?php echo link_tag("assets/bootstrap_2.3.2/css/bootstrap.css"); ?>
		<?php echo link_tag("css/simple.css"); ?>
    <style type="text/css">
			
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
				background-image: url('<?php echo base_url('images/background/kisspng-education-clip-art-school-vector-graphics-portable-5ba3c9c8228be6.4464452815374606801415.png');?>');
				background-repeat: no-repeat;
				background-position: center center;
      }
			

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
				float: right;
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

  </head>

  <body>

    <div class="container">

			

			<?php
			$gets = (array) $this->input->get();
			$gets['redir'] = (string) $this->input->get_post('redir');
			echo form_opening($uri . array2qs($gets), 'class="form-signin"');

			if ($logo)
				echo div('align="center"', img($logo));
			?>
			<h2 class="form-signin-heading" align="center"><?=TITLE_LOGIN?></h2>
			<?php echo alert_get(); ?>
			<?php 
			if($exambrow == 1){ 
				//echo $exambrow;
				?>
				<input type="hidden" name="logint" value="ok">
				<?php 
			} ?>
			<input type="text" name="username" class="input-block-level" placeholder="Username">
			<input type="password" name="password" class="input-block-level" placeholder="Password">
			<button class="btn btn-large btn-primary" type="submit">Sign in</button>
			<?php echo form_close(); ?>

    </div> <!-- /container -->

    <!-- Le javascript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

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

	</body>
</html>
