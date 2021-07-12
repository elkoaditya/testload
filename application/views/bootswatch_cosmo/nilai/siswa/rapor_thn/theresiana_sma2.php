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



function header_rapor($row)
{
?>
	<table width="100%" border="0" style="width: 100%;">
				<tr>
					<td width="26%" valign="top">
						<b>Nama Peserta Didik</b>					</td>
					<td width="1%" valign="top">:</td>
					<td colspan="4" valign="top">
					  <em><b><?php echo $row['siswa_nama']; ?></b>					    </em></td>
			    </tr>
				<tr>
					<td valign="top">
						<b>Nomor Induk</b>					</td>
					<td valign="top">:</td>
					<td width="32%" valign="top">
						<b><?php echo $row['siswa_nis']; ?></b>					</td>
				    
				</tr>
				
	  </table>
 <?php
}
?>
<style type="text/css">
 @page {
		sheet-size: 216mm 335mm ;
		margin: 45px 20px 20px 45px;
	}

	.page-notend{
		page-break-after: always;
	}<!--
.style3 {font-size: 14px}
-->
#halaman {
height:1500px;
}
.style4 {font-size: 12px}
.style5 {font-size: 10px}


.kecil td{
font-size: 12px;
padding:5px 5px 5px 5px;

}
.style6 {font-size: 16px; }
</style>

<div class="page page-notend" id="page-1">
<b>LAPORAN PENILAIAN HASIL BELAJAR PESERTA DIDIK SMA</b><br/>
<?php header_rapor($row);?>
<br/>

<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    <th width="5%" rowspan="6"></th>
    <th width="34%" >Tahun Pelajaran</th>
    <th colspan="12"><?php echo strtoupper($row['ta_nama']); ?></th>
  <tr/>
  <tr>
    <th >Kelas</th>
    <th colspan="12"><?php echo $row['kelas_nama']; ?></th>
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
  <?php 
  
  		foreach ($resultset1['data'] as $idx => $masuk1): 	
			$item_semester1[$masuk1['mapel_id']]['nipel_kkm']		= $masuk1['nipel_kkm'];
			$item_semester1[$masuk1['mapel_id']]['nas_teori']		= $masuk1['nas_teori'];
			$item_semester1[$masuk1['mapel_id']]['nas_praktek']		= $masuk1['nas_praktek'];
			$item_semester1[$masuk1['mapel_id']]['nas_sikap']		= $masuk1['nas_sikap'];
			
			$item_semester1[$masuk1['mapel_id']]['ketuntasan']	= $masuk1['ketuntasan'];
			$item_semester1[$masuk1['mapel_id']]['kompetensi']	= $masuk1['kompetensi'];
			
		endforeach;
		
		foreach ($resultset2['data'] as $idx => $masuk2): 	
			$item_semester2[$masuk2['mapel_id']]['nipel_kkm']		= $masuk2['nipel_kkm'];
			$item_semester2[$masuk2['mapel_id']]['nas_teori']		= $masuk2['nas_teori'];
			$item_semester2[$masuk2['mapel_id']]['nas_praktek']		= $masuk2['nas_praktek'];
			$item_semester2[$masuk2['mapel_id']]['nas_sikap']		= $masuk2['nas_sikap'];
			
			$item_semester2[$masuk2['mapel_id']]['ketuntasan']	= $masuk2['ketuntasan'];
			$item_semester2[$masuk2['mapel_id']]['kompetensi']	= $masuk2['kompetensi'];
			
			$ket_kenaikan_kelas = $$masuk2['ket_kenaikan_kelas'];
		endforeach;
		/*
		foreach ($nilaimulok['data'] as $idx => $masuk2):
			$item2[$masuk2['mapel_nama']]['kkm']		= $masuk2['kkm'];
			$item2[$masuk2['mapel_nama']]['nas_teori']	= $masuk2['nas_teori'];
			$item2[$masuk2['mapel_nama']]['nas_praktek']	= $masuk2['nas_praktek'];
			$item2[$masuk2['mapel_nama']]['nas_skp']	= $masuk2['nas_skp'];
			
			$item2[$masuk2['mapel_nama']]['ketuntasan']	= $masuk2['ketuntasan'];
			$item2[$masuk2['mapel_nama']]['kompetensi']	= $masuk2['kompetensi'];
			
		endforeach; 
    */
	    $masuk1 = $aspri1;
			
			$item_semester1['absen_s']	= $masuk1['absen_s'];
			$item_semester1['absen_i']	= $masuk1['absen_i'];
			$item_semester1['absen_a']	= $masuk1['absen_a'];
			
			$item_semester1['kepribadian']			= $masuk1['kepribadian'];
			$item_semester1['note_walikelas']		= $masuk1['note_walikelas'];
			$item_semester1['kenaikan_keterangan']	= $masuk1['kenaikan_keterangan'];
			$item_semester1['kenaikan_program']		= $masuk1['kenaikan_program'];
			
	  	 $masuk2 = $aspri2;
			
			$item_semester2['absen_s']	= $masuk2['absen_s'];
			$item_semester2['absen_i']	= $masuk2['absen_i'];
			$item_semester2['absen_a']	= $masuk2['absen_a'];
			
			$item_semester2['kepribadian']			= $masuk2['kepribadian'];
			$item_semester2['note_walikelas']		= $masuk2['note_walikelas'];
			$item_semester2['kenaikan_keterangan']	= $masuk2['kenaikan_keterangan'];
			$item_semester2['kenaikan_program']		= $masuk2['kenaikan_program'];
		
		
		foreach ($ekskul_result1['data'] as $ekskul1):
			$item_semester1[$ekskul1['ekskul_id']]['keterangan']		= $ekskul2['keterangan'];
		endforeach;
		
		foreach ($ekskul_result2['data'] as $ekskul2):
			$item_semester2[$ekskul2['ekskul_id']]['keterangan']		= $ekskul2['keterangan'];
		endforeach;
		
		foreach ($org_result1['data'] as $org2):
			$item2[$org2['org_nama']]['keterangan']		= $org2['keterangan'];
		endforeach;
		
	
		$mulok=0;
		foreach ($resultset['data'] as $idx => $item): 
		if(($item['kategori_kode']=='mulok')&&($mulok==0))
		{
			$mulok=1;
	?>
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
    <?php
		}
	?>
	
	
