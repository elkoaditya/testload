<?php
$img_sample = array(
	"1.jpg",
	"2.jpg",
	"3.jpg",
	"4.jpg",
	"5.jpg",
	"6.jpg",
);
$warna=array(
		'class="btn bgm-cyan"', 
		'class="btn bgm-teal"',
		'class="btn bgm-amber"',
		'class="btn bgm-orange"',
		'class="btn bgm-deeporange"',
		'class="btn bgm-red"',
		'class="btn bgm-pink"',
		'class="btn bgm-lightblue"',
		'class="btn bgm-indigo"',
		'class="btn bgm-lime"',
		'class="btn bgm-lightgreen"',
		'class="btn bgm-green"',
		'class="btn bgm-purple"',
		'class="btn bgm-deeppurple"',
		);
		
//audio
if(isset($row['audio']))
{
	$suara_tersimpan = $row['audio'];
	$sound_tersimpan = (!file_exists($suara_tersimpan)) ? NULL : array('src' => webpath($suara_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
}else{	$sound_tersimpan = '';	}
// vars

$pengecoh_jml = $evaluasi['pilihan_jml'] - 1;

// pindahkan opsi/pilihan ke variabel semestera saat load pertama

if ($pengecoh_jml > 1):

	$row['pilihan'] = (array) $row['pilihan'];

	if (isset($row['pilihan']['kunci']) && is_array($row['pilihan']['kunci']) && !$post_request):
		foreach ($row['pilihan']['kunci'] as $opsi):
			$pilihan['kunci'] = $opsi;
		endforeach;
	endif;

	if (isset($row['pilihan']['pengecoh']) && is_array($row['pilihan']['pengecoh']) && !$post_request):
		$i = 0;
		foreach ($row['pilihan']['pengecoh'] as $opsi):
			$i++;
			$pengecoh_index = "pengecoh-" . $i;
			$pilihan[$pengecoh_index] = $opsi;
		endforeach;
	endif;

endif;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}",
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi_soal/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input_pertanyaan = array(
		'pertanyaan',
		//'html_entity_decode',
		'type' => 'textarea',
		'name' => 'pertanyaan',
		'id' => 'pertanyaan',
		'class' => 'input tinymce_soal',
		'style' => 'height: 200px;',
);

$input_poin = array(
		'poin_max',
		'type' => 'input',
		'name' => 'poin_max',
		'id' => 'poin_max',
		'class' => 'form-control input-lg',
		'title' => 'bobot / poin pertanyaan',
);

$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_opsi',
		'style' => 'height: 80px;'
);

$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke detail evaluasi', 'class="btn btn-info btn-sm m-b-5 m-r-5"');

alert_info("Soal tersimpan saat ini :: {$evaluasi['soal_total']}");
?>

