<?php $d = $this->d; ?>
     <aside id="sidebar" class="sidebar c-overflow">
        <div class="s-profile">
            <a href="" data-ma-action="profile-menu-toggle">
                <div class="sp-pic">
                    <img src="<?php echo base_url("assets/material_admin");?>/img/demo/profile-pics/1.jpg" alt="">
                </div>

                <div class="sp-info">
                    <?php echo $d['user']['display_name']; ?>

                    <i class="zmdi zmdi-caret-down"></i>
                </div>
            </a>

            <ul class="main-menu">
                <li>
                    <a href="<?php echo base_url("data/profil/{$d['user']['role']}/id/{$d['user']['id']}"); ?>"><i class="zmdi zmdi-account"></i> View Profile</a>
                </li>
                <li>
                    <a href="<?php echo base_url("logout"); ?>"><i class="zmdi zmdi-time-restore"></i> Logout</a>
                </li>
            </ul>
        </div>

        <ul class="main-menu">
           
            <li class="active">
                <a href="<?php echo base_url(); ?>"><i class="zmdi zmdi-home"></i> Home</a>
            </li>
			
			<li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-wrench"></i> Pengaturan</a>

                <ul>
                    <li><a href="<?php echo base_url("data/non_akademik/ekstrakurikuler"); ?>">Konfigurasi</a></li>
                    <li><a href="<?php echo base_url("nilai/ekstrakurikuler"); ?>">Siswa Login</a></li>
                    <li><a href="<?php echo base_url("nilai/ekstrakurikuler"); ?>">Reset Pass Guru</a></li>
                    <li><a href="<?php echo base_url("nilai/ekstrakurikuler"); ?>">Reset Pass Siswa</a></li>
                </ul>
            </li>
            
            <li>
                <a href="<?php echo base_url("data/profil/admin"); ?>"><i class="zmdi zmdi-account"></i> Admin</a>
            </li>
            
            <li>
                <a href="<?php echo base_url("data/profil/sdm"); ?>"><i class="zmdi zmdi-accounts"></i> Guru / Pegawai</a>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-outline"></i> Siswa</a>

                <ul>
                    <li><a href="<?php echo base_url("data/profil/siswa"); ?>">Daftar Siswa</a></li>
                    <li><a href="<?php echo base_url("nilai/siswa"); ?>">Nilai Siswa</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-bookmark"></i> Kelas</a>

                <ul>
                    <li><a href="<?php echo base_url("data/akademik/kelas"); ?>">Daftar Kelas</a></li>
                    <li><a href="<?php echo base_url("nilai/kelas"); ?>">Nilai Kelas</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-book"></i>Pelajaran</a>

                <ul>
                    <li><a href="<?php echo base_url("data/akademik/kategori_mapel"); ?>">Kategori Mapel</a></li>
                    <li><a href="<?php echo base_url("data/akademik/mapel"); ?>">Daftar Mapel</a></li>
                    <li><a href="<?php echo base_url("data/akademik/pelajaran"); ?>">Daftar Pelajaran Guru</a></li>
                    <li><a href="<?php echo base_url("nilai/pelajaran"); ?>">Nilai Pelajaran</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-library"></i> Materi & Evaluasi</a>

                <ul>
                    <li><a href="<?php echo base_url("kbm/materi"); ?>"> Materi</a></li>
                   <li> <a href="<?php echo base_url("kbm/evaluasi"); ?>"> Evaluasi</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-directions-bike"></i> Ekstrakurikuler</a>

                <ul>
                    <li><a href="<?php echo base_url("data/non_akademik/ekstrakurikuler"); ?>">Daftar Ekstrakurikuler</a></li>
                    <li><a href="<?php echo base_url("nilai/ekstrakurikuler"); ?>">Nilai Ekstrakurikuler</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-mall"></i> Organisasi</a>

                <ul>
                    <li><a href="<?php echo base_url("data/non_akademik/organisasi"); ?>">Daftar Organisasi</a></li>
                    <li><a href="<?php echo base_url("nilai/organisasi"); ?>">Nilai Organisasi</a></li>
                </ul>
            </li>
            
            <li class="sub-menu">
                <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-star-outline"></i> Prestasi</a>

                <ul>
                    <li><a href="<?php echo base_url("data/non_akademik/organisasi"); ?>">Daftar Prestasi</a></li>
                    <li><a href="<?php echo base_url("nilai/organisasi"); ?>">Nilai Prestasi</a></li>
                </ul>
            </li>
            
            <li>
                <a href="<?php echo base_url("periode/semester"); ?>"><i class="zmdi zmdi-calendar-check"></i>Periode Semester</a>
            </li>
            
            <li>
                <a href="#"></a>
            </li>
            
        </ul>
    </aside>

            
