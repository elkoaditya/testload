  <?php include "/var/www/fresto.co/master_fresto_v2_01/assets/bootstrap_3.3.1/css/bootstrap.php";?> 
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap_3.3.1/css/bootstrap.min.css">
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootsidemenu2/css/BootSideMenu.css">
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
<script src="<?php echo base_url();?>assets/bootstrap_3.3.1/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/bootsidemenu2/js/BootSideMenu.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/jPlayer_circle/circle.skin/circle.player.css">

<!--<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.transform2d.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.grab.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/jquery.jplayer.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/mod.csstransforms.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/jPlayer_circle/js/circle.player.js"></script>


<!--<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="js/BootSideMenu.js"></script>-->

<script type="text/javascript">
	var jml_jawab = 0;
	var no_jawab = new Array();
	
	alert(screen.width);
	
	$(document).ready(function(){
		var value;
		if(screen.width < 720)
		{
			value = false;
			$('#demo').BootSideMenu({
				side:"right",
				width: '200px',
				pushBody:value,
				remember:value,
			 
			});
		}else{
			value = true;
			$('#demo').BootSideMenu({
				side:"right",
				width: '320px',
			 
				pushBody:value,
				remember:value,
			 
			});
		}
		
		 
	});
		
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	})
		
</script>
<?php
// vars

