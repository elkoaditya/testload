<?php
//vars

$file_path = array_node($row, array('lampiran', 'full_path'));
echo $file_path." aaaaaaaaaa ".webpath($file_path);
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
		'Materi' => 'kbm/materi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/materi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link

if ($row['id'] > 0):
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/materi/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan materi',
	);
else:
	$pills[] = array(
			'label' => 'Tabel',
			'uri' => "kbm/materi",
			'attr' => 'title="kembali ke tabel materi"',
	);
	$pills[] = array(
			'label' => 'Kembali',
			'uri' => "kbm/materi/id/{$row['id']}",
			'attr' => 'title="kembali ke tampilan materi',
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
				'class' => 'form-control input-lg',
				'title' => 'isikan nama atau judul materi',
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'label' => 'Pelajaran',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'extra' => 'class="form-control" id="pelajaran_id"',
		),
			/*
			  'konten_tipe' => array(
			  'konten_tipe',
			  'type' => 'dropdown',
			  'name' => 'konten_tipe',
			  'id' => 'konten_tipe',
			  'extra' => 'id="konten_tipe"',
			  'label' => 'Bentuk Materi',
			  'options' => array(
			  'file' => 'File office upload',
			  'artikel' => 'Artikel',
			  ),
			  ),
			 *
			 */
);

if ($row['id'] == 0 OR $author_ybs)
	$input['pelajaran_id']['options'] = $this->m_option->ajaran_user();
else
	$input['pelajaran_id']['options'][$row['pelajaran_id']] = $row['pelajaran_nama'];

$input_konten = array(
		'konten',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'konten',
		'id' => 'konten',
		'class' => 'input input-xxlarge tinymce',
		'rows' => 100,
);

$input_pertanyaan = array(
		'pertanyaan',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'pertanyaan',
		'id' => 'pertanyaan',
		'class' => 'input input-xxlarge tinymce_mini',
);

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/materi/id/{$row['id']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke tampilan materi', 'class="btn btn-info btn-sm m-b-5 m-r-5"');
else
	$btn_back = a("kbm/materi/", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke tabel materi', 'class="btn btn-info btn-sm m-b-5 m-r-5 "');
?>

<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Materi')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>Form Materi</b></h2>
            </div>

			<div class="card">
            	<div class="card-body card-padding">
            <?php
			echo alert_get();
			echo form_openmp("{$uri}?id={$row['id']}", '');

				// data umum

				echo '<fieldset>';
				//echo '<legend>Materi</legend>';

				foreach ($input as $inp):
					if($inp['type']=='input'){
						echo div('class="input-group fg-float col-sm-5 m-t-15"');
						echo div('class="fg-line"');
						echo "<label class=\"fg-label\" ><h4>{$inp['label']}</h4></label>";
					}else{
						echo "<p class='f-500 m-b-15 c-black'><h4>{$inp['label']}</h4></p>";
						echo "<div class='col-sm-5'>
							<div class='form-group'>
								<div class='fg-line'>
									<div class='select'>";
					}
					echo form_cell($inp, $row);
					
					if($inp['type']=='input')
					{
						echo "</label>";
						echo "</div>" . NL."</div>";
					}else{
						echo "</div></div></div></div>";
					}
					echo "<br/>" . NL;
					
				endforeach;

				echo '</fieldset>';

				// data upload

				echo '<fieldset>';
				echo '<div id="materi-file">';
				echo '<p class="f-500 m-b-15 c-black"><h4>Upload File / Lampiran</h4></p>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="fileinput fileinput-new" data-provides="fileinput"');
				echo '<span class="btn btn-primary btn-file m-r-10">';
				echo '<span class="fileinput-new">Pilih file</span>
                                            <span class="fileinput-exists">Upload</span>';
				echo form_upload('upload') . '</span><br/>';
				echo p('', '<i>file Microsoft Office, PDF atau gambar.</i>');

				if ($file_anchor)
					echo "tersimpan : {$file_anchor} <br/>";

				if ($upload_anhor)
					echo "diupload : {$upload_anhor} <br/>";

				echo '<span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a></div>';
				echo "</div>" . NL;
				echo '</div>';
				echo '</fieldset><br/>';
				
				
				// ketik artikel

				echo '<fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Artikel Materi</h4></p>';

				echo div('class="control-group"');
				//echo "<label class=\"control-label\" for=\"upload\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_button('', 'ketikan isi artikel', 'id="cmd-artikel" class="btn btn-info m-b-5"');
				echo '</div>';
				echo '</div>';

				echo '<div id="materi-artikel">';
				echo form_cell($input_konten, $row);
				echo '</div>';
				echo '</fieldset><br/><br/>';

				// ketik pertanyaan

				echo '<fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Pertanyaan siswa</h4></p>';
				echo form_cell($input_pertanyaan, $row);
				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div >'
				. '<button type="submit" class="btn btn-success btn-sm m-b-5 m-r-5"><i class="zmdi zmdi-check"></i> Simpan</button> '
				. '<button type="reset" class="btn bgm-gray btn-sm m-b-5 m-r-5"><i class="zmdi zmdi-close"></i> Batal</button> &nbsp; &nbsp; '
				. $btn_back
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>
                	</div>
                </div>
                
			</div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer_form"); ?>
<?php
		addon('tinymce');
		?>
<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );
        
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);




	$(function() {
		$("#konten_tipe").change(function() {
			if ($(this).val() === "artikel") {
				$('#materi-artikel').slideDown(100);
				$('#materi-file').slideUp(100);
			} else {
				$('#materi-file').slideDown(100);
				$('#materi-artikel').slideUp(100);
			}
		});
		$('#cmd-artikel').click(function() {
			$('#materi-artikel').slideToggle(100);
		});
		$("#konten_tipe").change();
		konten = $('#konten').html();

		if (konten == '')
			$('#materi-artikel').slideUp(100);
	});
</script>

	</body>
</html>
