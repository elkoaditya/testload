<!--  <?php include "/var/www/fresto.co/master_fresto_v2_01/assets/bootstrap_3.3.1/css/bootstrap.php";?> 
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap_3.3.1/css/bootstrap.min.css">-->
 <link rel="stylesheet" href="<?php echo base_url();?>assets/bootsidemenu/css/BootSideMenu.css">
<style type="text/css">
  .user{
    padding:5px;
    margin-bottom: 5px;
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
    <?php $this->load->view(THEME . "/-html-/content/footer_ljk"); ?>
 <!-- <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">-->
 <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

   


		<?php
		//$this->load->view(THEME . "/-menu-/{$user['role']}");
		//echo breacrumbs($breadcrumbs);
		?>
<section id="main">
<section id="content" class="content-alt">

    <div class="container" style="margin-top:-40px;">
    			<h2><?php echo strtoupper($evaluasi['nama']) ?></h2>
            	<h3><div id='ready'> <div style="background-color:#FFFF00">&nbspEVALUASI BELUM SIAP DIKERJAKAN (BILA TERLALU LAMA HARAP REFRESH)</div> </div></h3>
    	<div class="card">    
        	<div class="table-responsive m-t-10 p-l-20 p-r-20 m-b-10">
    <?php 
	/*print_r($evaluasi);
	echo"<br><br>";
	print_r($soal_result);
	echo"<br><br>";
	print_r($pengerjaan_ljs_jawaban);*/
	?>

			<!-- Typography	================================================== -->
			<div id="tabel">
            <!--
				<div class="page-header alert-block">
					Lembar Jawab Soal :<br/>
					
				</div>-->

				<style>
					p{
						font-size:15px;
					}
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
					echo form_opening("{$uri}?id={$evaluasi['id']}", 'class="form-horizontal" id="myform"');
				endif;
				
				////// check jawaban //////
				foreach ($pengerjaan_ljs_jawaban['data'] as $plj):
					//echo'<br><br>';
					//print_r($plj);
					$ljs_jawaban[$plj['soal_id']] = $plj['pilihan']; 
					$opsi_acak[$plj['soal_id']] = $plj['opsi'];
				endforeach;
					
				///////////////////////// SOAL //////////////////////////////////
				
				$no_soal=0;
				echo'<div class="tab-content">';/* tab konten*/
				
				foreach ($soal_result['data'] as $idx => $soal):
					$no_soal++;
					?>
					<script>
						no_jawab[<?php echo $no_soal;?>] = 0;
					</script>
					<?php
                    
					//// SIMULASI PENGERJAAN 
                    if(!isset($opsi_acak[$soal['id']]))
					{	
						$opsi = array("a","b","c","d","e");
						shuffle($opsi);		
						$opsi_acak[$soal['id']]='';
						foreach($opsi as $pilihan)
						{
							$opsi_acak[$soal['id']] .= $pilihan.',';
						}
					}
					////////
					
					soal_prepljs($soal,$opsi_acak);
					if($no_soal==1)
					{	$active_tab='active';	}
					else
					{	$active_tab='';	}
					echo '<div class="tab-pane '.$active_tab.'" id="tab'.$no_soal.'" >';
					
					echo '<div id="link_soal'.$no_soal.'"></div>';
					
					/* tombol next previus*/
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnPrevious">
					<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelumnya</a></div>';
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnNext">
					Lanjut SOAL <i class="zmdi zmdi-chevron-right"></i></a></div><br/><br/><br/>';
					
					echo '<div class="well">';
					
					
					
					
					/// SOAL ///
					
					//////  AUDIO ////////
					if($soal['audio']!='')
					{
						echo "<h2> Player Sound</h2>";
					?>
                    
                <script type="text/javascript">
				$(document).ready(function(){
		
					var myCirclePlayer = new CirclePlayer("#jquery_jplayer_<?=$soal['id'];?>",
					{
						oga: "<?php echo base_url().$soal['audio'];?>"
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
					
					echo '<fieldset>';
					echo "<legend>
					<div id='soal".$no_soal."'>&nbspPertanyaan ::&nbsp; " . ($idx + 1) . " (Belum dijawab)</div>
					</legend>";

					// tampilkan pertanyaan

					echo div('class="soal-pertanyaan" style="margin-bottom:-25;"', $soal['pertanyaan']) . '<br/>';

					// tampilkan isian siswa

					if ($evaluasi['pilihan_jml'] > 1 && is_array($soal['opsi'])):
						echo '<table class="table table-bordered table-striped table-hover">' . NL;

						foreach ($soal['opsi'] as $key => $opsi):
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
							
							echo "<label class=\"radio\" style=\"margin-bottom:-25;\"> " 
							. div(" class='radio radio-inline m-r-20 soal-opsi' onclick=javascript:input_jawab({$no_soal},{$soal['id']},'{$key}',{$soal['poin_max']})", form_radio($radio). "<i class='input-helper'></i>".$opsi)
							 
							. "</label>" . NL;

							echo '</td></tr>';

						endforeach;

						echo '</table>';

					else:
					
						$input_essay['id'] = "butir-{$soal['id']}";
						$input_essay['name'] = "butir-{$soal['id']}";
						$input_essay['value'] = (!$post_request) ? '' : html_entity_decode($this->input->post($input_essay['name']));

						echo form_cell($input_essay);

						if ($evaluasi['pilihan_jml'] > 1 && !is_array($soal['opsi'])):
							echo '<div class="label label-warning">Terjadi kesalahan pada opsi pilihan.<br/>';

							if ($editable)
								echo 'Klik ' . a("kbm/evaluasi_soal/form?id={$soal['id']}", 'disini', '') . ' untuk merubah daftar opsi/pilihan. ';

							if ($deletable)
								echo 'Klik ' . a("kbm/evaluasi_soal/delete?id={$soal['id']}", 'disini', '') . ' untuk menghapus butir soal. ';

							echo '</div>';

						endif;

					endif;

					echo ' </fieldset></div>';/*well*/
					
					/* tombol next previus*/
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnPrevious">
					<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelumnya</a></div>';
					echo '<div class="col-sm-6" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnNext">
					Lanjut SOAL <i class="zmdi zmdi-chevron-right"></i></a></div><br/><br/>';
					
					
					echo'</div>';/* tab*/
					
					
				endforeach;
				
				
				// form button selesai

				echo '<div class="tab-pane" id="tab_selesai" >';
					/* tombol next previus*/
				echo '<div class="col-sm-12" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnPrevious">
					<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelumnya</a></div><br/><br/><br/>';
					
					
				if ($user['role'] == 'siswa'):
					
					echo '<fieldset>';
					echo '<div class = "form-actions well" align="center">'
					. ' <button type = "submit" class = "btn btn-success btn-large" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">'
					. ' <i class = "icon-save icon-white"></i> TUTUP DAN SELESAI PENGERJAAN <br>'
					.'<i>*klik jika yakin selesai <br> menjawab semua</i></button> '
					. ' </div>';
					echo '</fieldset>';
				else:
				
					echo '<fieldset>';
					echo '<div class = "form-actions well" align="center">'
					. ' <button class = "btn btn-success btn-large" onclick="return confirm(\'APAKAH ANDA YAKIN TELAH SELESAI MENGERJAKAN ?\')">'
					. ' <i class = "icon-save icon-white"></i> TUTUP DAN SELESAI PENGERJAAN <br>'
					.'<i>*klik jika yakin selesai <br> menjawab semua</i></button> '
					. ' </div>';
					echo '</fieldset>';
					
				endif;	
				
				/* tombol next previus*/
				echo '<div class="col-sm-12" ><a class="btn btn-primary btn-block waves-effect m-b-10 btnPrevious">
				<i class="zmdi zmdi-chevron-left"></i> SOAL Sebelumnya</a></div>';
				
				echo'</div>';/* tab*/
			
				echo form_close();
				
				echo'</div>';/* tab konten*/
				
				/////////////////////// NOMER /////////////////////////////
				$no_soal=0;			
				echo' <b>NOMER SOAL:</b><br/> <ul class="nav nav-tabs">';
				foreach ($soal_result['data'] as $idx => $soal):
					$no_soal++;
					if($no_soal==1)
					{	$active_tab=' class="active"';	}
					else
					{	$active_tab='';	}
					echo '<li '.$active_tab.'><a href="#tab'.$no_soal.'" data-toggle="tab">'.$no_soal.'</a></li>';
				endforeach;
				echo '<li><a href="#tab_selesai" data-toggle="tab">SELESAI</a></li>';
				echo'</ul><br/><br/>';
				?>

			</div>

			</div>
		</div><!-- card -->
    </div><!-- /container -->

    <div class="navbar navbar-fixed-bottom" style="background-color:#FF4500">
    	<div class="navbar-inner m-t-10 m-l-10">
        	<div class="container">
             <div class="clearfix" >
            	<table style="color:#FFFFFF; font-size:16px;">
                	<tr>
                        <td><strong>WAKTU :	</strong></td>
                        <td><strong><div id="countdown"></div></strong></td>
                    	<td>&nbsp&nbsp&nbsp&nbsp&nbsp </td>
                        <td><strong>JAWAB : </strong></td>
                        <td><strong><div id="jawab"></div> </strong></td>
                        <td><strong>dari <?php echo $jml_soal; ?>
                            </strong>
                        </td>
                	</tr>
                </table>
                
                        
                    
             </div>
             
            </div>
        </div>
	</div>
    
</section>
</section>

<!-- menu nomer-->
   
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
		$nomer_link=1; 
		while($jml_soal>=$nomer_link)
		{
			?>
            
            	<!--<a href="#link_soal<?=$nomer_link;?>" >-->
                <a href="#tab<?=$nomer_link?>" data-toggle="tab">
                <div id="nomer_soal<?=$nomer_link;?>" class="img-thumbnail" style="margin-left:4px" >
                    <table>
                     <tr>
                      <td width="50px" height="50px" bgcolor="#FFFF00" align="center">
                    	<?=$nomer_link;?>
                      </td>
                     </tr>
                    </table>
                </div>
                </a>
               <!-- <img src="" width="60px" height="60px" alt="<?=$nomer_link;?>" class="img-thumbnail"></a>&nbsp;&nbsp;-->
            
			<?php
	  		$nomer_link++;
		}
		?>
     		 	<a href="#tab_selesai" data-toggle="tab">
                <div class="img-thumbnail" style="margin-left:4px" >
                    <table>
                     <tr>
                      <td width="100px" height="50px" bgcolor="#4CAF50" align="center">
                    	SELESAI
                      </td>
                     </tr>
                    </table>
                </div>
                </a>
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
		/*echo'
		<script type="text/javascript" src="' . base_url('js/common.js') . '"></script>' . NL;
		*/
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
			  },		  
			  
			  error: function (j){
				validate.html('<div style="background-color:#FF4444">&nbspPertanyaan :: '+$no+' ( Jawaban gagal di simpan, koneksi terputus. )<div>');
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
			$('#soal<?php echo $i;?>').html('<div style="background-color:#00AAFF">&nbspPertanyaan :: <?php echo $i;?> (Jawaban tersimpan)</div>');	
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
			$('#soal<?php echo $i;?>').html('<div style="background-color:#FFFF00">&nbspPertanyaan :: <?php echo $i;?> (Belum dijawab)</div>');	
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
	$('#ready').html('<div style="background-color:#00AAFF">&nbspEVALUASI SUDAH SIAP DIKERJAKAN<div> </div>');
	
$('.btnNext').click(function(){
  $('.nav-tabs > .active').next('li').find('a').trigger('click');
});

$('.btnPrevious').click(function(){
  $('.nav-tabs > .active').prev('li').find('a').trigger('click');
});
</script>	
