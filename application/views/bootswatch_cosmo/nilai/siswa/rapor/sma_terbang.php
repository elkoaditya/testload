<?php

function int2kata($n) {
    if (is_null($n) or !is_numeric($n))
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

function cek_null($cek) {
    if($cek == "")
    {
        $cek = " <br> ";
    }
    return $cek;
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

function int2huruf($n) {
    if (is_null($n) OR !is_numeric($n))
        return '';

    if ($n >= 90)
        return 'A';

    if ($n >= 70)
        return 'B';

    if ($n >= 60)
        return 'C';

    //if ($n >= 41)
        return 'D';

    //return 'E';
}
//$tgl_cetak_rapor = "13 Juni 2015";
//$tgl_cetak_rapor = "19 Desember 2015";
$kelas_explode = explode(" ",$resultset['data'][0]['kelas_nama']);
if($kelas_explode[0]=='XII')
	$tgl_cetak_rapor = "07 Mei 2016";
else
	$tgl_cetak_rapor = "17 Juni 2016";

$set_semester = 1;
if($resultset['data'][0]['semester'] == "genap"){
    $set_semester = 2;
}


function header_rapor($resultset,$set_semester){
?>
	<table width="100%" border="0" style="width: 100%;" class="style5">
        <tr>
            <td width="17%" valign="top" >
                <b>Nama Siswa</b></td>
            <td width="1%" valign="top">:</td>
            <td valign="top" width="33%">
                <b><?php echo $resultset['data'][0]['siswa_nama']; ?></b></td>
            <td width="20%" valign="top"><b>Kelas/Semester</b></td>
            <td width="1%" valign="top">:</td>
            <td width="29%" valign="top"><span style="text-transform:uppercase;"><b><?php echo $resultset['data'][0]['kelas_nama']; ?>/<?php echo $set_semester; ?></b></span></td>
        </tr>
        <tr>
            <td valign="top">
                <b>NIS</b>					</td>
            <td valign="top">:</td>
            <td valign="top">
                <b><?php echo $resultset['data'][0]['siswa_nis']; ?></b></td>

            <td valign="top"><b>Tahun Pelajaran</b></td>
            <td valign="top">:</td>
            <td valign="top"><b><?php 
				if(strtoupper(trim($resultset['data'][0]['semester']))=='GASAL'):
					echo ($resultset['data'][0]['ta']) . '/' . ($resultset['data'][0]['ta'] + 1);
				else:
					echo ($resultset['data'][0]['ta'] - 1) . '/' . ($resultset['data'][0]['ta']);
				endif;?></b></td>
        </tr>

    </table>
    <br/>
<?php
}
?>
<style type="text/css">
    
    .style3 {font-size: 11px}
    
    #halaman {
        /*padding:112px 5px 5px 5px;*/
		padding:85px 5px 5px 5px;
        height:1500px;
    }
    .style4 {font-size: 12px}

    .style5 {font-size: 14px}

    .kecil td{
        font-size: 11px;
        padding: 2px 4px 2px 4px;

    }
    .kecil th{
        font-size: 12px;
        padding:2px 4px 2px 4px;
        font-style: bold;
    }
    .style6 {font-size: 12px !important; }
    .style8 {padding:5px 5px 5px 5px; }
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

    <?php header_rapor($resultset,$set_semester);?>
    

    <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="5%" rowspan="3">No</th>
            <th width="26%" rowspan="3">Mata Pelajaran</th>
            <th width="12%" rowspan="3">Kriteria Ketuntasan Minimal (KKM)</th>
            <th colspan="4">HASIL PENILAIAN</th>
            <th width="7%" rowspan="3">Sikap</th>
        </tr>
        <tr>
            <th colspan="2">Pengetahuan</th>
            <th colspan="2">Praktek</th>
        </tr>
        <tr>
            <th width="6%">Angka</th>
            <th width="17%">Huruf</th>
            <th width="6%">Angka</th>
            <th width="17%">Huruf</th>
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
				$ktg_nama = $item['kategori_nama'];
			endif;
			
			$mp_no++;
		?>

            <tr>
                <td align="center" valign="middle"><?php echo $idx + 1; ?></td>
                <td valign="middle"><?php echo $item['mapel_nama']; ?></td>
                <td valign="middle" align="center"><div align="center"><?php echo round($item['kkm']); ?>&nbsp; </div></td>

                <?php
                if (($item['mapel_nama'] != 'Seni Musik') &&
                        ($item['mapel_nama'] != 'Seni Budaya')) {
                    ?>
                    <td valign="middle" align="center"><div align="center"><?php
            if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori'])) {
                echo "-";
            } else {
                echo ($item['nas_teori']) ? round($item['nas_teori']) : '';
            }
                    ?>&nbsp; </div></td>
                    <td valign="middle" align="center"><div align="center" class="style3">
                            <?php
                            if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori'])) {
                                echo "-";
                            } else {
                                echo int2kata(substr(round($item['nas_teori']), 0, 1)) . " " 
								. int2kata(substr(round($item['nas_teori']), 1, 1))." "
								. int2kata(substr(round($item['nas_teori']), 2, 1));
                            }
                            ?>
                        </div></td>

                    <?php
                } else {
                    ?>

                    <td valign="middle" align="center"><div align="center"> - </div></td>
                    <td valign="middle" align="center"><div align="center" class="style3"> - </div>

                        <?php
                    }

                    if (($item['mapel_nama'] != 'Ekonomi') &&
                            ($item['mapel_nama'] != 'Geografi') &&
                            ($item['mapel_nama'] != 'Matematika') &&
                            ($item['mapel_nama'] != 'Pendidikan Agama Islam') &&
                            ($item['mapel_nama'] != 'Pendidikan Agama Katolik') &&
                            ($item['mapel_nama'] != 'Pendidikan Agama Kristen') &&
                            ($item['mapel_nama'] != 'Pendidikan Kewarganegaraan') &&
                            ($item['mapel_nama'] != 'Sejarah') &&
                            ($item['mapel_nama'] != 'Sosiologi')
                    ) {
                        ?>


                    <td valign="middle" align="center"><div align="center">

        <?php
        if ($item['nas_praktek'] == 0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek'])) {
            echo "-";
        } else {
            echo ($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
        }
        ?>&nbsp; </div></td>
                    <td valign="middle" align="center"><div align="center" class="style3">

                            <?php
                            if ($item['nas_praktek'] == 0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek'])) {
                                echo "-";
                            } else {
                                echo int2kata(substr(round($item['nas_praktek']), 0, 1)) . " " 
								. int2kata(substr(round($item['nas_praktek']), 1, 1))." "
								. int2kata(substr(round($item['nas_praktek']), 2, 1));
                            }
                            ?>
                        </div></td>
                            <?php
                        } else {
                            ?>

                    <td valign="middle" align="center"><div align="center"> - </div></td>
                    <td valign="middle" align="center"><div align="center" class="style3"> - </div>

        <?php }
    ?>
                <td valign="middle" align="center"><div align="center"><?php echo int2huruf($item['nas_skp']); ?></div></td>
            </tr>

<?php endforeach; ?>
<!--        <tr>
            <td align="center" valign="middle"><strong>B</strong></td>
            <td valign="middle"><strong>Muatan Lokal </strong></td>
            <td valign="middle" align="center">&nbsp;</td>
            <td valign="middle" align="center">&nbsp;</td>
            <td valign="middle" align="center">&nbsp;</td>
            <td valign="middle" align="center">&nbsp;</td>
            <td valign="middle" align="center">&nbsp;</td>
            <td valign="middle" align="center">&nbsp;</td>
        </tr>-->
<?php foreach ($nilaimulok['data'] as $idx => $item): 
    
            $number_mapel++;
    ?>


            <tr>
                <td align="center" valign="middle"><?php echo $number_mapel; ?></td>
                <td valign="middle"><?php echo $item['mapel_nama']; ?></td>
                <td valign="middle" align="center"><div align="center"><?php echo round($item['kkm']); ?>&nbsp; </div></td>
                <td valign="middle" align="center"><div align="center"><?php
    if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori'])) {
        echo "-";
    } else {
        echo ($item['nas_teori']) ? round($item['nas_teori']) : '';
    }
    ?>&nbsp; </div></td>
                <td valign="middle" align="center"><div align="center" class="style3"><span class="style4">
                        <?php
                        if (is_null($item['nas_teori']) or !is_numeric($item['nas_teori'])) {
                            echo "-";
                        } else {
                            echo int2kata(substr(round($item['nas_teori']), 0, 1)) . " "
							 . int2kata(substr(round($item['nas_teori']), 1, 1))." "
							. int2kata(substr(round($item['nas_teori']), 2, 1));
                        }
                        ?>
                        </span></div></td>
                <td valign="middle" align="center"><div align="center">

    <?php
    if ($item['nas_praktek'] == 0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek'])) {
        echo "-";
    } else {
        echo ($item['nas_praktek']) ? round($item['nas_praktek']) : '-';
    }
    ?>&nbsp; </div></td>
                <td valign="middle" align="center"><div align="center" class="style3">

                        <?php
                        if ($item['nas_praktek'] == 0 or is_null($item['nas_praktek']) or !is_numeric($item['nas_praktek'])) {
                            echo "-";
                        } else {
                            echo int2kata(substr(round($item['nas_praktek']), 0, 1)) . " " 
							. int2kata(substr(round($item['nas_praktek']), 1, 1))." "
							. int2kata(substr(round($item['nas_praktek']), 2, 1));
                        }
                        ?>
                    </div></td>
                <td valign="middle" align="center"><div align="center"><?php echo int2huruf($item['nas_skp']); ?></div></td>
            </tr>

