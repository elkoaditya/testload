<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Tool',
	'Reset Password Siswa'
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Konfigurasi')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Reset Password Siswa</h1>
				</div>

				<p class="alert">
					Apa Anda yakin akan mereset semua password siswa??
				</p>

				<?php
				$grade = $this->m_option->grade();
				//print_r($grade);
				echo alert_get();
				echo form_opening("", 'class="form-horizontal well"');
				echo '<fieldset>';
				echo '<div class="form-actions well">';
				//. '<button type="submit" class="btn btn-success" onclick="return confirm(\'Apakah yakin Reset Password Siswa ?\')">
				//<i class="icon-save icon-white"></i> GO Reset Password Siswa</button> '
				//. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; <br><br>'
				
				
				//foreach()
				//SMP
				/*. a("/app/tool/reset_password_siswa_angkatan/7", '<i class="icon-download"></i> GO Reset Password Siswa kelas VII ', 'class="btn btn-success" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				. a("/app/tool/reset_password_siswa_angkatan/8", '<i class="icon-download"></i> GO Reset Password Siswa kelas VIII ', 'class="btn btn-success" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				. a("/app/tool/reset_password_siswa_angkatan/9", '<i class="icon-download"></i> GO Reset Password Siswa kelas IX ', 'class="btn btn-success" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				.'<br><br>'
				
				//SMA
				. a("/app/tool/reset_password_siswa_angkatan/10", '<i class="icon-download"></i> GO Reset Password Siswa kelas X ', 'class="btn btn-warning" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				. a("/app/tool/reset_password_siswa_angkatan/11", '<i class="icon-download"></i> GO Reset Password Siswa kelas XI ', 'class="btn btn-warning" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				. a("/app/tool/reset_password_siswa_angkatan/12", '<i class="icon-download"></i> GO Reset Password Siswa kelas XII ', 'class="btn btn-warning" title="reset password siswa" target="_blank"') . " &nbsp; "
				.'<br><br>'
				*/
				foreach($grade as $g){
					echo a("/app/tool/reset_password_siswa_angkatan/".$g, 
						'<i class="icon-download"></i> GO Reset Password Siswa Kelas '.$g, 
						'class="btn btn-success" title="reset password siswa" target="_blank"') . " &nbsp; ";
					echo'<br><br>';
				}
				
				echo a("/app/tool/print_password_siswa", '<i class="icon-download"></i> Download Hasil Reset Password Siswa <br/>(*jika kosong maka belum di reset login)', 'class="btn btn-primary" title="cetak password siswa" target="_blank"') . " &nbsp; "
				. a("/app/tool/back_password_to_nis", '<i class="icon-download"></i> Reset Password ke NIS <br/>(*jika ingin kembalikan ke awal NIS)', 'class="btn btn-danger" title="cetak password siswa" target="_blank"') . " &nbsp; "
				
				. '</div>';
				echo '</fieldset>';

				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>