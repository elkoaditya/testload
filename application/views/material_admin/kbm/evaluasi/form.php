<?php
//audio
$suara_tersimpan = $row['audio'];
$sound_tersimpan = (!file_exists($suara_tersimpan)) ? NULL : array('src' => webpath($suara_tersimpan), 'class' => "thumbnail", 'title' => 'tersimpan');

// vars

if ($row['id'] == 0 && !$post_request)
	$row['pelajaran_id'] = $this->input->get_post('pelajaran_id');

if ($row['id'] > 0 && !$row['soal_jml'])
	$row['soal_jml'] = NULL;

if ($row['id'] > 0 && !$row['ljs_max'])
	$row['ljs_max'] = NULL;

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
);

if ($row['id'] > 0):
	$breadcrumbs["#{$row['id']}"] = "kbm/evaluasi/id/{$row['id']}";
	$breadcrumbs[] = "#edit";
else:
	$breadcrumbs[] = "#baru";
endif;

// pills link
// input data

$input['umum'] = array(
		'nama' => array(
				'nama',
				'label' => 'Nama / Judul',
				'type' => 'input',
				'name' => 'nama',
				'id' => 'nama',
				'class' => 'form-control input-lg',
				'title' => 'nama/kompetensi',
		),
		'pelajaran_id' => array(
				'pelajaran_id',
				'type' => 'dropdown',
				'name' => 'pelajaran_id',
				'id' => 'pelajaran_id',
				'label' => 'Pelajaran',
				'extra' => 'class="form-control"  id="pelajaran_id"',
				'options' => 'opsi_pelajaran',
		),
		'tipe' => array(
				'tipe',
				'label' => 'Tipe',
				'type' => 'dropdown',
				'name' => 'tipe',
				'id' => 'tipe',
				'extra' => 'class="form-control"  id="tipe"',
				'options' => array(
						'latihan' => 'Latihan',
						'ulangan' => 'Ulangan',
						'ulangan_tengah_semester' => 'Ulangan Tengah Semester',
						'ulangan_akhir_semester' => 'Ulangan Akhir Semester',
						'tryout' => 'TryOut',
						'remidi' => 'Remidi',
						'tugas' => 'Tugas',
						'praktek' => 'Praktek',
				),
		),
		'pilihan_jml' => array(
				'pilihan_jml',
				'label' => 'Bentuk Soal',
				'type' => 'dropdown',
				'name' => 'pilihan_jml',
				'id' => 'pilihan_jml',
				'extra' => 'class="form-control"  id="pilihan_jml"',
				'options' => array(
						'Uraian',
						//3 => 'Pilihan Ganda : 3 opsi',
						4 => 'Pilihan Ganda : 4 opsi',
						5 => 'Pilihan Ganda : 5 opsi',
				),
		),
		'kkm' => array(
				'kkm',
				'label' => 'KKM',
				'type' => 'input',
				'name' => 'kkm',
				'id' => 'kkm',
				'class' => 'form-control input-lg',
				'title' => 'kriteria ketuntasan minimal',
		),
);
$input['checkbox'] = array(
		'soal_acak' => array(
				'name' => 'soal_acak',
				'id' => 'soal_acak',
				'value' => 1,
				'checked' => (bool) ($row['soal_acak']),
				'style' => 'margin: 10px 10px 14px 0;',
		),
);
$input['opsi'] = array(
		'soal_jml' => array(
				'soal_jml',
				'label' => 'Jumlah Soal Tampil (semua)',
				'type' => 'input',
				'name' => 'soal_jml',
				'id' => 'soal_jml',
				'class' => 'form-control input-lg',
				'title' => 'jumlah soal yang tampil untuk dikerjakan siswa',
				'suffix' => '<div class="subinfo">*jika kosong atau o (nol) berarti semua butir soal ditampilkan.</div>',
		),
		'ljs_max' => array(
				'ljs_max',
				'label' => 'Kesempatan mencoba (tidak terbatas)',
				'type' => 'input',
				'name' => 'ljs_max',
				'id' => 'ljs_max',
				'class' => 'form-control input-lg',
				'title' => 'jumlah maksimal untuk mengerjakan soal',
				'suffix' => '<div class="subinfo">**jika kosong atau o (nol) berarti kesempatan mencoba tidak dibatasi.</div>',
		),
);

