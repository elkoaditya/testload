<?php

// hak akses & user scope
// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Tool',
	'Check Token'
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Check Token')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Check Token</h1>
				</div>
				
				<div class="well">
					<?php
					echo '<fieldset>';
					//echo '<legend>Token = '.tanggal($resultset["tanggal"]).' '.$resultset["waktu"].'</legend>';
					//echo div('class="control-group"');
					
					echo '<div class="btn btn-info"><h3><b><font color="white">'.$resultset["token"].'</font></b></h3></div>';
					
					echo '<legend>Berlaku '.$resultset["awal"].' - '.$resultset["akhir"].'</legend>';
					
					//echo "</label></div>" . NL;
					echo '</fieldset>';
					?>
				</div>
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	<!--</body>
</html>-->