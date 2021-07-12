
<style type="text/css">
  br { clear: both; }
  .cntSeparator {
	font-size: 54px;
	margin: 10px 7px;
	color: #000;
  }
  .desc { margin: 7px 3px; }
  
	/*   .desc div {
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
			width:5%;
			}
	   .desc div {
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
			width:0;
			}
   }
   
   @media screen and (max-width: 1200px)
   {
	   .judul{
		   font-size:28px;
		   font-weight: bold;
			padding: 25px 10px 20px 10px;
			}
		.width_td{
			width:3%;
			}
	   .desc div {
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
	   .desc div {
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

 <h2>
       PENGUMUMAN KELULUSAN
        <hr/>
	</h2>
<?php
	$this->load->view('bootswatch_cosmo/nilai/siswa/pengumuman_kelulusan_detail');
?>