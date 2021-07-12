<?php

// vars

$ringkas = (strtolower($this->input->get_post('ringkas')) === 'ya');
$toggle_label = ($ringkas) ? 'Profil Ringkas' : 'Profil Detail';

//function

function dispel_nama($row)
{
	return a("data/akademik/pelajaran/id/{$row['id']}", $row['nama'], "title=\"lihat detail pelajaran\"");

}

function dispel_kbm($row)
{
	return a("kbm/materi/browse?pelajaran_id={$row['id']}", 'Materi', 'class="btn btn-small btn-success" title="lihat materi pelajaran ini"') . ' &nbsp; '
		. a("kbm/evaluasi/browse?pelajaran_id={$row['id']}", 'Evaluasi', 'class="btn btn-small btn-success" title="lihat evaluasi pelajaran ini"') . ' &nbsp; '
		. a("nilai/pelajaran/id/{$row['nilai_id']}", 'Nilai', 'class="btn btn-small btn-success" title="lihat nilai pelajaran ini"');

}

function diskls_nama($row)
{
	return a("data/akademik/kelas/id/{$row['id']}", $row['nama'], "title=\"lihat detail kelas\"");

}

function disxkul_nama($row)
{
	return a("data/non_akademik/ekstrakurikuler/id/{$row['id']}", $row['nama'], "title=\"lihat detail ekstrakurikuler\"");

}

function disxkul_nilai($row)
{
	return a("nilai/ekstrakurikuler/id/{$row['nilai_id']}", 'nilai', 'title="lihat nilai ektrakurikuler ini"');

}

function disorg_nama($row)
{
	return a("data/non_akademik/organisasi/id/{$row['id']}", $row['nama'], "title=\"lihat detail organisasi\"");

}

function disorg_nilai($row)
{
	return a("nilai/organisasi/id/{$row['nilai_id']}", 'nilai', 'title="lihat nilai organisasi ini"');

}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$sdm_ybs = ($user['id'] == $row['id']);
$admin_user = cfguc_admin('akses', 'data', 'user');
$view_nilai_pelajaran = cfguc_view('akses', 'nilai', 'pelajaran');
$view_nilai_kelas = cfguc_view('akses', 'nilai', 'kelas');
$view_nilai_ekskul = cfguc_view('akses', 'nilai', 'ekskul');
$view_nilai_organisasi = cfguc_view('akses', 'nilai', 'organisasi');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Data'							 => 'data',
	'Profil'						 => 'data/profil',
	GURU_ALIAS . ' &amp; SDM'		 => 'data/profil/sdm',
	"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
	'label'	 => 'Daftar ' . GURU_ALIAS . ' dan SDM',
	'uri'	 => "data/profil/sdm",
	'attr'	 => 'title="kembali ke tabel ' . strtolower(GURU_ALIAS) . ' dan sdm"',
);
$pills_kanan['detail'] = array(
	'label'	 => "<i class=\"icon-search\"></i> {$toggle_label}",
	'uri'	 => "#",
	'attr'	 => 'title="lihat profil detail siswa ini" id="cmd-info-toggle"',
);

if ($admin_user OR $sdm_ybs)
	$pills_kanan['akun'] = array(
		'label'	 => '<i class="icon-key"></i> Akun Login',
		'uri'	 => "data/user/id/{$row['id']}",
		'attr'	 => 'title="lihat akun login ini"',
	);

if ($admin OR $sdm_ybs)
{
	$pills_kanan['edit'] = array(
		'label'	 => '<i class="icon-edit"></i> Edit',
		'uri'	 => "data/profil/sdm/form?id={$row['id']}",
		'attr'	 => 'title="ubah data ' . strtolower(GURU_ALIAS) . '/sdm ini"',
		'class'	 => 'active',
	);
}

