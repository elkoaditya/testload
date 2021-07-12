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
	if($hari['key']=='siswa_download_rapor_mid_kelas_'.$user['grade'])
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
//$html .= a("nilai/siswa/rapor_mid/{$row['id']}/2013", 'R.Mid', 'title="cetak rapor Mid semester siswa" target="_blank"') . " &nbsp; ";
	
//$link_print = '';
$link_print = "<div align='center'>".
	"<a href='rapor_mid/".$user['nilai_id']."/2013' class='btn btn-success btn-block '". 
	"title='download hasil ini dalam PDF' target='_blank'><b><br/>Cetak Rapor Tengah Semester</b><br/><br/></a>".
"</div>";
?>


  
    
<!--    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
    <style type="text/css">
      br { clear: both; }
      .cntSeparator {
        font-size: 54px;
        margin: 10px 7px;
        color: #000;
      }
      .desc_mid { margin: 7px 3px; }
      
		/*   .desc_mid div {
			float: left;
			font-family: Arial;
			width: 70px;
			margin-right: 34px;
			margin-left: 29px;
			font-size: 20px;
			font-weight: bold;
			color: #000;
		  }*/
		  .judul{
			   font-size:48px;
			   font-weight: bold;
			   padding: 30px 15px 25px 15px;
			  	}
			.width_td{
				width:11%;
			  	}
		   .desc_mid div {
			float: left;
			font-family: Arial;
			width: 70px;
			margin-right: 44px;
			margin-left: 44px;
			font-size: 20px;
			font-weight: bold;
			color: #000;
		  }
	   @media screen and (max-width: 1220px)
	   {
		   .width_td{
				width:2%;
			  	}
	   }
	   
	   @media screen and (max-width: 1180px)
	   {
		   .judul{
			   font-size:28px;
			   font-weight: bold;
			    padding: 25px 10px 20px 10px;
			  	}
			.width_td{
				width:12%;
			  	}
		   .desc_mid div {
				float: left;
				font-family: Arial;
				width: 32px;
				margin-right: 49px;
				margin-left: 14px;
				font-size: 16px;
				font-weight: bold;
				color: #000;
		  }
	  }
	   
	  @media screen and (max-width: 560px)
	   {
		   .judul{
			   font-size:18px;
			   font-weight: bold;
			   padding: 15px 1px 5px 1px;
			  	}
			  	
			.width_td{
				width:17%;
			  	}
		   .desc_mid div {
				float: left;
				font-family: Arial;
				width: 32px;
				margin-right: 19px;
				margin-left: 5px;
				font-size: 12px;
				font-weight: bold;
				color: #000;
		  }
	  }
	  @media screen and (max-width: 430px)
	   {
		   .width_td{
				width:9%;
			  	}
	   }
	   @media screen and (max-width: 360px)
	   {
		   .width_td{
				width:0;
			  	}
	   }
    </style>
  

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
						
						  <div id="counter_mid"></div>
						  <div id="desc_mid" class="desc_mid">
							<div>Hari</div>
							<div>Jam</div>
							<div>Menit</div>
							<div>Detik</div>
						  </div>
						 <?php 
						 } 
					}else{?>
					<h3>Tunggu Waktu Tayang </h3>
					<?php 
					}?>
                      <br /><br/><br/><br/>
                  
                </td>
                <td  class="width_td"></td>
            </tr>
        </table>
        
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <script src="<?php echo base_url("assets/countdown"); ?>/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
 
 	var mb = window.matchMedia( "(min-width: 1181px)" );
	
	var mm = window.matchMedia( "(min-width: 561px)" );
    
	if (mb.matches) {
	/*	
	  $(function(){
        $('#counter_mid').countdown({  
			stepTime: 60,
			format: 'dd:hh:mm:ss',
			startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
			digitImages: 6,
			digitWidth: 53,
			digitHeight: 77,
			timerEnd: function() 
			{ 
				//alert('end!!'); 
				document.getElementById("counter_mid").innerHTML = "<a href=''>ok</a>";
			},
			image: "img/digits1.png"
		});
	  });*/
	  $(function(){
		  $('#counter_mid').countdown({  
				stepTime: 60,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				digitImages: 6,
				digitWidth: 67,
				digitHeight: 90,
				timerEnd: function() 
				{ 
					//alert('end!!'); 
					document.getElementById("counter_mid").innerHTML = "<?php echo $link_print;?>";
					document.getElementById("desc_mid").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits1.png"
			});
		  });
	  
	 } else if (mm.matches) {
		 
        $(function(){
			 $('#counter_mid').countdown({
				stepTime: 60,
				digitWidth: 34,
				digitHeight: 45,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				timerEnd: function () {
				   document.getElementById("counter_mid").innerHTML = "<?php echo $link_print;?>";
				   document.getElementById("desc_mid").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits2.png"
			});
		  });
		  
	 } else {
		 
        $(function(){
			 $('#counter_mid').countdown({
				stepTime: 60,
				digitWidth: 16,
				digitHeight: 24,
				format: 'dd:hh:mm:ss',
				startTime: "<?php echo $nday;?>:<?php echo $nhour;?>:<?php echo $nminute;?>:<?php echo $tsecond;?>",
				timerEnd: function () {
				   document.getElementById("counter_mid").innerHTML = "<?php echo $link_print;?>";
				   document.getElementById("desc_mid").innerHTML = "";
				},
				image: "<?php echo base_url("assets/countdown"); ?>/img/digits3.png"
			});
		  });
		  
	 }
     
    </script>
    
 <!-- <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>-->

