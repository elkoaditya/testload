<?php 
$ket_sekolah['tanggal_rapor'] = '17 Juni 2016';

$ket_sekolah['cetak_sekolah_nama'] = "SMA Negeri Semarang";
$ket_sekolah['cetak_sekolah_alamat'] = "Jalan - Semarang ";
$ket_sekolah['cetak_sekolah_kepsek_nama'] = "-";
$ket_sekolah['cetak_sekolah_kepsek_nip']= "NIP. -";

if (APP_DOMAIN == 'localhost'):
		$title ='SEKOLAH MENENGAH ATAS ';

	elseif (APP_SUBDOMAIN == 'sma-setiabudhi.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS SETIABUDHI';
		
	elseif (APP_SUBDOMAIN == 'sman8-smg.fresto.co'):
		$ket_sekolah['tanggal_rapor'] = '17 Juni 2016';

		$ket_sekolah['cetak_sekolah_nama'] = "SMA Negeri 8 Semarang";
		$ket_sekolah['cetak_sekolah_alamat'] = "Jalan Raya Tugu <br/>Semarang";
		$ket_sekolah['cetak_sekolah_kepsek_nama'] = "Poniman Slamet S.Pd, M.Kom";
		$ket_sekolah['cetak_sekolah_kepsek_nip']= "NIP. 19740604 199903 1007";
		
	elseif (APP_SUBDOMAIN == 'sman9-smg.fresto.co'):
		$ket_sekolah['tanggal_rapor'] = '17 Juni 2016';

		$ket_sekolah['cetak_sekolah_nama'] = "SMA Negeri 9 Semarang";
		$ket_sekolah['cetak_sekolah_alamat'] = "Jalan Cemara Raya Padangsari Banyumanik <br/>Semarang 50267";
		$ket_sekolah['cetak_sekolah_kepsek_nama'] = "Dr. Siswanto M. Pd. ";
		$ket_sekolah['cetak_sekolah_kepsek_nip']= "NIP. 19660608 199512 1 001";
		
	elseif (APP_SUBDOMAIN == 'sman14-smg.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS NEGERI 14';
		
	elseif (APP_SUBDOMAIN == 'smaterbang.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS TERANG BANGSA';
		
	elseif (APP_SUBDOMAIN == 'smamichael.smg.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS SANTO MICHAEL';
	
	elseif (APP_SUBDOMAIN == 'smk-penerbangan.smg.fresto.co'):
		$title ='SEKOLAH MENENGAH KEJURUAN KARTIKA AQASA BHAKTI';
		
	elseif (APP_SUBDOMAIN == 'smknusaputera1.fresto.co'):
		$title ='SEKOLAH MENENGAH KEJURUAN NUSA PUTERA 1';	
		
	elseif (APP_SUBDOMAIN == 'demo.fresto.co'):
		$title ='SEKOLAH MENENGAH ATAS ANDALUS';
		
	endif;


$ket_sekolah['set_semester'] = "1 (Satu)";
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
if ((strtolower($row["semester_nama"]) == "genap"))
{
	$ket_sekolah['set_semester'] = "2 (Dua)";
}

function set_header_rapor($ket_sekolah, $row) {
	echo '<table id="profil-siswa" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">

				<tr>
					<td class="field-header" valign="top" width="20%"><b>Nama Sekolah</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" width="40%" >
						<b>' . $ket_sekolah['cetak_sekolah_nama'] . '</b>
					</td>

					<td class="field-header" valign="top" width="20%"><b>Kelas</b></td>
					<td class="field-header" valign="top" width="2%"><b> : </b></td>
					<td class="field-header" valign="top" width="16%">
                        <b>' . $row["kelas_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Alamat</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $ket_sekolah['cetak_sekolah_alamat'] . '</b>
					</td>
					<td class="field-header" valign="top"><b>Semester</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $ket_sekolah['set_semester'] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nama Peserta Didik</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . strtoupper($row["siswa_nama"]) . '</b>
					</td>
					<td class="field-header" valign="top"><b>Tahun Pelajaran</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["ta_nama"] . '</b>
					</td>
				</tr>
				<tr>
					<td class="field-header" valign="top"><b>Nomor Induk/NISN</b></td>
					<td class="field-header" valign="top"><b> : </b></td>
					<td class="field-header" valign="top"><b>
                                         ' . $row["siswa_nis"] . ' / ' . $row["siswa_nisn"] . '</b>
					</td>
					<td valign="top"> </td>
					<td valign="top">   </td>
					<td valign="top">

					</td>
				</tr>
			</table><br/><br/>';
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
				font-size:12px;
				padding: 3px 0px 3px 0px;
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
			
			.t-border-left
			{
				border-left:solid; 
				border-left-width:1;
			}
			
			.t-border-right
			{
				border-right:solid; 
				border-right-width:1;
			}
			
			.t-border-bottom
			{
				border-bottom:solid; 
				border-bottom-width:1;
			}

            #t-nilai
            {
                width: 100%;
            }

            .thead-1{
                vertical-align: top;
                text-align: left;
				font-size:12px;
				padding: 4px 8px 4px 8px;
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
        </style>
    
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
                       <?php echo "Semeter ".$ket_sekolah['set_semester']." - ".$row["ta_nama"];?>
                    </td>
                </tr>
            </table>
        </div>
    </htmlpagefooter>
   
   
   <div id="bg_nilai" >
   	<div style="font-size:16px;" align="center"><b>KETERANGAN PINDAH SEKOLAH</div><br/><br/>
     <div id="header_1" class="header">
		<?php set_header_rapor($ket_sekolah,$row); ?>
     </div>
     <br/>
     <table cellspacing="0" class="t-border" width="100%" >
      <tr>
      	<td class="thead-1 t-border color-menu field-keluar" align="center"> NO. </td>
        <td class="thead-1 t-border color-menu field-keluar" colspan="3" align="center"> MASUK</td>
      </tr>
      
      
      <?php
	  $no=1;
	  ?>
      <tr>
       <td class="thead-1 t-border-left t-border-right"  width="20px"><?php echo $no; $no++; ?>. </td>
       <td class="thead-1 t-border-right"  width="28%"> Nama Siswa</td>
       <td class="thead-1 t-border-right"  width="35%" > <?php echo strtoupper($row["siswa_nama"]);?> </td>
       <td class="thead-1 t-border-right t-border-bottom" rowspan="7" >
       
       <table width="100%">
        <tr>
         <td width="5px"></td>
         <td class="thead-1 " align="left">
               Semarang, <?php echo $ket_sekolah['tanggal_rapor']; ?>
               <br>
               Kepala Sekolah
                <br><br><br><br><br>
                <?php echo "<u>" . $ket_sekolah['cetak_sekolah_kepsek_nama'] . "</u>"; ?><br>
                <?php echo $ket_sekolah['cetak_sekolah_kepsek_nip']; ?>
         </td>
        </tr>
        </table>
        
       </td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right" ><?php echo $no; $no++; ?>. </td>
       <td class="thead-1 t-border-right" > Nomor Induk</td>
       <td class="thead-1 t-border-right" > <?php echo $row["siswa_nis"];?> </td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right" ><?php echo $no; $no++; ?>. </td>
       <td class="thead-1 t-border-right" > Nama Sekolah</td>
       <td class="thead-1 t-border-right" > <?php echo $ket_sekolah['cetak_sekolah_nama'];?> </td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right"  ><?php echo $no; $no++; ?>. </td>
       <td class="thead-1 t-border-right" > Masuk di Sekolah ini:</td>
       <td class="thead-1 t-border-right" >  </td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right" ></td>
       <td class="thead-1 t-border-right" > a. Tanggal</td>
       <td class="thead-1 t-border-right" >  <?php echo tanggal($row["siswa_masuk_tgl"]);?></td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right" > </td>
       <td class="thead-1 t-border-right" > b. DiKelas</td>
       <td class="thead-1 t-border-right" >  <?php echo $row['kelas_diterima_nama']; ?></td>
      </tr>
      
      <tr>
       <td class="thead-1 t-border-left t-border-right t-border-bottom" ><?php echo $no; $no++; ?>. </td>
       <td class="thead-1 t-border-right t-border-bottom" > Tahun Pelajaran</td>
       <td class="thead-1 t-border-right t-border-bottom" > <?php echo $row["ta_nama"];?> </td>
      </tr>
      
     </table>
   </div>