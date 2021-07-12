<?php
// cek device
$device ='';
$mobile =0;
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') !== false )
{
	$device =  'windows';
}
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'android') !== false )
{
	$device =  'android';
	$mobile = 1;
}
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'iphone') !== false )
{
	$device = 'iphone';
	$mobile = 1;
}
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipad') !== false )
{
	$device = 'ipad';
	$mobile = 1;
}
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'ipod') !== false )
{
	$device = 'ipod';
	$mobile = 1;
}
	
// user akses
$author_ybs = ($user['id'] == $row['author_id']);

// breadcrumbs
$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'KBM'							 => 'kbm',
	'Video Call'						 => 'kbm/vidcall',
	"#{$row['id']}",
);

// pills link

$pills_kiri = array();
$pills_kanan = array();

$pills_kiri[] = array(
	'label'	 => 'Daftar Video Call',
	'uri'	 => "kbm/vidcall",
	'attr'	 => 'title="kembali ke daftar Video Call"',
);


	
if ($author_ybs OR $admin):
	
	$pills_kanan['edit'] = array(
		'label'	 => '<i class="icon-edit"></i> Edit',
		'uri'	 => "kbm/vidcall/form?id={$row['id']}",
		'attr'	 => 'title="ubah konten vidcall ini"',
		'class'	 => 'disabled',
	);
	$pills_kanan['surveillance'] = array(
		'label'	 => '<i class="icon-edit"></i> Surveillance',
		'uri'	 => "kbm/vidcall/surveillance?id={$row['id']}",
		'attr'	 => 'title="ubah konten vidcall ini"',
		'class'	 => 'active',
	);
	$pills_kanan['delete'] = array(
		'label'	 => '<i class="icon-trash"></i> Hapus',
		'uri'	 => "kbm/vidcall/hapus/{$row['id']}",
		'attr'	 => 'title="hapus konten vidcall ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK MENGHAPUS vidcall INI ?\')"',
		'class'	 => 'active',
	);
	if ($row['semester_id'] == $semaktif['id'])
		$pills_kanan['edit']['class'] = 'active';

endif;



if ($author_ybs OR $admin OR $user['role'] == 'sdm')
{
	$pills_kanan['reuse'] = array(
		'label'	 => 'Reuse',
		'uri'	 => "kbm/vidcall/reuse/{$row['id']}",
		'attr'	 => 'title="gunakan kembali vidcall ini"',
		'class'	 => 'active',
	);
}
// respon

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
	
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Video Call #{$row['id']}")); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">
		
		
			
			<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					Video Call:<br/>
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


				//print_r($row);
				//echo"<br>";
				//print_r($user);
				//echo"<br>";
				//print_r($kelas_video['data']);
				?>
				<div class="container">
					<div class="row">
						<div class="col-12">
						
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
							
						
						<div id="notification"> </div>
						
					
						<p class="alert">
							<b>PERINGATAN!!! MATIKAN BROWSER ATAU WEBSITE UNTUK MENUTUP WEBCAM ATAU MATIKAN LAPTOP/KOMPUTER</b>
							
						</p>
						
						<div class="container">
							<div class="row">
							<?php
							// ZOOM
							$vidcall_zoom = str_replace("aaa",$user['nama'],VIDCALL_2); 
							if($user['role']=='sdm'){
								?>
								<h3>HOST KEY = 254709 </h3>
								<?php
							}
							
							if($mobile == 1){
								echo "<a href='".VIDCALL_APK."' class='btn btn-info' >KLIK JOIN VIDEO CALL <br>*install dahulu zoom aplikasi</a>";
							}else{
							
							?>
								<div class="span12">
									<iframe allow="geolocation; microphone; camera" 
										style="width:100%; height:480px;" 
										src="<?=$vidcall_zoom?>">
									
									</iframe>
								</div>
							<?php
							}
							
							/*
							//JISTI
							if( ($user['role']=='sdm') or ($user['role']=='admin') ){
								$i=0;
								foreach($kelas_video['data'] as $kelas){
									$i++;
									?>
										<div class="span12">
											<h3>Kelas <?=$kelas['kelas_nama']?></h3>
											<iframe allow="geolocation; microphone; camera" 
												style="width:100%; height:480px;" 
												src='<?=VIDCALL?>/<?=APP_SCOPE."_kode".$row['id']."_".$kelas['kelas_id']?>#config.disableDeepLinking=true&userInfo.displayName="<?php echo $user['nama']; ?>"'>
											</iframe>
										</div>
									<?php
									if($i>=1){
										?>
										</div>
										<div class="row">
										<?php
										$i=0;
										
									}
								}
								
							}elseif($user['role']=='siswa'){
								?>
									<div class="span12">
										<iframe allow="geolocation; microphone; camera" 
											style="width:100%; height:480px;" 
											src='<?=VIDCALL?>/<?=APP_SCOPE."_kode".$row['id']."_".$user['kelas_id']?>#config.disableDeepLinking=true&userInfo.displayName="<?php echo $user['nama']; ?>"'>
										
										<!--src='https://us04web.zoom.us/wc/8055275507/join?track_id=&jmf_code=&meeting_result=&tk=&cap=03AGdBq25dOkE0WZKGt6aieeFAyw1R4dXnTsoETqwpY2l2ppsoVbGF3lFGSbiZ0xx1oV5JVeLVoyt43xYUFEHEhPAcJAuLTw94dhq0AbzESqxfA4U71QwIto8ENwxox-EXeDZ7T0l6bDO7NkfFREPUP-Rk2zpzRMlrqDZawi45_9cz5U0hqvuAcWlUz3S2UMEFVxe40BztM_4uTtK026F0m2jLR5chbWDH1-HKx5xPQKepS2KHk0nENYsXfoDi8HUdG9C1lYYUimVn1FAPLAoWiDqW7fUileqWiKUlIvIYg0rgNjntuF3vhyBOfhr1n8AisDkmQvGI09jjXGUqmQmE23Z7gqtPX5ufACqyO-QlnF_7tUFnD_juKY12OHzXodhSvl468WEdfdP03K-BQhZXbP07T4BIQj2gSVeuO7317oslI0Me2k-Nfs9vUfEx-JzYbD8k5Yc3eBCe&refTK=&wpk=wcpkf19ef8fd76eb62f7abe07ed3605b8431"'>
										-->
										</iframe>
									</div>
								<?php
							}*/
							
							
							
							?>
							</div>
						</div>
						 
						</div>
					</div>
				</div>
				

			</div>

		<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

<?php

echo cosmo_js();
//addon('tinymce');

?>
		
		
	</body>
</html>


<script>
				
	function reading(akses){
		if (this.timer) clearTimeout(this.timer);
		  
		this.timer = setTimeout(function () {
			  var result;
			$.ajax({
				url: '<?php echo base_url()."kbm/vidcall/record_vidcall";?>',
				data: 'id_record_vidcall=<?=$id_record_vidcall?>&akses='+akses,
				dataType: 'json',
				type: 'POST',
				success: function (j) {
					 //result =  j;
					//handleData(j); 
					 document.getElementById("notification").innerHTML = '<div class="alert alert-success" role="alert">'+j.message+'</div>';
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
