<?php
//audio
if(isset($row['audio']))
{
	$suara_tersimpan = $row['audio'];
	$sound_tersimpan = (!file_exists($suara_tersimpan)) ? NULL : array('src' => webpath($suara_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');
}else{
	$sound_tersimpan="";
}

// vars

//$pengecoh_jml = $evaluasi['pilihan_jml'] - 1;
$pengecoh_jml = 4;
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
		'Bank soal' => 'kbm/bank_soal',
		//"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		//'Soal' => "kbm/evaluasi_soal/browse?evaluasi_id={$evaluasi['id']}",
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
		'class' => 'input input-medium',
		'placeholder' => '1 - 100',
		'title' => 'bobot / poin pertanyaan',
);
/*
$input_kesulitan = array(
		'kesulitan',
		'label' => 'Kesulitan',
		'type' => 'dropdown',
		'name' => 'kesulitan',
		'id' => 'kesulitan',
		'extra' => 'class="input-large select" id="kesulitan"',
		'options' => array(
				'mudah' => 'mudah',
				'sedang' => 'sedang',
				'sulit' => 'sulit',
		),
);
*/
$input_option = array(
		'kurikulum_id' => array(
				'kurikulum_id',
				'label' => 'Kurikulum',
				'type' => 'dropdown',
				'name' => 'kurikulum_id',
				'id' => 'kurikulum_id',
				'extra' => 'id="kurikulum_id" class="input input-medium select"',
				'options' => $this->m_option->kurikulum(),
		),
		'kategori_id' => array(
				'kategori_id',
				'label' => 'Kategori',
				'type' => 'dropdown',
				'name' => 'kategori_id',
				'id' => 'kategori_id',
				'extra' => 'id="kategori_id" class="input input-large select"',
				'options' => $this->m_option->kategori_mapel(),
		),
		'mapel_id' => array(
				'mapel_id',
				'label' => 'Mapel',
				'type' => 'dropdown',
				'name' => 'mapel_id',
				'id' => 'mapel_id',
				'extra' => 'id="mapel_id" class="input input-large select"',
				'options' => $this->m_option->mapel(),
		),
		'grade' => array(
				'grade',
				'label' => 'Grade',
				'type' => 'dropdown',
				'name' => 'grade',
				'id' => 'grade',
				'extra' => 'id="grade" class="input-medium select"',
				'options' => $this->m_option->grade(),
		),
);
if ($user['role'] != 'admin'):

	$input_option['mapel_id']['options'] = $this->m_option->mapel_user('', 'evaluasi');
	$input_option['kategori_id']['options'] = $this->m_option->kategori_mapel_user('', 'evaluasi');

endif;

if($this->input->get_post('kurikulum_id')){
	$row['kurikulum_id'] 	= $this->input->get_post('kurikulum_id');		
}
if($this->input->get_post('kategori_id')){
	$row['kategori_id'] 	= $this->input->get_post('kategori_id');		
}
if($this->input->get_post('mapel_id')){
	$row['mapel_id'] 		= $this->input->get_post('mapel_id');		
}
if($this->input->get_post('grade')){
	$row['grade'] 			= $this->input->get_post('grade');		
}
if($this->input->get_post('komp_dasar_id')){
	$row['komp_dasar_id'] 	= $this->input->get_post('komp_dasar_id');
}

$kurikulum_id	= 0; 
$kategori_id	= 0;
$mapel_id		= 0; 
$grade			= 0;  
if($row['id']>0){
	$kurikulum_id	= $row['kurikulum_id']; 
	$kategori_id	= $row['kategori_id'];
	$mapel_id 		= $row['mapel_id']; 
	
	if(isset($row['grade'])){
		$grade 			= $row['grade'];
	}
	if(isset($row['komp_dasar_id'])){
		$komp_dasar_id	= $row['komp_dasar_id'];
	}
}
$input_kd = array(
	'komp_dasar_id',
	'label' => 'Kompetensi Dasar',
	'type' => 'dropdown',
	'name' => 'komp_dasar_id',
	'id' => 'komp_dasar_id',
	'extra' => 'id="komp_dasar_id" class="input input-large select"',
	'options' => array(
						'' => '',
				),
);
if( ($row['id']>0) || ($this->input->get_post('komp_dasar_id')) ){
	$input_kd['options'] = $this->m_option->kompetensi_dasar(FALSE, $kurikulum_id, $kategori_id, $mapel_id, $grade );
}

if(APP_SUBDOMAIN=='sman3-smg.fresto.co'){
	$input_kesukaran = array(
		'kesukaran',
		'label' => 'Tingkat Kesukaran',
		'type' => 'dropdown',
		'name' => 'kesukaran',
		'id' => 'kesukaran',
		'extra' => 'id="kesukaran" class="input input-medium select"',
		'options' => array(
							'C1' => 'C1',
						'C2' => 'C2',
						'C3' => 'C3',
						'C4' => 'C4',
						'C5' => 'C5',
						'C6' => 'C6',
					),
	);
}else{
	$input_kesukaran = array(
		'kesukaran',
		'label' => 'Tingkat Kesukaran',
		'type' => 'dropdown',
		'name' => 'kesukaran',
		'id' => 'kesukaran',
		'extra' => 'id="kesukaran" class="input input-medium select"',
		'options' => array(
							'mudah' => 'Mudah',
							'sedang' => 'Sedang',
							'sulit' => 'Sulit',
					),
	);

}
		
$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_opsi',
		'style' => 'height: 80px;'
);

