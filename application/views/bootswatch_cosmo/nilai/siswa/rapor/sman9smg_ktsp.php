<?php

function int2kata($n) {
	if (is_null($n) or !is_numeric($n))
		return '';

	if ($n == 0)
		return 'Nol';
	if ($n == 1)
		return 'Satu';
	if ($n ==2)
		return 'Dua';
	if ($n ==3)
		return 'Tiga';
	if ($n ==4)
		return 'Empat';
	if ($n ==5)
		return 'Lima';
	if ($n ==6)
		return 'Enam';
	if ($n ==7)
		return 'Tujuh';
	if ($n ==8)
		return 'Delapan';
	if ($n ==9)
		return 'Sembilan';
		
	return '';
}


function tgl_indo($tgl){
			$tanggal = substr($tgl,0,2);
			$bulan = getBulan(substr($tgl,3,2));
			$tahun = substr($tgl,6,4);
			return $tanggal.' '.$bulan.' '.$tahun;		 
	}	
function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 


function int2huruf($n) {
	if (is_null($n) OR !is_numeric($n))
		return '';

	if ($n >= 86)
		return 'A';

	if ($n >= 71)
		return 'B';

	if ($n >= 56)
		return 'C';

	if ($n >= 41)
		return 'D';

	return 'E';
}
?>
<style type="text/css">
<!--
.style3 {font-size: 11px}
-->
#halaman {
height:1500px;
}
.style4 {font-size: 11px}

.kecil td{
font-size: 12px;
padding:5px 5px 5px 5px;

}
.style6 {font-size: 16px; }
</style>

<div id="halaman"> 
<b>LAPORAN PENILAIAN HASIL BELAJAR PESERTA DIDIK SMA</b><br/>
<table width="100%" border="0" style="width: 100%;">
				<tr>
					<td width="26%" valign="top">
						<b>Nama Peserta Didik</b>					</td>
					<td width="1%" valign="top">:</td>
					<td colspan="4" valign="top">
					  <em><b><?php echo $resultset['data'][0]['siswa_nama']; ?></b>					    </em></td>
			    </tr>
				<tr>
					<td valign="top">
						<b>Nomor Induk</b>					</td>
					<td valign="top">:</td>
					<td width="32%" valign="top">
						<b><?php echo $resultset['data'][0]['siswa_nis']; ?></b>					</td>
				    <!--<td width="21%" valign="top"><b>Kelas/Semester</b></td>
				    <td width="1%" valign="top">:</td>
				    <td width="19%" valign="top"><span style="text-transform:uppercase;"><b><?php echo $resultset['data'][0]['kelas_nama']; ?>/<?php echo $resultset['data'][0]['semester']; ?></b></span></td>-->
				</tr>
				<tr>
					<!--<td valign="top">
						<b>Nama Sekolah</b>					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b>SMA Negeri 8 Semarang</b>					</td>
				    <td valign="top"><b>Tahun Pelajaran</b></td>
				    <td valign="top">:</td>
				    <td valign="top"><b><?php echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1); ?></b></td>-->
				</tr>
	  </table>
<br/>

