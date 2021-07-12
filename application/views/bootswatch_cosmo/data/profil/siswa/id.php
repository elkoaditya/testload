<?php

//if($user['role']=='siswa'){
//	redirect(base_url()."kbm/evaluasi", 'refresh');
//}

//echo base_url()."/kbm/evaluasi";
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
				'label' => '#',
				'uri' => '#',
				'attr' => '#',
		);
$pills_kanan['edit'] = array(
		'label' => '<i class="icon-edit"></i> Edit User Password',
		'uri' => "data/user/form?id={$row['id']}",
		'attr' => 'title="ubah User Password ini"',
);
$pills_kanan['edit_profil'] = array(
		'label' => '<i class="icon-edit"></i> Edit Foto Profil',
		'uri' => "data/profil/siswa/form?id={$row['id']}",
		'attr' => 'title="ubah data Foto Siswa ini"',
		'class' => 'active',
);
$pills_kanan['edit_profil'] = array(
		'label' => '<i class="icon-edit"></i> Edit Foto Profil',
		'uri' => "data/profil/siswa/form?id={$row['id']}",
		'attr' => 'title="ubah data Foto Siswa ini"',
		'class' => 'active',
);
if($row['kelas_grade']==12){
	$pills_kanan['kartu_ujian'] = array(
			'label' => '<i class="icon-download"></i> Kartu Ujian',
			'uri' => "nilai/siswa_tool/kartu_ujian/0/{$row['id']}",
			'attr' => 'title="download Kartu Ujian Siswa"',
			'class' => 'active',
	);
}
$pills_kanan['detail'] = array(
				'label' => "<i class=\"icon-search\"></i> {$toggle_label}",
				'uri' => "#",
				'attr' => 'title="lihat profil detail siswa ini" id="cmd-info-toggle"',
		);

if ($admin_user ){
		$pills_kiri[] = array(
				'label' => 'Daftar Siswa',
				'uri' => "data/profil/siswa",
				'attr' => 'title="kembali ke daftar siswa"',
		);
		/*
		$pills_kanan['cover'] = array(
			'label' => "<i class=\"icon-print\"></i> Cover",
			'uri' => "data/profil/siswa/cover/" . $row["id"],
			'attr' => 'title="cetak cover rapor siswa" target="_blank"',
		);*/
		$pills_kanan['cover_k13'] = array(
			'label' => "<i class=\"icon-print\"></i> Cover K13",
			'uri' => "data/profil/siswa/cover/" . $row["id"]."/pdf/k13",
			'attr' => 'title="cetak cover rapor siswa K13" target="_blank"',
		);
		$pills_kanan['cover_ktsp'] = array(
			'label' => "<i class=\"icon-print\"></i> Cover KTSP",
			'uri' => "data/profil/siswa/cover/" . $row["id"]."pdf/ktsp",
			'attr' => 'title="cetak cover rapor siswa KTSP" target="_blank"',
		);

		$pills_kanan[] = array(
				'label' => '<i class="icon-key"></i> Akun Login',
				'uri' => "data/user/id/{$row['id']}",
				'attr' => 'title="lihat user-akun siswa ini"',
		);
	}
if ($admin )
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
				'PD ID E-Rapor' => 'pd_id_erapor',
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
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Siswa')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		// print_r($user);
		if(isset($user['form_login'])){
			if ($user['form_login'] != 'alumni'){
				echo breacrumbs($breadcrumbs);
			}
		}
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Profil Siswa</h1>
				</div>

				<style>
					@media (max-width: 499px) {
						#cmd-info-toggle{
							float: none;
						}
					}
					@media (min-width: 500px) {
						#cmd-info-toggle{
							float: right;
						}
					}

					#cmd-info-toggle{
						cursor: pointer;
					}
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}

				</style>

				<?php
				echo alert_get();
				echo $bar_pills;

				// ringkasan profil

				echo '<div class="form-horizontal data-ringkas"><fieldset>';
				echo '<legend>Ringkasan Profil</legend>';
				echo "<div class=\"control-group\">";
				echo "<div class=\"control-label\">";
				echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 75, 'height' => 100));
				echo "</div><div class=\"controls\">";
				echo "NIS: {$row['nis']}<br/>";
				echo "NISN: {$row['nisn']}<br/>";
				echo "<b>{$row['nama']}</b> (" . strtoupper($row['gender']) . ')<br/>';
				echo "{$row['kelas_nama']}<br/>";
				echo "{$row['kota']}<br/>";
				echo "</div></div>";
				echo '</fieldset><br/></div>';

				// profil lengkap
				// mulai dr foto

				echo '<div class="form-horizontal data-lengkap"><fieldset>';
				echo '<legend>Foto Profil</legend>';
				echo "<div class=\"control-group\">"
				. "<div class=\"controls\">";
				echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 210, 'height' => 280));
				echo "</div></div>";
				echo '</fieldset><br/><br/></div>';

				echo '<div class="form-horizontal data-lengkap"><fieldset>';
				echo '<legend>Kesiswaan</legend>';

				foreach ($detail['kesiswaan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';

				echo '<div class="form-horizontal data-lengkap"><fieldset>';
				echo '<legend>Data Pribadi</legend>';

				foreach ($detail['profil'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';
				/*
				if ($view_profil_detail)
					$this->load->view("bootswatch_cosmo/{$uri}/profil_detail", $this->d);

				$this->load->view("bootswatch_cosmo/{$uri}/kbm", $this->d);

				if ($view_nilai_siswa):

					if(isset($user['form_login'])){
						if ($user['form_login'] != 'alumni'){
							echo '<div class="form-horizontal"><fieldset>';
							echo '<legend>Riwayat Belajar</legend>';
							echo ds_table($tabel_nilai, $nilai_result);
							echo '</fieldset><br/><br/></div>';
						}
					}
				endif;
				*/
				if(isset($pengumuman_depan)){
					echo $pengumuman_depan;
				}
				if($siswa_ybs){
					echo '<a class="btn btn-primary btn-block" href="'.base_url().'kbm/vidcall">VIDEO CALL</a>';
					echo '<a class="btn btn-primary btn-block" href="'.base_url().'kbm/evaluasi">SOAL UJIAN</a>';
				}
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

    <script>
			$('#cmd-info-toggle').click(function() {
				txt = $(this).html();

				if (txt === '<i class=\"icon-search\"></i> Profil Detail') {
					$(this).html('<i class=\"icon-search\"></i> Profil Ringkas');
					$('.data-ringkas').slideUp(200);
					$('.data-lengkap').slideDown(200);

				} else {
					$(this).html('<i class=\"icon-search\"></i> Profil Detail');
					$('.data-lengkap').slideUp(200);
					$('.data-ringkas').slideDown(200);

				}
			});
			$('#cmd-info-toggle').click();
		</script>
	</body>
</html>