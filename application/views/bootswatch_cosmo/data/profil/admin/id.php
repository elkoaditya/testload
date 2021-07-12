<?php
// vars

$ringkas = (strtolower($this->input->get_post('ringkas')) === 'ya');
$toggle_label = ($ringkas) ? 'Profil Ringkas' : 'Profil Detail';

//function
// komponen
// hak akses & user scope

$admin_ybs = ($user['id'] == $row['id']);
$admin_user = cfguc_admin('akses', 'data', 'user');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Admin' => 'data/profil/admin',
		"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Daftar Admin',
		'uri' => "data/profil/admin",
		'attr' => 'title="kembali ke daftar admin"',
);
$pills_kanan['detail'] = array(
		'label' => "<i class=\"icon-search\"></i> {$toggle_label}",
		'uri' => "#",
		'attr' => 'title="lihat profil detail admin ini" id="cmd-info-toggle"',
);
$pills_kanan['akun'] = array(
		'label' => '<i class="icon-key"></i> Akun Login',
		'uri' => "data/user/id/{$row['id']}",
		'attr' => 'title="ubah info user-akun sdm ini"',
		'class' => 'disabled',
);
$pills_kanan['edit'] = array(
		'label' => '<i class="icon-edit"></i> Edit',
		'uri' => "data/profil/admin/form?id={$row['id']}",
		'attr' => 'title="ubah data Admin ini"',
		'class' => 'disabled',
);

if ($admin_user)
	$pills_kanan['akun']['class'] = '';

if ($admin OR $admin_ybs)
	$pills_kanan['edit']['class'] = 'active';

// foto profil

$xdat = (array) json_decode($row['xdat'], TRUE);
$path_foto = array_node($xdat, array('foto', 'full_path'));

// data tabel

$detail1 = array(
		'ID' => array('id', 'prefix' => '#'),
		'Nama' => array('nama_title'),
		'Gender' => array('gender', array('l' => 'Laki-laki', 'p' => 'Perempuan')),
		'Alamat' => 'alamat',
		'Kota' => 'kota',
		'Telepon' => 'telepon',
);

if ($admin OR $admin_ybs)
	$detail1['Status Login'] = array('aktif', array('blokir login', 'aktif'));

// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Admin')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Profil Admin</h1>
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
				</style>

				<?php
				echo alert_get();
				//echo'<div id="cmd-info-toggle" class="btn btn-info">' . $toggle_label . '</div>';
				echo $bar_pill;

				// ringkasan profil

				echo '<div class="form-horizontal data-ringkas"><fieldset>';
				echo '<legend>Ringkasan Profil</legend>';
				echo "<div class=\"control-group\">";
				echo "<div class=\"control-label\">";
				echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 75, 'height' => 100));
				echo "</div><div class=\"controls\">";
				echo "ID: #{$row['id']}<br/>";
				echo "<b>{$row['nama_title']}</b> (" . strtoupper($row['gender']) . ')<br/>';
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
				
				
				///// JUMLAH DATA
				
				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Data Sekolah</legend>';

				echo '<div class="control-group">
						<label class="control-label">Jumlah Guru</label>
						<div class="controls"> '. $guru['jumlah'].' </div>
				</div>';
				
				echo '<div class="control-group">
						<label class="control-label">Jumlah Kelas</label>
						<div class="controls"> '. $kelas['jumlah'].' </div>
				</div>';
				
				//echo 'Jumlah Guru = '. $guru['jumlah'];
				//echo '<br>Jumlah Kelas = '. $kelas['jumlah'];

				$total=0;
				foreach ($siswa['data'] as $sis):
					$total = $total+$sis['jumlah'];
					//echo '<br>Jumlah Siswa Kelas '.$sis['grade'].' = '. $sis['jumlah'];
					
					echo '<div class="control-group">
							<label class="control-label">Jumlah Siswa Kelas '.$sis['grade'].'</label>
							<div class="controls"> '. $sis['jumlah'].' </div>
					</div>';
				endforeach;
				
				echo '<div class="control-group">
						<label class="control-label">Jumlah Total Siswa</label>
						<div class="controls"> '. $total.' </div>
				</div>';
				//echo '<br>Jumlah Total Siswa  = '. $total;
				
				echo '</fieldset><br/><br/></div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

    <script>
			$('#cmd-info-toggle').click(function() {
				txt = $(this).html();
				//alert(txt);

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