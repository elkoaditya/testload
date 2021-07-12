<?php

//$tanggal_rapor = '13 Juni 2015';
//$ket_sekolah['tanggal_rapor'] = '19 Desember 2015';
if($row["kelas_grade"]==12)
{
	$ket_sekolah['tanggal_rapor'] = '7 Mei 2016';
	$ket_sekolah['tanggal_mutasi'] = '9 Mei 2016';
}else{
	$ket_sekolah['tanggal_rapor'] = '17 Juni 2016';
}
$ket_sekolah['cetak_sekolah_nama'] = "SMA Negeri 9 Semarang";
$ket_sekolah['cetak_sekolah_alamat'] = "Jalan Taman Menteri Supeno No.1 <br/>Semarang 50243";
$ket_sekolah['cetak_sekolah_kepsek_nama'] = "Drs. Wiharto, M.Si";
$ket_sekolah['cetak_sekolah_kepsek_nip']= "NIP. 19631003 198803 1 009";
//$ket_sekolah['explode_kelas'] = explode(".", $row["kelas_nama"]);
$ket_sekolah['explode_kelas'] = explode(" ", $row["kelas_nama"]);
if (($ket_sekolah['explode_kelas'][0] == "X") || ($ket_sekolah['explode_kelas'][0] == "x"))
{
	$ket_sekolah['set_naik_kelas'] = "XI (Sebelas)";
	$ket_sekolah['set_tinggal_kelas']= "X (Sepuluh)";
}
else
{

	$ket_sekolah['set_naik_kelas'] = "XII (Dua Belas)";
	$ket_sekolah['set_tinggal_kelas'] = "XI (Sebelas)";
}
function set_header_rapor($data , $ket_sekolah, $row) {
	?>
	<table width="100%" border="0" style="width: 100%;">
		<tr>
		  <td width="23%"	valign="top"><span class="style1">Nama Peserta Didik</span> </td>
		  <td width="1%"	valign="top"><span class="style1">:</span></td>
		  <td width="35%" 	valign="top"><span class="style1"><em><?php echo $data['siswa_nama']; ?></em></span></td>
		  
		  <td width="21%" valign="top"><span class="style1">Kelas/Semester</span></td>
		  <td width="1%" valign="top"><span class="style1">:</span></td>
		  <td width="19%" valign="top"><span class="style1" style="text-transform:uppercase;"><?php echo $data['kelas_nama']; ?>/
		  <?php if($row['semester_nama']=='gasal'){	echo"1(satu)";	}else{	echo"2(dua)";	}  ?></span></td>
		</tr>
		<tr>
		  <td valign="top"><span class="style1">Nomor Induk</span> </td>
		  <td valign="top"><span class="style1">:</span></td>
		  <td valign="top"><span class="style1"><?php echo $data['siswa_nis']; ?></span> </td>
		  
		  <td valign="top"><span class="style1">Tahun Pelajaran</span></td>
		  <td valign="top"><span class="style1">:</span></td>
		  <td valign="top"><span class="style1"><?= str_replace("/"," - ",$row['ta_nama']) ?></span></td>
		  
		</tr>
		<tr>
		  <td valign="top"><span class="style1">Nama Sekolah</span> </td>
		  <td valign="top"><span class="style1">:</span></td>
		  <td colspan="4" valign="top"><span class="style1"><?=$ket_sekolah['cetak_sekolah_nama']?></span> </td>
		  
		</tr>
	</table>
<?php
}




