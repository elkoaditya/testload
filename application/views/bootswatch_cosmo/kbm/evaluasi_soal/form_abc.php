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

$opsi_abc = array(1 =>  'A', 'B', 'C', 'D', 'E');
$pengecoh_jml = $evaluasi['pilihan_jml'];

$input_kunci['kunci_abc'] = $opsi_abc[1];
// pindahkan opsi/pilihan ke variabel semestera saat load pertama

if ($pengecoh_jml >= 2):

	$row['pilihan'] = (array) $row['pilihan']; 
	if (isset($row['pilihan']['kunci']) && is_array($row['pilihan']['kunci']) && !$post_request):
		if(isset($row['pilihan']['kunci']['index'])): 
			// foreach ($row['pilihan']['kunci']['index'] as $opsi): 
				$pengecoh_index = "pengecoh-" . $row['pilihan']['kunci']['index'];
				$pilihan[$pengecoh_index] = $row['pilihan']['kunci']['label'];
			// endforeach;
				$input_kunci['kunci_abc'] = $row['pilihan']['kunci']['index'];
		endif;
	endif;

	if (isset($row['pilihan']['pengecoh']) && is_array($row['pilihan']['pengecoh']) && !$post_request):
		$i = 0;
		foreach ($row['pilihan']['pengecoh'] as $key => $opsi):
			$i++;
			$pengecoh_index = "pengecoh-" . $key;
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

$input_kd = array(
		'posisi_kd',
		'type' => 'dropdown',
		'name' => 'posisi_kd',
		'id' => 'posisi_kd',
		'class' => 'input input-medium',
		'placeholder' => '1 - 100',
		'title' => 'posisi KD',
		'extra' => 'class="input-medium select" id="posisi_kd"',
);
//option KD
for($i=1;$i<=$evaluasi['jml_kd'];$i++){
	$input_kd['options'][$i] = $i;
}

$input_nomor = array(
		'nomor',
		'type' => 'input',
		'name' => 'nomor',
		'id' => 'nomor',
		'class' => 'input input-medium',
		'placeholder' => '1 - 100',
		'title' => 'nomor pertanyaan',
);

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

$kunsian = 1;
while($kunsian<=9){
	$input_kunci_isian[$kunsian] = array(
			'kunci_isian'.$kunsian,
			'type' => 'input',
			'name' => 'kunci_isian'.$kunsian,
			'id' => 'kunci_isian'.$kunsian,
			'class' => 'input input-medium',
			'placeholder' => 'kunci isian ke '.$kunsian,
			'title' => 'kunci isian ke '.$kunsian,
	);
	$kunsian++;
}

$toleran_huruf_kapital = array(
		'toleran_huruf_kapital',
		'label' => 'Tambah Soal Isian Singkat',
		'type' => 'checkbox',
		'name' => 'toleran_huruf_kapital',
		'id' => 'toleran_huruf_kapital',
		'value' => 1,
		'checked' => (bool) ($row['toleran_huruf_kapital']),
		'style' => 'margin: 10px 10px 14px 0;',
);

$input_opsi = array(
		'type' => 'textarea',
		'class' => 'input tinymce_opsi',
		'style' => 'height: 80px;'
);

$input = array( 
		'kunci_abc' => array(
				'kunci_abc',
				'label' => '<b>Kunci</b>',
				'type' => 'dropdown',
				'name' => 'kunci_abc',
				'id' => 'kunci_abc',
				'extra' => 'class="input-large select" id="kunci_abc"',
				'options' => array( 
					'a' => 'Opsi A',
					'b' => 'Opsi B',
					'c' => 'Opsi C',
					'd' => 'Opsi D',
					'e' => 'Opsi E',  
				),
		),
		
	);

$nilai_bonus = array(
		'nilai_bonus',
		'label' => '<b>Nilai Bonus</b>',
		'type' => 'dropdown',
		'name' => 'nilai_bonus',
		'id' => 'nilai_bonus',
		'extra' => 'class="input-large select" id="nilai_bonus"',
		'options' => array(
			0 => 'TIDAK',
			1 => 'YA',
		),
);

$input_komp_dasar = array(
		'type_kd' => array(
				'type_kd',
				'label' => 'Kompetensi Dasar',
				'type' => 'dropdown',
				'name' => 'type_kd',
				'id' => 'type_kd',
				'extra' => 'id="type_kd" class="input input-medium select" onchange="javascript:input_type_kd(this.value)"',
				'options' => array(''=>'')
		),
		'ket_type_kd' => array(
				'ket_type_kd',
				'label' => 'Deskripsi KD',
				'type' => 'input',
				'name' => 'ket_type_kd',
				'id' => 'ket_type_kd',
				'class' => 'input input-xlarge',
				'placeholder' => 'Deskripsi KD',
				'title' => 'Deskripsi KD',
		),
		'materi' => array(
				'materi',
				'label' => 'Materi',
				'type' 	=> 'input',
				'name' 	=> 'materi',
				'id' 	=> 'materi',
				'class' 	=> 'input input-xlarge',
				'placeholder' => 'materi',
				'title' 	=> 'materi',
		),
		'level_kognitif' => array(
			'level_kognitif',
			'label' 	=> 'Level Kognitif',
			'type' 		=> 'dropdown',
			'name' 		=> 'level_kognitif',
			'id' 		=> 'level_kognitif',
			'extra' 	=> 'class="input-large select" id="level_kognitif"',
			'options' => array(
				''	=>	'',
				'pengetahuan' 	=> 'Pengetahuan/Pemahaman',
				'aplikasi' 		=> 'Aplikasi',
				'penalaran'		=> 'Penalaran',
			),
		),
		'indikator' => array(
				'indikator',
				'label' => 'Indikator',
				'type' 	=> 'textarea',
				'name' 	=> 'indikator',
				'id' 	=> 'indikator',
				'class' => 'input input-xxlarge',
				'placeholder' => 'indikator',
				'title' => 'indikator',
		),
);

