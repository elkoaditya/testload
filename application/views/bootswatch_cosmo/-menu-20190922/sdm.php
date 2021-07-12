<?php
$d = $this->d;
$cadmin_duser = cfguc_view('akses', 'data', 'user');
$cadmin_dakd_jurusan = cfguc_admin('akses', 'data', 'akademik', 'jurusan');
$cadmin_dakd_mapel = cfguc_admin('akses', 'data', 'akademik', 'mapel');
$cadmin_dnakd_aspri = cfguc_admin('akses', 'data', 'non_akademik', 'aspri');
$cview_kbm_absen = cfguc_view('akses', 'kbm', 'absen');
$cview_nilbi = cfguc_view('akses', 'nilai', 'buku_induk');
$cview_rkelas = cfguc_view('akses', 'nilai', 'kelas');
$cview_rpelajaran = cfguc_view('akses', 'nilai', 'pelajaran');
$cview_rsiswa = cfguc_view('akses', 'nilai', 'siswa');
$cview_org = cfguc_view('akses', 'nilai', 'organisasi');
$cview_ekskul = cfguc_view('akses', 'nilai', 'ekskul');
$walikelas = cfgu('walikelas');
$pengajar = cfgu('mengajar_list');
$pembina_org = cfguc('pembina', 'organisasi');
$pembina_ekskul = cfguc('pembina', 'ekskul');
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
					
                    <?php echo li('', a('app/tool/siswa_login', 'Daftar_Siswa_Login', ' id="swatch-link" title="daftar siswa login"')); ?>
                    <?php echo li('', a('modul/kurikulum', 'Kurikulum', ' id="swatch-link"')); ?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data <b class="caret"></b></a>
						<ul class="dropdown-menu" id="swatch-menu">
							<?php
							if ($cadmin_duser)
								echo li('', a('data/user', 'User'));

							echo li('class="nav-header"', 'Profil');
							echo li('', a('data/profil/sdm', GURU_ALIAS . ' &amp; SDM'));
							echo li('', a('data/profil/siswa', 'Siswa'));

							echo li('class="nav-header"', 'Akademik');
							
							if ($cadmin_dakd_jurusan)
								echo li('', a('data/akademik/jurusan', 'Jurusan'));

							echo li('', a('data/akademik/kelas', 'Kelas'));

							if ($cadmin_dakd_mapel):
								echo li('', a('data/akademik/kategori_mapel', 'Kategori Mapel'));
								echo li('', a('data/akademik/mapel', 'Mapel'));
							endif;
							echo li('', a('data/akademik/kompetensi_dasar', 'Kompetensi Dasar'));
							
							echo li('', a('data/akademik/pelajaran', 'Pelajaran'));
							?>
						</ul>
					</li>
					<!--
					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">KBM <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('', a('kbm/materi', 'Materi'));
							echo li('', a('kbm/evaluasi', 'Evaluasi'));
							
							echo li('', a('kbm/artikel', ((GURU_ALIAS == 'Tutor') ? 'Spotcapturing' : 'Artikel')));
							echo li('', a('kbm/angket', 'Angket'));
							if ($pengajar):
								echo li('class="nav-header"', 'Form Pengajar');
								echo li('', a('kbm/materi/form', 'Materi baru'));
								echo li('', a('kbm/evaluasi/form', 'Evaluasi baru'));
								echo li('', a('kbm/angket/form', 'Angket baru'));
							endif;
							?>
						</ul>
					</li>
					-->
					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Nilai <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('class="nav-header"', 'Akademik');

							if ($cview_rkelas OR $walikelas)
								echo li('', a('nilai/kelas', 'Kelas'));

							if ($pengajar)
								echo li('', a('nilai/pelajaran', 'Pelajaran'));

							if ($cview_rkelas OR $walikelas)
								echo li('', a('nilai/siswa', 'Siswa'));

							echo li('class="nav-header"', 'Non-Akademik');
							echo li('', a('nilai/ekstrakurikuler', 'Ekstrakurikuler'));
							echo li('', a('nilai/organisasi', 'Organisasi'));
							?>

						</ul>
					</li>

					<?php echo li('', a('kbm/materi', 'Materi')); ?>
					<?php echo li('', a('kbm/evaluasi', 'Evaluasi')); ?>
					<?php echo li('', a('kbm/bank_soal', 'Bank Soal')); ?>
					<?php //echo li('', a('kbm/artikel', ((GURU_ALIAS == 'Tutor') ? 'Spotcapturing' : 'Artikel'))); ?>
                    <?php //echo li('', a('kbm/angket', 'Angket')); ?>
					
                    <?php 
					if ($cview_rkelas OR $walikelas):
						//echo li('', a('kbm/kenaikan_kelas', 'Kenaikan Kelas'));
					endif; ?>

				</ul>

				<ul class="nav pull-right" id="main-menu-right">
					<li class="dropdown" id="user-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo GURU_ALIAS; ?> <b class="caret"></b></a>
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
