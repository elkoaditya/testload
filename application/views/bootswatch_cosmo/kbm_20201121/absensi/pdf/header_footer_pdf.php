<?php

function header_sekolah($sekolah, $evaluasi)
{
	$evaluasi['tipe'] = strtoupper(str_replace("_"," ",$evaluasi['tipe']));
	if($sekolah=='sma_terbang')
		header_sekolah_sma_terbang($evaluasi);
	elseif($sekolah=='sma_setiabudhi')
		header_sekolah_sma_setiabudhi($evaluasi);
	elseif($sekolah=='sman8smg')
		header_sekolah_sman9smg($evaluasi);
	elseif($sekolah=='sman9smg')
		header_sekolah_sman8smg($evaluasi);
	elseif($sekolah=='sman14smg')
		header_sekolah_sman14smg($evaluasi);
	elseif($sekolah=='smk_penerbangan')
		header_sekolah_smk_penerbangan($evaluasi);
	elseif($sekolah=='sma_michael')
		header_sekolah_sma_michael($evaluasi);
	
}

function header_sekolah_sma_terbang($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/sma-terang-bangsa.png',
					'width' => 80,
				);
				//echo img($logo2);
				
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma-terang-bangsa.png" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_sman8smg($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
					'width' => 80,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/sma8.jpg" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_sman9smg($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
					'width' => 80,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/SMAN_9_Semarang.jpg" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_sman14smg($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
					'width' => 80,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/logo-sman14-smg.png" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> TRY OUT UN<br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_sma_setiabudhi($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
					'width' => 80,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/logo_setiabudhi.png" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_smk_penerbangan($evaluasi)
{
	?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php 
				$logo2 = array(
					'src' => 'images/logo/'.APP_SCOPE.'/logo_setiabudhi.png',
					'width' => 80,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/smk-penerbad.png" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    LEMBAR SOAL <?php echo $evaluasi['tipe'];?> <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran <?php echo $evaluasi['ta_nama'];?> <br/>
                </div>
                <div id="head-1">
                    <?php echo TITLE_LOGIN;?><br/>
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

function header_sekolah_sma1($evaluasi)
{
?>
<div id="header-rapor" class="t-border2">
	<table border="0" cellspacing="0" width="100%">
        <tr>
            <td width="12%">
                <?php /*
                $logo = array(
                    'src' => 'content/sma1_smg/Logo Dinas Pend.jpg',
                    'width' => 80,
                    'height' => 104,
                );
                echo img($logo);*/
				$logo2 = array(
					'src' => 'content/sma1_smg/Logo SMA1.jpg',
					'width' => 70,
					'height' => 106,
				);
				//echo img($logo2);
                ?><img src="<?=APP_ROOT?>/images/logo/<?=APP_SCOPE?>/Logo SMA1.jpg" width="80" />&nbsp;
            </td>
            <td align="left" >
                <div id="head-1">
                    TRY OUT UNBK TINGKAT SEKOLAH 1 <br/>
                </div>
                <div id="head-2">
                    Tahun Pelajaran 2015/2016<br/>
                </div>
                <div id="head-1">
                    SMA NEGERI 1 SEMARANG<br/>
                </div>
                <div id="head-3">
                Jalan Taman Menteri Supeno No.1 Semarang 50243<br/>
                Telp.(024)8310447 - 8318539 Fax.(024)8414851 E-mail : sma1semarang@yahoo.co.id
                </div>
        </td>
        </tr>
    </table>
</div>
<?php
}

// FOOTER
function footer_sekolah($evaluasi)
{
	$evaluasi['tipe'] = strtoupper(str_replace("_"," ",$evaluasi['tipe']));?>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td colspan="2" width="100%" valign="top" style="border-top:solid; border-top-width:6; padding-top:-8"><strong><hr></strong></td>
        </tr>
        <tr>
            <td class="foot-text">
                <!-- USBK <?=$evaluasi['mapel_nama']?> -->
                <?=$evaluasi['tipe'];?> <?=$evaluasi['mapel_nama']?>

            </td>
            <td class="foot-text" align="right">
                Halaman {PAGENO}
            </td>
        </tr>
    </table>
<?php
}

?>