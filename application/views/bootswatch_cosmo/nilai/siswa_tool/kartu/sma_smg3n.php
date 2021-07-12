<style>
	@page
	{
		sheet-size: 210mm 290mm;
		margin: -5mm 2mm -5mm 2mm;
		
		header: html_header_1;
		footer: html_footer_pagenum;
	}
	.page-notend{
		page-break-after: always;
	}
	.table-border{
		border: 4px solid black; 
		padding-bottom: 2px;
	}
	.table-border2{
		border-top: 3px solid black;
		padding-bottom: 2px;
	}
	.padding{
		padding-bottom: 10px;
	}
 
	.style1{
		font-size: 22px; 
		font-weight: bold;
	}
 
</style> 
<?php //print_r($resultset['data']); ?>
<table width="100%" border="0" cellpadding="5px">
	<?php 
	$no = 0;
	// for ($y = 0; $y <= 20; $y++) {
	
	$limit = 2;
	
	foreach($resultset['data'] as $k_siswa => $v_siswa){
		
		$no++;
		//if($no<=8){
			if (($no % $limit )==1) {?>
			<tr>	
			<?php }?>
					<td width='50%'>	
						<?php echo '<img src="'.APP_ROOT.'content/'.APP_SCOPE.'/template_image/kartu_ujian.png" 
						style="margin-bottom:-400px" ><br/>';?>
						<table width="100%" border="0">
							<tr>
								<td height="74px" colspan="2"></td>
							</tr>
							<tr>
								<td rowspan="7" valign="top" align="center" width="36%">
								<?php
								$xdat = (array) json_decode($v_siswa['xdat'], TRUE);
								$path_foto = array_node($xdat, array('foto', 'full_path'));
								echo img_foto($path_foto, array('id' => 'pp-thumb', 'width' => 219, 'height' => 292));
								?></td>
								<td height="28px"></td>
							</tr>
							<tr>
								<td height="60px" valign="middle" class="style1"><?=$v_siswa['nama']?></td>
							</tr>
							<tr>
								<td height="46px" valign="top" class="style1"></td>
							</tr>
							<tr>
								<td height="60px" valign="middle" class="style1"><?=$v_siswa['kelas_nama']?></td>
							</tr>
							<tr>
								<td height="46px" valign="top" class="style1"></td>
							</tr>
							<tr>
								<td height="60px" valign="middle" class="style1"><?=$v_siswa['no_un']?></td>
							</tr>
							<tr>
								<td height="60px" ></td>
							</tr>
						</table> 
					</td>
				
			<?php if ( ($no % $limit)==0 ) {?>
			</tr>	
			<?php }
		//}
	}
	
	while(($no % $limit)!=0){
		$no++;
		?>
		<td width='50%'></td>
		
		<?php 
		if(($no % $limit)==0){ ?>
			</tr>
			<?php
		}
		
	}
	?> 
</table>  