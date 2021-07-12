<?php
// vars

$ringkas = (strtolower($this->input->get_post('ringkas')) === 'ya');
$toggle_label = ($ringkas) ? 'Profil Ringkas' : 'Profil Detail';

// function

function disnil_link($row) {
	return a("nilai/siswa/id/{$row['id']}", 'nilai', "title=\"lihat detail nilai\"");
}

function disnil_kelas($row) {
	return a("data/akademik/kelas/id/{$row['kelas_id']}", $row['kelas_nama'], "title=\"lihat detail kelas\"");
}

function disnil_wali($row) {
	return a("data/profil/sdm/id/{$row['kelas_wali_id']}", $row['kelas_wali_nama'], 'title="lihat detail walikelas"');
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$admin_user = cfguc_admin('akses', 'data', 'user');

$view_profil_detail = ($siswa_ybs OR $view);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Siswa' => 'data/profil/siswa',
		"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
		'label' => 'Daftar Siswa',
		'uri' => "data/profil/siswa",
		'attr' => 'title="kembali ke daftar siswa"',
);
$pills_kanan['detail'] = array(
		'label' => "<i class=\"icon-search\"></i> {$toggle_label}",
		'uri' => "#",
		'attr' => 'title="lihat profil detail siswa ini" id="cmd-info-toggle"',
);
$pills_kanan['cover'] = array(
	'label' => "<i class=\"icon-print\"></i> Cover",
	'uri' => "data/profil/siswa/cover/" . $row["id"],
	'attr' => 'title="cetak cover rapor siswa" target="_blank"',
);

$sma_terbang = (($user['role']=='sdm') && (APP_SCOPE == 'sma_terbang'));
if ($admin_user OR $siswa_ybs OR $sma_terbang)
	$pills_kanan[] = array(
			'label' => '<i class="icon-key"></i> Akun Login',
			'uri' => "data/user/id/{$row['id']}",
			'attr' => 'title="lihat user-akun siswa ini"',
	);

if ($admin OR $siswa_ybs)
	$pills_kanan[] = array(
			'label' => '<i class="icon-edit"></i> Edit',
			'uri' => "data/profil/siswa/form?id={$row['id']}",
			'attr' => 'title="ubah data Siswa ini"',
			'class' => 'active',
	);

// data tabel

$detail = array(
		'kesiswaan' => array(
				'N I S' => 'nis',
				'N I S N' => 'nisn',
				'Nomer U N' => 'no_un',
				'Kelas' => 'kelas_nama',
		),
		'profil' => array(
				'Nama' => array('nama'),
				'Gender' => array('gender', array('l' => 'Laki-laki', 'p' => 'Perempuan')),
				'Tempat Tgl Lahir' => array(
						'lahir_tempat',
						'suffix' => array(
								' ',
								array('lahir_tgl', 'date2tgl'),
						),
				),
				'Agama' => 'agama_nama',
				'Alamat' => 'alamat',
				'Kota' => 'kota',
				'Telepon' => 'telepon',
		),
);

if ($user['role'] == 'admin')
	$detail['kesiswaan']['Status Login'] = array('aktif', array('blokir', 'aktif'));

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// tabel nilai

$tabel_nilai = array(
		'table_properties' => array(
				'id' => 'tabel-nilai',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data tidak ditemukan</i></p>',
		'data' => array(
				'Semester' => array(
						'semester_nama',
						'ucfirst',
						'suffix' => array('&nbsp; ', 'ta_nama'),
				),
				'Kelas' => array(FALSE, 'disnil_kelas'),
				'Walikelas' => array(FALSE, 'disnil_wali'),
				'Nilai' => array(FALSE, 'disnil_link'),
		),
);

// pills bar

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Siswa')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
            

           
			<div class="block-header">
                <h2 id="title_page">PROFIL SISWA</h2>

            </div>

            <div class="card" id="profile-main">
                <div class="pm-overview c-overflow">

                    <div class="pmo-pic">
                        <div class="p-relative">
                            <?php echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210));?>

                            
                        </div>


                        
                    </div>

                    
                </div>

                <div class="pm-body clearfix">
                    <ul class="tab-nav tn-justified">
                        <li class="active"><a href="profile-about.html">Data Diri</a></li>
                       <!-- <li><a href="profile-timeline.html">Timeline</a></li>
                        <li><a href="profile-photos.html">Photos</a></li>
                        <li><a href="profile-connections.html">Connections</a></li>-->
                    </ul>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-account m-r-10"></i> Basic Information</h2>
							<!--
                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-ma-action="profile-edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            -->
                        </div>
                        <?php
                        	$gender = array('l' => 'Laki-laki', 'p' => 'Perempuan');
						?>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>Nama</dt>
                                    <dd><?=$row['nama']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Gender</dt>
                                    <dd><?=$gender[$row['gender']]?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Tempat & Tanggal Lahir</dt>
                                    <dd><?=$row['lahir_tempat']?>, <?=date2tgl($row['lahir_tgl'])?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Agama</dt>
                                    <dd><?=$row['agama_nama']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Alamat</dt>
                                    <dd><?=$row['alamat']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Kota</dt>
                                    <dd><?=$row['kota']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Telepon</dt>
                                    <dd><?=$row['telepon']?></dd>
                                </dl>
                            </div>

                            <div class="pmbb-edit">
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Full Name</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <input type="text" class="form-control"
                                                   placeholder="eg. Mallinda Hollaway">
                                        </div>

                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Gender</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <select class="form-control">
                                                <option>Male</option>
                                                <option>Female</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Birthday</dt>
                                    <dd>
                                        <div class="dtp-container dropdown fg-line">
                                            <input type='text' class="form-control date-picker"
                                                   data-toggle="dropdown" placeholder="Click here...">
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt class="p-t-10">Martial Status</dt>
                                    <dd>
                                        <div class="fg-line">
                                            <select class="form-control">
                                                <option>Single</option>
                                                <option>Married</option>
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </dd>
                                </dl>

                                <div class="m-t-30">
                                    <button class="btn btn-primary btn-sm">Save</button>
                                    <button data-ma-action="profile-edit-cancel" class="btn btn-link btn-sm">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pmb-block">
                        <div class="pmbb-header">
                            <h2><i class="zmdi zmdi-phone m-r-10"></i> Kesiswaan</h2>
							<!--
                            <ul class="actions">
                                <li class="dropdown">
                                    <a href="" data-toggle="dropdown">
                                        <i class="zmdi zmdi-more-vert"></i>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a data-ma-action="profile-edit" href="">Edit</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>-->
                        </div>
                        <div class="pmbb-body p-l-30">
                            <div class="pmbb-view">
                                <dl class="dl-horizontal">
                                    <dt>N I S</dt>
                                    <dd><?=$row['nis']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>N I S N</dt>
                                    <dd><?=$row['nisn']?></dd>
                                </dl>
                                <dl class="dl-horizontal">
                                    <dt>Kelas</dt>
                                    <dd><?=$row['kelas_nama']?></dd>
                                </dl>
                                <?php if ($user['role'] == 'admin'){
									$aktif = array('blokir', 'aktif');
								?>
                                <dl class="dl-horizontal">
                                    <dt>Status Login</dt>
                                    <dd><?=$aktif($row['aktif'])?></dd>
                                </dl>
                                <?php }?>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
                    
                    
                    
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>
	</body>
</html>
