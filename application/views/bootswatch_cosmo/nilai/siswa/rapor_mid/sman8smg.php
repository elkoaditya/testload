<?php
//$tanggal_rapor='22 Oktober 2016';
//$tanggal_rapor='April 2017';
$tanggal_rapor = $row['tanggal_mid_nama'];
//$tanggal_rapor = tanggal(date("Y-m-d"));

function int2huruf($n)
{
	if (is_null($n) OR ! is_numeric($n))
		return '';

	if ($n == 0)
		return 'Nol';
	if ($n == 1)
		return 'Satu';
	if ($n == 2)
		return 'Dua';
	if ($n == 3)
		return 'Tiga';
	if ($n == 4)
		return 'Empat';
	if ($n == 5)
		return 'Lima';
	if ($n == 6)
		return 'Enam';
	if ($n == 7)
		return 'Tujuh';
	if ($n == 8)
		return 'Delapan';
	if ($n == 9)
		return 'Sembilan';

	return '';

}

function tgl_indo($tgl)
{
	$tanggal = substr($tgl, 0, 2);
	$bulan = getBulan(substr($tgl, 3, 2));
	$tahun = substr($tgl, 6, 4);
	return $tanggal . ' ' . $bulan . ' ' . $tahun;

}

function getBulan($bln)
{
	switch ($bln)
	{
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
	
	@page {
	 	/* POLIO*/
       /* sheet-size: 210mm 330mm ;*/
	   sheet-size: 210mm 290mm ;
        margin: 0px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
	.style7 {font-size: 11px; font-weight: bold; }
	.style8 {font-size: 12px}
	
	.style11 {font-size: 14px;}
	.style12 {font-size: 13px; font-weight: bold;}
	.style13 {
		font-size: 18px;
		
	}
	.style16 {font-size: 21px}
	.style17 {font-size: 24px}
	.style18 {
		font-size: 30px;
		font-weight: bold;
	}
	.style19 {
		font-size: 28px;
		font-weight: bold;
	}
	
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
<table border="0" style="width: 100%;">
	<tr>
		<!--<td width="115" valign="top"><img src="<?=APP_ROOT?>/images/logo/Logo Dinas Pend.jpg" width="120" /> </td>
		<td width="942" align="center" valign="top"><span class="style13"><span class="style19">PEMERINTAH KOTA SEMARANG<br />
					DINAS PENDIDIKAN</span><br />-->
		<td valign="top" ><img src="<?=APP_ROOT?>/images/logo/logo-jawa-tengah3.png" width="128" /> </td>
		<td width="900" align="center" valign="top">
				<span class="style19">PEMERINTAH PROVINSI JAWA TENGAH<br />
					DINAS PENDIDIKAN</span><br />
				<span class="style18">SMA NEGERI 8 SEMARANG</span><br />
				<span class="style13">Jl. Raya Tugu Semarang 50158 Telp.024 8664553 Fax. 024 8661798<br />
				Website: http://www.sman8-smg.sch.id E-mail : sman8smg@yahoo.com</span></td>
		<td width="150" valign="top"><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma8.jpg" width="130" /></td>
	</tr>
	<tr>

		<td colspan="3" valign="top" style="padding-top:-8px; padding-bottom:-5px"><hr/></td>
	</tr>
	<tr>
		<td colspan="3" align="center" valign="top"><div align="center" class="style17" style="text-transform:uppercase;"><strong>LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH SEMESTER <?php echo strtoupper($row['semester_nama']); ?> <br />
					TAHUN PELAJARAN <?php echo $row['ta_nama']; ?></strong></div>
			<span class="style17"><br/>
			</span></td>
	</tr>
	<tr>
		<td colspan="3" valign="top"><table border="0" style="width: 100%;">
				<tr>
					<td width="8%" valign="top" class="style16"><b>NAMA</b></td>
					<td width="1%" valign="top" class="style16">:</td>
					<td width="69%" valign="top" class="style16"><b><?php echo strtoupper($row_per_siswa['siswa_nama']); ?></b> </td>
					
					<td width="8%" valign="top" class="style16"><b>KELAS</b> </td>
					<td width="1%" valign="top" class="style16">:</td>
					<td valign="top" class="style16"><b><?php echo $row['kelas_nama']; ?></b></td>
				</tr>
				<tr>
					<td valign="top" class="style16"><b>NIS</b> </td>
					<td valign="top" class="style16">:</td>
					<td valign="top" class="style16"><b><?php echo $row_per_siswa['siswa_nis']; ?></b> </td>
				</tr>
				
			</table></td>
	</tr>
</table>

<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
	<tr>
		<th width="5%" rowspan="3" class="style8">NO</th>
		<th width="40%" rowspan="3" class="style8">KOMPONEN</th>
		<th width="10%" rowspan="3" class="style8">KKM</th>
		<th colspan="4" class="style8">PENILAIAN TENGAH SEMESTER </th>
	
	</tr>
	
	<tr>
		<th colspan="2" class="style8 ">Pengetahuan</th>
		<th colspan="2" class="style8 ">Keterampilan</th>
	</tr>
	 
	<tr>
		<th width="10%" class="style8 ">Angka</th>
		<th width="80" class="style8 ">
		Predikat
		</th>
		<th width="10%" class="style8 ">Angka</th>
		<th width="80" class="style8 ">
		Predikat
		</th>
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
              //  if($item['kategori_kode']!='KelD')
				//{
					$mp_no = 0;
				//}
				
				if($item['kategori_kode']=='mapel'):?>
                 <tr>
                    <td valign="top" class="style8" align="center"><span class="style7">A</span></td>
                    <td valign="top" class="style8"><span class="style7"><?=$item['kategori_nama']?> </span></td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				<tr>
                    <td valign="top" class="style8" align="center"><span class="style7">B</span></td>
                    <td valign="top" class="style8"><span class="style7"><?=$item['kategori_nama']?> </span></td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="middle" colspan="7"><div class="style8"><b><?=$item['kategori_nama']?> </b></div></td>
				  </tr>
                  <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>I.</b></div></td>
					  <td valign="middle" colspan="6"><div class="style8"><b>Peminatan </b></div></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	   <td align="center" valign="middle"><div class="style8"><b>II.</b></div></td>
					  <td valign="middle" colspan="6"><div class="style8"><b>Lintas Minat </b></div></td>
				  </tr>
				<?php
				
				
				endif;
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
        
		<tr>
			<td valign="top" class="style8" align="right"><?php echo $mp_no; ?>. </td>
			<td valign="top" class="style8"><?php echo $item['mapel_nama']; ?></td>
			<td class="style8" valign="middle" align="center"><?php echo round($item['nipel_kkm']); ?>&nbsp; </td>
			<td class="style8" valign="middle" align="center">
				<div align="center" class="style2">
				<?php echo $item['mid_teori']; ?></div>
			</td>
			<td class="style8" valign="middle" align="center">
				<div align="center" class="style2">
				<?php echo $item['mid_pred_teori']; ?>
				</div>
			</td>
			<td class="style8" valign="middle" align="center">
				<div align="center" class="style2">
				<?php echo $item['mid_praktek']; ?></div>
			</td>
			<td class="style8" valign="middle" align="center">
				<div align="center" class="style2">
				<?php echo $item['mid_pred_praktek']; ?>
				</div>
			</td>
		</tr>
<?php endforeach; ?>
	
</table>

	<div style="padding-top:6px"></div>
	<span class="style12">Pengembangan Diri </span><br />
	<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
		<tr>
			<td width="5%" align="center"><div align="center" class="style7">NO</div></td>
			<td width="37%" align="center"><div align="center" class="style7">JENIS KEGIATAN </div></td>
			<td width="58%" align="center"><div align="center" class="style7">KETERANGAN</div></td>
		</tr>
		
        <?php
	$tampil_eskl = 0;
    foreach ($ekskul_result['data'] as $_idx => $_row):
		$ket_ekskul = '';
		$tampil_eskl = 1;
        echo '<tr>' . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"40\" align=\"right\" class=\"style8\"> " . ($_idx + 1) . ". </td>" . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"200\" class=\"style8\"> &nbsp;{$_row['ekskul_nama']}</td>" . NL;
        //echo "<td class=\"t-border\" valign=\"top\" align=\"center\"> {$_row['nilai']}</td>" . NL;
        //echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
        if(($_row['nilai']=='A')||($_row['nilai']=='a')):
			echo $ket_ekskul='Sangat Baik';
		elseif(($_row['nilai']=='B')||($_row['nilai']=='b')):
			echo $ket_ekskul='Baik';
		elseif(($_row['nilai']=='C')||($_row['nilai']=='c')):
			echo $ket_ekskul='Cukup';
		elseif(($_row['nilai']=='D')||($_row['nilai']=='d')):
			echo $ket_ekskul='Kurang';
		endif;
		echo "<td class=\"t-border\" valign=\"top\" class=\"style8\">&nbsp;".$ket_ekskul." </td>" . NL;
		echo '</tr>' . NL;
		
    endforeach;
	if($tampil_eskl == 0){
		echo '<tr>' . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\" class=\"style8\"> - </td>" . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\" class=\"style8\"> - </td>" . NL;
		echo "<td class=\"t-border\" align=\"center\" valign=\"top\" class=\"style8\"> - </td>" . NL;
		echo '</tr>' . NL;
	}
	?>
	</table>
	
	<div style="padding-top:6px"></div>
	<span class="style12">Ketidakhadiran</span><br />
	<table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse; margin-bottom:5px;">
		<tr>
			<td width="5%" align="center" class="style7">NO</td>
			<td width="37%" align="center" class="style7">ALASAN KETIDAKHADIRAN </td>
			<td width="58%" align="center" class="style7">LAMA</td>
		</tr>
		<tr>
			<td align="right"><span class="style8">1. </span></td>
			<td><span class="style8">Sakit</span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_s'] > 0) ? "&nbsp;&nbsp;{$row_per_siswa['absen_s']}&nbsp;" : "&nbsp;&nbsp;-&nbsp;"; ?> Hari</span></td>
		</tr>
		<tr>
			<td align="right"><span class="style8">2. </span></td>
			<td><span class="style8">Ijin</span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_i'] > 0) ? "&nbsp;&nbsp;{$row_per_siswa['absen_i']}&nbsp;" : "&nbsp;&nbsp;-&nbsp;"; ?> Hari</span></td>
		</tr>
		<tr>
			<td align="right"><span class="style8">3. </span></td>
			<td><span class="style8">Tanpa Keterangan </span></td>
			<td><span class="style8"> <?php echo ($row_per_siswa['absen_a'] > 0) ? "&nbsp;&nbsp;{$row_per_siswa['absen_a']}&nbsp;" : "&nbsp;&nbsp;-&nbsp;"; ?> Hari</span></td>
		</tr>
	</table>
	

<div style="padding-top:6px"></div>
<table style="width:100%;border-collapse: collapse;">
  <tr>
    <td width="98%" align="right" class="style11">

 <!-- Semarang, <?php echo tgl_indo(date('d-m-Y')); ?>-->
  Semarang, <?php echo $tanggal_rapor; ?>
   
   </td>
   <td width="2%"></td>
 </tr>
</table>

<table border="0" style="width: 100%;">
	<tr>
		<td width="30%" align="center" valign="top">
			<p class="style11">
				Orang Tua/Wali<br/>
				Peserta Didik<br/>
				<br/><br/><br/>
				.....................			</p>    </td>
		<td  align="center" valign="top">
			<p class="style11"><br/>
				<br/>
				<br/><br/><br/>
			</p>    </td>
		<td width="30%" align="center" valign="top">
			<p class="style11">Wali Kelas<br/>
				<br/>
				<br/><br/><br/>
				<?php echo "<u>".$row['wali_nama']."</u><br/>"; ?>
				<?php
			if(strlen($row['wali_nip'])<10){
				$row['wali_nip']='-';
			}
		echo "NIP . ".$row['wali_nip']; ?>	  </p>    </td>
    	  </p>    </td>
	</tr>
</table>

</div>
<?php }?>