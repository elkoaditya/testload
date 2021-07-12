<?php
//vars

$file_path = array_node($row, array('lampiran', 'full_path'));
$file_link = ($file_path && file_exists($file_path)) ? webpath($file_path) : NULL;
$file_name = array_nodex($row, array('lampiran', 'file_name'), 'berkas-tersimpan');
$file_anchor = ($file_link) ? a($file_link, $file_name, '') : NULL;

$upload_path = array_node($form, array('upload', 'full_path'));
$upload_link = ($upload_path && file_exists($upload_path)) ? webpath($upload_path) : NULL;
$upload_name = array_nodex($form, array('upload', 'file_name'), 'berkas-diupload');
$upload_anhor = ($upload_link) ? a($upload_link, $upload_name, '') : NULL;

if (!$post_request && $row['id'] == 0)
	$row['pelajaran_id'] = (int) $this->input->get_post('pelajaran_id');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Video Call' => 'kbm/vidcall',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/vidcall/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0):
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/vidcall/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan vidcall',
	);
else:
	$pills[] = array(
			'label' => 'Tabel',
			'uri' => "kbm/vidcall",
			'attr' => 'title="kembali ke tabel vidcall"',
	);
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/vidcall/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan vidcall',
	);

endif;

// input data

$input = array(
		'nama' => array(
				'nama',
				'label' => 'Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'input input-xxlarge',
				'placeholder' => 'nama / judul vidcall',
				'title' => 'isikan nama atau judul vidcall',
		),
		'tanggal_publish' => array(
				'tanggal_publish',
				'label' => 'Vidcall Mulai',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_publish',
				'id' 	=> 'tanggal_publish',
				'class' => 'input input-medium tglwaktu',
				'placeholder' => 'yyyy-mm-dd hh:ii',
				'title' => 'isikan tanggal publish ',
		),
		'tanggal_tutup' => array(
				'tanggal_tutup',
				'label' => 'Vidcall Tutup',
				'type' 	=> 'input',
				'name' 	=> 'tanggal_tutup',
				'id' 	=> 'tanggal_tutup',
				'class' => 'input input-medium tglwaktu',
				'placeholder' => 'yyyy-mm-dd hh:ii',
				'title' => 'isikan tanggal tutup ',
		),
		'tampil_guru' => array(
				'tampil_guru',
				'label' => 'Tampil ke Guru',
				'type' => 'checkbox',
				'name' => 'tampil_guru',
				'id' => 'tampil_guru',
				'value' => 1,
				'checked' => (bool) ($row['tampil_guru']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
		
);


$date_now = date("Y-m-d");
$input['tanggal_publish']['value'] = $date_now;
$input['tanggal_tutup']['value'] = "";

if(isset($row['tanggal_publish'])){
	$input['tanggal_publish']['value'] = $row['tanggal_publish']." 08:00";
}

$input['tanggal_publish']['value'] = datefix($input['tanggal_publish']['value'] , 'Y-m-d H:i');
if($input['tanggal_tutup']['value']!=''){
	$input['tanggal_tutup']['value'] = datefix($input['tanggal_tutup']['value'] , 'Y-m-d H:i');
}

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/vidcall/id/{$row['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tampilan vidcall', 'class="btn btn-info "');
else
	$btn_back = a("kbm/vidcall/", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke tabel vidcall', 'class="btn btn-info "');
?>
<!DOCTYPE html>

	
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Video Call')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Video Call</h1>
				</div>

				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", 'class="form-horizontal well"');

				// data umum

				echo '<fieldset>';
				echo '<legend>Video Call</legend>';

				foreach ($input as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;

				echo '</fieldset><br/>';

				echo div('class="control-group"  id="controls-kelas"');
				echo "<label class=\"control-label\" for=\"upload\">Pilih kelas</label>";
				echo div('class="controls"');
				//print_r($kelas);
				foreach ($opsi_kelas as $kelas_id => $kelas_nama):
				
					if(isset($kelas[$kelas_id])){
						$checked = TRUE;
					}else{
						$checked = FALSE;
					}
					
					echo "<label class=\"checkbox\">"
					. form_checkbox(array(
							'name' => 'kelas[]',
							'id' => 'kelas-' . $kelas_id,
							'value' => $kelas_id,
							'checked' => $checked,
					))
					. $kelas_nama
					. "</label>";
				endforeach;

				echo "</div>" . NL;
				echo "</label></div>" . NL;
				echo '</fieldset>';
				
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

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		//addon('tinymce');
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		addon('timepicker');
		?>

		<script type="text/javascript">
			$(function() {
				$('.tglwaktu').datetimepicker({dateFormat: "yy-mm-dd"});
				
			});
		</script>

	</body>
</html>