<?php

$img_sample = array(
	"1.jpg",
	"2.jpg",
	"3.jpg",
	"4.jpg",
	"5.jpg",
	"6.jpg",
);
$warna=array(
		'class="btn bgm-cyan"', 
		'class="btn bgm-teal"',
		'class="btn bgm-amber"',
		'class="btn bgm-orange"',
		'class="btn bgm-deeporange"',
		'class="btn bgm-red"',
		'class="btn bgm-pink"',
		'class="btn bgm-lightblue"',
		'class="btn bgm-indigo"',
		'class="btn bgm-lime"',
		'class="btn bgm-lightgreen"',
		'class="btn bgm-green"',
		'class="btn bgm-purple"',
		'class="btn bgm-deeppurple"',
		);
		
// pills link
$menu_atas_kiri = '<div class="col-sm-5">';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi_soal/browse?evaluasi_id='.$row["id"].'" id="back" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5" title="kembali ke daftar evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Daftar Evaluasi </a>';

$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi/id/'.$row["id"].'" id="detail" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5" title="kembali ke detail evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Detail Evaluasi </a>';

$menu_atas_kiri .= '</div>';

/*	
$pills_kiri['evaluasi_browse'] = array(
		'label' => 'Daftar Evaluasi',
		'uri' => "kbm/evaluasi",
		'attr' => 'title="kembali ke daftar evaluasi"',
);
$pills_kiri['evaluasi_id'] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$evaluasi['id']}",
		'attr' => 'title="kembali ke detail evaluasi"',
);*/

$menu_atas_kanan = '<div class="col-sm-7" align="right">';

if ($user['role'] == 'siswa'):
	
	/*		
	$pills_kanan = array(
			'jawab' => array(
					'label' => '<i class="icon-pencil"></i> Coba Lagi',
					'uri' => "kbm/evaluasi_ljs/form?id={$evaluasi['id']}",
					'attr' => 'title="beri catatan pada ini"',
					'class' => 'disabled',
			),
	);*/
	if($pengerjaan_ljs['id']):
		$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/form?id='.$row["id"].'" id="jawab" 
				class="btn btn-success btn-sm m-b-5 m-r-5" title="beri catatan pada ini" ><i class="zmdi zmdi-edit"></i> Teruskan Pengerjaan </a>';
	else:
	
		//if ($siswa_ybs && $evaluasi['#available']):
		if ($siswa_ybs):
			if(( $pengerjaan_ljs['id']) || ( $evaluasi['#available'] && !$pengerjaan_ljs['id'])):
				$menu_atas_kanan .= '<span id="jawab" 
					class="btn btn-success btn-sm m-b-5 m-r-5 disabled" title="beri catatan pada ini" ><i class="zmdi zmdi-edit"></i> Coba Lagi </span>';
			else:
				$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/form?id='.$row["id"].'" id="jawab"  
					class="btn btn-success btn-sm m-b-5 m-r-5" title="beri catatan pada ini" ><i class="zmdi zmdi-edit"></i> Coba Lagi </a>';
			endif;
		endif;
		
	endif;	

else:
/*				
	$pills_kanan = array(
			'koreksi' => array(
					'label' => '<i class="icon-ok"></i> Koreksi',
					'uri' => "kbm/evaluasi_ljs/koreksi?id={$row['id']}",
					'attr' => 'title="koreksi poin jawaban ini"',
					'class' => 'disabled',
			),
	);

	$pills_kanan['roleback'] = array(
					'label' => '<i class="icon-repeat"></i> Roleback Pengerjaan ',
					'uri' => "kbm/evaluasi_ljs/roleback?id={$row['id']}",
					'attr' => 'title="roleback pengerjaan siswa ini" onclick="return confirm(\'APAKAH ANDA YAKIN UNTUK ROLEBACK PERJAKAAN INI?\')"',
					'class' => 'disabled',
	);
*/	
	if (($admin OR $author_ybs) && $evaluasi['semester_id'] == $semaktif['id'] && !$evaluasi['closed']):
		//$pills_kanan['koreksi']['class'] = 'active';
		//$pills_kanan['roleback']['class'] = 'active';
		$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/roleback?id='.$row["id"].'" id="roleback" 
				class="btn btn-warning btn-sm m-b-5 m-r-5" title="beri catatan pada ini" >
				<i class="zmdi zmdi-refresh-alt"></i> Roleback Pengerjaan </a>';
	else:			
		$menu_atas_kanan .= '<span  id="roleback" 
				class="btn btn-warning btn-sm m-b-5 m-r-5 disabled" title="beri catatan pada ini" >
				<i class="zmdi zmdi-refresh-alt"></i> Roleback Pengerjaan </span>';
	endif;


endif;

$pills_kanan[] = array(
		'label' => '<i class="icon-print"></i> Cetak',
		'uri' => "kbm/evaluasi_ljs/id/{$row['id']}?pdf=true",
		'attr' => 'title="cetak lembar jawaban ini"',
		'class' => 'active',
);

