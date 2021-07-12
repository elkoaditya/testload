<?php $this->load->view(THEME . "/data/profil/siswa/cover/info", $this->d); 
$info = info();
?>
<html>
	<head>
		<style>
			
			@page
			{
				size: 210mm 297mm;
				margin: 3mm 10mm 0mm 10mm;
				margin-header: 10mm;
				margin-footer: 15mm;
				header: html_header_1;
                footer: html_footer_pagenum;
				
			}
			.page-notend{
                page-break-after: always;
            }
			.bold{
				font-weight: bold;
			}

			.center{
				text-align: center;
			}

			.foot-text
			{
				font-size: 10px;
				font-style: italic;
			}
			<?php /* 
            .page_bg0{
				background-image: url(<?=base_url("")?>/images/logo/<?=APP_SCOPE?>/bg_school.gif);
				background-size: 1200px 1200px;
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: relative;
            } */?>
			.page_bg0 {
				background-image: url(<?=base_url("")?>/images/logo/<?=APP_SCOPE?>/bg_school.png);
				
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: relative;
			}
		</style>
	</head>

	<body>
	<?php $this->load->view(THEME . "/data/profil/siswa/cover/front",$info); ?>
	
	<?php
	if (APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'){
		$this->load->view(THEME . "/data/profil/siswa/cover/front2"); 
	} ?>
	
	<?php 
	$data['info'] = $info;
	$this->load->view(THEME . "/data/profil/siswa/cover/k13_isi",$data); ?>
	


</body>
</html>