<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    <th width="5%" rowspan="6"></th>
    <th width="34%" >Tahun Pelajaran</th>
    <th colspan="12"><?php echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1); ?></th>
  <tr/>
  <tr>
    <th >Kelas</th>
    <th colspan="12"><?php echo $resultset['data'][0]['kelas_nama']; ?></th>
  <tr/>
  <tr>
    <th >Semester</th>
    <th colspan="5" align="center"> 1(satu) </th>
    <th width="13%" rowspan="4">Kriteria Ketuntas -an Minimal (KKM)</th>
    <th colspan="5" align="center"> 2(dua) </th>
    <th width="13%" rowspan="4">Kriteria Ketuntas -an Minimal (KKM)</th>
  <tr/>
  <tr> 
    <th rowspan="3">Komponen</th>
    
    <th colspan="5">Nilai Hasil Belajar</th>
    <th colspan="5">Nilai Hasil Belajar</th>
  </tr>
  <tr>
    <th colspan="2">Pengetahuan</th>
    <th colspan="2">Praktek</th>
    <th width="11%">Sikap</th>
    
    <th colspan="2">Pengetahuan</th>
    <th colspan="2">Praktek</th>
    <th width="11%">Sikap</th>
  </tr>
  <tr>
    <th width="7%">Angka</th>
    <th width="12%">Huruf</th>
    <th width="6%">Angka</th>
    <th width="11%">Huruf</th>
    <th>Predikat</th>
    
    <th width="7%">Angka</th>
    <th width="12%">Huruf</th>
    <th width="6%">Angka</th>
    <th width="11%">Huruf</th>
    <th>Predikat</th>
  </tr>	<tr>
		  <td align="center" valign="middle"><div align="center" class="style6"><strong>A</strong></div></td>
		  <td valign="middle"><div align="center" class="style6"><strong>Mata Pelajaran </strong></div></td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
  </tr>
  <?php foreach ($resultset2['data'] as $idx => $masuk2): 	
			$item2[$masuk2['mapel_nama']]['kkm']		= $masuk2['kkm'];
			$item2[$masuk2['mapel_nama']]['nas_ppk']	= $masuk2['nas_ppk'];
			$item2[$masuk2['mapel_nama']]['nas_prk']	= $masuk2['nas_prk'];
			$item2[$masuk2['mapel_nama']]['nas_skp']	= $masuk2['nas_skp'];
			
			$item2[$masuk2['mapel_nama']]['ketuntasan']	= $masuk2['ketuntasan'];
			$item2[$masuk2['mapel_nama']]['kompetensi']	= $masuk2['kompetensi'];
			
		endforeach;
		
		foreach ($nilaimulok['data'] as $idx => $masuk2):
			$item2[$masuk2['mapel_nama']]['kkm']		= $masuk2['kkm'];
			$item2[$masuk2['mapel_nama']]['nas_ppk']	= $masuk2['nas_ppk'];
			$item2[$masuk2['mapel_nama']]['nas_prk']	= $masuk2['nas_prk'];
			$item2[$masuk2['mapel_nama']]['nas_skp']	= $masuk2['nas_skp'];
			
			$item2[$masuk2['mapel_nama']]['ketuntasan']	= $masuk2['ketuntasan'];
			$item2[$masuk2['mapel_nama']]['kompetensi']	= $masuk2['kompetensi'];
			
		endforeach; 
    
	    foreach ($presensi2['data'] as $idx => $masuk2):
			$item2[$masuk2['mapel_nama']]['aspri_kedisiplinan']		= $masuk2['aspri_kedisiplinan'];
			$item2[$masuk2['mapel_nama']]['aspri_kebersihan']		= $masuk2['aspri_kebersihan'];
			$item2[$masuk2['mapel_nama']]['aspri_kesehatan']		= $masuk2['aspri_kesehatan'];
			$item2[$masuk2['mapel_nama']]['aspri_tanggungjawab']	= $masuk2['aspri_tanggungjawab'];
			$item2[$masuk2['mapel_nama']]['aspri_sopansantun']		= $masuk2['aspri_sopansantun'];
			$item2[$masuk2['mapel_nama']]['aspri_percayadiri']		= $masuk2['aspri_percayadiri'];
			$item2[$masuk2['mapel_nama']]['aspri_kompetitif']		= $masuk2['aspri_kompetitif'];
			$item2[$masuk2['mapel_nama']]['aspri_hubungansosial']	= $masuk2['aspri_hubungansosial'];
			$item2[$masuk2['mapel_nama']]['aspri_kejujuran']		= $masuk2['aspri_kejujuran'];
			$item2[$masuk2['mapel_nama']]['aspri_ibadah']			= $masuk2['aspri_ibadah'];
			
			$item2[$masuk2['extra1_nama']]['extra1_kompetensi']		= $masuk2['extra1_kompetensi'];
			$item2[$masuk2['extra2_nama']]['extra2_kompetensi']		= $masuk2['extra2_kompetensi'];
			$item2[$masuk2['extra3_nama']]['extra3_kompetensi']		= $masuk2['extra3_kompetensi'];
			
			$item2[$masuk2['org1_nama']]['org1_kompetensi']		= $masuk2['org1_kompetensi'];
			$item2[$masuk2['org2_nama']]['org2_kompetensi']		= $masuk2['org2_kompetensi'];
			$item2[$masuk2['org3_nama']]['org3_kompetensi']		= $masuk2['org3_kompetensi'];
			
			$item3['absen_s']	= $masuk2['absen_s'];
			$item3['absen_i']	= $masuk2['absen_i'];
			$item3['absen_a']	= $masuk2['absen_a'];
			
			$item3['catatan']				= $masuk2['catatan'];
			$item3['kenaikan_keterangan']	= $masuk2['kenaikan_keterangan'];
			$item3['kenaikan_program']		= $masuk2['kenaikan_program'];
			
	  	endforeach;
	?>
	<?php foreach ($resultset['data'] as $idx => $item): ?>
	
	<?php
	if ($item['mapel_nama'] != 'Seni Budaya') {
	
	?>
		<tr>
			<td align="center" valign="middle"><div align="center" class="style6"><?php echo $idx + 1; ?></div></td>
			<td valign="middle"><div align="center" class="style6"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item['nas_ppk']) ? round($item['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_ppk']),0,1))." ".int2kata(substr(round($item['nas_ppk']),1,1));
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center">
			
			<?php 
			if ($item['nas_prk']==0 or is_null($item['nas_prk']) or !is_numeric($item['nas_prk']) ) {
			echo "-";
			} else {
			echo ($item['nas_prk']) ? round($item['nas_prk']) : '-'; 
			}
			
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item['nas_prk']==0 or is_null($item['nas_prk']) or !is_numeric($item['nas_prk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_prk']),0,1))." ".int2kata(substr(round($item['nas_prk']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php echo int2huruf($item['nas_skp']); ?></div></td>
		    <td valign="middle" align="center"><div align="center" class="style6"><?php echo round($item['kkm']); ?>&nbsp; </div></td>
			
        
        <!-- SEMESTER 2 -->
		
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item2[$item['mapel_nama']]['nas_ppk']) ? round($item2[$item['mapel_nama']]['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),0,1))." ".int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),1,1));
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center" class="style6">
			
			<?php 
			if ($item2[$item['mapel_nama']]['nas_prk']==0 or is_null($item2[$item['mapel_nama']]['nas_prk']) or !is_numeric($item2[$item['mapel_nama']]['nas_prk']) ) {
			echo "-";
			} else {
			echo ($item2[$item['mapel_nama']]['nas_prk']) ? round($item2[$item['mapel_nama']]['nas_prk']) : '-'; 
			}
			
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item2[$item['mapel_nama']]['nas_prk']==0 or is_null($item2[$item['mapel_nama']]['nas_prk']) or !is_numeric($item2[$item['mapel_nama']]['nas_prk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item2[$item['mapel_nama']]['nas_prk']),0,1))." ".int2kata(substr(round($item2[$item['mapel_nama']]['nas_prk']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php echo int2huruf($item2[$item['mapel_nama']]['nas_skp']); ?></div></td>
            <td valign="middle" align="center"><div align="center" class="style6"><?php echo round($item2[$item['mapel_nama']]['kkm']); ?>&nbsp; </div></td>
			
		</tr>
        
<?php
 } else {
?>
 <tr>
			<td align="center" valign="middle"><div align="center" class="style6"><?php echo $idx + 1; ?></div></td>
			<td valign="middle"><div align="center" class="style6"><?php echo $item['mapel_nama']; ?></td>
			<td valign="middle" align="center"><div align="center"> - </div></td>
			<td valign="middle" align="center"><div align="center" class="style3"> - </div>
			</td>
			<td valign="middle" align="center"><div align="center" class="style6">
			
			<?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item['nas_ppk']) ? round($item['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_ppk']),0,1))." ".int2kata(substr(round($item['nas_ppk']),1,1));
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php echo int2huruf($item['nas_skp']); ?></div></td>
            <td valign="middle" align="center"><div align="center" class="style6"><?php echo round($item['kkm']); ?>&nbsp; </div></td>
			
            
            <!--SEMESTER 2-->
            <td valign="middle" align="center"><div align="center"> - </div></td>
			<td valign="middle" align="center"><div align="center" class="style3"> - </div>
			</td>
			<td valign="middle" align="center"><div align="center" class="style6">
			
			<?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item2[$item['mapel_nama']]['nas_ppk']) ? round($item2[$item['mapel_nama']]['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),0,1))." ".int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),1,1));
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center"><?php echo int2huruf($item2[$item['mapel_nama']]['nas_skp']); ?></div></td>
			<td valign="middle" align="center"><div align="center"><?php echo round($item2[$item['mapel_nama']]['kkm']); ?>&nbsp; </div></td>
			
        </tr>
 
<?php 
 }
?>		
		
	<?php endforeach; ?>
    
	<tr>
		  <td align="center" valign="middle"><div align="center" class="style6"><strong>B</strong></div></td>
		  <td valign="middle"><div align="center" class="style6"><strong>Muatan Lokal </strong></div></td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
          <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
		  <td valign="middle" align="center">&nbsp;</td>
  </tr>
    <?php foreach ($nilaimulok['data'] as $idx => $item): ?>
	
	<tr>
			<td align="center" valign="middle"><?php echo $idx + 1; ?></td>
			<td valign="middle"><div align="center" class="style6"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item['nas_ppk']) ? round($item['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3"><span class="style4">
			  <?php 
			if (is_null($item['nas_ppk']) or !is_numeric($item['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_ppk']),0,1))." ".int2kata(substr(round($item['nas_ppk']),1,1)) ;
			}
			 ?>
			</span></div></td>
			<td valign="middle" align="center"><div align="center" class="style6">
			
			<?php 
			if ($item['nas_prk']==0 or is_null($item['nas_prk']) or !is_numeric($item['nas_prk']) ) {
			echo "-";
			} else {
			echo ($item['nas_prk']) ? round($item['nas_prk']) : '-'; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item['nas_prk']==0 or is_null($item['nas_prk']) or !is_numeric($item['nas_prk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_prk']),0,1))." ".int2kata(substr(round($item['nas_prk']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php echo int2huruf($item['nas_skp']); ?></div></td>
            <td valign="middle" align="center"><div align="center" class="style6"><?php echo round($item['kkm']); ?>&nbsp; </div></td>
			
            
            <!--SEMESTER 2-->
            <td valign="middle" align="center"><div align="center" class="style6"><?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo ($item2[$item['mapel_nama']]['nas_ppk']) ? round($item2[$item['mapel_nama']]['nas_ppk']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3"><span class="style4">
			  <?php 
			if (is_null($item2[$item['mapel_nama']]['nas_ppk']) or !is_numeric($item2[$item['mapel_nama']]['nas_ppk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),0,1))." ".int2kata(substr(round($item2[$item['mapel_nama']]['nas_ppk']),1,1)) ;
			}
			 ?>
			</span></div></td>
			<td valign="middle" align="center"><div align="center" class="style6">
			
			<?php 
			if ($item2[$item['mapel_nama']]['nas_prk']==0 or is_null($item2[$item['mapel_nama']]['nas_prk']) or !is_numeric($item2[$item['mapel_nama']]['nas_prk']) ) {
			echo "-";
			} else {
			echo ($item2[$item['mapel_nama']]['nas_prk']) ? round($item2[$item['mapel_nama']]['nas_prk']) : '-'; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item2[$item['mapel_nama']]['nas_prk']==0 or is_null($item2[$item['mapel_nama']]['nas_prk']) or !is_numeric($item2[$item['mapel_nama']]['nas_prk']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item['nas_prk']),0,1))." ".int2kata(substr(round($item2[$item['mapel_nama']]['nas_prk']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php echo int2huruf($item2[$item['mapel_nama']]['nas_skp']); ?></div></td>
  			<td valign="middle" align="center"><div align="center" class="style6"><?php echo round($item2[$item['mapel_nama']]['kkm']); ?>&nbsp; </div></td>
			
  </tr>
	
	<?php endforeach; ?>
    <?php foreach ($presensi['data'] as $idx => $item): ?>
  <tr>
		  <td align="center" valign="middle"><span class="style6"><strong>A</strong></span></td>
		  <td valign="middle"><span class="style6"><strong>Pengembangan Diri / Kegiatan Extrakurikuler </strong></span></td>
		  <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
          <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
		  </tr>
	
		<tr>
		  <td align="center" valign="middle">1</td>
		  <td valign="middle"><span class="style6"><?php echo ($item['extra1_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['extra1_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['extra1_nama']]['extra1_kompetensi']); ?></span></td>
          
    </tr>
		<tr>
		  <td align="center" valign="middle"><span class="style6">2</span></td>
		  <td valign="middle"><span class="style6"><?php echo ($item['extra2_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['extra2_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['extra2_nama']]['extra2_kompetensi']); ?></span></td>
    </tr>
		<tr>
		  <td align="center" valign="middle"><span class="style6">3</span></td>
		  <td valign="middle"><span class="style6"><?php echo ($item['extra3_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['extra3_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['extra3_nama']]['extra3_kompetensi']); ?></span></td>
    </tr>
		
	<tr>
		  <td align="center" valign="middle"><span class="style6"><strong>B</strong></span></td>
		  <td valign="middle"><span class="style6"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
		  <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
          <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
  </tr>
  
	<tr>
	  <td align="center" valign="middle">1</td>
	 <td valign="middle"><span class="style6"><?php echo ($item['org1_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['org1_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['org1_nama']]['org1_kompetensi']); ?></span></td>
    </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style6">2</span></td>
	 <td valign="middle"><span class="style6"><?php echo ($item['org2_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['org2_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['org2_nama']]['org2_kompetensi']); ?></span></td>
   </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style6">3</span></td>
	  <td valign="middle"><span class="style6"><?php echo ($item['org3_nama']); ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['org3_kompetensi']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['org3_nama']]['org3_kompetensi']); ?></span></td>
  </tr>

	<tr>
		  <td align="center" valign="middle"><span class="style6"><strong></strong></span></td>
		  <td valign="middle"><span class="style6"><strong>Bimbingan dan Konseling </strong></span></td>
		  <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
          <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
  </tr>
  
	<tr>
	  <td align="center" valign="middle">1</td>
	 <td valign="middle"><span class="style6"> </span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
    </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style6">2</span></td>
	 <td valign="middle"><span class="style6"> </span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
   </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style6">3</span></td>
	  <td valign="middle"><span class="style6"> </span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"> </span></td>
  </tr>
	
  <tr>
    <th ><span class="style6"></span></th>
    <th ><span class="style6">Ketidakhadiran </span></th>
    <th colspan="6" ><span class="style6">Keterangan</span></th>
    <th colspan="6" ><span class="style6">Keterangan</span></th>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style6">1</span></td>
    <td valign="middle"><span class="style6">Sakit</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['absen_s']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item3['absen_s']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style6">2</span></td>
    <td valign="middle"><span class="style6">Izin</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['absen_i']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item3['absen_i']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style6">3</span></td>
    <td valign="middle"><span class="style6">Tanpa Keterangan </span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['absen_a']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item3['absen_a']); ?> Hari</span></td>
  </tr>
  
  
  <?php endforeach; ?>
  <tr>
      <td align="center" valign="middle"><span class="style6"><strong></strong></span></td>
      <td valign="middle"				rowspan="2"><span class="style6"><strong>Status Akhir Tahun </strong></span></td>
      <td colspan="6" valign="middle"	rowspan="2"><span class="style6"><?php echo $item3['kenaikan_keterangan'];?></span></td>
      <td colspan="6" rowspan="2" valign="middle">
       <span class="style6">Nama Wali Kelas :
      <?php foreach ($resultset['data'] as $idx => $item): 
				//echo $item['wali_nama'];
			  endforeach; 
			  echo "<b>".$item['wali_nama']."</b>";
			 // echo "<br/> NIP : ".$item['wali_nip'];
		?>
      <br/>Tanda Tangan &nbsp;&nbsp;&nbsp;&nbsp;:</span></td>
  </tr>
  <tr>
      <td align="center" valign="middle"><span class="style6"><strong></strong></span></td>
      <td valign="middle"><span class="style6"><strong> </strong></span></td>
      <!--<td colspan="6" valign="middle"><span class="style6">Tinggal Ke Kelas</span></td>-->
  </tr>
</table>
<!--
<br/>

<p align="right" class="style6">
  Semarang, 21 Desember 2013</p>
<br/>

<table border="0" style="width: 100%;">
  <tr>
    <td width="31%" align="center" valign="top">
			<p class="style6">
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
				.....................			</p>    </td>
    <td width="31%" align="center" valign="top">
			<p class="style6">
				Wali Kelas<br/>
				<br/>
				<br/><br/><br/> 
					<?php foreach ($resultset['data'] as $idx => $item): 
							//echo $item['wali_nama'];
						  endforeach; 
						  echo $item['wali_nama']."<br/> NIP : ";
						  echo $item['wali_nip'];
					?>
			</p>    </td>
    <td width="38%" align="center" valign="top">
			<p class="style6">
				Kepala Sekolah<br/>
				<br/>
				<br/><br/><br/>
				Drs. Haryoto, M.Ed<br />
NIP : 196001291986031010			</p>    </td>
  </tr>
</table>
-->
</div>

<!-- ===================================================================================== -->

<div id="halaman"> 

<b> KETERCAPAIAN KOMPETENSI DIDIK</b><br/>
<table border="0" style="width: 100%;">
  <tr>
    <td valign="top" width="400px">
			<table border="0" style="width: 100%;">
				<tr>
					<td valign="top">
						<b>Nama Peserta Didik</b>					</td>
					<td valign="top">:</td>
					<td valign="top">
					  <em><b><?php echo $resultset['data'][0]['siswa_nama']; ?></b>					    </em></td>
				</tr>
				<tr>
					<td valign="top">
						<b>Nomor Induk</b>					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo $resultset['data'][0]['siswa_nis']; ?></b>					</td>
				</tr>
				<!--<tr>
					<td valign="top">
						<b>Nama Sekolah</b>					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b>SMA Negeri 8 Semarang</b>					</td>
				</tr>-->
			</table>
    </td>
    <td align="left" valign="bottom">
	<!--
    		<table border="0">
				<tr>
					<td valign="top">
						<b>Kelas/Semester</b>
					</td>
					<td valign="top">:</td>
					<td valign="top"><div style="text-transform:uppercase;">
						<b><?php echo $resultset['data'][0]['kelas_nama']; ?>/<?php echo $resultset['data'][0]['semester']; ?></b></div>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<b>Tahun Pelajaran</b>
					</td>
					<td valign="top">:</td>
					<td valign="top">
						<b><?php echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1); ?></b>
					</td>
				</tr>
			</table>
       -->
    </td>
  </tr>
</table>

<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    
    <th colspan="2" width="30%">Kelas</th>
    <th colspan="2"><?php echo $resultset['data'][0]['kelas_nama']; ?></th>
  </tr>
  <tr>
    
    <td align="center" colspan="2" valign="middle" width="26%"><strong>Semester</strong></td>
    <td align="center" valign="middle" width="37%"><strong>1 (SATU)</strong></td>
    <td align="center" valign="middle" width="37%"><strong>2 (DUA)</strong></td>
  </tr>	<tr>
		  <td align="center" valign="middle"><strong>A</strong></td>
		  <td valign="middle"><strong>Mata Pelajaran </strong></td>
		  <td valign="middle" align="center" colspan="2">&nbsp;</td>
		  </tr>
	<?php foreach ($resultset['data'] as $idx => $item): ?>
	
		<tr>
			<td align="center" valign="middle"><?php echo $idx + 1; ?></td>
			<td valign="middle"><?php echo $item['mapel_nama']; ?></td>
		  <td valign="middle" align="left"><div align="center" class="style3">
		    <div align="left"><?php 
			if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
		echo $item['kompetensi']." ".$item['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
		  </div></td>
          
          <td valign="middle" align="left"><div align="center" class="style3">
		    <div align="left"><?php 
			if ($item2[$item['mapel_nama']]['ketuntasan'] != '' and $item2[$item['mapel_nama']]['kompetensi']!='') {
		echo $item2[$item['mapel_nama']]['kompetensi']." ".$item2[$item['mapel_nama']]['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
		  </div></td>
		</tr>
	<?php endforeach; ?>
	<tr>
		  <td align="center" valign="middle"><strong>B</strong></td>
		  <td valign="middle"><strong>Muatan Lokal </strong></td>
		  <td valign="middle" align="left"><div align="left"></div></td>
          <td valign="middle" align="left"><div align="left"></div></td>
  </tr>
    <?php foreach ($nilaimulok['data'] as $idx => $item): ?>
	<tr>
			<td align="center" valign="middle"><?php echo $idx + 1; ?></td>
			<td valign="middle"><?php echo $item['mapel_nama']; ?></td>
	  <td valign="middle" align="left"><div align="center" class="style3">
	    <div align="left"><?php 
		if ($item['ketuntasan'] != '' and $item['kompetensi']!='') {
		echo $item['kompetensi']." ".$item['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
	  </div></td>
      
      <td valign="middle" align="left"><div align="center" class="style3">
	    <div align="left"><?php 
		if ($item2[$item['mapel_nama']]['ketuntasan'] != '' and $item2[$item['mapel_nama']]['kompetensi']!='') {
		echo $item2[$item['mapel_nama']]['kompetensi']." ".$item2[$item['mapel_nama']]['ketuntasan'];
		} else { }
		 ?>&nbsp; </div>
	  </div></td>
  </tr>
	
	<?php endforeach; ?>
</table>

</div>

<!-- ====================================================================================== -->

<div id="halaman">
<b>AKHLAK MULIA DAN KEPRIBADIAN</b><br /> 
  <table width="100%" border="0" style="width: 100%;">
    <tr>
      <td width="26%" valign="top"><b>Nama Peserta Didik</b> </td>
      <td width="1%" valign="top">:</td>
      <td colspan="4" valign="top"><em><b><?php echo $resultset['data'][0]['siswa_nama']; ?></b> </em></td>
    </tr>
    <tr>
      <td valign="top"><b>Nomor Induk</b> </td>
      <td valign="top">:</td>
      <td width="32%" valign="top"><b><?php echo $resultset['data'][0]['siswa_nis']; ?></b> </td>
     <!-- <td width="21%" valign="top"><b>Kelas/Semester</b></td>
      <td width="1%" valign="top">:</td>
      <td width="19%" valign="top"><span style="text-transform:uppercase;"><b><?php echo $resultset['data'][0]['kelas_nama']; ?>/<?php echo $resultset['data'][0]['semester']; ?></b></span></td>-->
    </tr>
    <!--<tr>
      <td valign="top"><b>Nama Sekolah</b> </td>
      <td valign="top">:</td>
      <td valign="top"><b>SMA Negeri 8 Semarang</b> </td>
      <td valign="top"><b>Tahun Pelajaran</b></td>
      <td valign="top">:</td>
      <td valign="top"><b><?php echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1); ?></b></td>
    </tr>-->
  </table>
  <!--
  <br /> 
Pengembangan Diri
<br/>-->

<?php foreach ($presensi['data'] as $idx => $item): ?>
<!--
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    <th width="3%"><span class="style4">No</span></th>
    <th colspan="2"><span class="style4">Jenis Kegiatan </span></th>
    <th width="35%"><span class="style4">Keterangan</span></th>
    <th width="35%"><span class="style4">Keterangan</span></th>
  </tr>	<tr>
		  <td align="center" valign="middle"><span class="style4"><strong>A</strong></span></td>
		  <td colspan="2" valign="middle"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
		  <td valign="middle" align="center"><span class="style4"></span></td>
          <td valign="middle" align="center"><span class="style4"></span></td>
		  </tr>
	
		<tr>
		  <td align="center" valign="middle"><span class="style4"></span></td>
		  <td align="center" valign="middle">1</td>
		  <td valign="middle"><span class="style4"><?php echo ($item['extra1_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra1_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['extra1_nama']]['extra1_kompetensi']); ?></span></td>
          
    </tr>
		<tr>
		  <td align="center" valign="middle"><span class="style4"></span></td>
		  <td align="center" valign="middle"><span class="style4">2</span></td>
		  <td valign="middle"><span class="style4"><?php echo ($item['extra2_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra2_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['extra2_nama']]['extra2_kompetensi']); ?></span></td>
    </tr>
		<tr>
		  <td align="center" valign="middle"><span class="style4"></span></td>
		  <td align="center" valign="middle"><span class="style4">3</span></td>
		  <td valign="middle"><span class="style4"><?php echo ($item['extra3_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra3_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['extra3_nama']]['extra3_kompetensi']); ?></span></td>
    </tr>
		<tr>
			<td align="center" valign="middle"><span class="style4"></span></td>
			<td width="3%" align="center" valign="middle">&nbsp;</td>
		    <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
		  <td valign="middle" align="left">&nbsp;</td>
		</tr>
	<tr>
		  <td align="center" valign="middle"><span class="style4"><strong>B</strong></span></td>
		  <td colspan="2" valign="middle"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
		  <td valign="middle" align="left"><span class="style4"></span></td>
          <td valign="middle" align="left"><span class="style4"></span></td>
  </tr>
  
	<tr>
	  <td align="center" valign="middle"><span class="style4"></span></td>
	  <td align="center" valign="middle">1</td>
	 <td valign="middle"><span class="style4"><?php echo ($item['org1_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['org1_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['org1_nama']]['org1_kompetensi']); ?></span></td>
    </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style4"></span></td>
	  <td align="center" valign="middle"><span class="style4">2</span></td>
	 <td valign="middle"><span class="style4"><?php echo ($item['org2_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['org2_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['org2_nama']]['org2_kompetensi']); ?></span></td>
   </tr>
	<tr>
	  <td align="center" valign="middle"><span class="style4"></span></td>
	  <td align="center" valign="middle"><span class="style4">3</span></td>
	  <td valign="middle"><span class="style4"><?php echo ($item['org3_nama']); ?></span></td>
		  <td valign="middle" align="left"><span class="style4"><?php echo ($item['org3_kompetensi']); ?></span></td>
          <td valign="middle" align="left"><span class="style4"><?php echo ($item2[$item['org3_nama']]['org3_kompetensi']); ?></span></td>
  </tr>
	<tr>
			<td align="center" valign="middle"><span class="style4"></span></td>
			<td align="center" valign="middle">&nbsp;</td>
	        <td valign="middle"><span class="style4"></span></td>
            <td valign="middle"><span class="style4"></span></td>
      <td valign="middle" align="left"><span class="style4"></span></td>
  </tr>
</table>
<br />-->

<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr>
    <th width="2%" rowspan="2"><span class="style4">No</span></th>
    <th width="28%" rowspan="2"><span class="style4">Aspek Yang Dinilai  </span></th>
    <th width="35%"><span class="style4">Semester 1</span></th>
    <th width="35%"><span class="style4">Semester 2</span></th>
  </tr>
  <tr>
  	<td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
    <td align="center"><span class="style4"><strong>Keterangan</strong></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">1</span></td>
    <td valign="middle"><span class="style4">Kedisplinan</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_kedisiplinan']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_kedisiplinan']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">2</span></td>
    <td valign="middle"><span class="style4">Kebersihan</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_kebersihan']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_kebersihan']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">3</span></td>
    <td valign="middle"><span class="style4">Kesehatan</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_kesehatan']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_kesehatan']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">4</span></td>
    <td valign="middle"><span class="style4">Tanggungjawab</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_tanggungjawab']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_tanggungjawab']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">5</span></td>
    <td valign="middle"><span class="style4">Sopan Santun </span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_sopansantun']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_sopansantun']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">6</span></td>
    <td valign="middle"><span class="style4">Percaya Diri </span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_percayadiri']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_percayadiri']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">7</span></td>
    <td valign="middle"><span class="style4">Kompetitif</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_kompetitif']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_kompetitif']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">8</span></td>
    <td valign="middle"><span class="style4">Hubungan Sosial </span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_hubungansosial']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_hubungansosial']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">9</span></td>
    <td valign="middle"><span class="style4">Kejururan</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_kejujuran']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_kejujuran']); ?></span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">10</span></td>
    <td valign="middle"><span class="style4">Pelaksanaan Ibadah Ritual</span></td>
    <td valign="middle"><span class="style4"><?php echo ($item['aspri_ibadah']); ?></span></td>
    <td valign="middle"><span class="style4"><?php echo ($item2[$item['mapel_nama']]['aspri_ibadah']); ?></span></td>
  </tr>
</table>
<br/><br/>
<b>CATATAN WALI KELAS</b>
<br/>
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr><td height="140" align="left" valign="top">
  <?php 
  $catatan	= str_replace("\n","<br/>",($item['catatan']));
  $catatan2	= str_replace("\n","<br/>",($item3['catatan']));
  ?>
  	<table>
     <tr>
      <td align="left" valign="top"><b>Semester 1 :</b></td>
      <td align="left" valign="top"><?php echo $catatan;?></td>
     </tr>
     <tr>
      <td align="left" valign="top"><b>Semester 2 :</b></td>
      <td align="left" valign="top"><?php echo $catatan2;?></td>
     </tr>
    </table>
  </td></tr>
</table>  
<!--
<br />
Ketidakhadiran<br />
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr>
    <th width="3%"><span class="style4">No</span></th>
    <th width="27%"><span class="style4">Alasan Ketidakhadiran </span></th>
    <th width="35%"><span class="style4">Keterangan</span></th>
    <th width="35%"><span class="style4">Keterangan</span></th>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">1</span></td>
    <td valign="middle"><span class="style4">Sakit</span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_s']); ?> Hari</span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item3['absen_s']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">2</span></td>
    <td valign="middle"><span class="style4">Izin</span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_i']); ?> Hari</span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item3['absen_i']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4">3</span></td>
    <td valign="middle"><span class="style4">Tanpa Keterangan </span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_a']); ?> Hari</span></td>
    <td valign="middle" align="left"><span class="style4"><?php echo ($item3['absen_a']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style4"> </span></td>
    <td valign="middle"><span class="style4">&nbsp; </span></td>
    <td valign="middle" align="center"><span class="style4"></span></td>
    <td valign="middle" align="center"><span class="style4"></span></td>
  </tr>
</table>-->
<br/>
<?php endforeach; ?>
<!--
<p align="right" class="style6">
  Semarang, 21 Desember 2013</p>


<table border="0" style="width: 100%;">
  <tr>
    <td width="33%" align="center" valign="top">
			<p class="style6">
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
				.....................			</p>    </td>
    <td width="31%" align="center" valign="top">
			<p class="style6">
				Wali Kelas<br/>
				<br/>
				<br/><br/><br/>
				 <?php foreach ($resultset['data'] as $idx => $item): 
							//echo $item['wali_nama'];
						  endforeach; 
						  echo $item['wali_nama']."<br/> NIP : ";
						  echo $item['wali_nip'];
					?>
			</p>    </td>
    <td width="36%" align="center" valign="top">
			<p class="style6">
				Kepala Sekolah<br/>
				<br/>
				<br/><br/><br/>
				Drs. Haryoto, M.Ed<br />
NIP : 196001291986031010			</p>    </td>
  </tr>
</table>
-->
</div>