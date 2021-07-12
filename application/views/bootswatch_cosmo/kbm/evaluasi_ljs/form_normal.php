<?php
//print_r($_SESSION);
/*
echo "<div id='sessionTimer'>a";
print_r($this->session->sess_expiration);
echo "</div>";
*/
?><!--
<script>
	 var timeoutHandle = null;
	function startTimer(timeoutCount) {
        
        document.getElementById('sessionTimer').innerHTML = 'You have ' + (timeoutCount * 3000)/1000 + 'seconds until timeout' ;
        
        timeoutHandle = setTimeout(function () { startTimer(timeoutCount-1);}, '3000');
    }
    function refreshTimer() {
        killTimer(timeoutHandle);
        startTimer(<?=$this->session->sess_expiration?>);
    }
	startTimer(<?=$this->session->sess_expiration?>);
</script>-->
<?php

$vidcall=0;
if($this->input->get("vidcall")){
	
	$vidcall = $this->input->get("vidcall");

}

	if($this->input->get("simulasi")){
		$evaluasi_berakhir = "7200";
	}else{
		/// SET WAKTU BERAKHIR
		$kelas_id = $evaluasi['kelas_id'];
		$evaluasi_ditutup = strtotime($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_ditutup']);
		
		$evaluasi_durasi 	= JamToDetik($evaluasi['kelas_result']['data'][$kelas_id]['evaluasi_durasi']);
		$evaluasi_berakhir	= strtotime($pengerjaan_ljs['waktu']) + $evaluasi_durasi;
		
		//echo $evaluasi_ditutup." AAAAAAAAAAA ".$evaluasi_berakhir;
		if($evaluasi_ditutup!=''){
			if(($evaluasi_berakhir > $evaluasi_ditutup) || ($evaluasi_ditutup>0)){
				$evaluasi_berakhir = $evaluasi_ditutup;
			}
		}
	}
	//////////////////////
	
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
  <?php //include "/var/www/fresto.co/master_fresto_v2_01/assets/bootstrap_3.3.1/css/bootstrap.php"; ?> 
  <!--<?php include APP_ROOT."assets/bootstrap_3.3.1/css/bootstrap.php";?>
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap_3.3.1/css/bootstrap.min.css">-->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootsidemenu/css/BootSideMenu.css">
<style type="text/css">
  .user{
    padding:5px;
    margin-bottom: 5px;
  }
  
  .loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url('http://<?=URL_MASTER?>content/images/page-loader.gif') 50% 50% no-repeat rgb(249,249,249);
	}
</style>

<script src="<?php echo base_url();?>assets/bootsidemenu/js/jquery-1.11.0.min.js"></script>
<!--<script src="<?php echo base_url();?>assets/bootstrap_3.3.1/js/bootstrap.min.js"></script>-->
<script src="<?php echo base_url();?>assets/bootsidemenu/js/BootSideMenu.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/jPlayer_circle/circle.skin/circle.player.css">

<!--<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.grab.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/mod.csstransforms.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/circle.player.js"></script>

	
	<?php
	if(($evaluasi['pilihan_jml'] == 0) || ($evaluasi['plus_uraian'])){ ?>
	<!-- EDITOR FROALA -->
	<?php 
	//include '/var/www/fresto.co/master_fresto_v2_01/spotcapturing/resource/third_party/froala/css/plugins/font-awesome.php';
	?>
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

	<!--<link rel="stylesheet" href="<?php echo base_url();?>assets/froala/css/plugins/codemirror.min.css">-->
	
	
	<!-- JS -->
	<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>-->
	<!--<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/codemirror.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/froala/js/plugins/xml.min.js"></script>-->

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
	<?php 
	} 
	?>
	
	<!--<script type="text/javascript" src="<?php echo base_url();?>assets/jscroll-master/jquery.jscroll.js"></script>-->

<!--<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="js/BootSideMenu.js"></script>-->

<script type="text/javascript">
	var jml_jawab = 0;
	var no_jawab = new Array();
	
	$(document).ready(function(){
	 $('#demo').BootSideMenu({side:"right"});
	 
	});
	
	
</script>

<?php
	//addon('tinymce');
	
