<?php
$vidcall=0;
if($this->input->get("vidcall")){
	
	$vidcall = $this->input->get("vidcall");

}


// vars
$base_url = base_url();
$file_path = array_node($row, array('lampiran', 'full_path'));
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($row, array('lampiran', 'file_ext'));
$file_imag = array_nodex($row, array('lampiran', 'is_image'), FALSE);
$file_name = array_nodex($row, array('lampiran', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));

$file_link2 = str_replace("http://" ,"" ,$file_link);
$file_link2 = str_replace("https://" ,"" ,$file_link);
$file_view = "https://docs.google.com/viewer?url=" . $file_link2;

// user akses

$author_ybs = ($user['id'] == $row['author_id']);

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Materi'						 => 'kbm/materi',
	"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
	'label'	 => 'Daftar Materi',
	'uri'	 => "kbm/materi",
	'attr'	 => 'title="kembali ke daftar materi"',
);

if($this->input->get("vidcall")){
		
	$pills_kanan['vidcall'] = array(
		'label'	 => '<i class="icon-camera"></i> Matikan Video Call',
		'uri'	 => "kbm/materi/id/{$row['id']}",
		'attr'	 => 'title="Video Call materi ini" ',
		'class'	 => 'active',
	);
	
}else{
	
	$pills_kanan['vidcall'] = array(
		'label'	 => '<i class="icon-camera"></i> Hidupkan Video Call',
		'uri'	 => "kbm/materi/id/{$row['id']}?vidcall=1",
		'attr'	 => 'title="Video Call materi ini" ',
		'class'	 => 'active',
	);
	
}
	
if ($author_ybs OR $admin):
	
	
	$pills_kanan['edit'] = array(
		'label'	 => '<i class="icon-edit"></i> Edit',
		'uri'	 => "kbm/materi/form?id={$row['id']}",
		'attr'	 => 'title="ubah konten materi ini"',
		'class'	 => 'disabled',
	);
	$pills_kanan['pembaca'] = array(
		'label'	 => '<i class="icon-group"></i> Pembaca',
		'uri'	 => "kbm/materi/pembaca/{$row['id']}",
		'attr'	 => 'title="lihat aktifitas belajar siswa"',
		'class'	 => 'active',
	);
	$pills_kanan['delete'] = array(
		'label'	 => '<i class="icon-trash"></i> Hapus',
		'uri'	 => "kbm/materi/hapus/{$row['id']}",
		'attr'	 => 'title="hapus konten materi ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK MENGHAPUS MATERI INI ?\')"',
		'class'	 => 'active',
	);
	if ($row['semester_id'] == $semaktif['id'])
		$pills_kanan['edit']['class'] = 'active';

endif;

$pills_kanan['komentar_group'] = array(
		'label'	 => '<i class="icon-edit"></i> Komentar Group',
		'uri'	 => "kbm/materi/komentar/{$row['id']}",
		'attr'	 => 'title="komentar materi secara group"',
	);

if ($user['role'] == 'siswa'){
	$pills_kanan['komentar_guru'] = array(
			'label'	 => '<i class="icon-edit"></i> Komentar Hanya ke Guru',
			'uri'	 => "kbm/materi/komentar/{$row['id']}/{$row['baca_id']}",
			'attr'	 => 'title="komentar materi secara group"',
			
		);
}

if ($author_ybs OR $admin OR $user['role'] == 'sdm')
{
	$pills_kanan['reuse'] = array(
		'label'	 => 'Reuse',
		'uri'	 => "kbm/materi/reuse/{$row['id']}",
		'attr'	 => 'title="gunakan kembali materi ini"',
		'class'	 => 'active',
	);
}
// respon

$input_jawaban = array(
	'respon_jawaban',
	//'html_entity_decode',
	'type'			 => 'textarea',
	'name'			 => 'respon_jawaban',
	'id'			 => 'respon_jawaban',
	'class'			 => 'input input-xxlarge tinymce_mini',
	'placeholder'	 => 'isi jawaban soal terkait dengan materi diatas',
);

// bars

$bar_pill = '<div>'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. pills($pills_kiri)
	. '</div>';

?>



<!DOCTYPE html>