if ($admin)
{
	/*
	$pills_kanan['reset'] = array(
		'label'	 => '<i class="icon-edit"></i> Reset Password',
		'uri'	 => "data/profil/sdm/reset_password/{$row['id']}",
		'attr'	 => 'title="reset password ' . strtolower(GURU_ALIAS) . '/sdm ini"',
		'class'	 => 'active',
	);*/
	
	$pills_kanan['reset'] = array(
		'label'	 => '<i class="icon-edit"></i> Reset Back Password',
		'uri'	 => "data/profil/sdm/reset_password_back/{$row['id']}",
		'attr'	 => 'title="reset password ' . strtolower(GURU_ALIAS) . '/sdm ini"',
		'class'	 => 'active',
	);
}

// data tabel

$detail1 = array(
	'N I P'		 => 'nip',
	'N U P T K'	 => 'nuptk',
	'Nama'		 => array('nama_title'),
	'Gender'	 => array('gender', array('l' => 'Laki-laki', 'p' => 'Perempuan')),
	'Alamat'	 => 'alamat',
	'Kota'		 => 'kota',
	'Telepon'	 => 'telepon',
);

if ($admin_user)
	$detail1['Status Login'] = array('aktif', array('blokir login', 'aktif'));

$detail2['Jabatan'] = 'jabatan_nama';
$detail2['Mengajar'] = array('mengajar', array('tidak', 'ya'));

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// bentuk tabel data pelajaran

$tabel_pelajaran = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-pelajaran',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>data pelajaran kosong/tidak ditemukan</i></p>',
	'data'				 => array(
		'Kode'			 => 'kode',
		'Kurikulum'		 => 'kurikulum_nama',
		'Kategori'		 => 'kategori_kode',
		'Mapel'			 => 'mapel_nama',
		//'Agama' => 'agama_nama',
		'Nama pelajaran' => array(FALSE, 'dispel_nama'),
	),
);

// bentuk tabel data walikelas

$tabel_kelas = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-kelas',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>data kelas kosong/tidak ditemukan</i></p>',
	'data'				 => array(
		'Grade'		 => 'grade',
		'Jurusan'	 => 'jurusan_nama',
		'Nama kelas' => array(FALSE, 'diskls_nama'),
		'Kurikulum'	 => 'kurikulum_nama',
	),
);

// bentuk tabel data ekskul

$tabel_ekskul = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-ekskul',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>data ekstrakurikuler kosong/tidak ditemukan</i></p>',
	'data'				 => array(
		'Nama' => array(FALSE, 'disxkul_nama'),
	),
);

// bentuk tabel data org

$tabel_organisasi = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-org',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>data orgaisasi kosong/tidak ditemukan</i></p>',
	'data'				 => array(
		'Nama' => array(FALSE, 'disorg_nama'),
	),
);

// sub data akademik & non akademik

if ($semaktif['id'] > 0):
	$tabel_pelajaran['data']['Siswa'] = 'siswa_jml';

	if ($sdm_ybs OR $view_nilai_pelajaran):
		$tabel_pelajaran['data']['Proses KBM'] = array(FALSE, 'dispel_kbm');
		$tabel_pelajaran['data']['NAS Teori'] = 'nas_teori';
		$tabel_pelajaran['data']['NAS Praktek'] = 'nas_praktek';
	endif;
	/*
	  $tabel_kelas['data']['Siswa'] = 'siswa_jml';
	  $tabel_ekskul['data']['Siswa'] = 'siswa_jml';
	  $tabel_organisasi['data']['Siswa'] = 'siswa_jml';
	 *

	  if ($sdm_ybs OR $view_nilai_kelas):
	  $tabel_kelas['data']['NAS Teori'] = 'nas_teori';
	  $tabel_kelas['data']['NAS Praktek'] = 'nas_praktek';
	  endif;

	 */

	if ($sdm_ybs OR $view_nilai_ekskul):
		$tabel_ekskul['data']['Nilai'] = array(FALSE, 'disxkul_nilai');
	endif;

	if ($sdm_ybs OR $view_nilai_organisasi):
		$tabel_organisasi['data']['Nilai'] = array(FALSE, 'disorg_nilai');
	endif;

