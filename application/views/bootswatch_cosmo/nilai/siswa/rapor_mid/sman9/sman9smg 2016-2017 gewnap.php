<?php
//$tanggal_rapor='1 April 2016';
//$tanggal_rapor='21 Oktober 2016';
$tanggal_rapor='21 April 2017';
$ket_laporan = "LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH ";
if($row['kelas_grade']==10){
	$kurikulum = 'k13';
	$tampil_sub_nilai='Predikat';
	$jarak_enter="<br/>";
	$ket_laporan = "LAPORAN HASIL PENILAIAN HARIAN ";
}else{
	$kurikulum = 'ktsp';
    $tampil_sub_nilai='Huruf';
	$jarak_enter="<br/><br/><br/>";
}
function int2kata($n) {
	if (is_null($n) OR !is_numeric($n))
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
?>
<style type="text/css">

.border_btm1 {
    border-top:3px solid;
}
.border_btm2 {
    border-bottom:3px double;
}
.ttd_gb {
    background-image: url("images/sman9smg/scan001.png");
	 background-size: 80px 60px;
    background-repeat: no-repeat;
	
}

.ttdimg {
				background-image: url('<?=APP_ROOT?>/images/sman9smg/scan001.png');
				background-size: 1200px 1200px;
				background-position: 50% 50%;
				background-repeat: no-repeat;
				position: absolute;
}
<!--
 @page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 41px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }

    
	
.style2 {font-size: 14px}
.style3 {font-size: 12px}
.style7 {font-size: 9px; font-weight: bold; }
.style8 {font-size: 12px}
.style11 {font-size: 13px}
.style13 {
	font-size: 22px;
	font-weight: bold;
}
.style17 {font-size: 20px}
.style18 {font-size: 26px}
.style19 {font-size: 24px}
.style20 {font-size: 12px}
.style21 {
	font-size: 12px;
	padding:5px 10px 5px 10px;
}

-->
</style>

		
<?php
foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];
	$ekskul_result 		= $ekskul_result_array[$cetak['id']];

	if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div class="page" id="page-1" >';	
?>	

<?php if($kurikulum == 'ktsp'){
///<br/><br/><br/>
}?>
<table border="0" style="width: 100%;">
  <tr>
    <!--<td width="115" valign="top"><img src="<?=APP_ROOT?>/images/logo/Logo Dinas Pend.jpg" width="90" height="140" /> </td>
    <td width="900" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH KOTA SEMARANG<br />
      DINAS PENDIDIKAN</span><br />-->
	<td align="center" valign="top"><img src="<?=APP_ROOT?>/images/logo/logo-jawa-tengah3.png" width="140" /> </td>
	<td width="850" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH PROVINSI JAWA TENGAH<br />
      DINAS PENDIDIKAN DAN KEBUDAYAAN</span><br />
      <span class="style18">SMA NEGERI 9 SEMARANG</span><br />
      <span class="style17">Jl. Cemara Raya Padangsari Banyumanik Semarang 50267<br/>
       Telp.(024) 7472812  Fax.(024)7462790<br />
				Website: www.sma9semarang.sch.id  Email : smu092001@yahoo.com</span></td>
    <td width="140" align="left" valign="top"><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/SMAN_9_Semarang.jpg" width="94" height="150"/></td>
  </tr>
</table>
<table style="width: 100%;border-top:3px solid;">
<tr>
<th style="border-top:1px solid;"></th>
</tr>
</table>

<table border="0" style="width: 100%;">
  <tr>
    <td colspan="3" align="center" valign="top"><div align="center" class="style17" style="text-transform:uppercase;"><strong><?=$ket_laporan?>SEMESTER <?php echo strtoupper($row['semester_nama']); ?> <br />
    TAHUN PELAJARAN <?php echo $row['ta_nama']; ?></strong></div> 
      <span class="style17"><br/>
      </span></td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
    <br/>
 	    <table border="0" style="width: 100%;">
          <tr>
            <td width="80px" valign="top" class="style17"><b>NAMA</b></td>
            <td width="1%" valign="top" class="style17">:</td>
            <td width="800px" valign="top" class="style17"><b><?php echo strtoupper($row_per_siswa['siswa_nama']); ?></b> </td>
            
            <td valign="top" class="style17"><b>KELAS</b> </td>
            <td valign="top" class="style17">:</td>
            <td valign="top" class="style17" align="right"><b><?php echo $row['kelas_nama']; ?></b></td>
          </tr>
          <tr>
            <td valign="top" class="style17"><b>NIS</b> </td>
            <td valign="top" class="style17">:</td>
            <td valign="top" class="style17"><b><?php echo $row_per_siswa['siswa_nis']; ?></b> </td>
          </tr>
        </table>
        
    </td>
  </tr>
