<?php
//$tanggal_rapor='16 Oktober 2015';
//$tanggal_rapor='24 Maret 2016';
//$tanggal_rapor='08 Oktober 2016';
$tanggal_rapor='7 Oktober 2017';

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
        margin: 37px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
    .style6 {font-size: 12px}
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
    .t-border{
        border-width: 1px;
        border-style: solid;
        border-color: black;
        border-collapse: collapse;

    }
    .t-border2{
        border-style: solid;
        border-color: black;
        border-collapse: collapse;
        border-bottom: 3px;

    }
    #t-nilai
    {
        width: 100%;
    }
    .thead-1{
        vertical-align: middle;
        text-align: center;
    }
    .thead-2{
        vertical-align: middle;
        text-align: center;
        padding: 7px;
    }
    .field-nilai
    {
        padding: 2px 7px 2px 7px;
    }
	.field-nilai2
    {
        padding: 2px 7px 2px 7px;
		vertical-align:central;
		font-size:11px;
    }
    .f-kompetensi{
        padding: 3px 7px;
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
  <!--    <td width="115" valign="top"><img src="<?php //echo base_url();   ?>/images/pemkot.png" width="120" /> </td>-->
        <td width="115" valign="top"><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma-terang-bangsa.png" width="120" /> </td>
        <td width="942" align="center" valign="top">
            <span class="style14">
                LAPORAN PENILAIAN HARIAN TERPROGRAM
            </span>
            <br />
            <span class="style13">
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
<table cellspacing="0" id="t-nilai" class="t-border style6" >
        <tr>
            <td class="thead-1 t-border" rowspan="2" colspan="2" width="25%">MATA PELAJARAN</td>
           <td class="thead-1 t-border" rowspan="2">KKM</td>
            <td class="thead-1 t-border" colspan="2">Pengetahuan</td>
            <td class="thead-1 t-border" colspan="2">Keterampilan</td>
           <!-- <td class="thead-1 t-border">Sikap</td>-->
        </tr>

        <tr>

            <td class="thead-1 t-border" >&nbsp;Angka&nbsp;<br/><b> (1-100) </b></td>
            <td class="thead-1 t-border" >&nbsp;Predikat&nbsp;</td>
            <td class="thead-1 t-border" >&nbsp;Angka&nbsp;<br/><b> (1-100) </b></td>
            <td class="thead-1 t-border" >&nbsp;Predikat&nbsp;</td>
 <!--           <td class="thead-1 t-border" width="15%">&nbsp;Dalam Mapel&nbsp;<br><b>SB/B/C/K</b></td>
            <td class="thead-1 t-border" width="15%">&nbsp;Antar Mapel&nbsp;</td>-->
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
                $mp_no = 0;

                echo '<tr>' . NL;
                //echo "<td class=\"field-nilai t-border\" valign=\"top\"><b>" . chr($ktg_ascii) . "</b></td>" . NL;
                //echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>{$ktg_nama}</b></td>" . NL;
                if ($ktg_nama != NULL):
					if($item['kategori_kode']=='KelC'):
						echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
						echo '</tr>'. NL.'<tr>' . NL;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"1\" align=\"center\" width=\"5%\"><b>I</b></td>" . NL;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"6\"><b>Peminatan</b></td>" . NL;
					elseif($item['kategori_kode']=='KelD'):
						echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"1\" align=\"center\" width=\"5%\"><b>II</b></td>" . NL;
						echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"6\"><b>Lintas Minat</b></td>" . NL;
					else:
                    	echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
					endif;
                else:
                    echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"7\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                /* echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>(1-4)</b></td>" . NL;
                  echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
                  echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>(1-4)</b></td>" . NL;
                  echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
                  echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ><b>SB/B/K</b></td>" . NL; */
                //echo "<td class=\"field-nilai t-border\" valign=\"top\" ></td>" . NL;
                endif;
                echo '</tr>' . NL;

                $ktg_nama = $item['kategori_nama'];
            endif;

            $mp_no++;

            echo '<tr>' . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"right\" width=\"5%\">{$mp_no}. </td>" . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']} <br><b>{$item['guru_nama']}<b></td>" . NL;
			/*
			if($row['kelas_grade']==10)
				$kkm='70';
			elseif($row['kelas_grade']==11)
				$kkm='75';
			elseif($row['kelas_grade']==12)
				$kkm='75';
			*/
			$kkm = round($item['nipel_kkm']);
			echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\"><b>{$kkm}<b></td>" . NL;


            // ppk
            $cetak_nilai = 0;
            if ($item['nipel_teori']):
                /*foreach ($konversi_nilai['data'] as $konversi):
                    if ((round($item['nas_teori']) >= $konversi['rentang_nilai_min']) && (round($item['nas_teori']) <= $konversi['rentang_nilai_max'])):

                        if ($item['nas_teori'] != "") {
                            $cetak_nilai = 1;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['bobot'] . "</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['predikat'] . "</td>" . NL;
                        }
                    endif;
                endforeach;
				
                if ($cetak_nilai == 0):
                    echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                endif;*/
				
				echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">" . round($item['mid_teori'],0) . "</td>" . NL;
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_teori'] . "</td>" . NL;
            else:
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

            endif;

            // prk
            $cetak_nilai = 0;
            if ($item['nipel_praktek']):
                /*foreach ($konversi_nilai['data'] as $konversi):
                    if ((round($item['nas_praktek']) >= $konversi['rentang_nilai_min']) && (round($item['nas_praktek']) <= $konversi['rentang_nilai_max'])):
                        if ($item['nas_praktek'] != "") {
                            $cetak_nilai = 1;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['bobot'] . "</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['predikat'] . "</td>" . NL;
                        }
                    endif;
                endforeach;

                if ($cetak_nilai == 0):
                    echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                endif;*/
				echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">" . round($item['mid_praktek'],0) . "</td>" . NL;
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_praktek'] . "</td>" . NL;
            else:
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

            endif;

            // sikap
            //$avg = (round($item['nas_praktek'])+round($item['nas_teori']) )/2;
            $avg = $item['mid_sikap'];
            $cetak_nilai = 0;
            /*foreach ($konversi_nilai['data'] as $konversi):
                if ((round($avg) >= $konversi['rentang_nilai_min']) && (round($avg) <= $konversi['rentang_nilai_max'])):
                    if ($avg != "") {
                        $cetak_nilai = 1;
                        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $konversi['kualifikasi'] . "</td>" . NL;
                    }
                endif;
            endforeach;
            if (round($avg) == 0) {
                $cetak_nilai == 0;
            }
            if ($cetak_nilai == 0):*/
			
			/*
			if ($item['mid_pred_sikap']):
				if($item['mid_pred_sikap']=='A'):
					$item['mid_pred_sikap']='SB';
				elseif(($item['mid_pred_sikap']=='D')||($item['mid_pred_sikap']=='E')):
					$item['mid_pred_sikap']='K';	
				endif;
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_sikap'] . "</td>" . NL;
			else:	
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
            endif;*/
			
			
            //echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . ($item['nas_sikap']) . "</td>" . NL;
//			if($antr_mapel==0):
//				$text="Peserta didik sangat baik dalam menjalankan ajaran agama yang dianutnya dan menunjukan kesungguhannya dalam menerapkan sikap jujur, kerjasama, dan percaya diri";
//				echo "<td class=\"field-nilai t-border\" valign=\"top\" rowspan=\"".$jml_row."\"><b>".$text."</b></td>" . NL;
//				$antr_mapel++;
//			endif;

            echo '</tr>' . NL;
            $jml_row++;
        endforeach;
        ?>

    </table>
<br/>
	
	<table cellspacing="0" class="t-border style6" width="40%" >
    <tr>
            <td class="t-border" colspan="2" align="center">Ketidakhadiran</td>
    </tr>
    <tr>
            <td class="t-border" width="80%">&nbsp;Sakit</td>
            <td class="t-border">&nbsp; <?php echo ($row_per_siswa['absen_s'] > 0) ? "{$row_per_siswa['absen_s']}" : "-"; ?>&nbsp; hari</td>
    </tr>
    <tr>
            <td class="t-border">&nbsp;Ijin</td>
            <td class="t-border">&nbsp; <?php echo ($row_per_siswa['absen_i'] > 0) ? "{$row_per_siswa['absen_i']}" : "-"; ?>&nbsp; hari</td>
    </tr>
    <tr>
            <td class="t-border">&nbsp;Tanpa Keterangan</td>
            <td class="t-border">&nbsp; <?php echo ($row_per_siswa['absen_a'] > 0) ? "{$row_per_siswa['absen_a']}" : "-"; ?>&nbsp; hari</td>
    </tr>
</table>
	
    <table border="0" style="width: 100%;">
		<tr>
            <td valign="bottom" align="center" style="width: 40%;"  id="head-3">
                
            </td>
			<td style="width: 20%;" id="head-3">
		
            </td>

            <td valign="top" align="center" style="width: 40%;" id="head-3">
                <p>
                    Semarang, <?php echo $tanggal_rapor;?><br/>
                    
                </p>
            </td>
        </tr>
		
        <tr>
            <td valign="bottom" align="center" id="head-3">
                <p>
                    Orang Tua/Wali
                </p>
            </td>
			<td id="head-3">
		 
            </td>

            <td valign="bottom" align="center" id="head-3">
                <p>
                    
                     Wali Kelas 
                </p>
            </td>
        </tr>
		
        <tr>
            <td valign="bottom" align="center" id="head-3" >
                <p>
                    <br/><br/><br/>
                    ...................................
                </p>
            </td>
            <td valign="bottom" align="center" id="head-3">
                
            </td>
			<td valign="bottom" align="center" id="head-3">
				<p>
                    <br/><br/><br/>
                    <u><?php echo $row['wali_nama']; ?></u><!-- 
                    <br/>
                    NIP. <?php echo $row['wali_nip'];?> ---->
                </p>
			</td>
<!--            <td valign="bottom" align="center" id="head-3">
                <p>
                    <br/><br/><br/>
                    <u>Hj. Kastri Wahyuni, S.Pd, MM.</u>
                    <br/>
                    NIP. 19560615 197903 2 005
                </p>
            </td>-->

        </tr>
    </table>
</div>
<?php }?>