<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Soal Evaluasi')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>Form Soal Evaluasi</b></h2>
            </div>
            
            <div class="card">
            	<div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$row['id']}", $evaluasi['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $evaluasi['author_nama'];?></li>
                                <li>Mapel <?php echo $evaluasi['mapel_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                </div>
            	<div class="card-body card-padding">
            


				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}&evaluasi_id={$evaluasi['id']}", '');

				///// audio //////////////////
				echo '<fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Upload Sound</h4></p>';

				echo div('class="control-group"');
				//echo "<label class=\"control-label\" for=\"audio\">&nbsp;</label>";
				echo div('class="controls"');
				
				echo div('class="fileinput fileinput-new" data-provides="fileinput"');
				echo '<span class="btn btn-primary btn-file m-r-10">';
				echo '<span class="fileinput-new">Pilih file</span>
                                            <span class="fileinput-exists">Upload</span>';
											
				echo form_upload('audio', '', 'class="input-upload"') . '</span><br/>';
				echo '<i>Audio untuk Listening Section</i><br/><br/>';
				if ($sound_tersimpan )
				{
					echo '<table border="0"><tr>';
					echo tag('td', 'align="center"', "File <br/>".base_url().$row['audio'] . ' <br/><i>tersimpan</i>');
					echo '</tr></table>';
				}
				echo '<span class="fileinput-filename"></span>
                                        <a href="#" class="close fileinput-exists" data-dismiss="fileinput">&times;</a></div>';
										
				echo "</div>";
				echo "</div>" . NL;

				echo '</fieldset><br/><br/>';
				
				
				// data umum

				echo '<fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Soal / Pertanyaan</h4></p>';

				echo div('class="control-group"');
				echo div('class="input-group fg-float col-sm-2"');
				echo div('class="fg-line"');
				echo "<label class=\"fg-label\" ><b>Skor / Poin (1-100)</b></label>";
				echo div('class="select"', form_cell($input_poin, $row));
				echo "</div>
				</div></div><br/>" . NL;

				echo form_cell($input_pertanyaan, $row);
				echo '<br/><br/><br/>';

				
				// pilihan

				if ($pengecoh_jml > 1):
					echo '<p class="f-500 m-b-15 c-black"><h4>Opsi / Pilihan</h4></p>';

					$input_opsi['id'] = 'kunci';
					$input_opsi['name'] = 'kunci';
					$input_opsi['value'] = html_entity_decode($pilihan['kunci']);

					echo "<b>Kunci</b>";
					echo form_cell($input_opsi);
					echo '<br/><br/>';

					for ($i = 1; $i <= $pengecoh_jml; $i++):

						$pengecoh_index = "pengecoh-" . $i;
						$input_opsi['id'] = $pengecoh_index;
						$input_opsi['name'] = $pengecoh_index;
						$input_opsi['value'] = html_entity_decode($pilihan[$pengecoh_index]);

						echo "<b>Pengecoh - {$i}</b>";
						echo form_cell($input_opsi);
						echo '<br/>';

					endfor;

				endif;

				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div >';
				echo '<button type="submit" class="btn btn-success btn-sm m-b-5 m-r-5">
				<i class="zmdi zmdi-check"></i> Akhiri Menulis Soal.</button> ';

				if ($row['id'] > 0)
					echo '<button type="reset" class="btn bgm-gray btn-sm m-b-5 m-r-5">
					<i class="zmdi zmdi-close"></i> Batal</button> &nbsp; &nbsp; ';
				else
					echo '<button type="submit" class="btn btn-success btn-sm m-b-5 m-r-5" name="tambah" value="true">
					<i class="zmdi zmdi-check"></i> Tulis Soal Berikutnya.</button>  &nbsp; &nbsp; ';

				echo $btn_back;
				echo '</div>';
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
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

</script>
		<?php
		echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce_4.0.2/tinymce.min.js') . '"></script>' . NL;
		?>

		<script type="text/javascript">
			tinymce.init({
				selector: "textarea.tinymce_soal",
				theme: "modern",
				width: '100%',
				height: 240,
				plugins: [
					"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"save table contextmenu directionality emoticons template paste textcolor",
					"jbimages"
				],
				toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | forecolor backcolor | eqneditor asciimath asciimathcharmap asciisvg | youtube jbimages",
				style_formats: [
					{title: 'Bold text', inline: 'b'},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Example 1', inline: 'span', classes: 'example1'},
					{title: 'Example 2', inline: 'span', classes: 'example2'},
					{title: 'Table styles'},
					{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
				],
				AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
				ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
				relative_urls: false
			});
			tinymce.init({
				selector: "textarea.tinymce_opsi",
				theme: "modern",
				width: '100%',
				height: 120,
				plugins: [
					"eqneditor advlist autolink link image lists charmap print preview hr anchor pagebreak",
					"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					"save table contextmenu directionality emoticons template paste textcolor",
					"jbimages"
				],
				toolbar: "insertfile undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image media | forecolor backcolor | eqneditor asciimath asciimathcharmap asciisvg | youtube jbimages",
				AScgiloc: '<?php base_url(); ?>/imathas/svgimg.php',
				ASdloc: '<?php base_url(); ?>/assets/tinymce_4.0.2/plugins/asciisvg/js/d.svg',
				relative_urls: false
			});
		</script>

	</body>
</html>