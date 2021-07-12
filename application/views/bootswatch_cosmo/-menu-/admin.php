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
					<?php echo li('', a('', 'Dashboard', ' id="swatch-link"')); ?>
					<?php echo li('', a('app/config', 'Config', ' id="swatch-link"')); ?>
					
                    <li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Tool <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?= li('', a('app/tool/reset_password_sdm', 'Reset password Guru', ' id="swatch-link" title="reset password login sdm dan guru"')); ?>
							<?= li('', a('app/tool/reset_password_siswa', 'Reset password Siswa', ' id="swatch-link" title="reset password login siswa"')); ?>
							<?= li('', a('app/tool/siswa_login', 'Siswa Login', ' id="swatch-link" title="daftar siswa login"')); ?>
							<?= li('', a('app/tool/check_token', 'Check Token', ' id="swatch-link" title="token akses evaluasi"')); ?>
						</ul>
					</li>

					<?php //echo li('', a('modul/kurikulum', 'Kurikulum', ' id="swatch-link"')); ?>
					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Kurikulum <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							$CI =& get_instance();
							$CI->load->model('m_modul_kurikulum');
							$modul_kurikulum = $CI->m_modul_kurikulum->modul_kurikulum(0, 50 , '', 'lihat', $user['role']);
							
							
							//print_r($modul_kurikulum);
							foreach($modul_kurikulum['data'] as $mk){
								echo li('', a('modul/kurikulum/browse/'.$mk['kode'], $mk['nama']));
							}
							/*
							echo li('', a('modul/kurikulum/browse/kaldik', 'Kalender Akademik'));
							echo li('', a('modul/kurikulum/browse/jadwal', 'Jadwal'));
							echo li('', a('modul/kurikulum/browse/rpp', 'RPP'));
							echo li('', a('modul/kurikulum/browse/silabus', 'Silabus'));
							echo li('', a('modul/kurikulum/browse/prota', 'Prota'));
							echo li('', a('modul/kurikulum/browse/promes', 'Promes'));
							echo li('', a('modul/kurikulum/browse/kkm', 'KKM'));
							echo li('', a('modul/kurikulum/browse/kikd', 'KI/KD'));*/
							
							?>
						</ul>
					</li>
					
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data <b class="caret"></b></a>
						<ul class="dropdown-menu" id="swatch-menu">
							<?php

							echo li('', a('data/user', 'User'));

							echo li('class="nav-header"', 'Profil');
							echo li('', a('data/profil/admin', 'Admin'));
							echo li('', a('data/profil/sdm', GURU_ALIAS . ' &amp; SDM'));
							echo li('', a('data/profil/siswa', 'Siswa'));
							//echo li('', a('data/profil/wali', 'Wali'));

							echo li('class="nav-header"', 'Akademik');
							echo li('', a('data/akademik/jurusan', 'Jurusan'));
							echo li('', a('data/akademik/kelas', 'Kelas'));
							echo li('', a('data/akademik/kategori_mapel', 'Kategori Mapel'));
							echo li('', a('data/akademik/mapel', 'Mapel'));
							echo li('', a('data/akademik/kompetensi_dasar', 'Kompetensi Dasar'));
							echo li('', a('data/akademik/pelajaran', 'Pelajaran'));

							echo li('class="nav-header"', 'Non Akademik');
							echo li('', a('data/non_akademik/ekstrakurikuler', 'Ekstrakurikuler'));
							echo li('', a('data/non_akademik/organisasi', 'Organisasi'));
							echo li('', a('data/non_akademik/prestasi', 'Prestasi'));

							echo li('class="nav-header"', 'Master');
							echo li('', a('data/master/jabatan', 'Jabatan'));
							//echo li('', a('data/master/kota', 'Kota'));

							?>
						</ul>
					</li>

					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">KBM <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('', a('kbm/vidcall', 'Video Call'));
							echo li('', a('kbm/materi', 'Materi'));
							echo li('', a('kbm/evaluasi', 'Evaluasi'));
							echo li('', a('kbm/bank_soal', 'Bank Soal'));
							echo li('', a('kbm/artikel', 'Artikel'));
							//echo li('', a('kbm/jurnal_kelas', 'Jurnal kelas'));
							//echo li('', a('kbm/absensi', 'Absensi'));
							echo li('', a('kbm/angket', 'Angket'));

							?>
						</ul>
					</li>

					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Nilai <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php

							echo li('class="nav-header"', 'Akademik');
							echo li('', a('nilai/kelas', 'Kelas'));
							echo li('', a('nilai/pelajaran', 'Pelajaran'));
							echo li('', a('nilai/siswa', 'Siswa'));

							echo li('class="nav-header"', 'Non-Akademik');
							echo li('', a('nilai/ekstrakurikuler', 'Ekstrakurikuler'));
							echo li('', a('nilai/organisasi', 'Organisasi'));
							echo li('', a('nilai/prestasi', 'Prestasi'));
							
							echo li('class="nav-header"', 'E-rapor');
							echo li('', a('nilai/erapor', 'Isi Excel'));

							?>

						</ul>
					</li>

					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
							echo li('class="nav-header"', 'Guru');
							echo li('', a('laporan/ajar_guru/hari', 'Mengajar PerHari'));
							echo li('', a('laporan/ajar_guru/minggu', 'Mengajar PerMinggu'));
							echo li('', a('laporan/ajar_guru/bulan', 'Mengajar PerBulan'));
							echo li('', a('laporan/ajar_guru/semester', 'Mengajar PerSemester'));
							
							echo li('class="nav-header"', 'Siswa');
							echo li('', a('laporan/belajar_siswa/hari', 'Belajar PerHari'));
							echo li('', a('laporan/belajar_siswa/minggu', 'Belajar PerMinggu'));
							echo li('', a('laporan/belajar_siswa/bulan', 'Belajar PerBulan'));
							echo li('', a('laporan/belajar_siswa/semester', 'Belajar PerSemester'));
							?>
						</ul>
					</li>
					
					<li class="dropdown" id="preview-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">Periode <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php

							//echo li('', a('periode/ta', 'Tahun Ajaran', ' id="swatch-link" title="periode tahun ajaran / akademik"'));
							echo li('', a('periode/semester', 'Semester', ' id="swatch-link" title="periode semester akademik"'));

							?>
						</ul>
					</li>

				</ul>

				<ul class="nav pull-right" id="main-menu-right">
					<li class="dropdown" id="user-menu">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $d['user']['display_name']; ?>  <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php

							echo li('', a("data/profil/{$d['user']['role']}/id/{$d['user']['id']}", 'Profil'));
							echo li('', a("data/user/id/{$d['user']['id']}", 'Akun'));
							echo li('', a("logout", 'Logout'));

							?>
						</ul>
					</li>
				</ul>

			</div>
		</div>
	</div>
</div>