<?php endforeach; ?>
    </table>
    <br/>
    
    
    <table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="3%"><span class="style4">No</span></th>
            <th width="20%"><span class="style4">Aspek Yang Dinilai  </span></th>
            <th width="77%"><span class="style4">Keterangan</span></th>
        </tr>
        <?php
        
		foreach ($this->m_nilai_siswa->dm['kepribadian.ktsp'] as $idx => $label):
			echo '<tr>' . NL;
			echo '<td align="center" valign="middle"><span class="style4">' . ($no++) . '</td>' . NL;
			echo '<td valign="middle"><span class="style4">' . $label . '</td>' . NL;
			echo '<td valign="middle"><span class="style4">' . array_node($kepribadian, $idx) . '</td>' . NL;
			echo '</tr>' . NL;
	
		endforeach;
        ?>
        
    </table>
    <table border="0" style="width: 100%;">
        <tr><td height="10" valign="top" align="left" rowspan="3"></td><tr>
        <tr>
            <td width="29%" align="center" valign="top">
                
                <p class="style6">
                    <br>
                    Orang Tua/Wali<br/>
                    <br/>
                    <br/><br/><br/>
                    .....................			</p>    </td>
            <td width="35%" align="center" valign="top">
                
                <p class="style6">
                    <br>
                    Wali Kelas<br/>
                    <br/>
                    <br/><br/><br/>
