<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Data'							 => 'data',
	'Profil'						 => 'data/profil',
	GURU_ALIAS . ' &amp; SDM'		 => 'data/profil/sdm',
	"#{$row['id']}"					 => "data/profil/sdm/id/{$row['id']}",
	'#reset-password'
);

// pills link

$pills[] = array(
	'label'	 => 'Kembali',
	'uri'	 => "data/profil/sdm/id/{$row['id']}",
	'attr'	 => 'title="kembali ke detail ' . strtolower(GURU_ALIAS) . '/sdm"',
);

// input data

$input_akun = array(
	'konfirmasi_password' => array(
		'konfirmasi_password',
		'type'			 => 'password',
		'name'			 => 'konfirmasi_password',
		'id'			 => 'konfirmasi_password',
		'class'			 => 'input input-xlarge',
		'label'			 => 'Password',
		'placeholder'	 => 'masukan password',
	),
);

// buttons

$btn_back = a("data/profil/sdm/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke profil ' . strtolower(GURU_ALIAS) . ' / sdm', 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Reset Password ' . (GURU_ALIAS) . ' / SDM')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<style>
			.thumbnail{
				max-height: 100px;
				max-width: 75px;
			}
		</style>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Reset Password <?php echo GURU_ALIAS; ?>/SDM</h1>
				</div>

				<?php

				echo alert_get();
				echo pills($pills);
				echo form_openmp("{$uri}/{$row['id']}", 'class="form-horizontal well"');

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

				echo '<div class="form-horizontal data-lengkap"><fieldset>';
				echo '<legend>Data Pribadi</legend>';

				foreach ($detail1 as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset><br/><br/></div>';

// akun email pengguna baru

				echo '<fieldset>';
				echo '<legend>Konfirmasi password untuk melanjutkan</legend>';
				echo "<div class=\"control-group\">"
				. "<label class=\"control-label\" for=\"email\">Kata Kunci</label>"
				. "<div class=\"controls\">"
				. form_cell($input_akun['konfirmasi_password'], $row)
				. "</div></div>" . NL;
				echo '</fieldset><br/><br/>';



// form button

				echo '<fieldset>';
				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Reset Paswword</button> ';

				echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button>&nbsp; &nbsp; ';
				echo $btn_back;
				echo '</div>';
				echo '</fieldset>';

				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>