</table>
<?php if($kurikulum == 'k13'){?>
<span class="style11"><b>A. Sikap</b></span><br />
<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
  <tr>
   <td class="style21">Baik dalam sikap spiritual dan kerja sama, 
   baik dalam toleransi, disiplin, santun, jujur, cinta damai, responsip, pro aktif dan 
   baik dalam kepedulian
   
   </td>
  </tr>
</table>
<br/>
<span class="style11"><b>B. Pengetahuan dan Keterampilan</b></span><br />
<?php }?>

<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; ">
  <tr>
    <th width="5%" rowspan="3" class="style20 border_btm1 border_btm2">No.</th>
    <th width="220" rowspan="3" class="style20 border_btm1 border_btm2">Komponen</th>
    <th width="70" rowspan="3" class="style20 border_btm1 border_btm2">Kriteria Ketuntasan Minimal (KKM)</th>
    <?php// if($kurikulum == 'ktsp'){?>
    <th colspan="5" class="style20 border_btm1">Nilai Hasil Belajar</th>
	<?php //}else{?>
   <!--- <th colspan="4" class="style20 border_btm1">Nilai Hasil Belajar</th> ----->
    <?php //}?>
  </tr>
  <tr>
    <th colspan="2" class="style20">Pengetahuan</th>
    <th colspan="2" class="style20">
    <?php if($kurikulum == 'ktsp'){?>
    Praktek
    <?php }else{ ?>
    Keterampilan
	<?php } ?></th>
     
	 <?php //if($kurikulum == 'ktsp'){?>
    <th width="11%" class="style20">Sikap</th>
    <?php //}?>
  </tr>
  <?php if($kurikulum == 'ktsp'){?>
  <tr>
    <th width="7%" class="style20 border_btm2">Angka</th>
    <th width="130" class="style20 border_btm2">
    <?=$tampil_sub_nilai?>
    </th>
    <th width="6%" class="style20 border_btm2">Angka</th>
    <th width="130" class="style20 border_btm2">
    <?=$tampil_sub_nilai?>
    </th>
    <th class="style20 border_btm2">Predikat</th>
  </tr>
  <?php }elseif($kurikulum == 'k13'){?>
  <tr>
    <th width="10%" class="style20 border_btm2">Angka</th>
    <th width="80" class="style20 border_btm2">
    <?=$tampil_sub_nilai?>
    </th>
    <th width="10%" class="style20 border_btm2">Angka</th>
    <th width="80" class="style20 border_btm2">
    <?=$tampil_sub_nilai?>
    </th>
    
    <?php //if($kurikulum == 'ktsp'){?>
    <th class="style20 border_btm2">Predikat</th>
    <?php // }?>
  </tr>
  <?php }?>
 
		<?php
		$mp_no = 0;
        $ktg_ascii = 64;
        $ktg_nama = NULL;
        $jml_row = 0;

        foreach ($resultset['data'] as $idx => $item):
            if ($item['kategori_nama'] != $ktg_nama):
                $ktg_nama = $item['kategori_nama'];
                $jml_row++;
            endif;
            $jml_row++;
        endforeach;
		
		$ktg_nama = NULL;
        $antr_mapel = 0; 
		foreach ($resultset['data'] as $idx => $item): 
			 if ($item['kategori_nama'] != $ktg_nama):

                $ktg_ascii++;
                $mp_no = 0;

				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                      <td align="center" valign="middle"><div class="style3"><b>A.</b></div></td>
                      <td valign="middle"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                      <td valign="middle" align="center">&nbsp;</td>
                  </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				 <tr>
					  <td align="center" valign="middle"><div class="style3"><b>B.</b></div></td>
					  <td valign="middle"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
					  <td valign="middle" align="center">&nbsp;</td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="middle" colspan="8"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="middle" colspan="8"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="middle" colspan="8"><div class="style3"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  <tr>
                  	   <td align="center" valign="middle"><div class="style3"><b>I.</b></div></td>
					  <td valign="middle" colspan="7"><div class="style3"><b>Peminatan </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	   <td align="center" valign="middle"><div class="style3"><b>II.</b></div></td>
					  <td valign="middle" colspan="7"><div class="style3"><b>Lintas Minat </b></div></td>
				  </tr>
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
		<tr>
			<td align="center" valign="middle"><div class="style3"><?php echo $mp_no; ?>.</div></td>
			<td valign="middle"><div class="style3"><?php echo $item['mapel_nama']; ?></div></td>
			<td valign="middle" align="center"><div align="center" class="style2"><?php echo round($item['nipel_kkm']); ?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style2"><?php
			if ($item['mid_teori']==0 or is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
				echo "-";
			} else {
				echo ($item['mid_teori']) ? round($item['mid_teori']) : '';
			}
			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">
			<?php
			if ($item['mid_teori']==0 or is_null($item['mid_teori']) or !is_numeric($item['mid_teori']) ) {
			echo "-";
			} else {
				if($kurikulum=='k13'){
					echo $item['mid_pred_teori'];
				}else{
				
					echo int2kata(substr(round($item['mid_teori']),0,1))." "
					.int2kata(substr(round($item['mid_teori']),1,1))." "
					.int2kata(substr(round($item['mid_teori']),2,1));
				}
			}
			 ?>
			</div></td>
			<td valign="middle" align="center"><div align="center" class="style2">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
				echo ($item['mid_praktek']) ? round($item['mid_praktek']) : '-';
			}

			?>&nbsp; </div></td>
			<td valign="middle" align="center"><div align="center" class="style3">

			<?php
			if ($item['mid_praktek']==0 or is_null($item['mid_praktek']) or !is_numeric($item['mid_praktek']) ) {
				echo "-";
			} else {
				if($kurikulum=='k13'){
					echo $item['mid_pred_praktek'];
				}else{
					echo int2kata(substr(round($item['mid_praktek']),0,1))." "
					.int2kata(substr(round($item['mid_praktek']),1,1))." "
					.int2kata(substr(round($item['mid_praktek']),2,1)) ;
				}
			}
			 ?>
			 </div></td>
			<?php //if($kurikulum == 'ktsp'){?>
            <td valign="middle" align="center"><div align="center"><?php 
			
			if($kurikulum=='k13'){
				
				$n_sikap =  $item['mid_pred_sikap'];
			}
			else{
				$n_sikap =  $item['pred_sikap']; 
				
			}
			
			if($n_sikap == ""){
			$n_sikap = "-";
			}
			echo $n_sikap;
             //}?>
			</div></td>
		</tr>



	<?php endforeach; ?>