$author_ybs = ($evaluasi['author_id'] == $user['id']);
$editable = (($author_ybs OR $admin) && !$evaluasi['closed'] && $evaluasi['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$evaluasi['published']);

// vars 2 evaluasi['upload_soal']

//$file_path = array_node($evaluasi, array('upload_soal', 'full_path'));
$file_path = "content/".strtolower(APP_SCOPE)."/soal/".$evaluasi['id']."/soal/".$evaluasi['upload_soal'];
$file_local_path = APP_ROOT.$file_path;
$file_link = ($file_path && file_exists($file_local_path)) ? base_url(webpath($file_path)) : NULL;
$file_ofis = file_ofis($evaluasi, array('upload_soal', 'file_ext'));
$file_imag = array_nodex($evaluasi, array('upload_soal', 'is_image'), FALSE);
$file_name = array_nodex($evaluasi, array('upload_soal', 'file_name'), (($file_ofis) ? 'dokumen' : (($file_imag) ? 'gambar' : 'download')));
$file_view = "http://docs.google.com/viewer?url=" . $file_link;

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
		'type' => 'textarea',
		'class' => 'input tinymce_mini',
);

?>
<?php 
/* JUMLAH SOAL EVALUASI*/
if($evaluasi['soal_jml']>0) 
	$jml_soal = $evaluasi['soal_jml']; 
else 
	$jml_soal = $evaluasi['soal_total'];
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
 <!-- <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">-->
 <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

   <!-- menu nomer-->
   <div class="loader"></div>
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
    <div class="user">
    <?php
	$pilihan_ganda = array('a','b','c','d','e','f','g','h','i');
	///// pilihan ganda di kanan
		$nomer_link=1; 
		//while($jml_soal>=$nomer_link)
	

				////// check jawaban //////
				foreach ($pengerjaan_ljs_jawaban['data'] as $plj):
					//echo'<br><br>';
					//print_r($plj);
					$ljs_jawaban[$plj['soal_id']] = $plj['pilihan']; 
					$opsi_acak[$plj['soal_id']] = $plj['opsi'];
					
				//	echo "soal : ".$plj['soal_id'];
				//	echo "<br>";
				//	echo "jwb : ".$plj['pilihan'];
				//	echo "<br>";
				//	echo "<br>";
				//	echo "modified : ".$plj['modified'];
				//	echo "<br>";
				//	echo "<br>";
				//	echo "<br>";
				//	echo "<br>";
				endforeach;
							
		foreach ($soal_result['data'] as $soal_key => $soal_value)
		{
			
			$sudah_jawab = 0;
							$name = "butir-{$soal_value['id']}";
							if($pengerjaan_ljs['id']):
							$sudah_jawab = 1;
							endif;
			?>
				<script>
					no_jawab[<?php echo $nomer_link;?>] = 0;
				</script>
            	
                <div  class="img-thumbnail"style="margin-left:4px" >
                    <table width="100%">
                     <tr>
                      <td width="30px" height="40px"  align="center"  bgcolor="#FFFF00" id="nomer_soal<?=$nomer_link;?>" > 
                    	<?=$nomer_link;?>
                      </td>
						  <td width="18px" height="40px">
						  </td>
						<?php 
							for ($a = 0; $a < $evaluasi['pilihan_jml']; $a++):
							
						?>
						  <td width="40px" height="40px"  align="center">
								<?php ///$pilihan_ganda[$a]
							//echo $ljs_jawaban[$soal_value['id']]."==".$pilihan_ganda[$a]	;
								
							$checked = FALSE; 
							if($sudah_jawab == 1){
								if(isset($ljs_jawaban[$soal_value['id']])):
									if($ljs_jawaban[$soal_value['id']]==$pilihan_ganda[$a]):
										$checked = TRUE; 
										?><script>
										no_jawab[<?php echo $nomer_link;?>] = 1;
										</script><?php
									endif;
								endif;
							}	
							$radio = array(
									'name' => $name,
									'id' => $name . '-' . $soal_key,
									'value' => $soal_key,
									'checked' => $checked,
							);
						
						echo "<label class=\"radio\">"
						. div("class='soal-opsi' onclick=javascript:input_jawab({$nomer_link},{$soal_value['id']},'{$pilihan_ganda[$a]}',{$soal_value['poin_max']})", form_radio($radio) . $pilihan_ganda[$a])
							. "</label>" . NL;
						  ?>
						  </td>
						  <td width="8px" height="40px">
						  </td>
						<?php
							endfor;
						?>
						  <td height="40px" class="soal<?=$nomer_link;?>">
						  </td>
                     </tr>
                    </table>
                </div>
               <!-- <img src="" width="60px" height="60px" alt="<?=$nomer_link;?>" class="img-thumbnail"></a>&nbsp;&nbsp;-->
            
			<?php
	  		$nomer_link++;
		}
		?>
     
    </div>
</div>


		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">
    <?php 
	/*print_r($evaluasi);
	echo"<br><br>";
	print_r($soal_result);
	echo"<br><br>";
	print_r($pengerjaan_ljs_jawaban);*/
	?>

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header alert-block">
					Lembar Jawab Soal :<br/>
					<h1><?php echo strtoupper($evaluasi['nama']) ?></h1>
                    <h2><div id='ready'> <div style="background-color:#FFFF00">&nbspEVALUASI BELUM SIAP DIKERJAKAN (BILA TERLALU LAMA HARAP REFRESH)</div> </div></h2>
				</div>

				<?php
				echo alert_get();
				
				//// audio <<< terhapus
				
				if ($user['role'] == 'siswa'):
					echo form_opening("{$uri}?id={$evaluasi['id']}", 'class="form-horizontal" id="myform"');
				endif;
				
				
				/// SOAL ///
					//echo '<div class="well" >';
					//elseif ($file_ofis):
						echo "<iframe id=\"lampiran\" src=\"{$file_view}&embedded=true\" style='width:100%; height:500px;'></iframe>";

				// form button

				if ($user['role'] == 'siswa'):

					echo '<fieldset>';
					echo '<div class = "form-actions well">'
					. ' <button type = "submit" class = "btn btn-success btn-large" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">'
					. ' <i class = "icon-save icon-white"></i> TUTUP DAN SELESAI PENGERJAAN <br><i>*klik jika yakin selesai menjawab semua</i></button> '
					. ' </div>';
					echo '</fieldset>';

					echo form_close();

				endif;
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

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
                        <td><strong>dari <?php echo $nomer_link; ?>
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
		//echo'<script type="text/javascript" src="' . base_url('js/common.js') . '"></script>' . NL;
		
		addon('tinymce');
		addon('datetime');
		?>

	</body>
</html>

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
			  data: 'ljs_id=<?php echo $pengerjaan_ljs['id'];?>&soal_id='+$soal_id+'&pilihan=' + $pilihan+'&poin=' + $poin,
			  dataType: 'json',
			  type: 'POST',
			  success: function (j) {
				
				validate.html('<div style="background-color:'+j.warna+'">&nbspPertanyaan :: '+$no+' ( '+j.message+' )<div>');
				if(no_jawab[$no] == 0 )
				{	
					jml_jawab++;
					no_jawab[$no] = 1;
				}
				$('#jawab').html(jml_jawab);
				$('#nomer_soal'+$no).html('<table>'+
				 '<tr>'+
				  '<td width="50px" height="50px" bgcolor="#00AAFF" align="center">'+
					$no+
				  '</td>'+
				 '</tr>'+
				'</table>');
				document.getElementById("nomer_soal"+$no).style.backgroundColor = "#00AAFF";
			  },		  
			  
			  error: function (j){
				validate.html('<div style="background-color:#FF4444">&nbspPertanyaan :: '+$no+' ( Jawaban gagal di simpan, coba beberapa saat lagi. )<div>');
				document.getElementById("nomer_soal"+$no).style.backgroundColor = "#FF4444";
			  }
			});
		  }, 200);
		  
	  };
	  
	  /// CHECK JAWABAN
	  <?php
	  $i=1;
	  while($i<$nomer_link)
	  {?>
	  
		if(no_jawab[<?php echo $i;?>] == 1)
		{	
			$('#soal<?php echo $i;?>').html('<div style="background-color:#00AAFF">&nbspPertanyaan :: <?php echo $i;?></div>');	
			document.getElementById("nomer_soal<?php echo $i;?>").style.backgroundColor = "#00AAFF";
			jml_jawab++;
		}
		else
		{
			$('#soal<?php echo $i;?>').html('<div style="background-color:#FFFF00">&nbspPertanyaan :: <?php echo $i;?></div>');	
			document.getElementById("nomer_soal<?php echo $i;?>").style.backgroundColor = "#FFFF00";
		}
		
		<?php $i++;
	  }
	  ?>
	  
	$('#jawab').html(jml_jawab);
	$('#ready').html('<div style="background-color:#00AAFF">&nbspEVALUASI SUDAH SIAP DIKERJAKAN<div> </div>');
</script>	
