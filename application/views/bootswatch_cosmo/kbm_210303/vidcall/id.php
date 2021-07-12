<?php

require_once(APPPATH.'controllers/zoom/signature.php');

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
		'class'	 => 'active',
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

endif;

// bars

$bar_pill = '<div>'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. pills($pills_kiri)
	. '</div>';

?>



<!DOCTYPE html>

<html lang="en">
	
	
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
					Video Call : <?php 
					if($row['jenis_brand']==1){
						$jenis_brand = "ZOOM";
					}elseif($row['jenis_brand']==2){
						$jenis_brand = "JITSI";
					}
					echo "<b>".$jenis_brand."</b>"?><br/>
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
							if($row['jenis_brand']==1){
								
								if(($user['role']=='sdm')||($user['role']=='admin')){
									//$host_key = 254709;
									$host_key = $row['host_key'];
									?>
									<h3>HOST KEY = <?=$host_key?> </h3>
									<?php
								}
								
								// ZOOM EMBED
								$kode_signature = generate_signature ( API_KEY_ZOOM, API_KEY_SECRET_ZOOM, $row['meeting_id'], '0');
								//$kode_signature = generate_signature ( $row['api_key'], $row['api_secret'], $row['meeting_id'], '0');
								
								//$kode_signature = 'ZUJfSWVlT2JUWG1IR1hNM3BQWWx3dy4zMzkxMzkwMzA2LjE2MDkzMDY5MjAzMDYuMC41dm9Md2dzcm5GU1dzTVdjQWs1QW1UOW92WHk3MGhEOUdWdXpra0gvaFFBPQ';
								$vidcall_zoom = str_replace("aaa",$user['nama']."_".$row['meeting_id'], VIDCALL_ZOOM); 
								$vidcall_zoom = str_replace("meeting_id",$row['meeting_id'], $vidcall_zoom); 
								$vidcall_zoom = str_replace("meeting_email",$row['meeting_email'], $vidcall_zoom); 
								$vidcall_zoom = str_replace("password",$row['meeting_password'], $vidcall_zoom); 
								$vidcall_zoom = str_replace("kode_signature",$kode_signature, $vidcall_zoom);
								$vidcall_zoom = str_replace("api_key",API_KEY_ZOOM, $vidcall_zoom);
								
								// APK ZOOM MOBILE
								/*$vidcall_zoom_apk = VIDCALL_ZOOM_APK;
								$vidcall_zoom_apk = str_replace("meeting_id",$row['meeting_id'],$vidcall_zoom_apk);
								$vidcall_zoom_apk = str_replace("encrypted_password",$row['encrypted_password'],$vidcall_zoom_apk);*/
								$vidcall_zoom_apk = $row['invite'];
								
								?>
								<h4> Meeting ID <?=$row['meeting_id']?></h4>
								<?php
								if($mobile == 1){
									
									echo "<a href='".$vidcall_zoom_apk."' class='btn btn-info' >CLICK JOIN VIDEO CALL by APLICATION<br>*install dahulu zoom aplikasi</a>";
								
									?>
									
										<div class="span12">
											<iframe allow="geolocation; microphone; camera" 
												style="width:100%; height:480px;" 
												src="<?=$vidcall_zoom?>">
											
											</iframe>
										</div>
									<?php
								}else{
									//echo "<a href='".$vidcall_zoom_apk."' class='btn btn-info' >CLICK JOIN VIDEO CALL by APLICATION<br>*install dahulu zoom aplikasi</a>";
									?>
										<div class="span12">
											<iframe allow="geolocation; microphone; camera" 
												style="width:100%; height:480px;" 
												src="<?=$vidcall_zoom?>">
											
											</iframe>
										</div>
									<?php
								}
							
							}elseif($row['jenis_brand']==2){
								
								if($user['role']=='siswa'){
									$video = VIDCALL_JITSI.'/'.APP_SCOPE.'_'.$row["id"].'#interfaceConfig.TOOLBAR_BUTTONS='.
									'%5B%22microphone%22%2C%22camera%22%2C%22desktop%22%2C%22desktop%22%2C%22raisehand%22%2C%22fullscreen%22%2C%22hangup%22%2C%22profile%22%2C%22settings%22%2C%22videoquality%22%5D&'.
									'interfaceConfig.SETTINGS_SECTIONS=%5B%22devices%22%2C%22language%22%5D&interfaceConfig.TOOLBAR_ALWAYS_VISIBLE=true&config.disableDeepLinking=true&'.
									'userInfo.displayName="'.$user["nama"].'"';
								}else{
									$video = VIDCALL_JITSI.'/'.APP_SCOPE.'_'.$row["id"].'#config.disableDeepLinking=true&userInfo.displayName="'.$user["nama"].'"';
								}
								
								?>
								<h3>Kode Room untuk Aplikasi JITSI di HP<br>
								<b><?=APP_SCOPE."_".$row['id']?></b></h3>
								<a href='<?=VIDCALL_JITSI?>/<?=APP_SCOPE."_".$row['id']?>' class='btn btn-info' target="_blank">KLIK JOIN VIDEO CALL by HP <br>*install dahulu jitsi aplikasi</a><br>
									<iframe allow="camera; microphone; fullscreen; display-capture" style="width:100%; height:480px;" src='<?=$video?>'>
									
								</iframe>
								<?php
							}
							
							
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
