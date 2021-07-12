<?php
// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Nilai' => 'nilai',
		'Organisasi' => 'nilai/organisasi',
		'#impor keterangan organisasi'
);

// pills link

$pills[] = array(
		'label' => '<i class="icon-table"></i>Keterangan Organisasi',
		'uri' => 'nilai/organisasi',
		'attr' => 'title="kembali ke daftar keterangan organisasi"',
);
$pills[] = array(
		'label' => "<i class=\"icon-table\"></i>Keterangan {$row['org_nama']}",
		'uri' => "nilai/organisasi/id/{$row['id']}",
		'attr' => 'title="kembali ke detail nilai organisasi"',
);
$opsi_kelas = $this->m_option->kelas();

// buttons

$btn_back = a("nilai/organisasi/id/{$row['id']}", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke daftar keterangan organisasi siswa", 'class="btn btn-info "');
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Impor Keterangan Organisasi')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Impor Keterangan Organisasi :: <?php echo $row['org_nama']; ?></h1>
				</div>

				<?php
				echo alert_get();
				echo pills($pills);

				// upload

				echo form_openmp("{$uri}/{$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';
				echo '<legend>Pilih berkas yg ingin diimpor</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('upload', '', 'id="upload"');
				echo "</div>" . NL;
				echo "</label></div>" . NL;
				echo '</fieldset>';

				// form button

				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Simpan</button> ';
				echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button>&nbsp; &nbsp; ';
				echo $btn_back;
				echo '</div>';
				echo '</fieldset>';

				echo form_close() . '<br/><br/><br/>';

				// download

				echo form_openmp("nilai/organisasi/expor/{$row['id']}", 'class="form-horizontal well"');

				echo '<fieldset>';
				echo '<legend>Download format import</legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">Pilih kelas</label>";
				echo div('class="controls"');

				foreach ($opsi_kelas as $kelas_id => $kelas_nama):
					echo "<label class=\"checkbox\">"
					. form_checkbox(array(
							'name' => 'kelas_list[]',
							'id' => 'kelas-' . $kelas_id,
							'value' => $kelas_id,
							'checked' => FALSE,
					))
					. $kelas_nama
					. "</label>";
				endforeach;

				echo "</div>" . NL;
				echo "</label></div>" . NL;
				echo '</fieldset>';

				// form button

				echo '<div class="form-actions">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-download icon-white"></i> Download</button> ';
				echo '</div>';
				echo '</fieldset>';

				echo form_close() . '<br/><br/><br/>';
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>