function sikap($nilai_sosial, $nilai_spiritual, $deskripsi_sikap_sosial, $deskripsi_sikap_spiritual)
{
?>
    <!-- Sikap -->
    <div class="thead-1"><b>1.Sikap Spiritual</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>
			<?php
			//echo $nilai_spiritual[1]." ". $nilai_spiritual[2]." ". $nilai_spiritual[3]."<br/>";
			if(($nilai_spiritual[1]>=$nilai_spiritual[2])&&($nilai_spiritual[1]>=$nilai_spiritual[3])){
            	echo $deskripsi_sikap_spiritual[1];
			}elseif(($nilai_spiritual[2]>=$nilai_spiritual[1])&&($nilai_spiritual[2]>=$nilai_spiritual[3])){
            	echo $deskripsi_sikap_spiritual[2];
			}elseif(($nilai_spiritual[3]>=$nilai_spiritual[1])&&($nilai_spiritual[3]>=$nilai_spiritual[2])){	
				echo $deskripsi_sikap_spiritual[3];
			}
			?>
            </td>
        </tr>
	  </table>
      <br/>
    <div class="thead-1"><b>2.Sikap Sosial</b></div>
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="80px"> Deskripsi:
            <br/>
			<?php
			//echo $nilai_sosial[1]." ". $nilai_sosial[2]." ". $nilai_sosial[3]."<br/>";
			if(($nilai_sosial[1]>=$nilai_sosial[2])&&($nilai_sosial[1]>=$nilai_sosial[3])){
            	echo $deskripsi_sikap_sosial[1];
			}elseif(($nilai_sosial[2]>=$nilai_sosial[1])&&($nilai_sosial[2]>=$nilai_sosial[3])){
            	echo $deskripsi_sikap_sosial[2];
			}elseif(($nilai_sosial[3]>=$nilai_sosial[1])&&($nilai_sosial[3]>=$nilai_sosial[2])){	
				echo $deskripsi_sikap_sosial[3];
			}
			?>
            </td>
        </tr>
	  </table>
<?php
}

function ekstrakurikuler($ekskul_result)
{
?>
    <!-- Ekstrakurikuler -->
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Kegiatan Ekstrakurikuler</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>
        
        <?php

        foreach ($ekskul_result['data'] as $_idx => $_row)
        {
            $nisixk['nilai'] = strtoupper($_row['nilai']);

            if (strpos($nisixk['nilai'], 'A') !== false)
            {
                $set_ekskul_keterangan = 'Sangat Baik';
            }
            elseif (strpos($nisixk['nilai'], 'B') !== false)
            {
                $set_ekskul_keterangan = 'Baik';
            }
            else
            {
                $set_ekskul_keterangan = 'Kurang';
            }
            
            echo '<tr>' . NL;
			echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . ($_idx + 1) . ".</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">{$_row['ekskul_nama']}</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['nilai']}. {$set_ekskul_keterangan}</td>" . NL;
            echo '</tr>' . NL;
        }

        if (count($ekskul_result['data']) == 0)
        {
            echo '<tr>' . NL;
			echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            echo '</tr>' . NL;
        }
        ?>
        

    </table>
<?php
}

function prestasi($prestasi_result)
{
?>
    <!-- Prestasi -->
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td  class="t-border field-nilai color-menu" align="center" valign="middle" width="20px"> <b>NO</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width="30%"> <b>Jenis Prestasi</b></td>
            <td  class="t-border field-nilai color-menu" align="center" valign="middle" width=> <b>Keterangan</b></td>
        </tr>

        <?php
		$cetak_prestasi=0;
		$no=0;
        foreach ($prestasi_result['data'] as $_idx => $_row)
        {
			if($_row['prestasi_nama']!='')
			{
				$cetak_prestasi=1;
				$no++;
				echo '<tr>' . NL;
				echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >" . $no . "</td>" . NL;
				echo "<td class=\"t-border field-nilai\" valign=\"top\" width=\"200\">{$_row['kegiatan_prestasi_nama']}</td>" . NL;
				echo "<td class=\"t-border field-nilai\" valign=\"top\">{$_row['prestasi_nama']}</td>" . NL;
				echo '</tr>' . NL;
			}
        }

        if ($cetak_prestasi==0)
        {
            echo '<tr>' . NL;
			echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"right\" >-</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\" align=\"center\">-</td>" . NL;
            echo "<td class=\"t-border field-nilai\" valign=\"top\">-</td>" . NL;
            echo '</tr>' . NL;
        }

        ?>
    </table>
<?php
}

