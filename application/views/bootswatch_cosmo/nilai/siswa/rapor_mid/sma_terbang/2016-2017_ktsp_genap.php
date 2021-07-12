<?php
//$tanggal_rapor='16 Oktober 2015';
//$tanggal_rapor='24 Maret 2016';
//$tanggal_rapor='08 Oktober 2016';
$tanggal_rapor='16 Maret 2017';

function int2huruf($n) {
    if (is_null($n) OR !is_numeric($n))
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

function tgl_indo($tgl) {
    $tanggal = substr($tgl, 0, 2);
    $bulan = getBulan(substr($tgl, 3, 2));
    $tahun = substr($tgl, 6, 4);
    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulan($bln) {
    switch ($bln) {
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
        sheet-size: 210mm 330mm ;
        margin: 60px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
    .style7 {font-size: 11px; font-weight: bold; }
    .style8 {font-size: 14px}
    .style9 {font-size: 15px}
    .style11 {font-size: 18px}
    .style13 {
        font-size: 30px;
        font-weight: bold;
    }
    .style14 {
        font-size: 34px;
        font-weight: bold;
    }
    .style16 {font-size: 14px}
    .style17 {font-size: 13px}
    .style18 {font-size: 36px}
    .style19 {font-size: 28px}
    
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
  <!--    <td width="115" valign="top"><img src="<?php //echo base_url();   ?>/images/pemkot.png" width="120" /> </td>-->
        <td width="115" valign="top"><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma-terang-bangsa.png" width="120" /> </td>
        <td width="942" align="center" valign="top">
            <span class="style14">
                LAPORAN HASIL BELAJAR PESERTA DIDIK
            </span>
            <br />
            <span class="style13">
                TENGAH SEMESTER 
                <?php if(strtolower($row['semester_nama'])=='gasal') 
				{	echo '1';	}
				else 
				{	echo '2';	} 
				?>
            </span><br />
            <span class="style14">
                SMA KRISTEN TERANG BANGSA
                <!--      <br />-->
                <!--      Jl. Raya Tugu Semarang Telp.024 8664553 Fax. 024 8661798<br />
                                                website: http://www.sman8-smg.sch.id- Email : sman8smg@yahoo.com-->
            </span>
        </td>
    <!--    <td width="143" valign="top"><img src="<?php //echo base_url();   ?>/images/sma8.jpg" width="150" /></td>-->
    </tr>
    <tr>

        <td colspan="2" valign="top"><hr/></td>
    </tr>
</table>
<!--  <tr>
  <td colspan="3" align="center" valign="top"><div align="center" class="style17" style="text-transform:uppercase;"><strong>LAPORAN HASIL BELAJAR PESERTA DIDIK TENGAH SEMESTER <?php echo $resultset['data'][0]['semester']; ?> <br />
  TAHUN PELAJARAN <?php //echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1);    ?></strong></div> 
    <span class="style17"><br/>
    </span></td>
</tr>-->
<?php
	$font_header = "font-size:14";
	$width_nama = "42%";
	if(strlen($row['kelas_nama'])>20)
	{
		$font_header = "font-size:13;";
		$width_nama = "37%";
	}
?>
<table border="0" style="width: 100%;<?=$font_header?>">
    <tr>
        <td width="92px" valign="top" ><b>Nama Siswa</b></td>
        <td width="10px" valign="top" >:</td>
        <td width="<?=$width_nama?>" valign="top" ><b><?php 
		
		$nama = strtolower($row_per_siswa['siswa_nama']); 
        $nama = explode(" ",$nama);
		foreach($nama as $cetak_nama)
		{
			echo ucfirst($cetak_nama)." ";
		}
		
		?></b> </td>

        <td width="125px" valign="top" ><b>Kelas / Semester</b></td>
        <td width="10px" valign="top" >:</td>
        <td valign="top" ><b><?php 
			$nama_kelas = explode(" ",$row['kelas_nama']);
			$jml_nama_kelas=0;
			foreach($nama_kelas as $cetak_nama_kelas)
			{	
				//if(($cetak_nama_kelas=='CAM')or($cetak_nama_kelas=='GAC'))
				//{	echo"<br>";	}
				echo $cetak_nama_kelas." "; 
				$jml_nama_kelas++;
			}
			?> / 
				<?php if(strtolower($row['semester_nama'])=='gasal') 
				{	echo '1';	}
				else 
				{	echo '2';	} 
				?>
                </b> </td>
    </tr>
    <tr>
        <td valign="top" ><b>NIS</b> </td>
        <td valign="top" >:</td>
        <td valign="top" ><b><?php echo $row_per_siswa['siswa_nis']; ?></b> </td>

        <td valign="top" ><b>Tahun Pelajaran</b> </td>
        <td valign="top" >:</td>
<!--        <td valign="top" ><b><?php //echo $resultset['data'][0]['ta'] . '/' . ($resultset['data'][0]['ta'] + 1); ?></b> </td>-->
        <td valign="top" ><b>
		<?php echo $row['ta_nama']; ?></b> </td>
    </tr>
<!--      <tr>
      <td valign="top" class="style17"><b>KELAS</b> </td>
      <td valign="top" class="style17">:</td>
      <td valign="top" class="style17"><b><?php // echo $resultset['data'][0]['kelas_nama'];    ?></b></td>
    </tr>-->
</table>
<br/>
<table width="109%" border="1" cellpadding="2" cellspacing="0" style="width:100%;border-collapse: collapse;">
    <tr>
        <th width="5%" rowspan="3" class="style8" align="center">NO</th>
        <th width="28%" rowspan="3" class="style8">MATA PELAJARAN</th>
        <th width="12%" rowspan="3" class="style8">Kriteria Ketuntasan Minimal (KKM)</th>
        <th colspan="4" class="style8">HASIL PENILAIAN </th>
    </tr>

    <tr>
        <th colspan="2" width="17%" class="style8">Pengetahuan dan Pemahaman Konsep</th>
        <th colspan="2" width="15%" class="style8">Praktik</th>
    </tr>

    <tr>
        <th width="8%" class="style8">Angka</th>
        <th width="19%" class="style8">Huruf</th>
        <th width="8%" class="style8">Angka</th>
        <th class="style8">Huruf</th>
    </tr>
 
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
                /* $mp_no = 0;

				
				if($item['kategori_kode']=='mapel'):?>
                
                 <tr>
                    <td valign="top" class="style8"><strong>A</strong></td>
                    <td valign="top" class="style8"><strong>MATA PELAJARAN</strong> </td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                    <td align="center" valign="top" class="style8">&nbsp;</td>
                </tr>
				<?php elseif($item['kategori_kode']=='mulok'):?>
				<tr>
                    <td valign="top" class="style8"><strong></strong></td>
                    <td valign="top" class="style8">MUATAN LOKAL </td>
                    <td align="center" valign="top" class="style8"> </td>
                    <td align="center" valign="top" class="style8"></td>
                    <td align="center" valign="top" class="style8"></td>
                    <td align="center" valign="top" class="style8"></td>
                    <td align="center" valign="top" class="style8"></td>
                </tr> 
                  
                  <?php elseif($item['kategori_kode']=='KelA'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="7"><strong><?=$item['kategori_nama']?> </strong></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelB'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="7"><strong><?=$item['kategori_nama']?> </strong></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelC'):?>
				 <tr>
					  <td valign="top" class="style8" colspan="7"><strong><?=$item['kategori_nama']?> </strong></td>
				  </tr>
                  <tr>
                  	  <td valign="top" class="style8"><strong>I.</strong></td>
					  <td valign="top" class="style8" colspan="6"><strong>Peminatan </strong></td>
				  </tr>
                  
                  <?php elseif($item['kategori_kode']=='KelD'):?>
				 <tr>
                  	  <td valign="top" class="style8"><strong>II.</strong></td>
					  <td valign="top" class="style8" colspan="6"><strong>Lintas Minat </strong></td>
				  </tr>
				<?php
				
				
				endif;*/
				
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>
        <tr>
            <td valign="middle" class="style8" align="right"><?php echo $mp_no; ?>. </td>
            <td valign="top" class="style8"><?php 
			if($item['kategori_kode']=='mulok')
			{
				echo "Muatan Lokal <br/>";
			}
				echo $item['mapel_nama']; 
			
			?><br/></td>
            <td align="center" valign="middle" class="style8"><?php echo round($item['nipel_kkm']); ?> </td>
            <?php 
            if( ($item['mapel_nama']!='Seni Musik')&&
			($item['mapel_nama']!='Seni Budaya')
                    )
			{	
            ?>
            <td align="center" valign="middle" class="style8">
                <?php
                if($item['mid_teori'] != ''){
                     echo round($item['mid_teori']);
                }
                //echo ($item['mid_teori']) ? round($item['mid_teori']) : ''; 
                ?>
                     </td>
            <td align="center" valign="middle" class="style8">
                <?php
                if($item['mid_teori'] != ''){
                    echo int2huruf(substr(round($item['mid_teori']), 0, 1)) . " "
                    . int2huruf(substr(round($item['mid_teori']), 1, 1)) . " " . int2huruf(substr(round($item['mid_teori']), 2, 1));
                }
                ?></td>
                        <?php }
                        else
                        {
                           echo '<td align="center" valign="middle" >-</td><td align="center" valign="middle" >-</td>'; 
                        }
                   
            if( ($item['mapel_nama']!='Ekonomi')&&
			($item['mapel_nama']!='Geografi')&&
			($item['mapel_nama']!='Matematika')&&
			($item['mapel_nama']!='Pendidikan Agama Islam')&&
			($item['mapel_nama']!='Pendidikan Agama Katolik')&&
			($item['mapel_nama']!='Pendidikan Agama Kristen')&&
			($item['mapel_nama']!='Pendidikan Kewarganegaraan')&&
			($item['mapel_nama']!='Sejarah')&&
			($item['mapel_nama']!='Sosiologi')
                    )
			{	
                       
                        ?>
            <td align="center" valign="middle" class="style8">
                <?php 
                if($item['mid_praktek'] != ''){
                    echo round($item['mid_praktek']);
                }
                //echo ($item['mid_praktek']) ? round($item['mid_praktek']) : ''; ?>
                     </td>
            <td align="center" valign="middle" class="style8">
                <?php
                if($item['mid_praktek'] != ''){
                    echo int2huruf(substr(round($item['mid_praktek']), 0, 1)) . " "
                    . int2huruf(substr(round($item['mid_praktek']), 1, 1)) . " " . int2huruf(substr(round($item['mid_praktek']), 2, 1));
                }
                ?></td>
    <!--			<td align="center" valign="middle" class="style8">
              
            <?php 
                        } else
                        {
                           echo '<td align="center" valign="middle" >-</td><td align="center" valign="middle" >-</td>'; 
                        }
//echo substr($mid[$idx],0,5);  ?>			</td>-->
        </tr>
    <?php endforeach; ?>
    
</table>
<br />
<?php 

 $b[1] = ($row_per_siswa['absen_s']);
$b[2] = ($row_per_siswa['absen_i']);
$b[3] = ($row_per_siswa['absen_a']);
    

?>
            <!--<span class="style11">Pengembangan Diri <br />
            <table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
              <tr>
                <td width="5%" align="center"><div align="center" class="style7">NO</div></td>
                <td width="37%" align="center"><div align="center" class="style7">JENIS KEGIATAN </div></td>
                <td width="58%" align="center"><div align="center" class="style7">KETERANGAN</div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Kegiatan Extrakurikuler </td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>1</td>
                <td><?php //echo ($item['extra1_nama']);    ?></td>
                <td><?php //echo ($item['extra1_kompetensi']);    ?></td>
              </tr>
              <tr>
                <td>2</td>
                <td><?php //echo ($item['extra2_nama']);    ?></td>
                <td><?php //echo ($item['extra2_kompetensi']);    ?></td>
              </tr>
                <tr>
                <td>3</td>
                <td><?php //echo ($item['extra3_nama']);    ?></td>
                <td><?php //echo ($item['extra3_kompetensi']);    ?></td>
              </tr>
            </table>
            <br />-->
<!--            <span class="style11">Ketidakhadiran<br />-->

    <table width="100%" border="0" >
        <tr>
            <td width="50%"></td>
            <td width="50%">
                <table width="100%" border="1" cellspacing="0" cellpadding="2" style="width:100%;border-collapse: collapse;">
                    <tr>
                        <td  width="270px" colspan="3" align="center"><div align="center" class="style8"> <strong>Kehadiran Siswa</strong></div></td>  
                    </tr>
                    <tr>
                        <td width="100%" align="center"><div align="center" class="style8" >Sakit</div></td>
                        <td width="100%" align="center"><div align="center" class="style8" >Ijin </div></td>
                        <td width="100%" align="center"><div align="center" class="style8" >Alpa</div></td>
                    </tr>
                    <tr>
                        <?php
                        for ($a = 1; $a <= 3; $a++) {
                            ?>
                            <td align="center">
                                <span class="style8" align="center">
                                        <?php
                                        if ($b[$a] != 0) {
                                            echo $b[$a];
                                        } else {
                                            echo "-";
                                        }
                                        ?> 
                                
                            </td>
    <?php } ?>
                    </tr>
    <!--                    <tr>
                        <td><span class="style8" align="center">2</td>
                        <td><span class="style8" align="center">Ijin</td>
                        <td><span class="style8" align="center"><?php //echo ($item['absen_i']);  ?> </td>
                    </tr>
                    <tr>
                        <td><span class="style8" align="center">3</td>
                        <td><span class="style8" align="center">Tanpa Keterangan </td>
                        <td><span class="style8" align="center"><?php //echo ($item['absen_a']);  ?> </td>
                    </tr>-->
                </table>
            </td>
        </tr>
    </table>
    <br/>
<br/>
<p align="right" class="style9">
   <!-- Semarang, <?php //echo tgl_indo(date('d-m-Y')); ?> --->
     Semarang, <?php echo $tanggal_rapor; ?>
</p>


<table border="0" style="width: 100%;">
    <tr>
        <td width="26%" align="center" valign="top">
            <p class="style9"><br/>
                Orang Tua/Wali
                <br/>
                <br/>
                <br/><br/><br/>
                ....................			</p>    </td>
        <td width="48%" align="center" valign="top">
            <p class="style9"><br/>
                Wali Kelas<br/>
                <br/>
                <br/><br/><br/>	
             <?php foreach ($resultset['data'] as $idx => $item): 
				//echo $item['wali_nama'];
			  endforeach; 
			  echo "".$row['wali_nama']."";
			 // echo "<br/> NIP : ".$item['wali_nip'];
		?>
            
            </p>    </td>
        <td width="26%" align="center" valign="top">
            <p class="style9">Mengetahui,<br/>
                Kepala Sekolah<br/>
                <br/>
                <br/><br/><br/>
                 Drs. Sungkowo Prihadi	  </p>    </td>
    </tr>
</table>
</div>
<?php }?>