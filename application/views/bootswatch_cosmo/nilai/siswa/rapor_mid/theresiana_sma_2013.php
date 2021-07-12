<?php

//$tanggal_rapor = '18 April 2015';
//$tanggal_rapor = '02 November 2015';
$tanggal_rapor = '24 Maret 2016';

function ket_ekskul($str) {
    if (empty($str))
        return '-';

    if (strlen($str) == 1)
        return strtoupper($str);

    $str = substr($str, 0, 1);

    return strtoupper($str);
}
?>

<style>
    @page {
        sheet-size: 210mm 330mm ;
        margin: 5px 30 5px 30px;
    }

    .page *, td{
        font-size: 11px;
    }

    .page-notend{
        page-break-after: always;
    }

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
    .f-kompetensi{
        padding: 3px 7px;
    }


    #header-rapor{
        text-align: center;
        font-family: Arial;
        font-size: 120%;
        font-weight: bold;
    }
    .t-siswa tr td{
        padding: 6px 10px 6px 6px;
    }

    .t-ekskul{
        margin: 0px;
        width: 245px;
    }
    .thead-ekskul{
        text-align: center;
        margin: 4px;
        font-weight: bold;
    }

    #head-1{
        text-align: center;
        font-size: 24px;
        font-weight: bold;
    }
    #head-2{
        text-align: center;
        font-size: 16px;
        font-weight: bold;
    }
    #head-3{
        font-size: 12px;
    }
    #head-4{
        text-align: center;
        font-size: 14px;
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
<!-- <div class="page" id="page-1"> -->
    <div id="header-rapor" class="t-border2">

        <table border="0" cellspacing="0" width="100%">
            <tr>
                <td width="13%">
                    <?php
                    $logo = array(
                        'src' => 'content/sma1_smg/Logo Dinas Pend.jpg',
                        'width' => 80,
                        'height' => 104,
                    );
                    echo img($logo);
                    ?>&nbsp;
                </td>
                <td align="center" width="100%">
                    <div id="head-2">
                        PEMERINTAH KOTA SEMARANG<br/>
                    </div>
                    <div id="head-1">
                        DINAS PENDIDIKAN<br/>
                        SMA NEGERI 1 SEMARANG<br/>
                    </div>
                    Jalan Taman Menteri Supeno No.1 Semarang 50243<br/>
                    Telp.(024)8310447 - 8318539 Fax.(024)8414851 E-mail : <u>sma1semarang@yahoo.co.id</u>
            </td>
            <td align="center" width="16%">
                <?php
                $logo2 = array(
                    'src' => 'content/sma1_smg/Logo SMA1.jpg',
                    'width' => 80,
                    'height' => 106,
                );
                echo img($logo2);
                ?>
            </td>
            </tr>
        </table>

    </div>
    <table border="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
        	<div id="head-3">
        <u>LAPORAN CAPAIAN KOMPETENSI TENGAH SEMESTER</u>
			</div>

        </td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="0"  width="100%">
        <tr>
            <td valign="top"   width="70%">
                <table border="0" cellspacing="0" width="360px">
                    <tr>
                        <td valign="top"  id="head-3">Nama Peserta Didik &nbsp;</td>
                        <td valign="top"  id="head-3"> : &nbsp;</td>
                        <td valign="top"  id="head-3">
                            <?php echo strtoupper($row_per_siswa['siswa_nama']); ?> 
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"  id="head-3">Nomor Induk &nbsp;</td>
                        <td valign="top" id="head-3"> : &nbsp;</td>
                        <td valign="top" id="head-3">
                            <?php echo $row_per_siswa['siswa_nis']; ?>
                        </td>
                    </tr>
                </table>

            </td>
            <td valign="top" align="right">
                <table border="0" width="320px">
                    <tr>
                        <td valign="top" id="head-3" align="left">Kelas/Semester &nbsp;</td>
                        <td valign="top" id="head-3" align="left"> : &nbsp;</td>
                        <td valign="top" id="head-3">
                            <?php echo $row['kelas_nama'] . ' / ';
							if(($row['semester_nama']=='Gasal')||($row['semester_nama']=='gasal'))
								echo '1';
							else
								echo '2'; ?>
                        </td>
                    </tr>
					<tr>
                            <td valign="top" id="head-3" align="left">Tahun Pelajaran &nbsp;</td>
                            <td valign="top" id="head-3" align="left"> : &nbsp;</td>
                            <td valign="top" id="head-3">
                    <?php echo $row['ta_nama']; ?>
                            </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    
    <table cellspacing="0" id="t-nilai" class="t-border" >
        <tr>
            <td class="thead-1 t-border" rowspan="2" colspan="2" width="25%">MATA PELAJARAN</td>
            <td class="thead-1 t-border" colspan="2">Pengetahuan</td>
            <td class="thead-1 t-border" colspan="2">Keterampilan</td>
            <td class="thead-1 t-border">Sikap</td>
        </tr>

        <tr>

            <td class="thead-1 t-border" >&nbsp;Angka&nbsp;<br/><b> (1-100) </b></td>
            <td class="thead-1 t-border" >&nbsp;Predikat&nbsp;</td>
            <td class="thead-1 t-border" >&nbsp;Angka&nbsp;<br/><b> (1-100) </b></td>
            <td class="thead-1 t-border" >&nbsp;Predikat&nbsp;</td>
            <td class="thead-1 t-border" width="15%">&nbsp;Dalam Mapel&nbsp;<br><b>SB/B/C/K</b></td>