function ketidakhadiran($ketidakhadiran)
{
?>
	<table cellspacing="0" class="t-border field-nilai" width="50%" >
        
        <tr>
            <td width="50%" class=" field-nilai">Sakit</td>
            <td class="t-border field-nilai"> : <?php echo ($ketidakhadiran['absen_s'] > 0) ? "{$ketidakhadiran['absen_s']} hari" : "- hari"; ?></td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Ijin</td>
            <td class="t-border field-nilai"> : <?php echo ($ketidakhadiran['absen_i'] > 0) ? "{$ketidakhadiran['absen_i']} hari" : "- hari"; ?></td>
        </tr>
        <tr>
            <td class="t-border field-nilai">Tanpa Keterangan</td>
            <td class="t-border field-nilai"> : <?php echo ($ketidakhadiran['absen_a'] > 0) ? "{$ketidakhadiran['absen_a']} hari" : "- hari"; ?></td>
        </tr>
    </table>
<?php
}

function catatan_walikelas($siswa_nama , $nilai_catatan_walikelas,$row,$ekskul_result)
{
	if ((strtolower($row["semester_nama"]) == "genap"))
	{
		$keterangan_walikelas = array(
	
			'1' =>	$siswa_nama.' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
					
			'2' =>	$siswa_nama.' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik dalam meraih cita - citamu.',
				
			'3' => $siswa_nama.' berusahalah lebih keras dan tetap semangat untuk meraih cita - citamu.',	
		);
	
	}else{
	
		$keterangan_walikelas = array(
	
			'1' =>	$siswa_nama.' pertahankan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
					
			'2' =>	$siswa_nama.' tingkatkan prestasimu dan tetap semangat untuk melakukan yang terbaik di semester depan.',
				
			'3' => $siswa_nama.' berusahalah lebih keras dan tetap semangat untuk meraih hasil yang lebih baik.',	
		);
	
	}
	
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '50px';
	}else{
		$height = '65px';
	}
?>
    <!-- Catatan Walikelas -->
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="<?php echo $height;?>"> Deskripsi:
            <br/><?php 
			if($nilai_catatan_walikelas>=90)
				echo $keterangan_walikelas['1'];
			elseif($nilai_catatan_walikelas>=80)
				echo $keterangan_walikelas['2'];
			else
				echo $keterangan_walikelas['3'];
			?></td>
        </tr>
	  </table>
<?php
}


function tanggapan_ortu($ekskul_result)
{
	$jumlah_ekskul =0;
	foreach ($ekskul_result['data'] as $_idx => $_row)
    {
		$jumlah_ekskul++;
	}
	if($jumlah_ekskul>3){
		$height = '35px';
	}else{
		$height = '65px';
	}
?>
    <!-- Tanggapan Ortu -->
      <table cellspacing="0" class="t-border" width="100%" >
        <tr>
        	<td class="t-border field-nilai" align="left" valign="top" height="<?php echo $height;?>"></td>
        </tr>
	  </table>
      <?php if($jumlah_ekskul>3){?>
     
      <?php }else{ ?>
      <br/><br/>
	  <?php }?>
<?php
}

function head_table_nilai()
{
?>
	<tr>
        <td class="thead-1 t-border color-menu" rowspan="2" width="20px"><b>NO</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>Mata Pelajaran</b></td>
        <td class="thead-1 t-border color-menu" rowspan="2" ><b>KKM</b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Pengetahuan </b></td>
        <td class="thead-1 t-border color-menu" colspan="3"><b>Keterampilan </b></td>
        
    </tr>

    <tr>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        <td class="field-nilai thead-1 t-border color-menu" ><b>Angka</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="32px"><b>Pred</b></td>
        <td class="field-nilai thead-1 t-border color-menu" width="190px"><b>&nbsp;Deskripsi&nbsp;</b></td>
        
    </tr>
<?php
}
?>
<style>
            @page
            {
                size: 210mm 297mm;
                margin: 3mm 10mm 0mm 10mm;
                margin-header: 10mm;
                margin-footer: 15mm;
                header: html_header_1;
                footer: html_footer_pagenum;
            }
            .page-notend{
                page-break-after: always;
            }

			.field-header
            {
				/*font-size:14px;*/
				padding: 2px 0px 2px 0px;
            }
			
            .content, .content *, td
            {
                font-size: 10px;
            }

            .foot-text
            {
                font-size: 10px;
                font-style: italic;
            }

            .t-border
            {
                border-width: 1px;
                border-style: solid;
                border-color: black;
                border-collapse: collapse;

            }

            #t-nilai
            {
                width: 100%;
            }

            .thead-1{
                vertical-align: middle;
                text-align: center;
				font-size:12px;
            }

			.field-nilai
            {
				font-size:11px;
                padding: 4px 5px 4px 5px;
            }

            .field-nilai2
            {
				font-size:11px;
                padding: 4px 7px 4px 7px;
            }
			
			.field-keluar
            {
				padding: 8px 5px 8px 5px;
            }
			
            #ttd tr td{
                font-size: 12px;
            }
			.sub-kategori{
                font-size: 12px;
            }
			.color-menu{
				background-color:#FFEEDE;
			}
			.style1 {font-size: 14px}
        </style>