function js_send_text($id, $no_soal, $pengerjaan_ljs, $soal, $simulasi, $evaluasi_berakhir){
	?>
	<script type="text/javascript">

	new FroalaEditor('textarea#<?=$id?>', {
		
		heightMin: 150,
		
		attribution: false,
		
		 // Change save interval (time in miliseconds).
		saveInterval: 2000,

		// Set the save param.
		saveParam: 'jawaban',

		// Set the save URL.
		saveURL: '<?php echo base_url()."kbm/evaluasi_ljs/sent_answer_essay";?>',

		// HTTP request type.
		saveMethod: 'POST',

		// Additional save params.
		saveParams: {
			ljs_id:'<?php echo $pengerjaan_ljs["id"];?>',
			soal_id:'<?=$soal["id"]?>',
			simulasi:'<?=$simulasi?>' ,
			ltz:'<?=$evaluasi_berakhir?>' 
		},

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
			 'save.before': function () {
					$('#soal<?=$no_soal?>').removeClass('error').html('<div style="background-color:#CCCCCC">'+
					'&nbsp<img src="<?php echo base_url();?>content/images/loader.gif" style="width:34px;"/> Input Jawaban...</div>');
			  },

			  'save.after': function (j) {
				    myJSON = JSON.parse(j);
					$('#soal<?=$no_soal?>').html('<div style="background-color:'+myJSON.warna+'">&nbspPertanyaan :: <?=$no_soal?> <br>( '+myJSON.message+' )<div>');
					/*$('#soal<?=$no_soal?>').html('<div style="background-color:#00AAFF">&nbspSOAL NOMOR<?=$no_soal?> <br>Terjawab <div>');
					*/
					if(no_jawab[<?=$no_soal?>] == 0 )
					{	
						jml_jawab++;
						no_jawab[<?=$no_soal?>] = 1;
					}
					$('#jawab').html(jml_jawab);
					$('#nomer_soal<?=$no_soal?>').html('<table>'+
					 '<tr>'+
					  '<td width="50px" height="50px" bgcolor="'+myJSON.warna+'" align="center">'+
						<?=$no_soal?>+
					  '</td>'+
					 '</tr>'+
					'</table>');
			  },

			  'save.error': function (j) {
				
					$('#soal<?=$no_soal?>').html('<div style="background-color:#FF4444">&nbspSOAL NOMOR<?=$no_soal?> <br>Gagal di jawaban , coba refresh <div>');
					$('#nomer_soal<?=$no_soal?>').html('<table>'+
					 '<tr>'+
					  '<td width="50px" height="50px" bgcolor="#FF4444" align="center">'+
						<?=$no_soal?>+
					  '</td>'+
					 '</tr>'+
					'</table>');
			  },
			  
			 
		},
		
	  });
	

	</script>
	<?php
}
?>

<?php
// vars

