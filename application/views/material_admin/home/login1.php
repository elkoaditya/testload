<?php
	$logo = NULL;

	if (APP_DOMAIN == 'localhost'):
		$logo = array(
				'src' => 'images/logo/theresiana_sma1.jpg',
				'width' => 280,
				'height' => 262,
		);

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
		
	elseif (APP_SUBDOMAIN == 'smaterbang.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/sma-terang-bangsa.png',
				'width' => 180,
		);
		
	elseif (APP_SUBDOMAIN == 'smamichael.smg.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/Logo SMA santo michael.jpg',
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
				
	elseif (APP_SUBDOMAIN == 'demo.fresto.co'):
		$logo = array(
				'src' => 'images/logo/'.APP_SCOPE.'/logo fresto g2.png',
				'width' => 180,
				
		);
		
	endif;
	?>
<!DOCTYPE html>
<html class="login-content" data-ng-app="materialAdmin">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Login | <?php echo APP_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Team Fresto">
	<?php include "/var/www/fresto.co/master_fresto_v2_01/assets/material_admin/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.php";?> 
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

    <!-- CSS -->
    <?php include "/var/www/fresto.co/master_fresto_v2_01/assets/material_admin/css/app.php";?>
    <link href="<?php echo base_url("assets/material_admin"); ?>/css/app.min.1.css" rel="stylesheet">
    <link href="<?php echo base_url("assets/material_admin"); ?>/css/app.min.2.css" rel="stylesheet">
 
 	<style>
	/*div {
		-webkit-animation: mymove 2s infinite; 
		-webkit-animation-delay: 3s; 
		animation: mymove 2s infinite;
		animation-delay: 3s;
	}*/
	</style>
   <body class="login-content" data-ng-controller="loginCtrl as lctrl">
	


        <!-- Login -->
        <div class="lc-block" id="l-login" data-ng-class="{ 'toggled': lctrl.login === 1 }" data-ng-if="lctrl.login === 1">
         <form action="<?php echo base_url().$uri;?>"	method="post" accept-charset="utf-8">
            
            <table width="100%">
             <tr>
              <td align="center" style="font-family: roboto;"><div id="title"><h1><?php echo TITLE_LOGIN;?></h1></h1>
              </td>
             </tr>
             <tr>
              <td align="center"><div id="logo"><?=img($logo);?></div></td>
             </tr>
            </table>
            <?php echo alert_get(); ?>
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" name="username"  placeholder="Username">
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" name="password"  placeholder="Password">
                </div>
            </div>

            <div class="clearfix"></div>

            <!--<div class="checkbox">
                <label>
                    <input type="checkbox" value="">
                    <i class="input-helper"></i>
                    Keep me signed in
                </label>
            </div>-->

            <button id="submit" type="submit" name="submit" data-growl-demo data-type="danger" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></button>
<!--
            <ul class="login-navigation">
                <li data-block="#l-register" class="bgm-red" data-ng-click="lctrl.login = 0; lctrl.register = 1">Register</li>
                <li data-block="#l-forget-password" class="bgm-orange" data-ng-click="lctrl.login = 0; lctrl.forgot = 1">Forgot Password?</li>
            </ul>
-->
		 </form>
        </div>

        <!-- Register -->
        <div class="lc-block" id="l-register" data-ng-class="{ 'toggled': lctrl.register === 1 }" data-ng-if="lctrl.register === 1">
            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Username">   
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
                <div class="fg-line">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="checkbox">
                <label>
                    <input type="checkbox" value="">
                    <i class="input-helper"></i>
                    Accept the license agreement
                </label>
            </div>

            <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>

            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green" data-ng-click="lctrl.register = 0; lctrl.login = 1">Login</li>
                <li data-block="#l-forget-password" class="bgm-orange" data-ng-click="lctrl.register = 0; lctrl.forgot = 1">Forgot Password?</li>
            </ul>
        </div>

        <!-- Forgot Password -->
        <div class="lc-block" id="l-forget-password" data-ng-class="{ 'toggled': lctrl.forgot === 1 }" data-ng-if="lctrl.forgot === 1">
            <p class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla enim feugiat commodo sed ac lacus.</p>

            <div class="input-group m-b-20">
                <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                <div class="fg-line">
                    <input type="text" class="form-control" placeholder="Email Address">
                </div>
            </div>

            <a href="" class="btn btn-login btn-danger btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>

            <ul class="login-navigation">
                <li data-block="#l-login" class="bgm-green" data-ng-click="lctrl.forgot = 0; lctrl.login = 1">Login</li>
                <li data-block="#l-register" class="bgm-red" data-ng-click="lctrl.forgot = 0; lctrl.register = 1">Register</li>
            </ul>
        </div>
        
        
        
        <!-- Core -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/jquery/dist/jquery.min.js"></script>

        <!-- Angular -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular/angular.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-resource/angular-resource.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-animate/angular-animate.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-resource/angular-resource.min.js"></script>
		
        
        <!-- Angular Modules -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-loading-bar/src/loading-bar.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/oclazyload/dist/ocLazyLoad.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
		
        
        <!-- Common Vendors -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/Waves/dist/waves.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/angular-nouislider/src/nouislider.min.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/vendors/bower_components/ng-table/dist/ng-table.min.js"></script>
		
        
        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
                
        <!-- App level -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/app.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/config.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/controllers/main.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/services.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/templates.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/controllers/ui-bootstrap.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/controllers/table.js"></script>


        <!-- Template Modules -->
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/modules/template.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/modules/ui.js"></script>
        <script src="<?php echo base_url("assets/material_admin"); ?>/js/modules/form.js"></script>
    	
    	<script type="text/javascript">
			
			$('#title').addClass('animated zoomInDown');
			function delayAnimation () {
				var animatedEl = document.getElementById('title');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className = 'animated tada';
					setTimeout(delayAnimation, 8000);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			setTimeout(delayAnimation, 3000);
			
			 $('#logo').addClass('animated flip');
			function delayAnimation2 () {
				var animatedEl = document.getElementById('logo');
				animatedEl.className = '';
				setTimeout(function () {
					animatedEl.cl