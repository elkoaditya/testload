<?php

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai' => 'nilai',
	'Siswa' => 'nilai/siswa',
	'#pengumuman_rapor'
);

// buttons

$btn_back = a("nilai/siswa", "<i class=\"icon-circle-arrow-left icon-white\"></i> Kembali ke daftar nilai siswa", 'class="btn btn-info "');

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Pengumuman Rapor')); ?>

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
					<h1>Pengumuman Rapor</h1>
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
                    <h2>RAPOR SEMESTER AKHIR KELAS <?=$user['grade']?></h2>
                    <div class="span10">
                          <div class=" form-signin">
                            <table width="100%">
                                <tr>
                                <td width="100%" align="center">
                                
                                <br/>
                                <?php  $this->load->view('bootswatch_cosmo/nilai/siswa/pengumuman_rapor_detail_uas'); ?>
                                </td>
                                </tr>
                             </table>
                         </div>
                    </div>
                    
                    <div class="span1">
                    </div>
                  </div>
                  
                  
                  <div class="row">	
                    <div class="span1">
                    </div>
					
                    <h2>RAPOR TENGAH SEMESTER KELAS <?=$user['grade']?></h2>
                    <div class="span10">
                          <div class=" form-signin">
                            <table width="100%">
                                <tr>
                                <td width="100%" align="center">
                                
                                <br/>
                                <?php $this->load->view('bootswatch_cosmo/nilai/siswa/pengumuman_rapor_detail_mid'); ?>
                                </td>
                                </tr>
                             </table>
                         </div>
                    </div>
                    
                    <div class="span1">
                    </div>
                  </div>
                  
                  
                   <?php /*}
					}*/

				?>
				
              
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		

	</body>
</html>