else:

	if ($admin_pelajaran)
		$tabel_pelajaran['data']['Aktif'] = array('aktif', array('tidak', 'ya'));

	if ($admin_kelas)
		$tabel_kelas['data']['Aktif'] = array('aktif', array('tidak', 'ya'));

	if ($admin_ekskul)
		$tabel_ekskul['data']['Aktif'] = array('aktif', array('tidak', 'ya'));

	if ($admin_organisasi)
		$tabel_organisasi['data']['Aktif'] = array('aktif', array('tidak', 'ya'));

endif;

// pills bar

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
	. pills($pills_kiri, 'class="nav nav-pills pull-left"')
	. pills($pills_kanan, 'class="nav nav-pills pull-right"');


if ($sdm_ybs):
	$bar_pills .= '</td></tr><tr><td>';
	$bar_pills .= div('id="toolbar-right"');
	$bar_pills .= a("kbm/materi/form", '<i class="icon-star"></i> Susun Materi Baru', 'class="btn btn-large btn-primary"') . '&nbsp; ';
	$bar_pills .= a("kbm/evaluasi/form", '<i class="icon-star"></i> Susun Evaluasi Baru', 'class="btn btn-large btn-primary"') . '&nbsp; ';
	$bar_pills .= '</div>';

endif;

$bar_pills .= '</td></tr></table></div>';

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail ' . strtolower(GURU_ALIAS) . '/SDM')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Profil <?php echo GURU_ALIAS; ?> / SDM</h1>
				</div>

				<style>
					#cmd-info-toggle{
						cursor: pointer;
					}
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}

					@media (max-width: 799px) {
						#toolbar-right{
							float: none;
						}
					}
					@media (min-width: 800px) {
						#toolbar-right{
							float: right;
						}
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
				echo "NIP: {$row['nip']}" . (($row['nuptk']) ? ", NUPTK: {$row['nuptk']}" : "") . "<br/>";
				echo "<b>{$row['nama_title']}</b> (" . strtoupper($row['gender']) . ')<br/>';
				echo "{$row['jabatan_nama']}<br/>";
				echo "{$row['kota']}<br/>";
				echo "{$row['telepon']}<br/>";
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
				echo '<legend>Data Pribadi</legend>';

				foreach ($detail1 as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';

				echo '<div class="form-horizontal data-lengkap"><fieldset>';
				echo '<legend>Lingkup Kerja</legend>';

				foreach ($detail2 as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';

				$label_pelajaran = ($semaktif['id'] == 0) ? 'Sementara' : 'yang Diampu';
				$label_kelas = ($semaktif['id'] == 0) ? 'Sementara' : 'yang Diasuh';
				$label_ekskul = ($semaktif['id'] == 0) ? 'Sementara' : 'yang Dibina';
				$label_org = ($semaktif['id'] == 0) ? 'Sementara' : 'yang Dibina';

				echo '<div class="form-horizontal"><fieldset>';
				echo "<legend>Daftar Pelajaran {$label_pelajaran}</legend>";
				echo ds_table($tabel_pelajaran, $pelajaran_result);
				echo '</fieldset><br/><br/></div>';

				if ($kelas_result['selected_rows'] > 0):
					echo '<div class="form-horizontal"><fieldset>';
					echo "<legend>Daftar Kelas {$label_kelas}</legend>";
					echo ds_table($tabel_kelas, $kelas_result);
					echo '</fieldset><br/><br/></div>';
				endif;

				echo '<div class="row">';

				if ($ekskul_result['selected_rows'] > 0):
					echo '<div class="span6"><fieldset>';
					echo "<legend>Daftar Ekstrakurikuler {$label_ekskul}</legend>";
					echo ds_table($tabel_ekskul, $ekskul_result);
					echo '</fieldset><br/><br/></div>';
				endif;

				if ($organisasi_result['selected_rows'] > 0):
					echo '<div class="span6"><fieldset>';
					echo "<legend>Daftar Kelas {$label_org}</legend>";
					echo ds_table($tabel_organisasi, $organisasi_result);
					echo '</fieldset><br/><br/></div>';
				endif;

				echo '</div>';

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

		<script>
			$('#cmd-info-toggle').click(function () {
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