<?php
foreach ($resultset['data'] as $idx => $item):
//echo $item['wali_nama'];
endforeach;
echo $item['wali_nama'];
?>
                </p>    </td>
            <td width="36%" align="center" valign="top">
    <p align="right" class="style6">
        Semarang, <?php echo $tgl_cetak_rapor; ?></p>
                <p class="style6">
                    Kepala Sekolah<br/>
                    <br/>
                    <br/><br/><br/>
                    Drs. Sungkowo Prihadi<br />
<!--                    NIP : 196001291986031010			-->
                </p>    </td>
        </tr>
    </table>

</div>

<!-- ===================================================================================== -->

<div id="halaman">
    <?php header_rapor($resultset,$set_semester);?>
    
    <b class="style6">Ketercapaian Kompetensi Siswa </b>

    <table cellspacing="0" cellpadding="7" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
        <tr>
            <th width="4%">No</th>
            <th width="27%">MATA PELAJARAN</th>
            <th width="69%">Keterangan</th>
        </tr>	
<!--        <tr>
            <td align="center" valign="middle"><strong>A</strong></td>
            <td valign="middle"><strong>Mata Pelajaran </strong></td>
            <td valign="middle" align="center">&nbsp;</td>
        </tr>-->
       
<?php 
		$mp_no = 0;

        foreach ($resultset['data'] as $idx => $item):
            $mp_no++;
            echo '<tr>' . NL;
            echo '<td align="center" valign="middle"><span class="style4">{$mp_no}</td>' . NL;
            echo '<td valign="middle"><span class="style4">{$item["mapel_nama"]}</td>' . NL;
            echo '<td valign="middle"><span class="style4">{$item["cat_teori"]}</td>' . NL;
            echo '</tr>' . NL;
        endforeach;
		/*
 $jml_mapel = 0;
foreach ($resultset['data'] as $idx => $item): 
    $jml_mapel++;
    ?>

            <tr>
                <td align="center" valign="middle"><?php echo $idx + 1; ?></td>
                <td valign="middle"><?php echo $item['mapel_nama']; ?></td>
                <td valign="middle" align="left"><div align="center" class="style3">
                        <div align="left"><?php
        if ($item['ketuntasan'] != '' and $item['kompetensi'] != '') {
            echo $item['kompetensi'] ;//. " " . $item['ketuntasan'];
        } else {
            
        }
    ?>&nbsp; </div>
                    </div></td>
            </tr>
                        <?php endforeach; ?>
<!--        <tr>
            <td align="center" valign="middle"><strong>B</strong></td>
            <td valign="middle"><strong>Muatan Lokal </strong></td>
            <td valign="middle" align="left"><div align="left"></div></td>
        </tr>-->
<?php foreach ($nilaimulok['data'] as $idx => $item): 
    $jml_mapel++;
?>
            <tr>
                <td align="center" valign="middle"><?php echo $jml_mapel; ?></td>
                <td valign="middle"><?php echo $item['mapel_nama']; ?></td>
                <td valign="middle" align="left"><div align="center" class="style3">
                        <div align="left"><?php
        if ($item['ketuntasan'] != '' and $item['kompetensi'] != '') {
            echo $item['kompetensi']; // . " " . $item['ketuntasan'];
        } else {
            
        }
    ?>&nbsp; </div>
                    </div></td>
            </tr>

<?php endforeach; */?>
    </table>
    <br>
