<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'User' => 'data/user',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "data/user/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input = array(
		'alias' => array(
				'alias',
				'type' => 'input',
				'name' => 'alias',
				'id' => 'alias',
				'class' => 'input input-xlarge',
				'label' => 'Alias',
		),
		'tentang' => array(
				'tentang',
				//'html_entity_decode',
				'type' => 'textarea',
				'name' => 'tentang',
				'id' => 'tentang',
				'class' => 'input tinymce_mini',
				'rows' => 5,
				'label' => 'Tentang',
		),
		'email' => array(
				'email',
				'type' => 'input',
				'name' => 'email',
				'id' => 'email',
				'class' => 'input input-xlarge',
				'label' => 'Email',
		),
		'username' => array(
				'username',
				'type' => 'input',
				'name' => 'username',
				'id' => 'username',
				'class' => 'input input-xlarge',
				'label' => 'Username',
		),
		'password' => array(
				//'password',
				'type' => 'password',
				'name' => 'password',
				'id' => 'password',
				'class' => 'input input-xlarge',
				'label' => 'Password',
		),
		'passconf' => array(
				//'password',
				'type' => 'password',
				'name' => 'passconf',
				'id' => 'passconf',
				'class' => 'input input-xlarge',
				'label' => 'Konfirm password',
		),
		'role' => array(
				'role',
				'type' => 'input',
				'name' => 'role',
				'id' => 'role',
				'class' => 'input disabled',
				'label' => 'Role',
				'disabled' => 'true',
		),
);
$btn_back = a("data/user/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar user', 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Edit Evaluasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form User</h1>
				</div>

				<?php
				echo alert_get();
				echo form_opening("{$uri}?id={$row['id']}", 'class="form-horizontal well"');
				echo '<fieldset>';

				// data pribadi

				echo '<legend>Data Pribadi</legend>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</div>" . NL;
				endforeach;

				echo '</fieldset><br/><br/>';

				// hak akses admin & sdm

				if ($admin && $user['role'] == 'admin' && in_array($row['role'], array('admin', 'sdm')) && $row['id'] != $user['id']):
					//$this->_view('hak_akses');
					$this->load->view('bootswatch_cosmo/data/user/form/hak_akses');
				endif;

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">'
				. '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> '
				. '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php
			$this->load->view(THEME . "/-html-/content/footer");
			echo alert_get();
			?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		addon('tinymce');
		?>

	</body>
</html>