$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/id/'.$row["id"].'?pdf=true" id="print" 
				class="btn btn-info btn-sm m-b-5 m-r-5" title="beri catatan pada ini" >
				<i class="zmdi zmdi-print"></i> Cetak PDF </a>';

$menu_atas_kanan .= '</div>';				
// tabel data

$dset['Nama'] = array('siswa_nama');
$dset['Kelas'] = 'kelas_nama';

// HIDDEN NILAI
//$dset['Nilai'] = array('nilai');

if ($user['role'] != 'siswa' OR $evaluasi['closed'])
	$dset['Skor Poin'] = array(
			'poin',
			'suffix' => array(
					' / ',
					'poin_max',
			),
	);


// pesan

if ($siswa_ybs && !$evaluasi['closed'])
	alert_info('Untuk informasi poin skor dan kunci (pilihan ganda) tiap butir soal menunggu evaluasi ditutup.');
	
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Lembar Jawab Soal')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header" >
                <h2 id="title_page">Lembar Jawab Siswa Evaluasi</h2>
            </div>
			
            <style>
				.controls{
					font-size: 1.2em;
					margin: 0.2em 0;
					color: black;
				}
				.pengecoh{
					display: none;
				}
			</style>
            
			<div class="card" id="ljs">
                <div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
							class='lgi-img' 
							src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						&nbsp;";
						echo a("kbm/evaluasi/id/".$evaluasi['id'], $evaluasi['nama'], 'id="title_materi" title="lihat evaluasi" '.$warna[array_rand($warna)]);
						echo (($evaluasi['published']) ? '' : ' <div style="color:red">(Belum Dipublikasikan)</div>'); ?></b>
                        <small><ul class='lgi-attrs'>
                                <li>Oleh <?php echo $evaluasi['author_nama'];?></li>
                                <li>Mapel <?php echo $evaluasi['mapel_nama'];?></li>
                                <li>Pelajaran <?php echo $evaluasi['pelajaran_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
                <div class="card-body card-padding">
              		
						<?=$menu_atas_kiri?>
                        <?=$menu_atas_kanan?>
                    <br/><br/>
                    
				<?php
                echo alert_get();
    
                echo '<div class="form-horizontal"><fieldset>';
    
                foreach ($dset as $label => $cdat):
                    echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label>"
                    . "<div class=\"controls\">" . data_cell($cdat, $row) . "</div></div>";
                endforeach;
    
                echo '</fieldset></div><br/><br/>';
				
    
                foreach ($butir_result['data'] as $idx => $butir):
                    soal_prepjwb($butir);
    
                    echo '<div class="well">';
                    echo '<fieldset>';
                    echo "<legend>Pertanyaan ::&nbsp; " . ($idx + 1) . "</legend>";
    
                    // tampilkan pertanyaan
    
                    //if ($user['role'] != 'siswa' OR $evaluasi['closed'])
                        echo div('class="soal-pertanyaan"', $butir['pertanyaan']) . '<br/>';
    
                    // poin
    
                    if ($user['role'] != 'siswa' OR $evaluasi['closed'])
                        echo "<div><b>Poin: </b>{$butir['jwb_poin']} / {$butir['poin_max']}</div>";
    
                    // jawaban
                    if ($user['role'] != 'siswa' OR $evaluasi['closed'] OR $evaluasi['pilihan_jml']==0 )
                    {
                        echo "<div><b>Jawaban:</b>";
                        echo ul(array($butir['jwb_jawaban']));
                        echo "</div>";
                    }else
                    {
                        //echo "MAAF RAHASIA :)";
                    }
                    // pilihan, bila ada
    
                    if ($butir['pilihan'] && ($user['role'] != 'siswa' OR $evaluasi['closed'] )):
    
                        $kunci = (array) array_node($butir, 'pilihan', 'kunci', 'label');
                        $pengecoh = (array) array_node($butir, 'pilihan', 'pengecoh');
    
                        echo "<div><b>Kunci:</b>";
                        echo ul($kunci);
                        echo "</div>";
    
                        echo "<div>";
                        echo "<div class=\"btn btn-info btn-small\" onClick=\"$('#pengecoh-{$butir['id']}').slideToggle(200);\">Pengecoh</div>";
                        echo ul($pengecoh, "id=\"pengecoh-{$butir['id']}\" class=\"pengecoh\"");
                        echo "</div>";
    
                    endif;
    
                    echo '<fieldset>';
                    echo "</div>";
    
                //dump($butir);
    
                endforeach;
                ?>
                
                </div>
            </div>
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

<script type="text/javascript">

setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);


setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){nowAnimation('ljs','fadeInUp')},700);

setTimeout(function(){delayAnimation('back','rubberBand')},4000);
setTimeout(function(){delayAnimation('detail','rubberBand')},4400);

setTimeout(function(){delayAnimation('jawab','rubberBand')},5000);
setTimeout(function(){delayAnimation('roleback','rubberBand')},5400);
setTimeout(function(){delayAnimation('print','rubberBand')},5800);
</script>

	</body>
</html>