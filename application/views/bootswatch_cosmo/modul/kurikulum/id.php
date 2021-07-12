<?php
// vars
$base_url = base_url();
$file_path = array_node($row, array('lampiran', 'full_path'));
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_name = array_nodex($row, array('lampiran', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));

$file_link = str_replace("http://" ,"" ,$file_link);
$file_view = "http://docs.google.com/viewer?url=" . $file_link;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Kurikulum' => 'modul/kurikulum',
		"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
		'label' => 'Daftar Kurikulum '.$row['kurikulum_nama'].'',
		'uri' => "modul/kurikulum/browse/{$row['kurikulum_kode']}",
		'attr' => 'title="kembali ke daftar kurikulum"',
);

if ($admin):
	$pills_kanan['edit'] = array(
			'label' => '<i class="icon-edit"></i> Edit',
			'uri' => "modul/kurikulum/form?id={$row['id']}",
			'attr' => 'title="ubah konten kurikulum ini"',
			'class' => 'disabled',
	);
	
	$pills_kanan['delete'] = array(
			'label' => '<i class="icon-trash"></i> Delete',
			'uri' => "modul/kurikulum/hapus_kurikulum_isi/{$row['id']}",
			'attr' => 'title="ubah konten kurikulum ini" onClick="return confirm(\'Apakah Anda yakin hendak menghapusnya?\')"',
			'class' => 'disabled',
	);


endif;

	

if ($row['semester_id'] == $semaktif['id']){
	
	if (strpos( $row['kurikulum_ubah'] , $user['role']) !== false) {
		$pills_kanan['edit']['class'] = 'active';
	}
	
	if (strpos( $row['kurikulum_hapus'] , $user['role']) !== false) {
		$pills_kanan['delete']['class'] = 'active';
	}
}

// bars

$bar_pill = '<div>'
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. pills($pills_kiri)
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Kurikulum #{$row['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Kurikulum - <?php echo strtoupper($row['kurikulum_nama']);?> :<br/>
					<h1><?php echo strtoupper($row['nama']); ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#info{
						font-size: .9em;
						opacity: .7;
					}
					#lampiran{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php
				echo alert_get();

				
				echo $bar_pill;

				//klo ada gambar tampilkan saja

				if ($file_imag && $file_link):
					echo div('align="center"', img($file_link)) . '<br/>';
				endif;

				// tampilkan file

				if ($file_link):
					echo '<p><i>file: ' . a($file_link, $file_name, 'title="download file" target="_blank"') . '</i></p><br/><br/>';
				endif;

				// klo ada ketikan artikel, tampilkan. file jadi link

				if ($file_ofis):
					echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>";

				endif;

				echo '<br/><br/><br/>';

				// pertanyaan

				echo p('', '<b>Keterangan</b>') . $row['keterangan'];

				
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		addon('tinymce');
		?>

	</body>
</html>