<tr>
			<td align="center" valign="middle"><div align="center" class="style6"><?php echo $idx + 1; ?></div></td>
			<td valign="middle"><div align="center" class="style6"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) or !isset($item_semester1[$item['mapel_id']]['nas_teori']) ) {
				echo "-";
			} else {
				echo ($item_semester1[$item['mapel_id']]['nas_teori']) ? round($item_semester1[$item['mapel_id']]['nas_teori']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) or !isset($item_semester1[$item['mapel_id']]['nas_teori']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item_semester1[$item['mapel_id']]['nas_teori']),0,1))." ".int2kata(substr(round($item_semester1[$item['mapel_id']]['nas_teori']),1,1));
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center">
			
			<?php 
			if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) or !isset($item_semester1[$item['mapel_id']]['nas_praktek']) ) {
			echo "-";
			} else {
			echo ($item_semester1[$item['mapel_id']]['nas_praktek']) ? round($item_semester1[$item['mapel_id']]['nas_praktek']) : '-'; 
			}
			
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) or !isset($item_semester1[$item['mapel_id']]['nas_praktek']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item_semester1[$item['mapel_id']]['nas_praktek']),0,1))." ".int2kata(substr(round($item_semester1[$item['mapel_id']]['nas_praktek']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if(isset($item_semester1[$item['mapel_id']]['nas_sikap']))
				echo $item_semester1[$item['mapel_id']]['nas_sikap']; 
			?></div></td>
		    <td valign="middle" align="center"><div align="center" class="style6"><?php 
			if(isset($item_semester1[$item['mapel_id']]['nipel_kkm']))
				echo round($item_semester1[$item['mapel_id']]['nipel_kkm']); 
			?>&nbsp; </div></td>
			
        
        <!-- SEMESTER 2 -->
		
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) or !isset($item_semester2[$item['mapel_id']]['nas_teori']) ) {
				echo "-";
			} else {
				echo ($item_semester2[$item['mapel_id']]['nas_teori']) ? round($item_semester2[$item['mapel_id']]['nas_teori']) : ''; 
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php 
			if ($item['nas_teori']==0 or is_null($item['nas_teori']) or !is_numeric($item['nas_teori']) or !isset($item_semester2[$item['mapel_id']]['nas_teori']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item_semester2[$item['mapel_id']]['nas_teori']),0,1))." ".int2kata(substr(round($item_semester2[$item['mapel_id']]['nas_teori']),1,1));
			}
			 ?>
			</div></td>
			
			<td valign="middle" align="center"><div align="center">
			
			<?php 
			if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) or !isset($item_semester2[$item['mapel_id']]['nas_praktek']) ) {
			echo "-";
			} else {
			echo ($item_semester2[$item['mapel_id']]['nas_praktek']) ? round($item_semester2[$item['mapel_id']]['nas_praktek']) : '-'; 
			}
			
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			
			<?php 
			if ($item['nas_praktek']==0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek']) or !isset($item_semester2[$item['mapel_id']]['nas_praktek']) ) {
			echo "-";
			} else {
			echo int2kata(substr(round($item_semester2[$item['mapel_id']]['nas_praktek']),0,1))." ".int2kata(substr(round($item_semester2[$item['mapel_id']]['nas_praktek']),1,1)) ;
			}
			 ?>
			 </div></td>
			<td valign="middle" align="center"><div align="center" class="style6"><?php 
			if(isset($item_semester2[$item['mapel_id']]['nas_sikap']))
				echo $item_semester2[$item['mapel_id']]['nas_sikap']; 
			?></div></td>
		    <td valign="middle" align="center"><div align="center" class="style6"><?php 
			if(isset($item_semester2[$item['mapel_id']]['nipel_kkm']))
				echo round($item_semester2[$item['mapel_id']]['nipel_kkm']); 
			?>&nbsp; </div></td>
			
		</tr>
 
	
		
	<?php endforeach; ?>
    
	
   
    
  <tr>
		  <td align="center" valign="middle"><span class="style6"><strong>A</strong></span></td>
		  <td valign="middle"><span class="style6"><strong>Pengembangan Diri / Kegiatan Extrakurikuler </strong></span></td>
		  <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Nilai</strong></span></td>
          <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Nilai</strong></span></td>
		  </tr>
	<?php
		$idx=0; 
		$cetak_ekskul = 0;
		foreach ($ekskul_result1['data'] as $item):
			$cetak_ekskul = 1;?>
		<tr>
		  <td align="center" valign="middle"><?php echo $idx + 1; ?></td>
		  <td valign="middle"><span class="style6"><?php echo $item['ekskul_nama']; ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['keterangan']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php 
		  if(isset($item_semester2[$item['ekskul_id']]['keterangan']))
		  {	echo ($item_semester2[$item['ekskul_id']]['keterangan']); }
		  else
		  { echo'-';	}?></span></td>
          
    </tr>
    <?php 
		endforeach; 
		
		if($cetak_ekskul==0){
	?>
        `<tr>
              <td align="center" valign="middle">-</td>
              <td valign="middle"><span class="style6">-</span></td>
              <td colspan="6" valign="middle" align="left"><span class="style6">-</span></td>
              <td colspan="6" valign="middle" align="left"><span class="style6">-</span></td>
              
        </tr>
	<?php } ?>
		<?php
		$idx=0; 
		foreach ($ekskul_result2['data'] as $item):
		if(isset($item_semester1[$item['ekskul_id']]['keterangan']))
		{?>
		<tr>
		  <td align="center" valign="middle"><?php echo $idx + 1; ?></td>
		  <td valign="middle"><span class="style6"><?php echo $item['ekskul_nama']; ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6">-</span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['keterangan']); ?></span></td>
          
    </tr>
    	<?php
        }?>
    <?php endforeach; ?>
		
	<tr>
		  <td align="center" valign="middle"><span class="style6"><strong>B</strong></span></td>
		  <td valign="middle"><span class="style6"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
		  <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
          <td colspan="6" valign="middle" align="center"><span class="style6"><strong>Keterangan</strong></span></td>
  </tr>
  
	<?php 
		$idx=0;
		foreach ($org_result1['data'] as $item):
	?>
		<tr>
		  <td align="center" valign="middle"><?php echo $idx + 1; ?></td>
		  <td valign="middle"><span class="style6"><?php echo $item['org_nama']; ?></span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item['keterangan']); ?></span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item2[$item['org_nama']]['keterangan']); ?></span></td>
          
    </tr>
    <?php endforeach; ?>
    <tr>
		  <td align="center" valign="middle">-</td>
		  <td valign="middle"><span class="style6">-</span></td>
		  <td colspan="6" valign="middle" align="left"><span class="style6">-</span></td>
          <td colspan="6" valign="middle" align="left"><span class="style6">-</span></td>
          
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
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester1['absen_s']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester2['absen_s']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style6">2</span></td>
    <td valign="middle"><span class="style6">Izin</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester1['absen_i']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester2['absen_i']); ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="style6">3</span></td>
    <td valign="middle"><span class="style6">Tanpa Keterangan </span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester1['absen_a']); ?> Hari</span></td>
    <td colspan="6" valign="middle" align="left"><span class="style6"><?php echo ($item_semester2['absen_a']); ?> Hari</span></td>
  </tr>
  
  
 
  <tr>
      <td align="center" valign="middle"><span class="style6"><strong></strong></span></td>
      <td valign="middle"				rowspan="2"><span class="style6"><strong>Status Akhir Tahun </strong></span></td>
      <td colspan="6" valign="middle"	rowspan="2"><span class="style6">
      <b> <?php 
	  if(isset($ket_kenaikan_kelas))
	  	echo $ket_kenaikan_kelas; ?></b></span></td>
      <td colspan="6" rowspan="2" valign="middle">
       <span class="style6">Nama Wali Kelas :
      <?php 
			  echo "<b>". $row['wali_nama']."</b>";
			 // echo "<br/> NIP : ".$item['wali_nip'];
		?>
      <br/>Tanda Tangan &nbsp;&nbsp;&nbsp;&nbsp;:</span></td>
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

<div class="page page-notend" id="page-2"> 

<b> KETERCAPAIAN KOMPETENSI DIDIK</b><br/>
<?php header_rapor($row);?>

<table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
  <tr>
    
    <th colspan="2" width="30%">Kelas</th>
    <th colspan="2"><?php echo $row['kelas_nama']; ?></th>
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
	<?php
		$mulok=0; 
		foreach ($resultset['data'] as $idx => $item): 
		if(($item['kategori_kode']=='mulok')&&($mulok==0))
		{
			$mulok=1;
	?>
    	<tr>
		  <td align="center" valign="middle"><strong>B</strong></td>
		  <td valign="middle"><strong>Muatan Lokal </strong></td>
		  <td valign="middle" align="left"><div align="left"></div></td>
          <td valign="middle" align="left"><div align="left"></div></td>
 	 </tr>
    <?php
		}
	?>
		<tr>
			<td align="center" valign="middle"><?php echo $idx + 1; ?></td>
			<td valign="middle"><?php echo $item['mapel_nama']; ?></td>
		  <td valign="middle" align="left"><div align="center" class="style5">
		    <div align="left"><?php 
			if(isset($item_semester1[$item['mapel_id']]['kompetensi']))
				echo $item_semester1[$item['mapel_id']]['kompetensi']; 
			else 
				echo "-";
			?>&nbsp; </div>
		  </div></td>
          
          <td valign="middle" align="left"><div align="center" class="style5">
		    <div align="left"><?php 
			if(isset($item_semester2[$item['mapel_id']]['kompetensi']))
				echo $item_semester2[$item['mapel_id']]['kompetensi'];
			else 
				echo "-";
			?>&nbsp; </div>
		  </div></td>
		</tr>
	<?php endforeach; ?>
    
</table>

</div>

<!-- ====================================================================================== -->

<div class="page" id="page-3">
<b>AKHLAK MULIA DAN KEPRIBADIAN</b><br /> 
  <?php header_rapor($row);?>
  


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
  <?php
  $kepribadian1 = (array) json_decode($aspri1['kepribadian'], TRUE);
  $kepribadian2 = (array) json_decode($aspri2['kepribadian'], TRUE);
    $no = 1;

    foreach ($this->m_nilai_siswa->dm['kepribadian.ktsp'] as $idx => $label):
        echo '<tr>' . NL;
        echo '<td valign="middle" align="center"><span class="style4">' . ($no++) . '</span></td>' . NL;
        echo '<td valign="middle"><span class="style4">' . $label . '</span></td>' . NL;
        echo '<td valign="middle"><span class="style4">' . array_node($kepribadian1, $idx) . '</span></td>' . NL;
		echo '<td valign="middle"><span class="style4">' . array_node($kepribadian2, $idx) . '</span></td>' . NL;
        echo '</tr>' . NL;

    endforeach;
    ?>
</table>
<br/><br/>
<b>CATATAN WALI KELAS</b>
<br/>
<table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
  <tr><td height="140" align="left" valign="top">
  <?php 
  $item_semester1['note_walikelas']	= str_replace("\n","<br/>",($item_semester1['note_walikelas']));
  $item_semester2['note_walikelas']	= str_replace("\n","<br/>",($item_semester2['note_walikelas']));
  ?>
  	<table>
     <tr>
      <td align="left" valign="top"><b>Semester 1 :</b></td>
      <td align="left" valign="top"><?php if(isset($item_semester1['note_walikelas']))echo $item_semester1['note_walikelas'];?></td>
     </tr>
     <tr>
      <td align="left" valign="top"><b>Semester 2 :</b></td>
      <td align="left" valign="top"><?php if(isset($item_semester2['note_walikelas']))echo $item_semester2['note_walikelas'];?></td>
     </tr>
    </table>
  </td></tr>
</table>  

</div>