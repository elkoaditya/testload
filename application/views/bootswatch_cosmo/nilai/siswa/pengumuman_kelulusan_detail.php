<?php

//print_r($user);
//print_r($semaktif);
date_default_timezone_set("Asia/Bangkok");
$day5 = date("Y-m-d H:i:s");
//$day5 = "2016-05-06 01:00:00";
$day = strtotime($day5);
//print_r($resultset);
foreach($resultset['data'] as $hari)
{
	if($hari['key']=='siswa_download_kelulusan')
	{
		$day2 = strtotime($hari['value']);
	}
}
//$day2 = strtotime("2016-05-07 15:00:00");
$day3 = $day2-$day;

$nday	= floor($day3 / 86400);
$thour	= $day3 % 86400;

$nhour		= floor($thour / 3600);
$tminute	= $thour % 3600;

$nminute	= floor($tminute / 60);
$tsecond	= $tminute % 60;

//$nday=0; $nhour=0; $nminute=0; $tsecond=5;

/// PEMGUMUMAN BIASA
$link_print = "<div align='center'>".
	"<a href='http://fresto.id/kelulusan/index.php?kode=".APP_SCOPE."' class='btn btn-success btn-block '". 
	"title='download dari laman ini'><b><br/>Link PENGUMUMAN KELULUSAN </b><br/><br/></a>".
"</div>";	

/// SKHUN
if(APP_SCOPE=='sman9smg') {
	$link_print = "<div align='center'>".
		"<a href='".base_url()."nilai/siswa/skhun/".$user['nilai_id']."/2013' class='btn btn-success btn-block '". 
		"title='download dari laman ini' target='_blank'><b><br/> PENGUMUMAN KELULUSAN </b><br/><br/></a>".
	"</div>";	
}

?>


  
    
<!--    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
    
  

<?php //echo $nday." ".$nhour." ".$nminute." ".$tsecond." | ".$day3." ".$day2." ".$day." ".$day5;?>

        <table width="100%">
            <tr>
                <td  class="width_td"> </td>
                <td>  
                    
                    <br/>
                    <?php 
					$day_2month	= strtotime(date('Y-m-d', strtotime("+2 months", $day2)));	
					if($day<=$day_2month){
						if($day>=$day2)
						{
							echo $link_print;
							
						}else{
						?>
						
						  <div id="counter"></div>
						  <div id="desc" class="desc">
							<div>Hari</div>
							<div>Jam</div>
							<div>Menit</div>
							<div>Detik</div>
						  </div>
						 <?php 
						 } 
					}else{ ?>
					<h3>Tunggu Waktu Tayang </h3>
					<?php 
					}	 
					?>
                      
                 
                </td>
                <td  class="width_td"></td>
            </tr>
        </table>
        
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="<?php echo base_url("assets/countdown"); ?>/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
 
 	var mb = window.matchMedia( "(min-width: 1200px)" );
	
	var mm = window.matchMedia( "(min-width: 561px)" );
    
	if (mb.matches) {
	
	  $(function(){
		  $('#counter').countdown({  
				stepTime: 60,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				digitImages: 6,
				digitWidth: 67,
				digitHeight: 90,
				timerEnd: function() 
				{ 
					//alert('end!!'); 
					document.getElementById("counter").innerHTML = "<?php echo $link_print;?>";
					document.getElementById("desc").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits1.png"
			});
		  });
	  
	 } else if (mm.matches) {
		 
        $(function(){
			 $('#counter').countdown({
				stepTime: 60,
				digitWidth: 34,
				digitHeight: 45,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				timerEnd: function () {
				   document.getElementById("counter").innerHTML = "<?php echo $link_print;?>";
				   document.getElementById("desc").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits2.png"
			});
		  });
		  
	 } else {
		 
        $(function(){
			 $('#counter').countdown({
				stepTime: 60,
				digitWidth: 16,
				digitHeight: 24,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				timerEnd: function () {
				   document.getElementById("counter").innerHTML = "<?php echo $link_print;?>";
				   document.getElementById("desc").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits3.png"
			});
		  });
		  
	 }
     
    </script>
	
    


