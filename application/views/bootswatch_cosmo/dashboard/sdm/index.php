<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => GURU_ALIAS . ' & SDM')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80" style="padding-top: 100px; margin-top: 36px;">

		<?php $this->load->view(THEME . "/-menu-/{$user['role']}"); ?>

    <div class="container">


			<!-- Masthead
			================================================== -->
			<header class="jumbotron subhead" id="overview">
				<div class="row">
					<div class="span6">
						<h1>Fresto</h1>
						<p class="lead">learning system</p>
					</div>
					<div class="span6">
						<div class="bsa well">
							<div id="bsap_1277971" class="bsap_1277971 bsap">
								<div class="bsa_it one">
									<div class="bsa_it_ad ad1 odd" id="bsa_3590370" align="center">
										<span class="bsa_it_i"><?php echo img('images/logo/sman8smg.jpg'); ?></span>
										<h3> SMA N 8 Semarang</h3>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="subnav subnav-fixed">
					<ul class="nav nav-pills">
						<li class=""><a href="#typography">Typography</a></li>
						<li class="active"><a href="#navbar">Navbar</a></li>
					</ul>
				</div>
			</header>

			<?php echo alert_get(); ?>

			<!-- Typography	================================================== -->
			<section id="typography">
				<div class="page-header">
					<h1>Typography</h1>
				</div>
				<p>contoh teks</p>

			</section>


			<!-- Navbar			================================================== -->
			<section id="navbar">
				<div class="page-header">
					<h1>Navbars</h1>
				</div>

				<p>contoh teks</p>

			</section>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>