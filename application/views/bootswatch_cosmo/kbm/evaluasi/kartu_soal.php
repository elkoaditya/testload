<?php
// komponen
//print_r($evaluasi);
//echo"<br><br>";
//print_r($resultset);
include('pdf/header_footer_pdf.php');

$this->load->helper('dataset');

// tabel data
$ds_row = array(
		'data' => array(
				'Mata Pelajaran &nbsp;' => array('mapel_nama', 'prefix' => ': '),
				
		),
);
$ds_row2 = array(
		'data' => array(
				'Hari / Tanggal &nbsp;&nbsp;' => array('evaluasi_mulai', 'tgl', 'prefix' => ': '),
		),
);
$ds_row3 = array(
		'data' => array(
				'Kelas &nbsp; ' => array('kelas_nama','prefix' => ': '),
				'Waktu &nbsp; ' => array('evaluasi_mulai - evaluasi_ditutup','waktu' ,  'prefix' => ': '),
				' - '	=> array('evaluasi_ditutup','waktu'),
		),
);


?>
<style>
	@page
	{
		sheet-size: 290mm 210mm;
		margin: 3mm 10mm 0mm 10mm;
		margin-header: 10mm;
		margin-footer: 15mm;
		footer: html_footer_pagenum;
	}
	.page-notend{
		page-break-after: always;
	}
	.controls{
		font-size: 1.2em;
		margin: 0.2em 0;
		color: black;
	}
	.t-border2{
		border-style: solid;
		border-color: black;
		border-collapse: collapse;
		border-bottom: 3px;

	}
	.content, .content *, td
	{
		font-size: 12px;
	}
	.info
	{
		font-size: 13px;
		vertical-align:top; 
	}
	#head-1{
		text-align: left;
		font-size: 18px;
		font-weight: bold;
	}
	 #head-2{
		text-align: left;
		font-size: 16px;
		font-weight: bold;
	}
	 #head-3{
		text-align: left;
		font-size: 14px;
	}
