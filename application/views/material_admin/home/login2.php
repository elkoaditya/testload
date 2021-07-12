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
				background-image: url('<?php echo base_url("images/background/abstraction_green_white_line_369_1600x1200.jpg"); ?>');
				background-repeat: no-repeat;
				background-position: top center;
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

  <!--</head>-->
  <?php $this->load->view("bootswatch_cosmo/-html-/head"); ?>
  <body>

    <div class="container">
    	<div align="center">

            <div class="page-header">
                <h1>
					SMA N 1 SEMARANG
				</h1>
            </div>
			<table border="0" width="300px" cellspacing="5px">
				<tr>
					<td colspan="2" align="center">
			<?php
			$logo = NULL;

			if (APP_DOMAIN == 'localhost'):
				$logo = array(
						'src' => 'images/logo/theresiana_sma1.jpg',
						'width' => 280,
						'height' => 262,
				);

			elseif (APP_DOMAIN == 'anugrahbangsa.fresto.co'):
				$logo = array(
						'src' => 'images/logo/anugrahbangsa.png',
						'width' => 232,
						'height' => 263,
				);

			elseif (APP_DOMAIN == 'smapldonbosko.fresto.co'):
				$logo = array(
						'src' => 'images/bosko/logo.jpg',
						'width' => 200,
						'height' => 240,
				);

			elseif (APP_DOMAIN == 'theresiana.fresto.co'):
				$logo = array(
						'src' => 'images/logo/theresiana_sma1.jpg',
						'width' => 280,
						'height' => 262,
				);

			elseif (APP_DOMAIN == 'sman1-smg.fresto.co'):
				$logo = array(
						'src' => 'content/sma1_smg/Logo SMA1.jpg',
						'width' => '50%',
				);

			endif;
			?>
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
			<br/><br/>
			<b>SISTEM AKAN DI BUKA JAM 08.00</b>
            
			<?php echo form_close(); ?>
            <br>Selamat datang di <b>Fresto</b> learning system.
            	</td>
            </tr>
          </table>
          </div>     
		<?php $this->load->view("bootswatch_cosmo/-html-/content/footer"); ?>
    </div> 
    
    <!-- /container -->

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