<?php
//print_r($id_nilai_siswa['data']);
foreach($id_nilai_siswa['data'] as $cetak)
{
	$jumlah_rapor--;
	$row_per_siswa=$cetak;
	
	$resultset 			= $resultset_array[$cetak['id']];
	$ekskul_result 		= $ekskul_result_array[$cetak['id']];
	$prestasi_result 	= $prestasi_result_array[$cetak['id']];
	$org_result 		= $org_result_array[$cetak['id']];
	
		
$deskripsi_sikap_spiritual = array(

		'1' =>	'Sangat baik, '.$row_per_siswa["siswa_nama"].' selalu berdoa saat awal dan akhir kegiatan belajar , '.
				'selalu memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut '.
				'serta senantiasa menghormati orang lain dalam menjalankan ibadah sesuai dengan agamanya.',
				
		'2' =>	'Baik, '.$row_per_siswa["siswa_nama"].' mengawali dan mengakhiri kegiatan belajar dengan berdoa, '.
				'memberi salam pada saat awal dan akhir presentasi sesuai agama yang dianut.',
			
		'3' => '',	
	);


$deskripsi_sikap_sosial = array(

		'1' =>	'Sangat baik, '.$row_per_siswa["siswa_nama"].' selalu percaya diri dalam mengerjakan ujian / ulangan , '.
				'selalu tertib dan patuh pada peraturan , selalu rajin dan bertanggung jawab dalam tugas - tugasnya , '.
				'selalu santun terhadap guru - guru dan teman - teman , selalu sopan dalam menyampaikan pendapat dan '.
				'selalu dapat bekerja sama dalam suatu tim.',
				
		'2' =>	'Baik, '.$row_per_siswa["siswa_nama"].' memiliki percaya diri dalam mengerjakan ujian / ulangan , '.
				'tertib dan patuh pada peraturan , mampu bertanggung jawab dalam tugas tugasnya , '.
				'bersikap santun terhadap guru - guru dan teman - teman , mampu menyampaikan pendapat dengan sopan.',
				
		'3' => '',
	);
?>
        
   
    
    

    <htmlpageheader name="header_1">

        

    </htmlpageheader>

    
    
    <htmlpagefooter name="footer_pagenum">
        <div id="footer_pagenum" class="footer">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="foot-text">
						<?php 
						//echo $row['siswa_nis'] . "-" . $row['kelas_nama'];
						echo $row['kelas_nama']; ?>
                    </td>
                    <td class="foot-text" align="right">
                       <!-- Hal. {PAGENO}-->
                       <?php echo "Semeter ".$row['semester_nama']." - ".$row["ta_nama"];?>
                    </td>
                </tr>
            </table>
        </div>
    </htmlpagefooter>
    
    <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			<?php set_header_rapor($row_per_siswa, $ket_sekolah,$row); ?>
        </div>
        
        <div class="sub-kategori"><b>CAPAIAN HASIL BELAJAR</b></div>
        
        <?php //print_r($deskripsi_pelajaran['data']);
				$mp_no = 0;
                $ktg_ascii = 64;
                $ktg_nama = NULL;
                $jml_row = 0;
    			$nilai_catatan_walikelas = 100;
				
				// NILAI SOSIAL DAN SPIRITUAL
				for($x=1;$x<=3;$x++)
				{
					$nilai_sosial[$x]		= 0;
					$nilai_spiritual[$x]	= 0;
				}
				
                foreach ($resultset['data'] as $idx => $item)
                {
					if(($item['pred_sikap']=='A')||($item['pred_sikap']=='a')||($item['pred_sikap']=='SB')||($item['pred_sikap']=='sb')){
						$nilai_sosial[1]++;
						$nilai_spiritual[1]++;
					}elseif(($item['pred_sikap']=='B')||($item['pred_sikap']=='b')){
						$nilai_sosial[2]++;
						$nilai_spiritual[2]++;
					}elseif(($item['pred_sikap']=='C')||($item['pred_sikap']=='c')){
						$nilai_sosial[3]++;
						$nilai_spiritual[3]++;
					}
					
                    if ($item['kategori_nama'] != $ktg_nama){
                        $ktg_nama = $item['kategori_nama'];
                        $jml_row++;
                    }
                    $jml_row++;
                }
				
				//nilai sikap BK
				if(($row["nilai_sikap_bk"]=='A')||($row["nilai_sikap_bk"]=='a')||($row["nilai_sikap_bk"]=='SB')||($row["nilai_sikap_bk"]=='sb')){
					$nilai_sosial[1]++;
					$nilai_spiritual[1]++;
				}elseif(($row["nilai_sikap_bk"]=='B')||($row["nilai_sikap_bk"]=='b')){
					$nilai_sosial[2]++;
					$nilai_spiritual[2]++;
				}elseif(($row["nilai_sikap_bk"]=='C')||($row["nilai_sikap_bk"]=='c')){
					$nilai_sosial[3]++;
					$nilai_spiritual[3]++;
				}
				//nilai sikap WALI
				if(($row["nilai_sikap_wali"]=='A')||($row["nilai_sikap_wali"]=='a')||($row["nilai_sikap_wali"]=='SB')||($row["nilai_sikap_wali"]=='sb')){
					$nilai_sosial[1]++;
					$nilai_spiritual[1]++;
				}elseif(($row["nilai_sikap_wali"]=='B')||($row["nilai_sikap_wali"]=='b')){
					$nilai_sosial[2]++;
					$nilai_spiritual[2]++;
				}elseif(($row["nilai_sikap_wali"]=='C')||($row["nilai_sikap_wali"]=='c')){
					$nilai_sosial[3]++;
					$nilai_spiritual[3]++;
				}
				
				
		?>
		<table>
         <tr>
          <td class="sub-kategori" width="20px"><b>A.</b></td>
          <td class="sub-kategori"><b>Sikap</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<?php sikap($nilai_sosial, $nilai_spiritual, $deskripsi_sikap_sosial, $deskripsi_sikap_spiritual);?>
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>B.</b></td>
          <td class="sub-kategori"><b>Pengetahuan dan Keterampilan</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	<!-- NILAI PENGETAHUAN DAN SIKAP -->
            <table cellspacing="0" id="t-nilai" class="t-border" >
    
                <?php head_table_nilai();?>
    
                <?php
    
                $ktg_nama = NULL;
                $antr_mapel = 0;
                foreach ($resultset['data'] as $idx => $item)
                {
    
                    if ($item['kategori_nama'] != $ktg_nama)
                    {
    
                        $ktg_ascii++;
                        $mp_no = 0;
    
                        echo '<tr>' . NL;
    
                        if ($item['kategori_kode'] == "KelC")
                        {
    
                            $minat = (strstr($row['kelas_nama'], "MIPA") !== FALSE) ? "Matematika dan Ilmu Pengetahuan Alam" : "Ilmu Pengetahuan Sosial";
    
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                            echo "</tr><tr>
                            <td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>I</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>Peminatan {$minat}</b></td>" . NL;
                        }
                        else if ($item['kategori_kode'] == 'KelD')
                        {
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"><b>II</b></td>
                            <td class=\"field-nilai t-border\" valign=\"top\" colspan=\"8\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else if ($ktg_nama != NULL)
                        {
							?>
                                    </tr>
                                </table>                                
                              </td>
                            </tr>
      </table>
      </div>
      <div id="bg_deskripsi" class="content page-notend">
    	<style>
            #profil-siswa tr td{
                font-size: 12px;
            }
        </style>

        <div id="header_1" class="header">
			<?php set_header_rapor($row_per_siswa, $ket_sekolah,$row); ?>
        </div>
      <table>
                            <tr>
                              <td class="sub-kategori" width="20px"></td>
                              <td class="sub-kategori">
                            	<table cellspacing="0" id="t-nilai" class="t-border" >
    							
                				 <?php head_table_nilai();?>
    								<tr>
                                
							<?php
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"9\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                        }
                        else
                        {
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" colspan=\"2\"><b>" . $item['kategori_nama'] . "</b></td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
							echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" ></td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" > </td>" . NL;
                            
                        }
                        echo '</tr>' . NL;
    
                        $ktg_nama = $item['kategori_nama'];
                    }
    
                    $mp_no++;
    
                    echo '<tr>' . NL;
                    echo "<td class=\"field-nilai t-border\" align=\"right\" valign=\"top\">{$mp_no}.</td>" . NL;
                    echo "<td class=\"field-nilai t-border\" valign=\"top\">{$item['mapel_nama']}<br><b>{$item['guru_nama']}<b></td>" . NL;
					
					if($mode_range==100)
    				{	$cetak_kkm = 75;	}
					elseif($mode_range==4)
					{	$cetak_kkm = 2.67;	}
					echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\"> ".$cetak_kkm." </td>" . NL;
    				
    
                    // PENGETAHUAN /////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_teori'])
                    {
                        
                        if ($item['nas_teori']>0)
                        {
                            if($mode_range==100)
							{	$cetak_nas_teori = round($item['nas_teori']);	}
							elseif($mode_range==4)
                            {	$cetak_nas_teori = round(($item['nas_teori']/25),2);	}
							
							if( ( (
								(($item['mapel_id']=='10')||($item['mapel_id']=='1'))
								&&($item['kategori_kode'] == "KelA"))
								||($item['kategori_kode'] == "KelC")) 
								&&($nilai_catatan_walikelas > $item['nas_teori']))
							{	$nilai_catatan_walikelas = $item['nas_teori'];	}
							
							echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_teori ."</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_teori'] . "</td>" . NL;
                        }
                        else
                        {
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        }
                    }
                    else
                    {
                        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    }
					
					//////// DESKRIPSI PENGETAHUAN //////////////////
					$cetak_des = 0;
					foreach ($deskripsi_pelajaran['data'] as $deskripsi)
					{
						if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 1) )
						{
							if(	( $item['pred_teori']=='A' && $deskripsi['kode']==1 )||
								( $item['pred_teori']=='B' && $deskripsi['kode']==2 )||
								( $item['pred_teori']=='C' && $deskripsi['kode']==3 )||
								( $item['pred_teori']=='D' && $deskripsi['kode']==4 )	)
							{							
								if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
								{
									$cetak_des = 1;
									echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
						echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
					}
					
    
                    // KETRAMPILAN //////////////////////////////////////////////////////////////////////////////////////////////////////////
                    $cetak_nilai = 0;
                    if ($item['nipel_praktek'])
                    {
                        
                        if ($item['nas_praktek']>0)
                        {
                            if($mode_range==100)
							{	$cetak_nas_praktek = round($item['nas_praktek']);	}
							elseif($mode_range==4)
                            {	$cetak_nas_praktek = round(($item['nas_praktek']/25),2);	}
							
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $cetak_nas_praktek . "</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\" >" . $item['pred_praktek'] . "</td>" . NL;
                        }
                        else
                        {
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                            echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        }
                    }
                    else
                    {
                        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                        echo "<td class=\"field-nilai t-border\" valign=\"top\" align=\"center\">-</td>" . NL;
                    }
    
                    //////// DESKRIPSI KETRAMPILAN //////////////////
				    $cetak_des = 0;
					foreach ($deskripsi_pelajaran['data'] as $deskripsi)
					{
						if (($deskripsi['mapel_id'] == $item['mapel_id']) && ($deskripsi['kategori_id'] == $item['kategori_id']) && ($deskripsi['grade'] == $row['kelas_grade']) && ($deskripsi['aspek_penilaian_id'] == 2) )
						{
							if(	( $item['pred_praktek']=='A' && $deskripsi['kode']==1 )||
								( $item['pred_praktek']=='B' && $deskripsi['kode']==2 )||
								( $item['pred_praktek']=='C' && $deskripsi['kode']==3 )||
								( $item['pred_praktek']=='D' && $deskripsi['kode']==4 )	)
							{
								if ((($deskripsi['agama_id'] != 0) && ($deskripsi['agama_id'] == $item['nipel_agama_id'])) || ($deskripsi['agama_id'] == 0))
								{
									$cetak_des = 1;
									echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">{$deskripsi['deskripsi']}</td>" . NL;
								}
							}
						}
					}
					if ($cetak_des == 0)
					{
						echo "<td class=\"field-nilai2 t-border\" valign=\"top\" align=\"left\">-</td>" . NL;
					}

    
                    echo '</tr>' . NL;
                    $jml_row++;
                }
    
                ?>
    
            </table>
            
       
		  </td>
         </tr>
      </table>
     </div>
     <!------------------- PAGE 2 -->
     <?php 
	 if( ($jumlah_rapor>0)or(($ket_sekolah['explode_kelas'][0]=="XII")||($ket_sekolah['explode_kelas'][0]=="xii")) )
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div id="bg_nilai" >';
	?>
     <div id="header_1" class="header">
		<?php set_header_rapor($row_per_siswa, $ket_sekolah,$row); ?>
    </div>
     <!-- -->
	   <table>   
         <tr>
          <td class="sub-kategori"><b>C.</b></td>
          <td class="sub-kategori"><b>Ekstra Kurikuler</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  <?php ekstrakurikuler($ekskul_result); ?>
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>D.</b></td>
          <td class="sub-kategori"><b>Prestasi</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  <?php prestasi($prestasi_result); ?>
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>E.</b></td>
          <td class="sub-kategori"><b>Ketidakhadiran</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  <?php ketidakhadiran($row_per_siswa); ?>
          		<br/><br/>
          </td>
         </tr>
         
         <tr>
          <td class="sub-kategori"><b>F.</b></td>
          <td class="sub-kategori"><b>Catatan Wali Kelas</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  <?php catatan_walikelas($row_per_siswa["siswa_nama"],$nilai_catatan_walikelas,$row,$ekskul_result); 
			  ?>
          		<br/><br/>
          </td>
         </tr>
       
         <tr>
          <td class="sub-kategori"><b>G.</b></td>
          <td class="sub-kategori"><b>Tanggapan Orang tua/Wali</b></td>
         </tr>
         <tr>
          <td></td>
          <td>
          
          	  <?php tanggapan_ortu($ekskul_result); ?>
          		
          </td>
         </tr>
         
        </table>
        <br/>
        
        <table id="ttd" border="0" style="width: 100%;">
        <tr>
        	<td width="18px"></td>
        	<td valign="top" width="40%">
            	Mengetahui:<br/>
            	Orang Tua/Wali,
				<br/><br/><br/><br/><br/>

				...............................
            </td>
            <td width="200px"></td>
            <td valign="top">
                Semarang, <?php echo $ket_sekolah['tanggal_rapor']; ?><br/>
					Wali Kelas
					<p>
						<br/><br/><br/><br/>
						<?php

						$jml_kata_walikelas_nama = strlen($row['wali_nama']);
						$jml_kata_walikelas_nip = strlen($row['wali_nip']) + 5;

						if ($jml_kata_walikelas_nama > $jml_kata_walikelas_nip)
						{
							$for_kata_walikelas_nama = 0;
							$for_kata_walikelas_nip = $jml_kata_walikelas_nama - $jml_kata_walikelas_nip;
						}
						else
						{
							$for_kata_walikelas_nama = $jml_kata_walikelas_nip - $jml_kata_walikelas_nama;
							$for_kata_walikelas_nip = 0;
						}

						?>

						<?php

						echo "<u>" . $row['wali_nama'] . "</u>";

						?>

						<br/>
						NIP : <?php

						echo $row['wali_nip'];


						?>
					</p></b>
				<br>

			</td>
           </tr>
           <tr>
            
            <td colspan="2"></td>
			<td colspan="3">
				<table>
					<tr>
						<td style="padding:20px;width: 100%;" >
							<?php

							if ((strtolower($row["semester_nama"]) == "genap")&& 
							(($ket_sekolah['explode_kelas'][0]=="X")||($ket_sekolah['explode_kelas'][0]=="x")||
							($ket_sekolah['explode_kelas'][0]=="XI")||($ket_sekolah['explode_kelas'][0]=="xi")))
							{

								?>
								<b>Keputusan:</b> 
								<br>
								Berdasar hasil yang dicapai pada <br>
								semester 1 dan 2, peserta didik ditetapkan <br>
								<?php
								/* if(($ket_sekolah['explode_kelas'][0]=="XII")||($ket_sekolah['explode_kelas'][0]=="xii")){ ?>
                                <br>dinyatakan <b>LULUS</b> <br>
								<?php }else{ */?>
                                naik ke kelas <?php echo $ket_sekolah['set_naik_kelas']; ?> <br>
								tinggal di kelas <?php echo $ket_sekolah['set_tinggal_kelas']; ?> <br>
                                <?php // } ?>
								<br>
                              <?php } else
							  {	echo "<br><br>";}?>  
                                Mengetahui,<br/>
                                Kepala Sekolah
                                <br><br><br><br>
                                <?php echo "<u>" . $ket_sekolah['cetak_sekolah_kepsek_nama'] . "</u>"; ?><br>
                                <?php echo $ket_sekolah['cetak_sekolah_kepsek_nip']; ?>
                                
							
							
						</td>
					</tr>
				</table>
			</td>
            <td></td>
		</tr>
	</table>
     </div>
  <?php if(($ket_sekolah['explode_kelas'][0]=="XII")||($ket_sekolah['explode_kelas'][0]=="xii")){    
    
	 if($jumlah_rapor>0)
	 	echo '<div id="bg_deskripsi" class="content page-notend">';
	 else
	 	echo '<div id="bg_nilai" >';
	?>
   	<div style="font-size:16px;" align="center"><b>KETERANGAN PINDAH SEKOLAH</div><br/><br/>
     <div id="header_1" class="header">
		<?php set_header_rapor($row_per_siswa, $ket_sekolah,$row); ?>
     </div>
     <br/>
     <table cellspacing="0" class="t-border" width="100%" >
      <tr>
      	<td class="thead-1 t-border color-menu field-keluar" colspan="4" align="center"> KELUAR</td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border color-menu field-keluar" align="center" width="120px"> Tanggal </td>
       <td class="thead-1 t-border color-menu field-keluar" align="center" width="130px"> Kelas yang Ditinggalkan </td>
       <td class="thead-1 t-border color-menu field-keluar" align="center" width="140px"> Sebab-sebab Keluar atau Atas Permintaan (Tertulis) </td>
       <td class="thead-1 t-border color-menu field-keluar" align="center" > Tanda Tangan Kepala Sekolah, Stempel Sekolah, dan Tanda Tangan Orang Tua/Wali</td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border" align="center" valign="middle" height="400px" ><?php echo $ket_sekolah['tanggal_rapor']; ?></td>
       <td class="thead-1 t-border" align="center" valign="middle" ><?php echo $row["kelas_nama"]?></td>
       <td class="thead-1 t-border" align="center" valign="middle" > LULUS </td>
       <td class="thead-1 t-border" valign="middle" >
       
       <table width="100%">
        <tr>
         <td width="80px"></td>
         <td class="thead-1 " align="left">
               Semarang, <?php echo $ket_sekolah['tanggal_mutasi']; ?>
               <br>
               Kepala Sekolah
                <br><br><br><br><br><br>
                <?php echo "<u>" . $ket_sekolah['cetak_sekolah_kepsek_nama'] . "</u>"; ?><br>
                <?php echo $ket_sekolah['cetak_sekolah_kepsek_nip']; ?>
         </td>
        </tr>
        <tr>
         <td></td>
         <td class="thead-1 " align="left">       
                <br/><br/><br/><br/><br/><br/><br/><br/>
                
                Orang Tua/Wali,
                <br><br><br><br><br><br>
        
                ...............................
        
         </td>
        </tr>
        </table>
        
       </td>
      </tr>
     </table>
   </div>
  
<?php
	}
 }
 ?>