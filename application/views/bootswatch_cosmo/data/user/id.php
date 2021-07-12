<?php
// vars

$user_ybs = ($user['id'] == $row['id']);

// function

function display_nama($row) {
	$nama = "{$row['nama']} (" . strtoupper($row['gender']) . ")";
	return ($row['role'] == 'admin') ? $nama : a("data/profil/{$row['role']}/id/{$row['id']}", $nama, 'title="lihat profil detail "');
}

function display_xdat($xdat = FALSE) {
	if (!is_array($xdat))
		$xdat = (array) json_decode($xdat, TRUE);

	if (!isset($xdat['config']))
		return NULL;

	return ds_ul($xdat['config'], 'style="margin: 0; padding-left: 24px;"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'User' => 'data/user',
		"#{$row['id']}",
);

// pills link

$pills_kiri[] = array(
		'label' => 'Daftar User',
		'uri' => "data/user",
		'attr' => 'title="kembali ke daftar user"',
);

$pills_kanan['profil'] = array(
		'label' => 'Profil',
		'uri' => "data/profil/{$row['role']}/id/{$row['id']}?ringkas=ya",
		'attr' => 'title="lihat profil user"',
		'class' => 'active',
);
$pills_kanan['edit'] = array(
		'label' => '<i class="icon-edit"></i> Edit',
		'uri' => "data/user/form?id={$row['id']}",
		'attr' => 'title="ubah data user ini"',
		'class' => 'disabled',
);

$sma_terbang = (($user['role']=='sdm') && (APP_SCOPE == 'sma_terbang'));
if ($admin OR $user_ybs OR $sma_terbang)
	$pills_kanan['edit']['class'] = 'active';

// tabel data

$dset['Nama'] = array(FALSE, 'display_nama');
$dset['Alias'] = 'alias';
$dset['Tentang'] = array('tentang', 'auto_link');

if ($admin OR $user_ybs):
	$dset['Email'] = 'email';
	$dset['Username'] = 'username';

endif;

if ($user['role'] == 'admin'):
	$dset['Role'] = 'role';

	if ($admin)
		$dset['Data'] = array('xdat', 'display_xdat');

endif;

// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Kelas')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail User</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php
				echo alert_get();
				echo $bar_pill;

				// data utama

				echo '<div class="form-horizontal"><fieldset>';

				foreach ($dset as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>