</table>
<br />
<?php if($kurikulum == 'k13'){?>
<span class="style11"><b>C. Ketidakhadiran</b></span><br />
<?php }else{?>
<span class="style11"><b>Ketidakhadiran</b></span><br />
<?php }?>
<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
  <tr>
    <td width="5%" align="center"><div align="center" class="style3"><b>No.</b></div></td>
    <td width="37%" align="center"><div align="center" class="style3"><b>Alasan Ketidakhadiran </b></div></td>
    <td width="58%" align="center"><div align="center" class="style3"><b>Lama </b></div></td>
  </tr>
  <tr>
    <td align="center"><span class="style3">1.</span></td>
    <td><span class="style3">Sakit</span></td>
    <td><span class="style3">&nbsp;&nbsp;
	 <?php echo ($row_per_siswa['absen_s'] > 0) ? "{$row_per_siswa['absen_s']}" : "-"; ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center"><span class="style3">2.</span></td>
    <td><span class="style3">Ijin</span></td>
    <td><span class="style3">&nbsp;&nbsp;
	 <?php echo ($row_per_siswa['absen_i'] > 0) ? "{$row_per_siswa['absen_i']}" : "-"; ?> Hari</span></td>
  </tr>
  <tr>
    <td align="center"><span class="style3">3.</span></td>
    <td><span class="style3">Tanpa Keterangan </span></td>
    <td><span class="style3">&nbsp;&nbsp;
	 <?php echo ($row_per_siswa['absen_a'] > 0) ? "{$row_per_siswa['absen_a']}" : "-"; ?> Hari</span></td>
  </tr>
</table>

<?=$jarak_enter?>
<!-- 
<?php if($kurikulum == 'ktsp'){?>
<table style="width:100%;border-collapse: collapse;">
  <tr>
    <td width="98%" align="right" class="style11">

  <!-- Semarang, <?php echo tgl_indo(date('d-m-Y')); ?>
  Semarang, <?php echo $tanggal_rapor; ?>
   
   </td>
   <td width="2%"></td>
 </tr>
</table>
<?php }else{?>
<table style="width:100%;border-collapse: collapse;">
  <tr>
    <td width="93%" align="right" class="style11">

  <!-- Semarang, <?php echo tgl_indo(date('d-m-Y')); ?>
  Semarang, <?php echo $tanggal_rapor; ?> 
   
   </td>
   <td ></td>
 </tr>
</table>
<?php }?>
-->
<table border="0" style="width: 100%;">
  <tr>
    <td width="23%" align="center" valign="top">
			<p class="style11"><br>
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
	.....................			</p>    </td>
    <td width="47%" align="center" valign="top" >
	
			<p class="style11 ttdimg"><br/>
				<br/><br>
				Mengetahui
				<br/>
				Kepala Sekolah
				<br/>
				
				<img src="<?=APP_ROOT?>/images/sman9smg/scan001.png" width="150" style="position: absolute; top: 5px; left: 5px; z-index: 1" />
				<br/>
				<u >Drs. Siswanto, M.Pd</u>
				<br>
				NIP. 19660608 199512 1001
	</p>    
	</td>
    <td width="30%" align="left" valign="top" style="margin-left:30px;">
			<p class="style11">
			 Semarang, <?php echo $tanggal_rapor; ?><br>
			Wali Kelas<br/>
				<br/>
				<br/><br/><br/>
	<?php echo "<u>".$row['wali_nama']."</u><br/>"; ?>
    <?php echo "NIP : ".$row['wali_nip']; ?>	  </p>    </td>
  </tr>
</table>

</div>
<?php }?>
