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
			<a class="brand" href="#"><strong>ANSA SPOT CAPTURE</strong></a>
			<div class="nav-collapse in collapse" id="main-menu" style="height: auto;">
				<ul class="nav" id="main-menu-left">
					<?php echo li('', a('', 'Dashboard', ' id="swatch-link"')); ?>
                    <?php echo li('', a('modul/kurikulum', 'Kurikulum', ' id="swatch-link"')); ?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data <b class="caret"></b></a>
						<ul class="dropdown-menu" id="swatch-menu">
							<?php
							echo li('class="nav-header"', 'Profil');
							echo li('', a('data/profil/sdm', GURU_ALIAS . ' &amp; SDM'));
							echo li('', a('data/profil/siswa', 'Siswa'));
							echo li('', a('data/profil/wali', 'Wali'));

							echo li('class="nav-header"', 'Akademik');
							echo li('', a('data/akademik/jurusan', 'Jurusan'));
							echo li('', a('data/akademik/kelas', 'Kelas'));
							echo li('', a('data/akademik/mapel', 'Mata pelajaran'));
							echo li('', a('data/akademik/pelajaran', 'Pelajaran'));

							echo li('class="nav-header"', 'Non Akademik');
							echo li('', a('data/non_akademik/ekstrakurikuler', 'Ekstrakurikuler'));
							echo li('', a('data/non_akademik/organisasi', 'Organisasi'));
							?>
						</ul>
					</li>

					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">KBM <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('', a('kbm/materi', 'Materi'));
							echo li('', a('kbm/evaluasi', 'Evaluasi'));
							echo li('', a('kbm/jurnal_kelas', 'Jurnal kelas'));
							echo li('', a('kbm/absensi', 'Absensi'));
							?>
						</ul>
					</li>

					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Nilai <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('', a('nilai/buku_induk', 'Buku induk'));

							echo li('class="nav-header"', 'Tahunan');
							echo li('', a('nilai/tahunan/kelas', 'Kelas'));
							echo li('', a('nilai/tahunan/pelajaran', 'Pelajaran'));
							echo li('', a('nilai/tahunan/siswa', 'Siswa'));

							echo li('class="nav-header"', 'Semester');
							echo li('', a('nilai/kelas', 'Kelas'));
							echo li('', a('nilai/pelajaran', 'Pelajaran'));
							echo li('', a('nilai/siswa', 'Siswa'));
							?>

						</ul>
					</li>

				</ul>

				<ul class="nav pull-right" id="main-menu-right">
					<li class="dropdown" id="user-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $d['user']['display_name']; ?>  <b class="caret"></b></a>
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