$author_ybs = ($evaluasi['author_id'] == $user['id']);
$editable = (($author_ybs OR $admin) && !$evaluasi['closed'] && $evaluasi['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$evaluasi['published']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		"LJS" => "kbm/evaluasi_ljs/browse?evaluasi_id={$evaluasi['id']}",
		'#pengerjaan',
);

// input data

$input_essay = array(
		'type' => 'input',
		//'class' => 'input',
);

?>
<?php 
/* JUMLAH SOAL EVALUASI*/
if($evaluasi['soal_jml']>0) 
	$jml_soal = $evaluasi['soal_jml']; 
else 
	$jml_soal = $evaluasi['soal_total'];


$pills_kanan = array();

$simulasi_url='';
if($this->input->get("simulasi")){
	$simulasi_url='&simulasi=ok';
}

if($evaluasi['show_webcam']==1){
	if($this->input->get("vidcall")){
			
		$pills_kanan['vidcall'] = array(
			'label'	 => '<i class="icon-camera"></i> Matikan Video Call',
			'uri'	 => "/kbm/evaluasi_ljs/form?id={$evaluasi['id']}".$simulasi_url,
			'attr'	 => 'title="Video Call materi ini" ',
			'class'	 => 'active',
		);
		
	}else{
		
		$pills_kanan['vidcall'] = array(
			'label'	 => '<i class="icon-camera"></i> Hidupkan Video Call',
			'uri'	 => "/kbm/evaluasi_ljs/form?id={$evaluasi['id']}&vidcall=1".$simulasi_url,
			'attr'	 => 'title="Video Call materi ini" ',
			'class'	 => 'active',
		);
		
	}
}

$bar_pill = '<div>'
	. pills($pills_kanan, 'class="nav nav-pills pull-right"')
	. '</div>';
	
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pengerjaan Evaluasi')); ?>
	<style type="text/css">
		.navbar-fixed-bottom
		{
			bottom: 0;
			position: fixed;
		}
		.brand2
		{
			padding:15px 30px 15px 30px;
			color:#FFFFFF;
		}
	</style>
 <!-- <body translate="no" class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">-->
 <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

   <!-- menu nomer-->
   <?php 
   if($this->input->get('open_soal')==1)
	{}
	else{ ?>
	   <div class="loader">
		<a href="https://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>&open_soal=1" class="btn btn-block"> 
			<h4><b>KLIK INI JIKA <br> LOADING LEBIH DARI <br>15 DETIK </b></h4>
		</a>
	   </div>
	   <?php
	}
	?>
<div id="demo">
	<div style="padding-left:10px"><h4><b>(TOMBOL CEPAT) SOAL NOMER: </b></h4></div>
     <div style="padding-left:20px" >
    	<div class="img-thumbnail">
            <table>
             <tr>
              <td width="15px" height="15px" bgcolor="#FFFF00" align="center" ></td>
              <td style="font-size:12px"> &nbsp;BELUM DI JAWAB </td>
             </tr>
            </table>
        </div>
        <div class="img-thumbnail">
            <table>
             <tr>
              <td width="15px" height="15px" bgcolor="#00AAFF" align="center" ></td>
              <td style="font-size:12px"> &nbsp;BERHASIL DI JAWAB </td>
             </tr>
            </table>
         </div>
        <div class="img-thumbnail">
            <table>
             <tr> 
              <td width="15px" height="15px" bgcolor="#FF4444" align="center" ></td>
              <td style="font-size:12px"> &nbsp;GAGAL DI JAWAB </td>
             </tr>
            </table>
     	</div>
     </div>
    <div class="">
    <?php
		$nomer_link=1; 
		$jml_soal_tampil=0;
		//while($jml_soal>=$nomer_link)
		$nomer_soal =	$soal_result['data'];
		foreach ($nomer_soal as $idx => $soal)
		{
			?>
            
            	<a  href="#tab<?=$nomer_link;?>" data-toggle="tab">
                <button type="button" class="btn" id="nomer_soal<?=$nomer_link;?>"  style="margin-left:4px; margin-bottom:4px;" >
                    <table>
                     <tr>
                      <td width="50px" height="50px" bgcolor="#FFFF00" align="center">
                    	<?=$nomer_link;?>
						
                      </td>
                     </tr>
                    </table>
                </button>
                </a>
               <!-- <img src="" width="60px" height="60px" alt="<?=$nomer_link;?>" class="img-thumbnail"></a>&nbsp;&nbsp;-->
            
			<?php
	  		$nomer_link++;
			$jml_soal_tampil++;
		}
		
		$nomer_link2=$nomer_link;
		$nomer_link--;
		// URAIAN
		if($evaluasi['plus_uraian']){
			?>
            
            	<a  href="#tab<?=$nomer_link2;?>" data-toggle="tab">
                <button type="button" class="btn" id="nomer_soal<?=$nomer_link2;?>"  style="margin-left:4px; margin-bottom:4px;" >
                    <table>
                     <tr>
                      <td width="50px" height="50px" bgcolor="#FFFF00" align="center">
                    	URAIAN
						
                      </td>
                     </tr>
                    </table>
                </button>
                </a>
               <!-- <img src="" width="60px" height="60px" alt="<?=$nomer_link;?>" class="img-thumbnail"></a>&nbsp;&nbsp;-->
            
			<?php
	  		$nomer_link2++;
		}
		/// SELESAI
		if ($user['role'] == 'siswa'){
			?>
            
            	<a  href="#tab<?=$nomer_link2;?>" data-toggle="tab">
                <button type="button" class="btn" id="nomer_soal<?=$nomer_link2;?>"  style="margin-left:4px; margin-bottom:4px;" >
                    <table>
                     <tr>
                      <td width="50px" height="50px" bgcolor="#4CAF50" align="center">
                    	SELESAI
						
                      </td>
                     </tr>
                    </table>
                </button>
                </a>
               <!-- <img src="" width="60px" height="60px" alt="<?=$nomer_link;?>" class="img-thumbnail"></a>&nbsp;&nbsp;-->
            
			<?php
	  		$nomer_link2++;
		}
		?>
    </div>
</div>


		<?php
		if($vidcall==1){ 
			?>
			<div class="container">
			  <div class="row">
				<div class="col-6">
				<br><br>
				<p class="alert">
					<b>PERINGATAN!!! MATIKAN BROWSER ATAU WEBSITE UNTUK MENUTUP WEBCAM ATAU MATIKAN LAPTOP/KOMPUTER</b>
					
				</p>
				<?php
				$kelas_nama = '';
				if(isset($user['kelas_nama'])){
					$kelas_nama = strtolower(str_replace(" ","_",$user['kelas_nama']));
				}?>
				<iframe allow="geolocation; microphone; camera" 
					style="width:100%; height:480px;" 
					src='<?=VIDCALL?>/<?=APP_SCOPE."_kelas_".$kelas_nama?>#config.disableDeepLinking=true&userInfo.displayName="<?php echo $user['nama']; ?>"'>
					<!--src='<?=VIDCALL?>/<?=APP_SCOPE."_kode".$evaluasi['pelajaran_id']?>#config.disableDeepLinking=true&userInfo.displayName="<?php echo $user['nama']; ?>"'>-->
					
				</iframe>
				 
				</div>
				<div class="col-6">
			
			<?php
		}
		
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		//echo breacrumbs($breadcrumbs);
		?>

    <div class="container">
    <?php 
	/*print_r($evaluasi);
	echo"<br><br>";
	print_r($soal_result);
	echo"<br><br>";
	print_r($pengerjaan_ljs_jawaban);*/
	echo $bar_pill;
	?>

			<!-- Typography	================================================== -->
			
			<div id="tabel">
				<div class="page-header alert-block" style="margin-top:-20px; margin-bottom:-20px">
					
					<h2><?php echo strtoupper($evaluasi['nama']) ?></h2>
                    <h4><div id='ready'> <div style="background-color:#FFFF00">&nbspEVALUASI BELUM SIAP DIKERJAKAN (BILA TERLALU LAMA HARAP REFRESH)</div> </div></h4>
					
				</div>
				
				<table width="100%">
					<tr>
						<td width="100%" align="center"><?php 
						$evaluasi['kop'] = str_replace('<img src="/','<img src="'.base_url(),$evaluasi['kop']);
						$evaluasi['kop'] = str_replace('<img src="../../','<img src="'.base_url(),$evaluasi['kop']);
						echo $evaluasi['kop']; 
						?></td>
					</tr>
				</table>
				
				<style>
				</style>

				<?php
				echo alert_get();
				
				if($evaluasi['audio']!='')
				{
					///////////////// AUDIO ///////////////////////
					echo "<h2> Player Listening</h2>";
					//// FOR PC ////
					//echo $this->load->view(THEME.'/kbm/evaluasi_ljs/audio',$evaluasi,TRUE);
					//// FOR MOBILE ////
					echo "<table width='30%'><tr><td width='100%' align='center'>";
						echo $this->load->view(THEME.'/kbm/evaluasi_ljs/audio_mobile',$evaluasi,TRUE);
					echo "</td></tr></table>";
				}
				if ($user['role'] == 'siswa'):
					//$uri = str_replace("/form","/submit_evaluasi",$uri);
					echo form_opening("{$uri}?id={$evaluasi['id']}&time=".$this->input->get('time'), 'class="form-horizontal" id="myform"');
					//echo '<input type="hidden" name="time" value="'.$this->input->get('time').'">';
				endif;
				
				////// check jawaban //////
				
				foreach ($pengerjaan_ljs_jawaban['data'] as $plj):
					//echo'<br><br>';
					//print_r($plj);
					essay_jawaban_prepare($plj); 
					$ljs_essay_jawaban[$plj['soal_id']] = $plj['jawaban']; 
					$ljs_jawaban[$plj['soal_id']] = $plj['pilihan']; 
					$opsi_acak[$plj['soal_id']] = $plj['opsi'];
					
				endforeach;
							
				$no_soal=0;
				echo'<div class="tab-content">';/* tab konten*/
				
				//print_r($soal_result['data']);
				foreach ($soal_result['data'] as $idx => $soal):
					$no_soal++;
					?>
					<script>
						no_jawab[<?php echo $no_soal;?>] = 0;
					</script>
					<?php
                    
					//// SIMULASI PENGERJAAN 
					//if ($evaluasi['pilihan_jml'] > 1 ){
						if(!isset($opsi_acak[$soal['id']]))
						{	
							$opsi = array("a","b","c","d","e");
							if(strtolower($evaluasi['metode']) != "opsi_tampil_abc"){
								shuffle($opsi);	
							}
							$opsi_acak[$soal['id']]='';
							foreach($opsi as $pilihan)
							{
								$opsi_acak[$soal['id']] .= $pilihan.',';
							}
						}
					//}
					////////
					if(strtolower($evaluasi['metode']) == "opsi_tampil_abc"){
						unset($opsi_acak);
						
						$opsi = array("a","b","c","d","e");
						$opsi_acak[$soal['id']]='';
						foreach($opsi as $pilihan)
						{
							$opsi_acak[$soal['id']] .= $pilihan.',';
						}
						
					}
					soal_prepljs($soal,$opsi_acak);

					if($no_soal==1)
					{	$active_tab='active';	}
					else
					{	$active_tab='';	}
					
					echo '<div class="tab-pane '.$active_tab.'" id="tab'.$no_soal.'" >';
					// echo '<div id="link_soal'.$no_soal.'"><br/><br/></div>';
					echo '<div class="well" >';
					
					/// SOAL ///
					
					//////  AUDIO ////////
					if($soal['audio']!='')
					{
						echo "<h2> Player Sound</h2>";
					?>
                    
                <script type="text/javascript">
				<?php
					if (strpos($soal['audio'], 'http') !== false){
						$audio = $soal['audio'];
					}else{
						$audio = base_url().$soal['audio'];
					}
					/// replace 
					$audio = str_replace('C:/xampp/htdocs/','',$audio);
				?>
				$(document).ready(function(){
		
					var myCirclePlayer = new CirclePlayer("#jquery_jplayer_<?=$soal['id'];?>",
					{
						oga: "<?php echo $audio;?>"
					}, {
						cssSelectorAncestor: "#cp_container_<?=$soal['id'];?>"
					});
				});
				</script>
			
		
				<!-- The jPlayer div must not be hidden. Keep it at the root of the body element to avoid any such problems. -->
				<div id="jquery_jplayer_<?=$soal['id'];?>" class="cp-jplayer"></div>
		
				<div class="prototype-wrapper"> <!-- A wrapper to emulate use in a webpage and center align -->
		
					<div id="cp_container_<?=$soal['id'];?>" class="cp-container">
						<div class="cp-buffer-holder"> <!-- .cp-gt50 only needed when buffer is > than 50% -->
							<div class="cp-buffer-1"></div>
							<div class="cp-buffer-2"></div>
						</div>
						<div class="cp-progress-holder"> <!-- .cp-gt50 only needed when progress is > than 50% -->
							<div class="cp-progress-1"></div>
							<div class="cp-progress-2"></div>
						</div>
						<div class="cp-circle-control"></div>
						<ul class="cp-controls">
							<li><a class="cp-play" tabindex="1">play</a></li>
							<li><a class="cp-pause" style="display:none;" tabindex="<?=$soal['id'];?>">pause</a></li> <!-- Needs the inline style here, or jQuery.show() uses display:inline instead of display:block -->
						</ul>
					</div>
		
		
				</div>
                    <?php
					}
					
					// FIX URL GAMBAR
					$soal['pertanyaan'] = str_replace('<img src="/','<img src="'.base_url(),$soal['pertanyaan']);
					$soal['opsi']		= str_replace('<img src="/','<img src="'.base_url(),$soal['opsi']);
					
					$soal['pertanyaan'] = str_replace('<img src="../../','<img src="'.base_url(),$soal['pertanyaan']);
					$soal['opsi']		= str_replace('<img src="../../','<img src="'.base_url(),$soal['opsi']);
					
					echo '<fieldset>';
					echo "<legend>
					<div id='soal".$no_soal."'>&nbspSOAL NOMER&nbsp; " . ($idx + 1) . "</div>
					</legend>";

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan"', $soal['pertanyaan']) . '<br/>';

					// tampilkan isian siswa
					
					//// URAIAN
					if($soal['type']==3){
					
						$input_essay['id'] = "butir-{$soal['id']}";
						$input_essay['name'] = "butir-{$soal['id']}";
						//$input_essay['value'] = (!$post_request) ? '' : html_entity_decode($this->input->post($input_essay['name']));
						$input_essay['value']='';
						if(isset($ljs_essay_jawaban)){
							//print_r($ljs_essay_jawaban);
							//echo $plj['soal_id']." aaaa";
							if($ljs_essay_jawaban[$soal['id']]!=''){
								$input_essay['value'] = $ljs_essay_jawaban[$soal['id']];
								?>
								<script>
								no_jawab[<?php echo $no_soal;?>] = 1;
								</script><?php
							}
						}
						//echo form_cell($input_essay);
						//echo " xxxxxxxx ".$input_essay['value']."zzzzzzzz";
						echo "<textarea name=".$input_essay['name']." id=".$input_essay['id'].">".$input_essay['value']."</textarea>";
							
						js_send_text($input_essay['id'], $no_soal, $pengerjaan_ljs, $soal, $this->input->get("simulasi"), $evaluasi_berakhir);
					//// ISIAN
					}else if($soal['type']==2){
					
						$input_isian['id'] = "butir-{$soal['id']}";
						$input_isian['name'] = "butir-{$soal['id']}";
						//$input_isian['value'] = (!$post_request) ? '' : html_entity_decode($this->input->post($input_isian['name']));
						$input_isian['value']='';
						if(isset($ljs_essay_jawaban)){
							//print_r($ljs_essay_jawaban);
							//echo $plj['soal_id']." aaaa";
							if($ljs_essay_jawaban[$soal['id']]!=''){
								$input_isian['value'] = $ljs_essay_jawaban[$soal['id']];
								?>
								<script>
								no_jawab[<?php echo $no_soal;?>] = 1;
								</script><?php
							}
						}
						//echo form_cell($input_isian);
						//echo " xxxxxxxx ".$input_isian['value']."zzzzzzzz";
						echo "<input type='text' name=".$input_isian['name']." id=".$input_isian['id']." value='".$input_isian['value']."' 
						 class='input input-large' onchange=javascript:input_jawab_essay({$no_soal},{$soal['id']},this.value)>";
					
					//// PILGAN
					}else{
					
						if ($evaluasi['pilihan_jml'] > 1 && is_array($soal['opsi'])):
							echo '<table class="table table-bordered table-striped table-hover">' . NL;

							foreach ($soal['opsi'] as $key => $opsi):
								if(strtolower($evaluasi['metode']) == "opsi_tampil_abc"){ 
									$opsi = str_replace("<p>","<p>".strtoupper($key).". ",$opsi);
								}
								$name = "butir-{$soal['id']}";
								if($pengerjaan_ljs['id']):
								
									if(isset($ljs_jawaban[$soal['id']])):
										if($ljs_jawaban[$soal['id']]==$key):
											$checked = TRUE; 
											?><script>
											no_jawab[<?php echo $no_soal;?>] = 1;
											</script><?php
										else:
											$checked = FALSE; 
										endif;
									else:
										$checked = FALSE; 
									endif;
								
								else:
								
									if($this->input->post($name) == $key):
										$checked = TRUE;
										?><script>
										no_jawab[<?php echo $no_soal;?>] = 1;
										</script><?php 
									else:
										$checked = FALSE; 
									endif;
								
								endif;
								$radio = array(
										'name' => $name,
										'id' => $name . '-' . $key,
										'value' => $key,
										'checked' => $checked,
								);
								echo '<tr><td>';

								echo "<label class=\"radio\">"
								. div("class='soal-opsi' onclick=javascript:input_jawab({$no_soal},{$soal['id']},'{$key}',{$soal['poin_max']})", form_radio($radio) . $opsi)
								. "</label>" . NL;

								echo '</td></tr>';

							endforeach;

							echo '</table>';

							
						else:
							
							$input_essay['id'] = "butir-{$soal['id']}";
							$input_essay['name'] = "butir-{$soal['id']}";
							//$input_essay['value'] = (!$post_request) ? '' : html_entity_decode($this->input->post($input_essay['name']));
							$input_essay['value']='';
							if(isset($ljs_essay_jawaban)){
								//print_r($ljs_essay_jawaban);
								//echo $plj['soal_id']." aaaa";
								if($ljs_essay_jawaban[$soal['id']]!=''){
									$input_essay['value'] = $ljs_essay_jawaban[$soal['id']];
									?>
									<script>
									no_jawab[<?php echo $no_soal;?>] = 1;
									</script><?php
								}
							}
							//echo form_cell($input_essay);
							//echo " xxxxxxxx ".$input_essay['value']."zzzzzzzz";
							echo "<textarea name=".$input_essay['name']." id=".$input_essay['id'].">".$input_essay['value']."</textarea>";
							
							js_send_text($input_essay['id'], $no_soal, $pengerjaan_ljs, $soal, $this->input->get("simulasi"), $evaluasi_berakhir);
							
							if ($evaluasi['pilihan_jml'] > 1 && !is_array($soal['opsi'])):
								echo '<div class="label label-warning">Terjadi kesalahan pada opsi pilihan.<br/>';

								if ($editable)
									echo 'Klik ' . a("kbm/evaluasi_soal/form?id={$soal['id']}", 'disini', '') . ' untuk merubah daftar opsi/pilihan. ';

								if ($deletable)
									echo 'Klik ' . a("kbm/evaluasi_soal/delete?id={$soal['id']}", 'disini', '') . ' untuk menghapus butir soal. ';

								echo '</div>';

							endif;
							
						endif;
					
					}
					
					
					
					echo ' </fieldset></div>';

					/* tombol next previus*/
					echo '<div class="row-fluid show-grid">';
						echo '<div class="span6" ><a class="btn btn-primary btn-block " data-toggle="tab" href="#tab'.($no_soal-1).'">
						<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelum</a><br/></div>';
						//echo '<div class="span4" ></div>';
						echo '<div class="span6" ><a class="btn btn-primary btn-block " data-toggle="tab" href="#tab'.($no_soal+1).'">
						Lanjut SOAL <i class="zmdi zmdi-chevron-right"></i></a><br/></div>';
					echo '</div>';
					
					
					echo'</div>';/* tab*/
					
				endforeach;

				$no_soal2=$no_soal;
				
				//// IF URAIAN ADD
				if($evaluasi['plus_uraian']){
					
					$no_soal2++;
					echo '<div class="tab-pane" id="tab'.$no_soal2.'" >';
					
						//echo '<div id="link_soal_uraian"><br/><br/></div>';
						echo '<h2>URAIAN</h2>';
						echo '<div class="well" >';
						echo '<table class="table table-bordered table-striped table-hover">
								<tbody><tr><td>';
						echo $evaluasi['detail_uraian'];
						echo '	</td></tr></tbody></table>';
						
						echo '</div>';
						//echo '</div>';
						
					/* tombol next previus*/
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block " data-toggle="tab" href="#tab'.($no_soal2-1).'">
					<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelum</a><br/></div>';
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block " data-toggle="tab" href="#tab'.($no_soal2+1).'">
					Lanjut SOAL <i class="zmdi zmdi-chevron-right"></i></a><br/></div>';
					
					echo'</div>';/* tab*/
				}
				// form button

				if ($user['role'] == 'siswa'):
					$no_soal2++;
					$selesai = $no_soal2;
					echo '<div class="tab-pane" id="tab'.$selesai.'" >';
					
						echo '<fieldset>';
						//echo '<div class = "form-actions well">'
						//. ' <button type = "submit" class = "btn btn-success btn-large" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">'
						echo ' <button type = "button" id="myBtn" class = "btn btn-success btn-large btn-block">'
						
						. ' <i class = "icon-save icon-white"></i> SELESAI PENGERJAAN <br><i>*hanya aktif jika semua soal sudah terisi dan berwarna biru</i></button> <br><br>';
						//. ' </div>';
						echo '</fieldset>';

					/* tombol next previus*/
					echo '<div class="col-sm-12" ><a class="btn btn-primary btn-block " data-toggle="tab" href="#tab'.($no_soal2-1).'">
					<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelumnya</a></div>';
					
					echo'</div>';/* tab*/
					
					$this->load->view (THEME .'/kbm/evaluasi_ljs/modal');
					
					
					
				endif;
				
				echo form_close();
				echo'</div>';/* tab konten*/
				?>

			</div>
			
			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

<?php
		if($vidcall==1){ 
			?>
		
			</div>
		  </div>
		</div>
		
			<?php
		}
		?>
		
    <div class="navbar navbar-fixed-bottom">
    	<div class="navbar-inner">
        	<div class="container">
             <div class="brand2" >
            	<table style="color:#FFFFFF">
                	<tr>
                        <td><strong>WAKTU :	</strong></td>
                        <td><strong><div id="countdown"></div></strong></td>
                    	<td>&nbsp&nbsp&nbsp&nbsp&nbsp </td>
                        <td><strong>JAWAB : </strong></td>
                        <td><strong><div id="jawab"></div> </strong></td>
                         <td><strong>dari <?php echo $jml_soal_tampil; ?>
                            </strong>
                        </td>
                	</tr>
                </table>
             </div>
             
            </div>
        </div>
	</div>

    	<?php
		//echo cosmo_js();
		echo'
		<script type="text/javascript" src="' . base_url('assets/bootswatch_cosmo/jquery.smooth-scroll.min.js') . '"></script>' . NL;
		echo'
		<script type="text/javascript" src="' . base_url('assets/bootswatch_cosmo/bootstrap.min.js') . '"></script>' . NL;
		echo'
		<script type="text/javascript" src="' . base_url('assets/bootswatch_cosmo/bootswatch.js') . '"></script>' . NL;
		echo'
		<script type="text/javascript" src="' . base_url('js/common.js') . '"></script>' . NL;
		
		//addon('tinymce');
		addon('datetime');
		?>

	<!--</body>
</html>-->

<script>
	var $jml_jawab = 0;
	//// JS KIRIM JAWABAN DAN GANTI WARNA 
	  function input_jawab($no ,$soal_id,$pilihan ,$poin) {
		var validate = $('#soal'+$no);
		
		  if (this.timer) clearTimeout(this.timer);
		  validate.removeClass('error').html('<div style="background-color:#CCCCCC">'+
		  '&nbsp<img src="<?php echo base_url();?>content/images/loader.gif" style="width:34px;"/> Input Jawaban...</div>');
		  
		  this.timer = setTimeout(function () {
			$.ajax({
			  url: '<?php echo base_url()."kbm/evaluasi_ljs/sent_answer";?>',
			  data: 'ljs_id=<?php echo $pengerjaan_ljs['id'];?>&soal_id='+$soal_id+'&pilihan=' + $pilihan+'&poin=' + $poin+'&simulasi=<?=$this->input->get('simulasi')?>&ltz=<?=$evaluasi_berakhir?>',
			  dataType: 'json',
			  type: 'POST',
			  success: function (j) {
				
				validate.html('<div style="background-color:'+j.warna+'">&nbspSOAL NOMOR'+$no+' <br>( '+j.message+' )<div>');
				if(no_jawab[$no] == 0 )
				{	
					jml_jawab++;
					no_jawab[$no] = 1;
				}
				$('#jawab').html(jml_jawab);
				if(jml_jawab >= <?php echo $jml_soal_tampil; ?>) {
					$('#myBtn').removeAttr('disabled');
				}
				$('#nomer_soal'+$no).html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="'+j.warna+'" align="center">'+
					$no+
				  '</td>'+
				 '</tr>'+
				'</table>');
			  },		  
			  
			  error: function (j){
				validate.html('<div style="background-color:#FF4444">&nbspSOAL NOMOR'+$no+' ( Jawaban gagal di simpan, coba beberapa saat lagi. )<div>');
				$('#nomer_soal'+$no).html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#FF4444" align="center">'+
					$no+
				  '</td>'+
				 '</tr>'+
				'</table>');
				
				document.getElementById('butir-'+$soal_id+'-'+$pilihan).checked = false;
			  }
			});
		  }, 200);
		  
	  };
	  
	  
	  //// JS KIRIM JAWABAN ESSAY DAN GANTI WARNA 
	  function input_jawab_essay($no ,$soal_id, $jawaban) {
		var validate = $('#soal'+$no);
		
		  if (this.timer) clearTimeout(this.timer);
		  validate.removeClass('error').html('<div style="background-color:#CCCCCC">'+
		  '&nbsp<img src="<?php echo base_url();?>content/images/loader.gif" style="width:34px;"/> Input Jawaban...</div>');
		  
		  this.timer = setTimeout(function () {
			$.ajax({
			  url: '<?php echo base_url()."kbm/evaluasi_ljs/sent_answer_essay";?>',
			  data: 'ljs_id=<?php echo $pengerjaan_ljs['id'];?>&soal_id='+$soal_id+'&jawaban=' + $jawaban+'&simulasi=<?=$this->input->get('simulasi')?>&ltz=<?=$evaluasi_berakhir?>',
			  dataType: 'json',
			  type: 'POST',
			  success: function (j) {
				
				validate.html('<div style="background-color:'+j.warna+'">&nbspSOAL NOMOR'+$no+' <br>( '+j.message+' )<div>');
				if(no_jawab[$no] == 0 )
				{	
					jml_jawab++;
					no_jawab[$no] = 1;
				}
				$('#jawab').html(jml_jawab);
				if(jml_jawab >= <?php echo $jml_soal_tampil; ?>) {
					$('#myBtn').removeAttr('disabled');
				}
				$('#nomer_soal'+$no).html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#00AAFF" align="center">'+
					$no+
				  '</td>'+
				 '</tr>'+
				'</table>');
			  },		  
			  
			  error: function (j){
				validate.html('<div style="background-color:#FF4444">&nbspSOAL NOMOR'+$no+' ( Jawaban gagal di simpan, coba beberapa saat lagi. )<div>');
				$('#nomer_soal'+$no).html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#FF4444" align="center">'+
					$no+
				  '</td>'+
				 '</tr>'+
				'</table>');
			  }
			});
		  }, 200);
		  
	  };
	  
	  /// CHECK JAWABAN
	  <?php
	  $i=1;
	  while($i<=$no_soal)
	  {?>
	  
		if(no_jawab[<?php echo $i;?>] == 1)
		{	
			$('#soal<?php echo $i;?>').html('<div style="background-color:#00AAFF">&nbspSOAL NOMOR<?php echo $i;?></div>');	
			$('#nomer_soal<?php echo $i;?>').html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#00AAFF" align="center">'+
					'<?php echo $i;?>'+
				  '</td>'+
				 '</tr>'+
				'</table>');
			jml_jawab++;
			
		}
		else
		{
			$('#soal<?php echo $i;?>').html('<div style="background-color:#FFFF00">&nbspSOAL NOMOR<?php echo $i;?></div>');	
			$('#nomer_soal<?php echo $i;?>').html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#FFFF00" align="center">'+
					'<?php echo $i;?>'+
				  '</td>'+
				 '</tr>'+
				'</table>');
			
		}
		
		<?php $i++;
	  }
	  ?>
	  
	$('#jawab').html(jml_jawab);
	if(jml_jawab >= <?php echo $jml_soal_tampil; ?>) {
	   $('#myBtn').removeAttr('disabled');
	}
	$('#ready').html('<div style="background-color:#00AAFF">&nbspEVALUASI SUDAH SIAP DIKERJAKAN<div> </div>');
	
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	})	
	
</script>	