//$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');
$btn_back = a("kbm/bank_soal/browse", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke daftar bank soal', 'class="btn btn-info "');

//alert_info("Soal tersimpan saat ini :: {$evaluasi['soal_total']}");
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Form Soal')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Form Bank Soal:</h1>
					<!--<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke detail evaluasi"'); ?></h1>-->
				</div>
				
				<?php
				//print_r($row);?>
				<style>
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}", 'class="form-horizontal well"');

				
				
				
				// data umum

				echo '<fieldset>';
				echo '<legend>Mapel KD </legend>';

				foreach ($input_option as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;
				
				echo '<fieldset>';
				echo '<legend>Kompetensi Dasar </legend>';
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"kd\">Kompetensi Dasar</label>";
				echo div('class="controls"', form_cell($input_kd, $row));
				echo "</label></div>" . NL;
				
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"kd\">Tingkat Kesukaran</label>";
				echo div('class="controls"', form_cell($input_kesukaran, $row));
				echo "</label></div>" . NL;
				
				///// audio //////////////////
				//echo '<fieldset>';
				echo '<legend>Upload Sound</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"audio\">&nbsp;</label>";
				echo div('class="controls"');
				echo form_upload('audio', '', 'class="input-upload"') . '<br/>';
				echo '<i>Audio untuk Listening Section</i><br/><br/>';
				if ($sound_tersimpan )
				{
					echo '<table border="0"><tr>';
					echo tag('td', 'align="center"', "File <br/>".base_url().$row['audio'] . ' <br/><i>tersimpan</i>');
					echo '</tr></table>';
				}
				echo "</div>";
				echo "</div>" . NL;
				
				//echo '</fieldset><br/><br/>';
				
				echo '<legend>Soal / Pertanyaan</legend>';
				/*
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"poin_max\">Skor / Poin</label>";
				echo div('class="controls"', form_cell($input_poin, $row));
				echo "</div>" . NL;
				*/
				echo form_cell($input_pertanyaan, $row);
				echo '<br/><br/><br/>';

				
				// pilihan

				if ($pengecoh_jml > 1):
					echo '<legend>Opsi / Pilihan</legend>';

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
						echo '<br/><br/>';

					endfor;

				endif;

				echo '</fieldset><br/>';

				// form button

				echo '<fieldset>';
				echo '<div class="form-actions well">';
				echo '<button type="submit" class="btn btn-success"><i class="icon-save icon-white"></i> Akhiri Menulis Soal.</button> ';

				if ($row['id'] > 0)
					echo '<button type="reset" class="btn"><i class="icon-undo icon-white"></i> Batal</button> &nbsp; &nbsp; ';
				else
					echo '<button type="submit" class="btn btn-success" name="tambah" value="true"><i class="icon-save icon-white"></i> Tulis Soal Berikutnya.</button>  &nbsp; &nbsp; ';

				echo $btn_back;
				echo '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php
		echo cosmo_js();
		addon('tinymce');
		
		//echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce_4.0.2/tinymce.min.js') . '"></script>' . NL;
		?>

		<script type="text/javascript">
			
			$(function() {
				
				function kompetensi_dasar( handleData, kurikulum_id, kategori_id, mapel_id, grade) {
						
					  //if (this.timer) clearTimeout(this.timer);
					  
					  //this.timer = setTimeout(function () {
						  var result;
						$.ajax({
						  url: '<?php echo base_url()."kbm/bank_soal/list_data";?>',
						  data: 'kurikulum_id='+kurikulum_id+'&kategori_id='+kategori_id+'&mapel_id=' + mapel_id+'&grade=' + grade,
						  dataType: 'json',
						  type: 'POST',
						  success: function (j) {
								 //result =  j;
								handleData(j); 
								 //document.write(j);
						  }		  
						  
						});
					  //}, 200);
					  
				};
	  
				function change_kd(){
					var kurikulum_id 	= document.getElementById("kurikulum_id").value;
					var kategori_id 	= document.getElementById("kategori_id").value;
					var mapel_id 		= document.getElementById("mapel_id").value;
					var grade 			= document.getElementById("grade").value;
			
					var myDiv = document.getElementById("komp_dasar_id");
					// Clear all
					var lengthx = myDiv.options.length;
					for (x = 0; x < lengthx; x++) {
					  myDiv.options[0] = null;
					}

					//Create array of options to be added
					//var result = kompetensi_dasar(kurikulum_id, kategori_id, mapel_id, grade);
					
					kompetensi_dasar(function(output){
						//document.write(result);
						var array_id = output['id'];
						var array_label = output['nama'];

						//Create and append select list
						/*var selectList = document.createElement("select");
						selectList.id = "mySelect";
						myDiv.appendChild(selectList);
	*/
						//Create and append the options
						for (var i = 0; i < array_id.length; i++) {
							var option = document.createElement("option");
							option.value = array_id[i];
							option.text = array_label[i];
							myDiv.appendChild(option);
						}
					}, kurikulum_id, kategori_id, mapel_id, grade);
				}
				
				$("#kurikulum_id").change(function() {
					change_kd();
				});
				$("#kategori_id").change(function() {
					change_kd();
				});
				$("#mapel_id").change(function() {
					change_kd();
				});
				$("#grade").change(function() {
					change_kd();
				});
				//$("#kurikulum_id").change();
				<?php if( ($row['id']>0) || ($this->input->get_post('komp_dasar_id')) ){ ?>
				<?php }else{?>
					change_kd();
				<?php }?>
			});
		
		</script>
		<!--
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
		-->
	</body>
</html>