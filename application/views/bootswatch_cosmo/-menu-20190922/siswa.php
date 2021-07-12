<?php 
$d = $this->d; 
$setview = 0;
if(isset($user['kelas_id'])){
	if($user['kelas_id'] > 0){
		$setview = 1;
	}
}
?>
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
					<?php echo li('', a('', 'Dashboard', ' id="swatch-link"')); ?>
					<?php if($setview == 1){ ?> 
						<?php echo li('', a('modul/kurikulum', 'Kurikulum', ' id="swatch-link"')); ?>
						<?php
						if(APP_SCOPE=='sman8smg') 
						{	echo li('', a('nilai/siswa/pengumuman_rapor', 'Rapor', ' id="swatch-link"')); }?>
						<?php 
						//print_r($user);
						/*
						if($user['grade'] == '12')
						{	echo li('', a('nilai/siswa/pengumuman_kelulusan', 'Kelulusan', ' id="swatch-link"'));  };*/ ?>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data <b class="caret"></b></a>
							<ul class="dropdown-menu" id="swatch-menu">
								<?php
								echo li('class="nav-header"', 'Profil');
								echo li('', a('data/profil/sdm', GURU_ALIAS . ' &amp; SDM'));
								echo li('', a('data/profil/siswa', 'Siswa'));

								echo li('class="nav-header"', 'Akademik');
								echo li('', a('data/akademik/kelas', 'Kelas'));
								echo li('', a('data/akademik/pelajaran', 'Pelajaran'));
								?>
							</ul>
						</li>

						<li class="dropdown" id="preview-menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">KBM <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<?php
								echo li('', a('kbm/materi', 'Materi'));
								echo li('', a('kbm/evaluasi', 'Evaluasi'));
								echo li('', a('kbm/artikel', ((GURU_ALIAS == 'Tutor') ? 'Spotcapturing' : 'Artikel')));
								echo li('', a('kbm/angket', 'Angket'));
								?>
							</ul>
						</li>

						<?php //echo li('', a('kbm/materi', 'Materi')); ?>
						<?php echo li('', a('kbm/evaluasi', 'Evaluasi')); ?>
						<?php //echo li('', a('kbm/artikel', ((GURU_ALIAS == 'Tutor') ? 'Spotcapturing' : 'Artikel'))); ?>
						<?php //echo li('', a('kbm/angket', 'Angket')); ?>
					<?php } ?>
				</ul>

				<ul class="nav pull-right" id="main-menu-right">
					<li class="dropdown" id="user-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $d['user']['nama']; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('', a("", 'Profil'));
							echo li('', a("logout", 'Logout'));
							?>
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>
