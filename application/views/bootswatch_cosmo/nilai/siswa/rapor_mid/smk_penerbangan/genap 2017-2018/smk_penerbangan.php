<?php
//$tanggal_cetak_rapor = "13 Juni 2015";
$tanggal_cetak_rapor = $row['tanggal_mid_nama'];

function int2huruf($n) {
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
    <!--
	@page {
	 	/* POLIO*/
        sheet-size: 210mm 330mm ;
        margin: 60px 30 5px 30px;
    }

    .page-notend{
        page-break-after: always;
    }
    .style7 {font-size: 11px; font-weight: bold; }
    .style8 {font-size: 11px}
    .style11 {font-size: 12px}
    .style14 {
        font-size: 14px;
    }
    .style24 {
        font-size: 24px;
        font-weight: bold;
    }
    .style17 {font-size: 24px}
    .style18 {font-size: 36px}
    .style19 {font-size: 28px}

    .t-border{
        border-width: 1px;
        border-style: solid;
        border-color: black;
        border-collapse: collapse;
        padding: 2px 5px 2px 5px;

    }
    .t-grey-background{
        background-color:#999999;

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
    .thead-3{
        vertical-align: top;
        text-align: center;
    }
    .field-nilai
    {
        font-size: 12px;
        padding: 7px 12px 7px 7px;
    }
    .f-kompetensi{
        font-size: 12px;
        padding: 3px 7px;
    }


    #header-rapor{
        text-align: center;
        font-family: Arial;
        font-size: 120%;
    }
    .t-siswa tr td{
        padding: 2px 5px 2px 2px;
    }

	.t-siswa2 tr td{
        padding: -2px -5px -2px -5px;
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

    .tx-ekskul{
        font-size: 12px;

    }
    .backgrounds{

       /* background-image: url("<?php echo base_url('images/logo/smk-penerbad-bw.png'); ?>");*/
	    background-image: url("http://<?=URL_MASTER;?>/images/logo/<?=APP_SCOPE?>/smk-penerbad-bw.png");
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
        /*
        opacity: 0.4;
        position: absolute;
        z-index: -1;
        */
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
	 	echo '<div id="bg_deskripsi" class="content page-notend backgrounds">';
	 else
	 	echo '<div class="page backgrounds" id="page-1" >';	
?>	

<!--<div class="backgrounds">-->
    <?php
    $height_table_judul_1 = 10;
    $width_komponen1 = 250;
    $width_komponen2 = 30;

    $set_type_rapor = 0;
    $set_rapor_page = "";

    if ($set_type_rapor == 0) {
        $set_rapor_page = "page-notend";
    }

    $for_header = "<br/><br/><br/><br/><br/><br/>";
    $set_sekolah_nama = "SMK Penerbangan Kartika Aqasa Bhakti";
    $set_sekolah_alamat = "Jalan Jembawan Raya 20 A Semarang";
    $set_sekolah_nss = "562036314001";
    $set_sekolah_kepsek = "Mukar S.Pd.";
    
    $set_bidang_studi = "Teknologi dan Rekayasa";
    $set_program_studi = "Teknologi Pesawat Udara";
	$wali_nama = $row['wali_nama'];
	
	$set_program_keahlian="";
	if( (strpos($row['kelas_nama'], 'AP') !== false) or (strpos($row['kelas_nama'], 'AFP') !== false))
    {
		$set_program_keahlian = 'Airframe dan Powerplant';
	}
	elseif(strpos($row['kelas_nama'], 'KPU') !== false)
    {
		$set_program_keahlian = 'Kelistrikan Pesawat Udara';
	}
	
	$set_header_siswa = '
 <table border="0" class="t-siswa style14" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td valign="top" width="165px">
                Nama Peserta Didik
            </td>
            <td valign="top" width="5px"> : </td>
            <td valign="top" width="255px">
                ' . $row_per_siswa['siswa_nama'] . '
            </td>

            <td valign="top" width="100px">
                Nomor Induk
            </td>
            <td valign="top" width="5px"> : </td>
            <td valign="top">
                ' . $row_per_siswa['siswa_nis'] . '
            </td>
        </tr>
        <tr>
            <td valign="top">
                Bidang Studi Keahlian
            </td>
            <td valign="top"> : </td>
            <td valign="top">
		' . $set_bidang_studi . '
            </td>
           
			
			<td valign="top" rowspan="2">
                Program Keahlian
            </td>
            <td valign="top" rowspan="2"> : </td>
            <td valign="top" rowspan="2">
                ' . $set_program_keahlian . '
            </td>
        </tr>
        <tr>

            <td valign="top">
                Program Studi Keahlian
            </td>
            <td valign="top"> : </td>
            <td valign="top">
				' . $set_program_studi . '
            </td>

            
        </tr>

        <tr>

            <td valign="top">
                Tahun Pelajaran
            </td>
            <td valign="top"> : </td>
            <td valign="top">
                ' . $row['ta_nama'] . '
            </td>

            <td valign="top">
                Kelas/Semester
            </td>
            <td valign="top"> : </td>
            <td valign="top">
                ' . $row['kelas_nama'] . ' /  ' . strtoupper($row['semester_nama']) . '
            </td>
        </tr>
    </table>';
//print_r($resultset['data'][0]);

    if ($set_type_rapor == 1) {
        ?>
        <div class="page page-notend" id="page-1">

            <div id="header-rapor">

                <div class="font7">
                    <b>
                        LAPORAN
                        <br/>
                        HASIL BELAJAR
                        <br/>
                        SEKOLAH MENENGAH KEJURUAN
                    </b>
                </div>

                <br/><br/>
                <?php
                $logo = array(
                    'src' => '/images/logo/smk-penerbad.png',
                    'width' => 600,
                    'height' => 550,
                );
                echo img($logo);
                ?>
                &nbsp;

                <br/><br/><br/><br/><br/>

                <div class="font4">
                    YAYASAN KARTIKA JAYA
                </div>

                <div class="font6">
                    <b> <?php echo strtoupper($set_sekolah_nama); ?> </b>
                </div>

                <div class="font2">
                    Status : Swasta Terakreditasi B NIS.400180 NSS.562036314001 NPSN. 20328943 <br/>
                    <?php echo $set_sekolah_alamat; ?> 50145 Telepon/Fax (024) 7617708 <br/>
                    Website : www.smkpenerbangansemarang.com <br/>
                    Email : smk_penerbangan_smg@yahoo.co.id
                </div>

            </div>
        </div>

        <div class="page page-notend" id="page-2">
            <table width="100%" height="100%" border="1">
                <tr>
                    <td  align="center">

                        <?php
                        $logo2 = array(
                            'src' => '/images/logo/smk-penerbad.png',
                            'width' => 150,
                            'height' => 120,
                        );
                        echo img($logo2);
                        ?>
                        &nbsp;

                        <br/><br/><br/><br/><br/>

                        <div class="font4">

                            <b>
                                LAPORAN HASIL BELAJAR
                                <br/>
                                SEKOLAH MENENGAH KEJURUAN
                                <br/>
                                (SMK)
                            </b>
                        </div>

                        <br/><br/>

                        <table width="100%" height="100%" border="0">
                            <tr>
                                <td>Bidang Studi Keahlian</td>
                                <td>:</td>
                                <td><?php echo $set_bidang_studi; ?></td>
                            </tr>
                            <tr>
                                <td>Program Studi Keahlian</td>
                                <td>:</td>
                                <td><?php echo $set_program_studi; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Sekolah</td>
                                <td>:</td>
                                <td><?php echo strtoupper($set_sekolah_nama); ?> Semarang</td>
                            </tr>
                            <tr>
                                <td>NSS</td>
                                <td>:</td>
                                <td><?php echo $set_sekolah_nss; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat Sekolah</td>
                                <td>:</td>
                                <td><?php echo $set_sekolah_alamat; ?></td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>:</td>
                                <td>Semarang Barat</td>
                            </tr>
                            <tr>
                                <td>Kabupaten/Kota</td>
                                <td>:</td>
                                <td>Semarang</td>
                            </tr>
                            <tr>
                                <td>Provinsi</td>
                                <td>:</td>
                                <td>Jawa Tengah</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

        </div>

    <?php } ?>
    <br/>

    <?php
	if($row['kelas_grade'] < 12){
		echo '<table width="100%"><tr><td align="center"><h2>RAPORT PENILAIAN TENGAH SEMESTER</h2></td></tr></table>';
    }else{
		echo '<table width="100%"><tr><td align="center"><h2>RAPORT TENGAH SEMESTER</h2></td></tr></table>';
    }
	echo $set_header_siswa;
    //print_r($resultset['data'][4]);
    ?>


    <?php
	
    $mp_no = 0;
    $ktg_ascii = 64;
    $ktg_nama = NULL;
    $jml_row = 0;

    $jml_judul_pel = 0;
    $jml_judul_per_pel = 0;
    $type_judul_sementara = "";

    foreach ($resultset['data'] as $idx => $item):

        if ($item['kategori_nama'] != $ktg_nama):
            $ktg_nama = $item['kategori_nama'];
            $jml_row++;
        endif;

        $jml_row++;

    endforeach;

    $ktg_nama = NULL;
    $antr_mapel = 0;
    $jml_mapel[1] = 0;
    $keseluruhan_rata2nilai = 0;
    $no_judul_mapel = 0;
	$kur_baru=0;
	if($row['kurikulum_nama']==2017){
		$kur_baru=1;
	}
    foreach ($resultset['data'] as $idx => $item):
        $no_judul_mapel++;
//$asdasfasfas++;
//        if ($type_judul_sementara != $item['mapel_kategori']) {
//            $type_judul_sementara = $item['mapel_kategori'];
//            $jml_judul_pel++;
//            $jml_mapel[$jml_judul_pel] = 0;
//            $mapel_jenis_nilai[$jml_judul_pel] = 0;
//        }
//
//        if ($type_judul_sementara == $item['mapel_kategori']) {
//            $jml_mapel[$jml_judul_pel] ++;
//        }
//echo $type_judul_sementara." - ".$item['mapel_kategori']. " + ".$item['mapel_nama']." + ". $asdasfasfas."___". $jml_judul_pel."<br>";
//        $mapel_jenis[$jml_judul_pel] = $this->m_mapel->kategori_label($item['mapel_kategori']);
        $mapel_jenis[$no_judul_mapel] = $item['kategori_nourut'];
        $mapel_kategori[$no_judul_mapel] = $item['kategori_nama'];

        $mapel_nama[$no_judul_mapel] = $item['mapel_nama'];
		if($row['kelas_grade']==12){
			$mapel_kkm[$no_judul_mapel] = round(75, 0);
		}else{
			$mapel_kkm[$no_judul_mapel] = round(70, 0);
		}
        $mapel_nilai[$no_judul_mapel] = round($item['mid_teori'], 0);

        ////////// RENTANG PREDIKAT ////////////////
        if ($mapel_kategori[$no_judul_mapel] == "pdk") {
            // 100 - 70
            if ($mapel_nilai[$no_judul_mapel] >= 70) {
                $mapel_predikat[$no_judul_mapel] = "Kompeten";
            } else { // 69-0
                $mapel_predikat[$no_judul_mapel] = "Belum Kompeten";
            }
        } else {
            // 100 - 90
            if ($mapel_nilai[$no_judul_mapel] >= 90) {
                $mapel_predikat[$no_judul_mapel] = "Amat Baik";
            } else if ($mapel_nilai[$no_judul_mapel] >= 75) { // 89-75
                $mapel_predikat[$no_judul_mapel] = "Baik";
            } else if ($mapel_nilai[$no_judul_mapel] >= 60) { // 74-60
                $mapel_predikat[$no_judul_mapel] = "Cukup";
            } else { // 59-0
                $mapel_predikat[$no_judul_mapel] = "Kurang";
            }
        }

        //$mapel_rata_kelas[$no_judul_mapel] = round($rerata_mapel_kelas[$item['mapel_id']]['data'][0]['rerata_nas_ppk'], 0);
		$mapel_rata_kelas[$no_judul_mapel] = round($rerata[$item['pelajaran_id']], 0);
        //$mapel_kompetensi[$no_judul_mapel] = $item['cat_teori'];

//        $mapel_jenis_nilai[$no_judul_mapel] += $mapel_nilai[$no_judul_mapel];

    endforeach;
    $max_mapel = 0;
    if ($no_judul_mapel != 0) {
        $max_mapel = max($mapel_jenis);
    }
    ?>
    <table cellspacing="0" id="t-nilai" class="t-border" >
        <tr>
            <td  class="thead-2 t-border">No</td>
            <td  class="thead-2 t-border">Mata Pelajaran</td>
            <td  class="thead-2 t-border"> (KKM) </td>
            <td  class="thead-2 t-border"> NILAI</td>
            <td  class="thead-2 t-border"> PREDIKAT </td>
            <td  class="thead-2 t-border"> RATA KELAS </td>
        </tr>
        <?php
        $set_classs_grey = "class=' t-border t-grey-background'";
        $set_classs = "class=' t-border '";
        $set_classs1 = "class='thead-1 t-border'";
        $set_classs2 = "class='thead-2 t-border'";
        $set_classs3 = "class='thead-3 t-border'";
        $set_classs4 = "class=' t-border'";
        $keseluruhan_rata2nilai = 0;
        $no_kategori = 0;
        for ($set_a = 1; $set_a <= $max_mapel; $set_a++) {
            $jml_row = 0;
            for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++) {
                if ($mapel_jenis[$set_b] == $set_a) {
                    $mapel_array[$set_a] = $mapel_kategori[$set_b];
                    $jml_row++;
                }
            }
            if ($jml_row != 0) {
                $no_kategori++;
				if($kur_baru == 1){
					if($no_kategori ==3){
						echo "<tr>";
						echo "<td colspan=6 >";
						echo "<b>C. Muatan Peminatan Kejuruan</b>";
						echo "</td>";
						echo "</tr>";
					}
				}
                echo "<tr>";
				
				
				if($kur_baru == 1){
					echo "<td colspan=6 " . $set_classs_grey . " >";
				}else{
					echo "<td rowspan=" . ($jml_row + 1) . " " . $set_classs3 . " >";
					echo "<b>" . $no_kategori . "</b>";
					echo "</td>";
					echo "<td colspan=5 " . $set_classs_grey . " >";
				}
                echo "<b>" . $mapel_array[$set_a] . "</b>";
                echo "</td>";
                echo "</tr>";
                $no_mapel = 0;
                $no_mapel_nilai = 0;
                for ($set_b = 1; $set_b <= $no_judul_mapel; $set_b++) {
                    if ($mapel_jenis[$set_b] == $set_a) {
                        $no_mapel++;

                        //    for ($set_b = 1; $set_b <= $jml_mapel[$set_a]; $set_b++) {$mapel_jenis

                        echo "<tr>";
                        //echo "<td " . $set_classs . " width='50%' >";
                      //  echo "<table class='t-siswa2' width='100%'><tr><td width='6%' valign='top'> &nbsp;".$no_mapel . ". </td>";
						//echo "<td>" . $mapel_nama[$set_b]."</td></tr></table>";
						
                       // echo "</td>";
						if($kur_baru == 1){
							echo "<td " . $set_classs1 . " >";
							echo $no_mapel.". ";
							echo "</td>";
							echo "<td " . $set_classs4 . " width='47%'>";
							echo $mapel_nama[$set_b];
							echo "</td>";
						}else{ 
							echo "<td " . $set_classs . " width='50%' >";
							echo "<table class='t-siswa2' width='100%'><tr><td width='6%' valign='top'> &nbsp;".$no_mapel . ". </td>";
							echo "<td>" . $mapel_nama[$set_b]."</td></tr></table>";
						
							echo "</td>";
						}
                        echo "<td " . $set_classs1 . " >";
                        echo $mapel_kkm[$set_b];
                        echo "</td>";
                        echo "<td " . $set_classs1 . " >";
                        echo $mapel_nilai[$set_b];
                        echo "</td>";
                        echo "<td " . $set_classs1 . " >";
                        echo $mapel_predikat[$set_b];
                        echo "</td>";
                        echo "<td " . $set_classs1 . " >";
                        echo $mapel_rata_kelas[$set_b];
                        echo "</td>";
                        echo "</tr>";
                        $no_mapel_nilai += $mapel_nilai[$set_b];
                        //}
                    }
                }

                echo "<tr>";
                echo "<td " . $set_classs . " >";
                //echo "<b>" . $set_a . "</b>";
                echo "</td>";
                echo "<td " . $set_classs1 . " >";
                echo "<b>RATA - RATA</b>";
                echo "</td>";
                echo "<td " . $set_classs1 . " >";
                // echo $mapel_kkm[$set_a][$set_b];
                echo "</td>";
                echo "<td " . $set_classs1 . " >";
                $rata_mapel = round(($no_mapel_nilai / $no_mapel), 0);
                echo $rata_mapel;
                echo "</td>";
                echo "<td " . $set_classs1 . " >";
                // echo $mapel_predikat[$set_a][$set_b];
                echo "</td>";
                echo "<td " . $set_classs1 . " >";
                //echo $mapel_rata_kelas[$set_a][$set_b];
                echo "</td>";
                echo "</tr>";

                if ($set_a == 3) {
                    $keseluruhan_rata2nilai += (2 * $rata_mapel);
                } else {
                    $keseluruhan_rata2nilai += $rata_mapel;
                }
            }
        }
        echo "</table>";
        ?>
        <br/>
        <?php if($row['kelas_grade']!=10){?>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="40%"></td>
                <td width="50%" class="t-border">Nilai Prestasi Rata-Rata (I + II + 2 III + IV ) / 5 </td>
                <td width="5%" class="t-border" align="center"> <?php echo ($keseluruhan_rata2nilai / 5); ?></td>
                <td width="5%"></td>
            </tr>
        </table>
        <?php }else{?>
        <br/>
        <?php }?>
        <tr>
            <td></td>
        </tr>
    </table>
    <?php
//    print_r($resultset['data']);
    ?>
    <!--<table cellspacing="0" id="t-nilai" class="t-border" >
        <tr>
            <td colspan="2" class="thead-1 t-border"> &nbsp; Pengetahuan/Kognitif &nbsp; </td>
            <td colspan="2" class="thead-1 t-border"> &nbsp; Praktek/Motorik &nbsp;</td>
            <td class="thead-1 t-border"> &nbsp; Afeksi &nbsp; </td>
        </tr>
        <tr>
            <td class="thead-1 t-border">Angka</td>
            <td class="thead-1 t-border">Huruf</td>
            <td class="thead-1 t-border">Angka</td>
            <td class="thead-1 t-border">Huruf</td>
            <td class="thead-1 t-border">Huruf</td>
        </tr>
    <?php
    $mp_no = 0;

    foreach ($resultset['data'] as $idx => $item):

        $mp_no++;
        echo '<tr>' . NL;
        echo "<td class=\"field-nilai t-border\" valign=\"top\">{$mp_no}</td>" . NL;
        echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}</td>" . NL;
        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . round($item['nipel_kkm']) . "</td>" . NL;

        // ppk

        if ($item['nipel_teori']):
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . round($item['nas_teori']) . "</td>" . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><i>" . formnil_huruf($item['nas_teori']) . "</i></td>" . NL;

        else:
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

        endif;

        // prk

        if ($item['nipel_praktek']):
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . round($item['nas_praktek']) . "</td>" . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><i>" . formnil_huruf($item['nas_praktek']) . "</i></td>" . NL;

        else:
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;

        endif;

        // sikap

        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">" . ($item['nas_sikap']) . "</td>" . NL;

        echo '</tr>' . NL;
    endforeach;
    ?>
    
        <tr>
            <td class="t-border" rowspan="3" colspan="4" align="center" valign="middle">Ketidakhadiran</td>
            <td class="t-border" colspan="2">&nbsp; 1. <i>Sakit</i></td>
            <td class="t-border" align="center"> <?php echo ($row['absen_s'] > 0) ? $row['absen_s'] : '-'; ?></td>
            <td class="t-border">&nbsp; Hari</td>
        </tr>
        <tr>
            <td class="t-border" colspan="2">&nbsp; 2. <i>Ijin</i></td>
            <td class="t-border" align="center"> <?php echo ($row['absen_i'] > 0) ? $row['absen_i'] : '-'; ?></td>
            <td class="t-border">&nbsp; Hari</td>
        </tr>
        <tr>
            <td class="t-border" colspan="2">&nbsp; 3. <i>Tanpa Keterangan</i></td>
            <td class="t-border" align="center"> <?php echo ($row['absen_a'] > 0) ? $row['absen_a'] : '-'; ?></td>
            <td class="t-border">&nbsp; Hari</td>
        </tr>
    </table>-->
    <br/>

    <table border="0" style="width: 100%;">
        <tr>
            <td valign="bottom" align="center" style="width: 35%;">
                <p><br/>
                    Mengetahui,<br/>
                    Kepala SMK Penerbangan<br/>
                    Kartika Aqasa Bhakti
                </p>
            </td>
            <td valign="bottom" align="center" style="width: 30%;">
                <p>
                    Nama Orangtua/Wali Siswa<br/><br/><br/>
                </p>
            </td>


            <td valign="bottom" align="center" style="width: 35%;">
                <p>
                    Semarang, <?=$tanggal_cetak_rapor?><br/><br/>
                    Wali Kelas<br/><br/><br/>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="bottom" align="center">
                <p>
                    <br/><br/><br/><br/>
<?php echo $set_sekolah_kepsek; ?>
                </p>
            </td>
            <td valign="bottom" align="center">
                <p>
                    <br/><br/><br/><br/>
                    ...................................
                </p>
            </td>


            <td valign="bottom" align="center">
                <p>
                    <br/><br/><br/><br/>
<?php echo $wali_nama; ?>
                </p>
            </td>
        </tr>
    </table>

</div>
<?php }
///print_r($row);
?>

<!--
<p align="right" class="style11">
    Semarang, <?php echo tgl_indo(date('d-m-Y')); ?></p>


<table border="0" style="width: 100%;">
    <tr>
        <td width="26%" align="center" valign="top">
            <p class="style11">
                Orang Tua/Wali<br/>
                Peserta Didik<br/>
                <br/><br/><br/>
                .....................	<?= $jml_judul_pel ?>		</p>    </td>
        <td width="48%" align="center" valign="top">
            <p class="style11"><br/>
                <br/>
                <br/><br/><br/>
            </p>    </td>
        <td width="26%" align="center" valign="top">
            <p class="style11">Wali Kelas<br/>
                <br/>
                <br/><br/><br/>
                .....................	  </p>    </td>
    </tr>
</table>
</div>-->