$jml_kd = 1;
while($jml_kd <= 20){
	$input_komp_dasar['type_kd']['options']['3.'.$jml_kd] = '3.'.$jml_kd; 
	$jml_kd++;
}


$btn_back = a("kbm/evaluasi/id/{$evaluasi['id']}", ' <i class="icon-circle-arrow-left icon-white"></i> Kembali ke detail evaluasi', 'class="btn btn-info "');

alert_info("Soal tersimpan saat ini :: {$evaluasi['soal_total']}");

if ($row['id'] > 0){
	
}else{
	$input_nomor['value'] = $evaluasi['soal_total']+1;
	$input_kd['value'] = $this->input->get_post('posisi_kd');
}
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
					Form Soal Evaluasi - Bagian Soal ke - <?=$this->input->get_post('posisi_kd')?>:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke detail evaluasi"'); ?></h1>
				</div>

				<style>
				</style>

				<?php
				//print_r($evaluasi);
				//echo"<br><br><br>";
				//print_r($row);
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}&evaluasi_id={$evaluasi['id']}", 'class="form-horizontal well"');
				//echo '<input type="hidden" name="posisi_kd" value="'.$this->input->get('posisi_kd').'">';
				///// audio //////////////////
				echo '<fieldset>';
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

				echo '</fieldset><br/><br/>';
				
				
				// data umum
				echo '<fieldset>';
				
				if((!$this->input->get_post('isian')) && (!$this->input->get_post('uraian'))){
					echo '<legend>Posisi Bagian Soal</legend>';

					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"nomor\">Posisi Bagian Soal</label>";
					echo div('class="controls"', form_cell($input_kd, $row));
					echo "</div>" . NL;
				}
				
				echo '<legend>Keterangan Tambahan</legend>';

				foreach ($input_komp_dasar as $inp):
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;
				endforeach;
				
				
				echo '<legend>Soal / Pertanyaan</legend>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"nomor\">Nomor Soal</label>";
				echo div('class="controls"', form_cell($input_nomor, $row));
				echo "</div>" . NL;
				
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"poin_max\">Skor / Poin</label>";
				echo div('class="controls"', form_cell($input_poin, $row));
				echo "</div>" . NL;
				
				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"poin_max\">Nilai Bonus</label>";
				echo div('class="controls"', form_cell($nilai_bonus, $row));
				echo "</div>" . NL;

				echo form_cell($input_pertanyaan, $row);
				echo '<br/><br/><br/>';

				
				
				
				if($this->input->get_post('uraian')){
					
				}else if($this->input->get_post('isian')){
					
					echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"poin_max\">Toleransi Huruf Kecil dan Kapital</label>";
					echo div('class="controls"', form_cell($toleran_huruf_kapital, $row));
					echo "</div>" . NL;
					
					$kunsian = 1;
					while($kunsian<=9){
						echo div('class="control-group"');
						echo "<label class=\"control-label\" for=\"poin_max\">Alternatif Kunci Jawaban ke ".$kunsian."</label>";
						echo div('class="controls"', form_cell($input_kunci_isian[$kunsian], $row));
						echo "</div>" . NL;
						$kunsian++;
					}
					
					
				
				}else{
					// pilihan
					if ($pengecoh_jml > 1):
					
						foreach ($input as $inp):
							echo div('class="control-group"');
							echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
							echo div('class="controls"', form_cell($inp, $input_kunci));
							echo "</label></div>" . NL;
						endforeach;
					
						echo '<legend>Opsi / Pilihan</legend>';
						for ($i = 1; $i <= $pengecoh_jml; $i++):

							$pengecoh_index 		= "pengecoh-" . strtolower($opsi_abc[$i]);
							$input_opsi['id'] 		= $pengecoh_index;
							$input_opsi['name'] 	= $pengecoh_index;
							$input_opsi['value'] 	= html_entity_decode($pilihan[$pengecoh_index]);

							echo "<b>Opsi - {$opsi_abc[$i]}</b>";
							echo form_cell($input_opsi);
							echo '<br/><br/>';

						endfor;

					endif;
				}

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
		
		// echo NL . '<script type="text/javascript" src="' . base_url('assets/tinymce_4.0.2/tinymce.min.js') . '"></script>' . NL;
		
		?>
		
	</body>
</html>

<script>
	function input_type_kd(value) {
		var nama = '';
		
		$.ajax({
			url: '<?php echo base_url()."data/akademik/kompetensi_dasar/chek_nama";?>',
			data: 'kurikulum_id=<?php echo $evaluasi["kurikulum_id"];?>'+
				'&kategori_id=<?php echo $evaluasi["kategori_id"];?>'+
				'&mapel_id=<?php echo $evaluasi["mapel_id"];?>'+
				'&grade=<?php echo $evaluasi["kelas_grade"];?>'+
				'&type_nomor='+value,
			dataType: 'json',
			type: 'POST',
			success: function (j) {
				
				if(j != false){
					nama = j.nama;
				}
				document.getElementById('ket_type_kd').value = nama;
			},	
			error: function (j){
				document.getElementById('ket_type_kd').value = '';
			}
		});
		  
	}
</script>