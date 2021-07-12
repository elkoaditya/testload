<?php
/// CEK SISWA
	if(isset( $this->session->userdata['user']['no_peserta'])){
		$data_siswa ='';
		if(isset($data['data_siswa']['data'])){
			$data_siswa = $data['data_siswa']['data'];
		}
		cek_siswa_bersangkutan( $this->session->userdata['user']['id'], $data_siswa);
	}
	?>
<html>
<body>
	<style type="css">
		@page {
			/*sheet-size: 210mm 297mm ;*/
			sheet-size: 210mm 330mm ;
			margin: -20px 20px -20px 20px;
		}
		.page-notend{
			page-break-after: always;
		}
		.header1{
			 display: block;
			/*font-size: 1em;*/
			margin-top: 1.33em;
			margin-bottom: 1.33em;
			margin-left: 0;
			margin-right: 0;
			/*font-weight: bold;*/
			
		}
		.personil{
			padding: 4px 2px 2px 4px;
		}
		td {
			font-size: 12px;
			
		}
		.bold{
			font-weight: bold;
		}
		.text{
			font-size: 13px;
			text-align: justify;
			text-justify: inter-word;
		}
		.text2{
			font-size: 14px;
			text-align: justify;
			text-justify: inter-word;
		}
		.style8{
			font-size: 8px;
		}
		.style9{
			font-size: 9px;
		}
		.style10{
			font-size: 10px;
		}
		.style11{
			font-size: 11px;
		}
		.style12{
			font-size: 12px;
		}
		.style14{
			font-size: 14px;
		}
		.style14b{
			font-size: 14px;
			font-weight: bold;
		}
		.style16{
			font-size: 16px;
		}
		.style16b{
			font-size: 16px;
			font-weight: bold;
		}
		.style18{
			font-size: 18px;
		}
		.style18b{
			font-size: 18px;
			font-weight: bold;
		}
		.style20{
			font-size: 20px;
			font-weight: bold;
		}
		.line_bottom{
			border-bottom:solid; 
			border-bottom-width:1; 
			padding-bottom:1;
		}
	</style>
<?php
	
	include"print/siswa_daftar_ulang.php";
	include"print/siswa_lintas_minat.php";
?>
</body>
</html>