</style>
		

		
		

		 <htmlpagefooter name="footer_pagenum">
			<div id="footer_pagenum" class="footer">
			<?php footer_sekolah($evaluasi);	?>
			</div>
		</htmlpagefooter>
    
		<?php
		
			
		$count=0;
		foreach ($resultset['data'] as $idx => $butir):
			$count++;
			
			//if($count > 20){
				
				soal_prepljs_print($butir);
				echo '<div class="container page-notend">';
				//echo '<div id="tabel">';
				
				echo '<table border="1"  cellspacing="0" cellpadding="0" width="100%">';
				echo '<tr>';
				echo '<td colspan="3">';
				///////////////////////////////////////////////////////////
					// HEADER
					?>
					<table width='100%'>
						<tr>
							<td colspan="3" align="center">
								<b>KARTU SOAL <?=strtoupper($evaluasi['nama'])?><br>
								Tahun Pelajaran <?=strtoupper($evaluasi['ta_nama'])?><br>

								Provinsi/Kota/Kabupaten : Jawa Tengah / Kota Semarang
								</b>
							</td>
						</tr>
						<tr>
							<td>
								<b>
								Program Studi	:	SMA<br>
								Mata Pelajaran	:	<?=strtoupper($evaluasi['mapel_nama'])?><br>
								Kelas			:	<?=strtoupper($evaluasi['kelas_grade'])?><br> IPA/IPS
								Kurikulum		:	2013
								</b>
							</td>
							<td>
								<b>
								Nama Penulis Soal :<br>
								1. <?=strtoupper($evaluasi['guru_nama'])?><br>
								2. ...............
								</b>
							</td>
							<td>
								<b>
								Satuan Kerja :<br>
								<?=APP_SCHOOL?><br>
								</b>
							</td>
						</tr>
					</table>
					<?php
				///////////////////////////////////////////////////////////
				echo '</td>';
				echo '</tr>';
				
				/// LINE 2
				echo '<tr>';
					echo '<td align="left" valign="top" rowspan="2">';
					?>
						<b>Kompetensi Yang Diujikan</b><br>
					<?php
						echo trim($butir['ket_type_kd']);
					echo '</td>';
					echo '<td align="left">';
					?>
						<b>Buku Acuan / Referensi:</b>
					<?php
						
					echo '</td>';
					echo '<td align="left">';
					?>
						<b>Level Kognitif</b>
					<?php
						echo trim($butir['level_kognitif']);
					echo '</td>';
				echo '</tr>';
				
				/// LINE 3
				echo '<tr>';
				echo '<td colspan="2">';
				///////////////////////////////////////////////////////////
					// ISI 1
					?>
					<?php
					echo '<br/><table border="0">';
						
					echo '<tr>';
					echo '<td valign="top" align="right">' . ($idx + 1) . '. &nbsp; </td>';
					echo '<td colspan="2" valign="top">';

					// tampilkan pertanyaan
					//print_r($butir);
					$butir['pertanyaan'] = trim($butir['pertanyaan']);
					$butir['pertanyaan'] = str_replace('../../','/',$butir['pertanyaan']);
					
					$butir['pertanyaan'] = str_replace("/content",APP_ROOT."content",$butir['pertanyaan']);
					$butir['pertanyaan'] = str_replace("?img=kbm","",$butir['pertanyaan']);
					$butir['pertanyaan'] =str_replace('/>','style="max-height:200px;" />',$butir['pertanyaan']);
					
					if(strlen($butir['pertanyaan'])<5000){
						echo $butir['pertanyaan'] ;
					}
					echo '</td></tr>';
						$pilihan_tambahan=0;
						
						unset($opsi);
						foreach ($butir['opsi'] as $idx2 => $ket):
						
							if($ket==''){
								$opsi[$idx2] ='';
								$pilihan_tambahan++;
							}else{
								//echo ul($butir['opsi']);
								$opsi[$idx2]= trim($ket);
								$opsi[$idx2] =str_replace('../../','/',$opsi[$idx2]);
								
								$opsi[$idx2] =str_replace("/content",APP_ROOT."content",$opsi[$idx2]);
								$opsi[$idx2] =str_replace("?img=kbm","",$opsi[$idx2]);
								$opsi[$idx2] =str_replace('/>','style="min-height:20px;" />',$opsi[$idx2]);
								
								

								$cek[$idx2]= str_replace("<p>","",$opsi[$idx2]);
								$cek[$idx2]= str_replace("</p>","",$cek[$idx2]);
								$cek[$idx2]= str_replace("<br>","",$cek[$idx2]);
								$cek[$idx2]= str_replace("<br/>","",$cek[$idx2]);
								$cek[$idx2]= trim($cek[$idx2]);
								
								
								if( $cek[$idx2]=='A' || $cek[$idx2]=='a' ||
								$cek[$idx2]=='B' || $cek[$idx2]=='b' ||
								$cek[$idx2]=='C' || $cek[$idx2]=='c' ||
								$cek[$idx2]=='D' || $cek[$idx2]=='d' ||
								$cek[$idx2]=='E' || $cek[$idx2]=='e' )
								{	$pilihan_tambahan++;}
							}
							
							//if($evaluasi['mapel_id']==1)
								//$opsi[$idx2] = str_replace("<img","<img width='50%'",$opsi[$idx2]);
					
						endforeach;
						
						//echo"<table width='100%'>";
						
						if($pilihan_tambahan<4)
						{
							
							
							// A
							if($opsi['a']!=''){
								echo "<tr><td></td><td valign='top' width='10px'> A. </td><td>".$opsi['a']."</td></tr>";
							}
							
							// B
							if($opsi['a']==''){
								// kunci
								if(strtoupper($butir['pilihan']['kunci']['index']) == 'B')
								{
									$butir['pilihan']['kunci']['index'] = 'a';
								}
								echo "<tr><td></td><td valign='top'> A. </td><td>".$opsi['b'].'</td></tr>';
							}elseif($opsi['b']!=''){
								echo "<tr><td></td><td valign='top'> B. </td><td>".$opsi['b'].'</td></tr>';
							}
							
							//C
							if(($opsi['a']=='')||($opsi['b']=='')){
								// kunci
								if(strtoupper($butir['pilihan']['kunci']['index']) == 'C')
								{
									$butir['pilihan']['kunci']['index'] = 'b';
								}
								echo "<tr><td></td><td valign='top'> B. </td><td>".$opsi['c'].'</td></tr>';
							}elseif($opsi['c']!=''){
								echo "<tr><td></td><td valign='top'> C. </td><td>".$opsi['c'].'</td></tr>';
							}
							
							//D
							if(($opsi['a']=='')||($opsi['b']=='')||($opsi['c']=='')){
								// kunci
								if(strtoupper($butir['pilihan']['kunci']['index']) == 'D')
								{
									$butir['pilihan']['kunci']['index'] = 'c';
								}
								echo "<tr><td></td><td valign='top'> C. </td><td>".$opsi['d'].'</td></tr>';
							}elseif($opsi['d']!=''){
								echo "<tr><td></td><td valign='top'> D. </td><td>".$opsi['d'].'</td></tr>';
							}
							
							// E
							if(($opsi['a']=='')||($opsi['b']=='')||($opsi['c']=='')||($opsi['d']=='')){
								// kunci
								if(strtoupper($butir['pilihan']['kunci']['index']) == 'E')
								{
									$butir['pilihan']['kunci']['index'] = 'd';
								}
								echo "<tr><td></td><td valign='top'> D. </td><td>".$opsi['e'].'</td></tr>';
							}elseif($opsi['e']!=''){
								echo "<tr><td></td><td valign='top'> E. </td><td>".$opsi['e'].'</td></tr>';
							}
						}
						//echo"</table>";
						
						if($request['kunci']=="1")
						{
							echo "<tr><td></td><td colspan='2'><b>KUNCI : ".strtoupper($butir['pilihan']['kunci']['index'])."</b></td></tr><br>";
						}

					echo '<br/></td>';
					echo '</tr>';
					echo '</table>';
					
			//}	////////////////////////////////////////////////////
				echo '<br/></td>';
				echo '</tr>';
				echo '</table>';
				echo'</div>';
		endforeach;

		
		
		?>

	
