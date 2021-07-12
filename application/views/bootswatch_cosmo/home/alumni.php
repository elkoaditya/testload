<?php
	$logo = NULL;

	if (APP_DOMAIN == 'localhost'):
		$logo = array(
				'src' => 'images/logo/theresiana_sma1.jpg',
				'width' => 280,
				'height' => 262,
		);

	elseif (APP_SUBDOMAIN == 'sman6smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);
		//redirect(base_url()."/elibrary");
	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);

	elseif (APP_SUBDOMAIN == 'sman8-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma8.jpg',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'sman9-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/Logo-sma-9-semarang.jpg',
				'width' => 120,
		);
		
	elseif (APP_SUBDOMAIN == 'sman14-smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo-sman14-smg.png',
				'width' => 180,
		);
	
	elseif (APP_SUBDOMAIN == 'smkn6smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smkn6smg.jpg',
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
	
	elseif (APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/smk-penerbad.png',
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
		
	//// ADDITIONAL
	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co/revisi'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
				'width' => 180,
		);
	endif;
	?>
            
<!DOCTYPE html>
<html lang="en">
	<!--<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login | <?php echo APP_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Fredy & Risto">

    <!-- Le styles -->
		<?php //echo link_tag("assets/bootstrap_2.3.2/css/bootstrap.css"); ?>
		<?php //echo link_tag("css/simple.css"); ?>
    <style type="text/css">
	   body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #f5f5f5;
				/*background-image: url('<?php echo base_url("images/background/green-abstract_00384241.jpg"); ?>');
				background-image: url('<?php echo base_url("images/background/Green-And-White-Wallpaper.jpg"); ?>');*/
				background-image: url('<?php echo base_url("images/background/green_abstract_1280x1024_wallpaper_Wallpaper_1280x1024_www.wallpaperswa.com.jpg"); ?>');
				background-size: 1500px;
				background-repeat: no-repeat;
				background-position: center -200px;
			}
			/*
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
				background-image: url('<?php echo ''; //base_url('images/ansa/zat.png');          ?>');
				background-repeat: no-repeat;
      }
			*/
	  .title {
	  	padding: 19px 29px 29px;
	 	background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
				-moz-border-radius: 5px;
				border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				-moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
				box-shadow: 0 1px 2px rgba(0,0,0,.05);
		}
      .form-signin {
        /*max-width: 300px;*/
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
	  
	  .arsip {
        padding:5px;
		text-align: center;
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
  <body>

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

    <div class="container">
    	<div align="center">

            <div class="page-header ">
                <h1>
					<?php echo TITLE_LOGIN;?>
				</h1>
            </div>
            <div class="row" >
  				<div class="span4">
                
					<table border="0" width="300px" cellspacing="5px">
						<tr>
							<td colspan="2" align="center">
					
						</td>
					</tr>
					<tr>
						<td>
					<?php
					$gets = (array) $this->input->get();
					$gets['redir'] = (string) $this->input->get_post('redir');
					echo form_opening($uri . array2qs($gets), 'class="form-signin"');

					if ($logo)
						echo div('align="center"', img($logo));
					?>
					<br/>
					<h3 class="form-signin-heading" align="center"><b>LOG - IN ALUMNI</b></h3>
					<?php echo alert_get(); ?>
					<input type="text" name="username" class="input-block-level" placeholder="ID Fresto">
					<input type="password" name="password" class="input-block-level" placeholder="Konfirmasi ID">
					<!--<button class="btn btn-large btn-primary" type="submit">Sign in</button>-->
					<input id="submit" type="submit" name="submit" class="btn btn-success" value=" Sign in "/>
					<br/>
					<br/>
					<div align="center"> <b>Fresto</b> learning system.</div>
					<?php echo form_close(); ?>
					
						</td>
					</tr>
				  </table>
          	</div>
          	
            <div class="span8" >
			 
            </div>
            
          </div>
          
          </div>     
		<?php //$this->load->view("bootswatch_cosmo/-html-/content/footer"); ?>
    </div> 
    
    <!-- /container -->

    <!-- Le javascript ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

		
	</body>
</html>