<html lang="en">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/third_party/font_awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/froala_editor.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/froala_style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/code_view.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/colors.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/emoticons.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/image_manager.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/image.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/line_breaker.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/table.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/char_counter.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/video.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/fullscreen.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/quick_insert.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/file.css">

	<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/themes/gray.css">

	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/froala_editor.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/align.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/code_beautifier.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/code_view.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/colors.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/draggable.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/emoticons.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/font_size.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/font_family.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/image.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/file.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/image_manager.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/line_breaker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/link.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/lists.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/paragraph_format.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/paragraph_style.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/video.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/table.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/url.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/entities.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/char_counter.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/inline_style.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/quick_insert.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/save.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/fullscreen.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/quote.min.js"></script>
	
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Materi #{$row['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
		
		<?php
		if($vidcall==1){ 
			?>
			<div class="container">
			  <div class="row">
				<div class="col-6">
				
				
					<table width="100%" >
						<tr>
							<td width="80px">
								<h4><b>RECORD</b></h4>
							</td>
							<td align="center" width="20px">
								<h4><b><div id="hours">00</div></b></h4>
							</td>
							<td align="center" width="5px">:</td>
							<td align="center" width="20px">
								<h4><b><div id="minutes">00</div></b></h4>
							</td>
							<td align="center" width="5px">:</td>
							<td align="center" width="20px">
								<h4><b><div id="seconds">00</div></b></h4>
								
							</td><td>							
							</td>		
						</tr>
					</table>
					
				<div class="row">
					<div class="col-sm-12" id="notification">
					</div>
				</div>
			
				<p class="alert">
					<b>PERINGATAN!!! MATIKAN BROWSER ATAU WEBSITE UNTUK MENUTUP WEBCAM ATAU MATIKAN LAPTOP/KOMPUTER</b>
					
				</p>
				
				<iframe allow="geolocation; microphone; camera" 
					style="width:100%; height:480px;" 
					src='<?=VIDCALL?>/<?=APP_SCOPE."_kode".$row['pelajaran_id']?>#config.disableDeepLinking=true&userInfo.displayName="<?php echo $user['nama']; ?>"'>
				</iframe>
				 
				</div>
				<div class="col-6">
			
			<?php
		}

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Materi:<br/>
					<h1><?php echo strtoupper($row['nama']) ?></h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
					#info{
						font-size: .9em;
						opacity: .7;
					}
					#lampiran{
						width: 100%;
						min-height: 600px;
					}
				</style>

				<?php

				echo alert_get();

				$info = "Oleh {$row['author_nama']}<br/>"
					. "Mapel {$row['mapel_nama']} ({$row['pelajaran_nama']})<br/>"
					. "Waktu Publish ".tglwaktu($row['tanggal_publish'])."<br/>"
					. "Waktu Tutup ".tglwaktu($row['tanggal_tutup'])."";

				echo p('id="info"', $info);
				echo $bar_pill;

				//klo ada gambar tampilkan saja

				if ($file_imag && $file_link):
					echo div('align="center"', img($file_link)) . '<br/>';
				endif;

				// tampilkan lampiran
				
				if ($file_link):
					echo '<p><i>lampiran: ' . a($file_link, $file_name, 'title="download lampiran" target="_blank"') . '</i></p><br/><br/>';
				endif;

				// klo ada ketikan artikel, tampilkan. lampiran jadi link

				if ($file_ofis):
					echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\"></iframe>";
				endif;	
				if (!empty($row['konten'])):
					$row['konten'] = str_replace('<img src="/', '<img src="'.$base_url, $row['konten']);
					$row['konten'] = str_replace('<img src="../../', '<img src="'.$base_url, $row['konten']);
				
					$row['konten'] = str_replace('style="','style="max-width: 100%; ', $row['konten']);
					$row['konten'] = str_replace('iframe','iframe style="max-width: 100%;" ', $row['konten']);
					
					echo tag('article', 'id="artikel"', clean_charset($row['konten']));


				endif;

				echo '<br/><br/><br/>';

				// pertanyaan
				
				$row['pertanyaan'] = str_replace('<img src="/', '<img src="'.$base_url, $row['pertanyaan']);
				$row['pertanyaan'] = str_replace('<img src="../../', '<img src="'.$base_url, $row['pertanyaan']);
				
				$row['pertanyaan'] = str_replace('style="','style="max-width: 100%; ', $row['pertanyaan']);
				$row['pertanyaan'] = str_replace('iframe','iframe style="max-width: 100%;" ', $row['pertanyaan']);
				
				echo p('', '<b>Pertanyaan Siswa</b>') . $row['pertanyaan'];
				
				if ($user['role'] == 'siswa'):
					echo p('', '<b>Respon Jawaban</b>');

					//if ($row['respon_jawaban']):
					//	echo ($row['respon_jawaban']);

					//else:
						echo form_opening("{$uri}/{$row['id']}");
						echo form_cell($input_jawaban, $row);
						
						?>
						<script type="text/javascript">
			  
								new FroalaEditor('textarea#respon_jawaban', {
									
									heightMin: 150,
									
									attribution: false,
									
									/// FILE /////
									// Set the file upload parameter.
									fileUploadParam: 'file',

									// Set the file upload URL.
									fileUploadURL: '<?=base_url()?>froala_document',

									// Additional upload params.
									fileUploadParams: {id: 'my_editor'},

									// Set request type.
									fileUploadMethod: 'POST',

									// Set max file size to 20MB.
									fileMaxSize: 20 * 1024 * 1024,

									// Allow to upload any file.
									fileAllowedTypes: ['*'],
									
									
									
									/// IMAGE ////
									// Set the image upload parameter.
									imageUploadParam: 'file',

									// Set the image upload URL.
									imageUploadURL: '<?=base_url()?>froala_image',

									// Additional upload params.
									imageUploadParams: {id: 'my_editor'},

									// Set request type.
									imageUploadMethod: 'POST',

									// Set max image size to 5MB.
									imageMaxSize: 5 * 1024 * 1024,

									// Allow to upload PNG and JPG.
									imageAllowedTypes: ['jpeg', 'jpg', 'png'],
									
									
									
									/// VIDEO ////
									// Set the video upload parameter.
									videoUploadParam: 'file',

									// Set the video upload URL.
									videoUploadURL: '<?=base_url()?>froala_video',

									// Additional upload params.
									videoUploadParams: {id: 'my_editor'},

									// Set request type.
									videoUploadMethod: 'POST',

									// Set max video size to 200MB.
									videoMaxSize: 200 * 1024 * 1024,

									// Allow to upload MP4, WEBM and OGG
									videoAllowedTypes: ['wmv', 'webm', 'mp4', 'ogg', 'avi'],

									events: {
										 
										 
									},
									
								  });
								
			
								</script>
						<?php
						// ketik pertanyaan
				
						echo '<button type="submit" class="btn btn-success" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">
						<i class="icon-save icon-white"></i> Simpan Respon Jawaban</button> ';
						echo form_close();

				//	endif;

				endif;

				?>

			</div>

		<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

