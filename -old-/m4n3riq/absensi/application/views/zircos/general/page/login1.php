<!DOCTYPE html>
<html>
    
<!-- Mirrored from coderthemes.com/zircos_1.6/menu_2_md/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2017 23:55:11 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?=base_url();?>assets/images/favicon.ico">
        <!-- App title -->
        <title>Zircos - Responsive Admin Dashboard Template</title>

		 <!-- Animated css -->
        <link href="<?=base_url();?>plugins/animate/animate.min.css" rel="stylesheet" type="text/css" />
		
        <!-- App css -->
        <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?=base_url();?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?=base_url();?>assets/js/modernizr.min.js"></script>
<script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','../../../www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-83057131-1', 'auto');
          ga('send', 'pageview');

        </script>

    </head>


    <body class="bg-transparent">

        <!-- HOME -->
        <section>
            <div class="container-alt">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="m-t-40 account-pages" id="title_page">
                                <div class="text-center account-logo-box">
                                    <h2 class="text-uppercase">
                                        <a href="<?=base_url();?>dashboard/login" class="text-success">
                                            <span><img src="<?=base_url();?>assets/images/logo.png" alt="" height="36"></span>
                                        </a>
                                    </h2>
                                    <!--<h4 class="text-uppercase font-bold m-b-0">Sign In</h4>-->
                                </div>
                                <div class="account-content">
                                    <form class="form-horizontal" action="<?=base_url();?>dashboard/login/verifikasi" method="post">

                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="text" required="" placeholder="Username" name="username" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12">
                                                <input class="form-control" type="password" required="" placeholder="Password" name="password" required>
                                            </div>
                                        </div>
										<!--
                                        <div class="form-group ">
                                            <div class="col-xs-12">
                                                <div class="checkbox checkbox-success">
                                                    <input id="checkbox-signup" type="checkbox" checked>
                                                    <label for="checkbox-signup">
                                                        Remember me
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
										
                                        <div class="form-group text-center m-t-30">
                                            <div class="col-sm-12">
                                                <a href="<?=base_url();?>page-recoverpw.html" class="text-muted"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                                            </div>
                                        </div>
-->
                                        <div class="form-group account-btn text-center m-t-10" >
                                            <div class="col-xs-12">
                                                <button id="button" class="btn w-md btn-bordered btn-success waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>

                                    </form>

                                    <div class="clearfix"></div>

                                </div>
                            </div>
                            <!-- end card-box


                            <div class="row m-t-50">
                                <div class="col-sm-12 text-center">
                                    <p class="text-muted">Don't have an account? <a href="<?=base_url();?>page-register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                                </div>
                            </div>-->

                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
          </section>
          <!-- END HOME -->

        <script>
            var resizefunc = [];
			
			function nowAnimation($var,$jenis_animasi) {
				$("#"+$var).addClass("animated "+$jenis_animasi);
			}
			function delayAnimation($var,$jenis_animasi,$delay_time) {
				$delay_time = typeof $delay_time !== 'undefined' ? $delay_time : 4000;
				var animatedEl = document.getElementById($var);
				animatedEl.className = animatedEl.className.replace(" animated","");
				animatedEl.className = animatedEl.className.replace(" "+$jenis_animasi,"");
				//animatedEl.className = '';
				setTimeout(function () {
					animatedEl.className += " animated "+$jenis_animasi;
					//animatedEl.className = 'btn btn-primary btn-sm animated rubberBand';
					setTimeout(function(){delayAnimation($var,$jenis_animasi)}, $delay_time);// i see 2.4s is your animation duration
				}, 500)// wait 0.5s
			}
			
			setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
			setTimeout(function(){delayAnimation('button','rubberBand')},3000);
			
        </script>

        <!-- jQuery  -->
        <script src="<?=base_url();?>assets/js/jquery.min.js"></script>
        <script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?=base_url();?>assets/js/detect.js"></script>
        <script src="<?=base_url();?>assets/js/fastclick.js"></script>
        <script src="<?=base_url();?>assets/js/jquery.blockUI.js"></script>
        <script src="<?=base_url();?>assets/js/waves.js"></script>
        <script src="<?=base_url();?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?=base_url();?>assets/js/jquery.scrollTo.min.js"></script>

		<script src="<?=base_url();?>plugins/switchery/switchery.min.js"></script>
		
        <!-- App js -->
        <script src="<?=base_url();?>assets/js/jquery.core.js"></script>
        <script src="<?=base_url();?>assets/js/jquery.app.js"></script>

    </body>

<!-- Mirrored from coderthemes.com/zircos_1.6/menu_2_md/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2017 23:55:11 GMT -->
</html>