// setup mode edit

if (!$modit['aturan']):
	$input['umum']['tipe']['extra'] .= ' disabled="true"';
	$input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
	$input['opsi-cek']['soal_acak']['disabled'] = 'true';
	$input['opsi']['ljs_max']['disabled'] = 'true';
endif;

if (!$modit['pelajaran']):
	$input['umum']['pelajaran_id']['extra'] .= ' disabled="true"';
endif;

if (!$modit['bentuk']):
	$input['umum']['pilihan_jml']['extra'] .= ' disabled="true"';
endif;

// buttons

if ($row['id'] > 0)
	$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke tampilan evaluasi', 'class="btn btn-info  btn-sm m-b-5 m-r-5"');
else
	$btn_back = a("kbm/evaluasi", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke detail evaluasi', 'class="btn btn-info  btn-sm m-b-5 m-r-5"');

$i_mulai = array(
		'type' => 'input',
		'class' => 'form-control date-time-picker',
		'placeholder' => 'mm-dd-yyyy hh:ii',
		'title' => 'isikan tanggal-jam mulai ',
);
$i_ditutup = array(
		'type' => 'input',
		'class' => 'form-control date-time-picker',
		'placeholder' => 'mm-dd-yyyy hh:ii',
		'title' => 'isikan tanggal-jam selesai',
);
$evaluasi_mulai = (array) $this->input->post('evaluasi_mulai');
$evaluasi_ditutup = (array) $this->input->post('evaluasi_ditutup');
?>
<html>
<?php $this->load->view(THEME . "/-html-/head_form", array('title' => 'Form Evaluasi')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>Form Evaluasi</b></h2>
            </div>

			<div class="card">
            	<div class="card-body card-padding">

				<style>
					#detail-tambahan{
						display: none;
					}
					.subinfo{
						font-size: 0.8em;
						opacity: 0.8;
						font-style: italic;
					}
				</style>

				<?php
				echo alert_get();
				echo form_openmp("{$uri}?id={$row['id']}", '');
				echo '<fieldset>';

				echo '<p class="f-500 m-b-15 c-black"><h4>Informasi Umum</h4></p>';

// input umum

				foreach ($input['umum'] as $inp):
					/*echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;*/
					
					if($inp['type']=='input'){
						echo div('class="input-group fg-float col-sm-5 m-t-15"');
						echo div('class="fg-line"');
						echo "<label class=\"fg-label\" ><h5>{$inp['label']}</h5></label>";
					}else{
						echo "<p class='f-500 m-b-15 c-black'><h5>{$inp['label']}</h5></p>";
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
						echo "</div></div></div></div><br/><br/>";
					}
					echo "<br/>" . NL;
				endforeach;

				///// audio //////////////////
				echo '<fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Upload Sound</h4></p>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"audio\">&nbsp;</label>";
				echo div('class="controls"');
				
				echo div('class="fileinput fileinput-new" data-provides="fileinput"');
				echo '<span class="btn btn-primary btn-file m-r-10">';
				echo '<span class="fileinput-new">Pilih file</span>
                                            <span class="fileinput-exists">Upload</span>';
											
				echo form_upload('audio', '', 'class="input-upload"') . '</span><br/>';
				echo p('', '<i>Audio untuk Listening Section</i>');
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
				
				// input opsi tambahan
				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';

				echo div('class="control-group"');
				echo "<label class=\"control-label\" for=\"checkbox\"><h5>Acak Soal</h5></label>";
				echo div('class="checkbox"');
				echo "<label class=\"checkbox\" for=\"soal_acak\">"
				
				. form_checkbox($input['checkbox']['soal_acak'])
				.'<i class="input-helper" ></i>'
				. " acak soal yang tampil ke siswa</label>";
				echo '</div>';
				echo "</div>" . NL;

				foreach ($input['opsi'] as $inp):
					/*echo div('class="control-group"');
					echo "<label class=\"control-label\" for=\"{$inp['id']}\">{$inp['label']}</label>";
					echo div('class="controls"', form_cell($inp, $row));
					echo "</label></div>" . NL;*/
					if($inp['type']=='input'){
						echo div('class="input-group fg-float col-sm-5 m-t-15"');
						echo div('class="fg-line"');
						echo "<label class=\"fg-label\" ><h5>{$inp['label']}</h5></label>";
					}else{
						echo "<p class='f-500 m-b-15 c-black'><h5>{$inp['label']}</h5></p>";
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
						echo "</div></div></div></div><br/><br/>";
					}
					echo "<br/>" . NL;
				endforeach;

				echo '</fieldset></div><br/><br/>';

// jadwal evaluasi

				echo '<fieldset>';

				echo '<p class="f-500 m-b-15 c-black"><h4>Jadwal Pelaksanaan</h4></p>';
				//echo '<div class="table-responsive">';
				//echo '<table id="data-table-basic" class="table table-striped">';
				//echo '<thead><tr><td>Kelas</td><td>Mulai</td><td>Selsai</td></tr></thead>';
				//echo "<tbody class=\"\">";

				foreach ($kelas_jadwal as $kelas):
					$kid = (int) $kelas['id'];
					$_class = 'kelas-jadwal kelas-' . $kelas['id'];
					$i_mulai['id'] = "evaluasi_mulai-{$kelas['id']}";
					$i_mulai['name'] = "evaluasi_mulai[{$kelas['id']}]";
					$i_mulai['value'] = (array_key_exists($kid, $evaluasi_mulai) && $post_request) ? $evaluasi_mulai[$kid] : $kelas['evaluasi_mulai'];
					$i_mulai['value'] = datefix($i_mulai['value'], 'm/d/Y H:i');
					$i_ditutup['id'] = "evaluasi_ditutup-{$kelas['id']}";
					$i_ditutup['name'] = "evaluasi_ditutup[{$kelas['id']}]";
					$i_ditutup['value'] = (array_key_exists($kid, $evaluasi_ditutup) && $post_request) ? $evaluasi_ditutup[$kid] : $kelas['evaluasi_ditutup'];
					$i_ditutup['value'] = datefix($i_ditutup['value'], 'm/d/Y H:i');


					foreach ($kelas['pelajaran_list'] as $pid)
						$_class .= " pelajaran-{$pid}";

					//echo "<tr class=\"{$_class}\">";
					//echo "<td>{$kelas['nama']}</td>";
					echo "<div class='col-sm-2'>{$kelas['nama']}</div>";
					echo '<div class="col-sm-5"><div class="input-group form-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <div class="dtp-container">
                                            ' . form_cell($i_mulai, $kelas) . '
                                        </div><div class="subinfo">**mulai.</div>
                                    </div></div>';
									
					echo '<div class="col-sm-5"><div class="input-group form-group">
                                        <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                        <div class="dtp-container">
											' . form_cell($i_ditutup, $kelas) . '
										</div><div class="subinfo">**akhir.</div>
                                    </div></div>';
					//echo '</tr>';

				endforeach;

				//echo "</tbody>";
				//echo '</table>';
				//echo '</div>';

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
		echo link_js('assets/jquery-ui_1.10.3/js/jquery-ui-1.10.3.custom.min.js');
		echo link_tag("assets/jquery-ui_1.10.3/css/south-street/jquery-ui-1.10.3.custom.min.css");
		//addon('timepicker');
		?>
<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );
 
$('#data-table-basic').dataTable( {
  "pageLength": 50
} )
       

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
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
				$("#pelajaran_id").change(function() {
					pid = $(this).val();
					$('.kelas-jadwal').slideUp(100);
					$('.pelajaran-' + pid).slideDown(100);
				});
				$("#pelajaran_id").change();
				//$('.tglwaktu').datetimepicker({dateFormat: "yy-mm-dd"});
			});
		</script>

	</body>
</html>