<?php

echo cosmo_js();
//addon('tinymce');

?>
		<?php
		if($vidcall==1){ 
			?>
		
			</div>
		  </div>
		</div>
		
			<?php
		}
		?>
		
	</body>
</html>

<?php
if($vidcall==1){ 
	?>
	<script>
					
		function reading(akses){
			if (this.timer) clearTimeout(this.timer);
			  
			this.timer = setTimeout(function () {
				  var result;
				$.ajax({
					url: '<?php echo base_url()."kbm/materi/record_vidcall";?>',
					data: 'materi=<?=$row['id']?>&role= <?=$user['role']?>&user_id=<?=$user['id']?>&akses='+akses,
					dataType: 'json',
					type: 'POST',
					success: function (j) {
						 //result =  j;
						//handleData(j); 
						 document.getElementById("notification").innerHTML = j.message;
					},
					error: function (j) {
						document.getElementById("notification").innerHTML = '<div class="alert alert-danger" role="alert">'+
								'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini atau cek "INTERNET".'+
							'</div>';
					}  
				});
			}, 200);
		}
		
		var akses = 1;
		var hoursLabel 	 = document.getElementById("hours");
		var minutesLabel = document.getElementById("minutes");
		var secondsLabel = document.getElementById("seconds");
		var totalSeconds = 0;
		setInterval(setTime, 1000);

		function setTime() {
		  ++totalSeconds;
		  
		  secondsLabel.innerHTML = pad(totalSeconds % 60);
		  minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
		  hoursLabel.innerHTML 	 = pad(parseInt(totalSeconds / 3600));
		  
		  <?php 
		 // if(( $user['role'] != 'admin' )){
			  ?>
			  if(parseInt(totalSeconds % 60)==0)
			  {
				  reading(akses);
				  akses = 0;
			  }
		  <?php 
		  //}
		  ?>
		}

		function pad(val) {
		  var valString = val + "";
		  if (valString.length < 2) {
			return "0" + valString;
		  } else {
			return valString;
		  }
		}
		
		//$('.ndfHFb-c4YZDc-Wrql6b').remove();
		//document.getElementByClass('ndfHFb-c4YZDc-Wrql6b').style.display='none';
		
		var appBanners = document.getElementsByClassName('ndfHFb-c4YZDc-Wrql6b'), i;

		for (var i = 0; i < appBanners.length; i ++) {
			appBanners[i].style.display = 'none';
		}
		
	</script>
	<?php
}
?>