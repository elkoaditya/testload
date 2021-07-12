<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Siswa' => 'nilai/siswa',
	'#pengumuman_kelulusan'
);

// buttons

$btn_back = a("nilai/siswa", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke daftar nilai siswa", 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pengumuman Kelulusan')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80" oncontextmenu="return false">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		echo cosmo_js(); 
		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				
                <div class="page-header">
					<h1>Pengumuman Kelulusan</h1>
				</div>
			
           
                <?php

				echo alert_get();

				// upload

			/*	if ($this->user['tipe'] == 'siswa')
					{
						if($row['kelas_tingkat'] == 12)
						{
				*/		?>
                
                 <div class="row">	
                    <div class="span1">
                    </div>
                    <h2>PENGUMUMAN KELULUSAN</h2>
                    <div class="span10">
                          <div class=" form-signin">
                            <table width="100%">
                                <tr>
                                <td width="100%" align="center">
                                
                                <br/>
								
								<!--- PENGUMUMAN KELULUSAN -->
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
											width:11%;
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
											width:2%;
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
											width:12%;
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
                                <?php  $this->load->view('bootswatch_cosmo/nilai/siswa/pengumuman_kelulusan_detail'); ?>
                                
								<!-- ///////////////////////////////////////////////////////////// -->
								</td>
                                </tr>
                             </table>
							 
							 <br/><br/><br/><br/>
							 
                         </div>
                    </div>
                    
                    <div class="span1">
                    </div>
                  </div>
                  
                  <!--
                  <div class="row">	
                    <div class="span1">
                    </div>
                    <h2>RAPOR TENGAH SEMESTER</h2>
                    <div class="span10">
                          <div class=" form-signin">
                            <table width="100%">
                                <tr>
                                <td width="100%" align="center">
                                
                                <br/>
                                <?php // $this->load->view('bootswatch_cosmo/nilai/siswa/pengumuman_rapor_detail_mid'); ?>
                                </td>
                                </tr>
                             </table>
                         </div>
                    </div>
                    
                    <div class="span1">
                    </div>
                  </div>-->
                  
                  
                   <?php /*}
					}*/

				?>
				
              
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		

	</body>
</html>