<?php 

                        $b[1] = ($row['absen_s'] > 0) ? $row['absen_s'] : '-';
                        $b[2] = ($row['absen_i'] > 0) ? $row['absen_i'] : '-';
                        $b[3] = ($row['absen_a'] > 0) ? $row['absen_a'] : '-';

?>
    
    <table width="100%" border="0" class="style6">
        <tr>
            <td width="50">
                <table width="100%" border="1" cellspacing="10" cellpadding="2" style="width:100%;border-collapse: collapse;">
                    <tr>
                        <td  width="70%"  align="center"><div align="center" class="style8"> <strong>Pengembangan Diri</strong></div></td> 
                        <td width="30%" align="center"><div align="center" class="style8" ><B>Nilai</B></div></td> 
                    </tr>
                    
<?php 
//$count
foreach ($presensi['data'] as $idx => $item): ?>
                   
                    
    <!--
        <table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="kecil">
            <tr>
                <th width="3%"><span class="style4">No</span></th>
                <th colspan="2"><span class="style4">Jenis Kegiatan </span></th>
                <th width="62%"><span class="style4">Keterangan</span></th>
            </tr>	<tr>
                <td align="center" valign="middle"><span class="style4"><strong>A</strong></span></td>
                <td colspan="2" valign="middle"><span class="style4"><strong>Kegiatan Extrakurikuler </strong></span></td>
                <td valign="middle" align="center"><span class="style4"></span></td>
            </tr>

            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle">1</td>
                <td valign="middle"><span class="style4"><?php echo ($item['extra1_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra1_kompetensi']); ?></span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle"><span class="style4">2</span></td>
                <td valign="middle"><span class="style4"><?php echo ($item['extra2_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra2_kompetensi']); ?></span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle"><span class="style4">3</span></td>
                <<td valign="middle"><span class="style4"><?php echo ($item['extra3_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['extra3_kompetensi']); ?></span></td>
            </tr>
        		<tr>
                                <td align="center" valign="middle"><span class="style4"></span></td>
                                <td width="3%" align="center" valign="middle">&nbsp;</td>
                            <td valign="middle">&nbsp;</td>
                          <td valign="middle" align="left">&nbsp;</td>
                        </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4"><strong>B</strong></span></td>
                <td colspan="2" valign="middle"><span class="style4"><strong>Kegiatan dalam Organisasi / Kegiatan di Sekolah </strong></span></td>
                <td valign="middle" align="left"><span class="style4"></span></td>
            </tr>

            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle">1</td>
                <td valign="middle"><span class="style4"><?php echo ($item['org1_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['org1_kompetensi']); ?></span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle"><span class="style4">2</span></td>
                <td valign="middle"><span class="style4"><?php echo ($item['org2_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['org2_kompetensi']); ?></span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4"></span></td>
                <td align="center" valign="middle"><span class="style4">3</span></td>
                <td valign="middle"><span class="style4"><?php echo ($item['org3_nama']); ?></span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['org3_kompetensi']); ?></span></td>
            </tr>
                  <tr>
                                  <td align="center" valign="middle"><span class="style4"></span></td>
                                  <td align="center" valign="middle">&nbsp;</td>
                          <td valign="middle"><span class="style4"></span></td>
                <td valign="middle" align="left"><span class="style4"></span></td>
            </tr>
        </table>
        Ketidakhadiran<br />
        <table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;">
            <tr>
                <th width="3%"><span class="style4">No</span></th>
                <th width="35%"><span class="style4">Alasan Ketidakhadiran </span></th>
                <th width="62%"><span class="style4">Keterangan</span></th>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4">1</span></td>
                <td valign="middle"><span class="style4">Sakit</span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_s']); ?> Hari</span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4">2</span></td>
                <td valign="middle"><span class="style4">Izin</span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_i']); ?> Hari</span></td>
            </tr>
            <tr>
                <td align="center" valign="middle"><span class="style4">3</span></td>
                <td valign="middle"><span class="style4">Tanpa Keterangan </span></td>
                <td valign="middle" align="left"><span class="style4"><?php echo ($item['absen_a']); ?> Hari</span></td>
            </tr>
            <tr>
              <td align="center" valign="middle"><span class="style4"> </span></td>
              <td valign="middle"><span class="style4">&nbsp; </span></td>
              <td valign="middle" align="center"><span class="style4"></span></td>
            </tr>
        </table>
        <br/>-->

    <?php 
    $jenis_ekstra1 = ($item['extra1_nama']);
    $jenis_ekstra2 = ($item['extra2_nama']);
    $jenis_ekstra3 = ($item['extra3_nama']);
    
    $nilai_ekstra1 = ($item['extra1_kompetensi']);
    $nilai_ekstra2 = ($item['extra2_kompetensi']);
    $nilai_ekstra3 = ($item['extra3_kompetensi']);
    endforeach; ?>
     
                    <tr>
                        <td width="100%" align="center"> <?php echo cek_null($jenis_ekstra1); ?></td>
                        <td width="100%" align="center"> <?php echo cek_null($nilai_ekstra1); ?></td>
                    </tr>
                              <tr>
                        <td width="100%" align="center"><div align="center" class="style8" ><?php echo cek_null($jenis_ekstra2); ?></div></td>
                        <td width="100%" align="center"><div align="center" class="style8" ><?php echo cek_null($nilai_ekstra2); ?> </div></td>
                    </tr>
                    <tr>
                        <td width="100%" align="center"><div align="center" class="style8" ><?php echo cek_null($jenis_ekstra3); ?></div></td>
                        <td width="100%" align="center"><div align="center" class="style8" ><?php echo cek_null($nilai_ekstra3); ?> </div></td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
            <td width="45%">
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
                                </span>
                            </td>
    <?php } ?>
                    </tr>
                </table>
                <br>
                <br>
            </td>
        </tr>
    </table>
    <br>
        <table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="style6">
            <tr><td height="75" valign="top" align="left"><b>&nbsp;&nbsp;Catatan Wali Kelas : </b>
                    <br/><?php
    $catatan = str_replace("\n", "<br/>", ($item['catatan']));
    echo "&nbsp;&nbsp;".$catatan;
    ?>
                </td></tr>
        </table>
    <?php if ($resultset['data'][0]['semester'] == 'genap') {
				if($kelas_explode[0]!='XII')
				{
        ?>
            <table cellspacing="0" cellpadding="3" border="1" style="width:100%;border-collapse: collapse;" class="style6">
                <tr><td height="30" valign="top" align="left">
                        <table>
                            <tr>
                                <td align="right"><b>&nbsp;Keterangan : </b> NAIK / TIDAK NAIK</td>
                                
                            </tr>
        <?php
				}
				
			if ($item['kelas_tingkat'] == 10) {
            ?>
<!--                                <tr>
                                    <td align="right">Program</td>
                                    <td><span style="text-transform:uppercase;">: <?php echo ($item['kenaikan_program']); ?></span></td>
                                </tr>-->
        <?php } ?>
                        </table>
                    </td></tr>
                <tr><td height="10" valign="top" align="left"></td><tr>
            </table>
    <?php } ?>
    <table border="0" style="width: 100%;">
        <tr>
            <td width="29%" align="center" valign="top">
                
                <p class="style6">
                    <br>
                    Orang Tua/Wali<br/>
                    <br/>
                    <br/><br/><br/>
                    .....................			</p>    </td>
            <td width="35%" align="center" valign="top">
                
                <p class="style6">
                    <br>
                    Wali Kelas<br/>
                    <br/>
                    <br/><br/><br/>
<?php
foreach ($resultset['data'] as $idx => $item):
//echo $item['wali_nama'];
endforeach;
echo $item['wali_nama'];
?>
                </p>    </td>
            <td width="36%" align="center" valign="top">
    <p align="right" class="style6">
        Semarang, <?php echo $tgl_cetak_rapor; ?></p>
                <p class="style6">
                    Kepala Sekolah<br/>
                    <br/>
                    <br/><br/><br/>
                    Drs. Sungkowo Prihadi<br />
<!--                    NIP : 196001291986031010			-->
                </p>    </td>
        </tr>
    </table>

</div>

<?php }?>
<?php 
//print_r($presensi);
//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
//print_r($item);
//echo "<br>";
?>