<!--            <td class="thead-1 t-border" width="15%">&nbsp;Antar Mapel&nbsp;</td>-->
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
				
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . round($item['mid_teori'],0) . "</td>" . NL;
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_teori'] . "</td>" . NL;
            else:
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

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
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . round($item['mid_praktek'],0) . "</td>" . NL;
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_praktek'] . "</td>" . NL;
            else:
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

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
			if ($item['mid_pred_sikap']):
				if($item['mid_pred_sikap']=='A'):
					$item['mid_pred_sikap']='SB';
				elseif(($item['mid_pred_sikap']=='D')||($item['mid_pred_sikap']=='E')):
					$item['mid_pred_sikap']='K';	
				endif;
				echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . $item['mid_pred_sikap'] . "</td>" . NL;
			else:	
                echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
            endif;
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
<?php 
	//print_r($ekskul_result['data']);
?>
	<table cellspacing="0" class="t-border" width="100%" >
                <tr>
                        <td class="t-border" align="center" valign="middle" width="40">No</td>
                        <td class="t-border" align="center" valign="middle" >Kegiatan Ekstrakurikuler</td>
                        <td class="t-border" align="center" valign="middle" width="8%">Nilai</td>
            <td class="t-border" align="center" valign="middle">Keterangan</td>
                </tr>

    <?php
	$tampil_eskl = 0;
    foreach ($ekskul_result['data'] as $_idx => $_row):
		$ket_ekskul = '';
		$tampil_eskl = 1;
        echo '<tr>' . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"40\" align=\"right\"> " . ($_idx + 1) . ". </td>" . NL;
        echo "<td class=\"t-border\" valign=\"top\" width=\"200\"> &nbsp;{$_row['ekskul_nama']}</td>" . NL;
        echo "<td class=\"t-border\" valign=\"top\" align=\"center\"> {$_row['nilai']}</td>" . NL;
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
		echo "<td class=\"t-border\" valign=\"top\">&nbsp;".$ket_ekskul."</td>" . NL;
		echo '</tr>' . NL;
		
    endforeach;
	/*
      foreach ($org_result['data'] as $_idx => $_row):
      echo '<tr>' . NL;
      echo "<td class=\"t-border\" valign=\"top\" width=\"40\">" . ($_idx + 1) . ".</td>" . NL;
      echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['org_nilai']}</td>" . NL;
      echo "<td class=\"t-border\" valign=\"top\" width=\"200\">{$_row['org_nama']}</td>" . NL;
      echo "<td class=\"t-border\" valign=\"top\">{$_row['keterangan']}</td>" . NL;
      echo '</tr>' . NL;

      endforeach;
     */
	if($tampil_eskl==0)
    {
    ?>
        <tr>
            <td class="t-border" align="center"></td>
            <td class="t-border" align="center">-</td>
            <td class="t-border" align="center">-</td>
            <td class="t-border" align="center">-</td>
        </tr>
     <?php 
	 }?>
        </table>
    <br>
	<table cellspacing="0" class="t-border" width="40%" >
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
            <td valign="bottom" align="center" style="width: 30%;"  id="head-3">
                <p>
                    Orang Tua/Wali
                </p>
            </td>

			<td valign="bottom"style="width: 40%;"></td>
<!--            <td valign="bottom" align="center" style="width: 35%;" id="head-3">
                <p>
                    Wali Kelas
                </p>
            </td>-->

            <td valign="bottom" align="left" style="width: 30%;" id="head-3">
                <p>
                    Semarang, <?php echo $tanggal_rapor;?><br/>
                    <br/>
                     Wali Kelas
                </p>
            </td>
        </tr>
        <tr>
            <td valign="bottom" align="center" id="head-3">
                <p>
                    <br/><br/><br/>
                    ...................................
                </p>
            </td>
			<td></td>
            <td valign="bottom" align="left" id="head-3">
                <p>
                    <br/><br/><br/>
                    <u><?php echo $row['wali_nama']; ?></u>
                    <br/>
                    NIP. <?php echo $row['wali_nip'];?>
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
