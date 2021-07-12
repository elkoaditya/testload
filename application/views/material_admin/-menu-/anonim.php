<?php $d = $this->d; ?>
<!-- Navbar
	================================================== -->
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="#"><strong><?php echo APP_TITLE; ?></strong></a>
			<div class="nav-collapse in collapse" id="main-menu" style="height: auto;">
				<ul class="nav" id="main-menu-left">
					<?php echo li('', a('login', 'Login', ' id="swatch-link"')); ?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data <b class="caret"></b></a>
						<ul class="dropdown-menu" id="swatch-menu">
							<?php
							echo li('class="nav-header"', 'Profil');
							echo li('', a('data/profil/sekolah', 'Sekolah'));
							echo li('', a('data/profil/sdm', GURU_ALIAS . ' &amp; SDM'));

							echo li('class="nav-header"', 'Akademik');
							echo li('', a('data/akademik/jurusan', 'Jurusan'));
							echo li('', a('data/akademik/mapel', 'Mapel'));

							echo li('class="nav-header"', 'Non Akademik');
							echo li('', a('data/non_akademik/ekstrakurikuler', 'Ekstrakurikuler'));
							echo li('', a('data/non_akademik/organisasi', 'Organisasi'));
							?>
						</ul>
					</li>

				</ul>

			</div>
		</div>
	</div>
</div>
