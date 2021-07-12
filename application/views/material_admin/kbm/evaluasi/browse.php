<?php

// function
//print_r($resultset);
function display_nama($no,$row)
{
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
		'class="btn bgm-gray"',
		'class="btn bgm-bluegray"',
		);
	 $a = a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'title="lihat detail evaluasi" id="evaluasi'.$no.'" '.$warna[array_rand($warna)]
	 .' ') . (($row['published']) ? '' : ' <div style="color:red">(Belum Dipublikasikan)</div>');
	 
	if (isset($row['evaluasi_terkoreksi'])):
		if($row['evaluasi_terkoreksi']):
			$a =  $row['nama'];
		endif;
	endif;
	
	return  $a;

}

function display_nilai($row)
{
	// HIDDEN NILAI
	if ($row['evaluasi_terkoreksi']):
		$a = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> ' . formnil_angka($row['evaluasi_nilai']) . '</b>'), 'title="lihat lembar jawaban"');
		//$a = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", ('<b> CEK PENGERJAAN </b>'), 'title="lihat lembar jawaban"');
		
		if(strpos(strtolower($row['tipe']),'ulangan')=== FALSE)
			return '<div align="right">' . $a . '</div>';
		else
			return '<div align="right" style="color:#F00;"><b> Selesai </b></div>';
	endif;

	if ($row['ljs_id'])
		return '<div align="right"><i>menunggu koreksi</i></div>';

	return '<div align="right">' . a("kbm/evaluasi_ljs/form?id={$row['id']}", 'kerjakan', 'title="kerjakan evaluasi ini"') . '</div>';

}

function display_bentuk($pilihan_jml)
{
	return ($pilihan_jml > 1) ? 'pilihan' : 'uraian';

}

function table(&$no,$data,$request,$user,$mengajar_list)
{
	$header_table = "
				<tr>
                    <th>Nama Evaluasi</th>";
					if($user['role'] != 'siswa')
					{
						$header_table .= "<th>Bentuk</th>
										<th>KKM</th>
										<th>Pengerjaan</th>
										<th>Rata-Rata Nilai</th>";
					}else{
						$header_table .= "<th>Nilai</th>
										<th>Di BUKA</th>
										<th>Di TUTUP</th>
										<th>Di Kerjakan</th>";
					}
	$header_table .= "</tr>";
	
    $aktif = array('disable', 'aktif');
	$gender = array('l'=>'laki-laki', 'p'=>'perempuan');
    ?>
    <div class="card" id="table">
        <?php 
		if($mengajar_list)
		{
			?>
        <div class="card-header">
            <div class="col-sm-3" align="right">
                <a href="<?=base_url()?>kbm/materi/form?pelajaran_id=<?=$request['pelajaran_id']?>" 
                id="tambah" class="btn btn-primary btn-sm" title="tambah materi baru" >
                <i class="zmdi zmdi-plus"></i> Susun Evaluasi Baru</a>
            </div>
        </div>
		 <?php 
		}
		?>
        <br>
        <div class="table-responsive">
            <table id="data-table-basic" class="table table-striped">
                <thead>
                 <?php echo $header_table;?>
                </thead>
                <tfoot>
                  <?php echo $header_table;?>
                </tfoot>
                <tbody>
                    <?php
					$img_sample = array(
						"1.jpg",
						"2.jpg",
						"3.jpg",
						"4.jpg",
						"5.jpg",
						"6.jpg",
					);
					foreach($data as $view)
					{
						$no++;
						echo"<tr>
						 <td><img id=img_sample".$no." 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;
							".display_nama($no,$view)."
						 	<ul class='lgi-attrs'>
								<li>".$view['mapel_nama']."</li>
								<li>".$view['author_nama']."</li>
								<li>".$view['semester_nama']."</li>
								<li>".$view['ta_nama']."</li>
							</ul>
						</td>";
						if($user['role'] != 'siswa')
						{
							echo"<td>".display_bentuk($view)."</td>";
							echo"<td>".$view['kkm']."</td>";
							if($view['siswa_menjawab'] < $view['siswa_total'])
							{	echo"<td><div style='color:red'>".$view['siswa_menjawab']." / ".$view['siswa_total']."</div></td>";	}
							else
							{	echo"<td><div style='color:green'>".$view['siswa_menjawab']." / ".$view['siswa_total']."</div></td>";	}
							
							echo"<td>".$view['rata2_nilai']."</td>";
						}else{
							echo"<td>".display_nilai($view)."</td>
								<td>".tglwaktu($view['evaluasi_mulai'])."</td>
								<td>".tglwaktu($view['evaluasi_ditutup'])."</td>
								<td>".date2tgl($view['ljs_last'])."</td>";
						}
						
						echo"</tr>";
					}
					?>
                </tbody>
             </table>
           </div>
         </div>
    <?php
}
	
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Evaluasi Belajar')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>DAFTAR EVALUASI BELAJAR</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
			<?php
			$no=0;
			echo table($no,$resultset['data'],$request,$user,$mengajar_list);
			?>
			
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>


<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );
        
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);

////table
<?php
$time=3000;
$no_js=0;
if($no>30)
{	$no=30;	}

while($no_js < $no)
{
	$no_js++;
	?>
	setTimeout(function(){delayAnimation('img_sample<?=$no_js?>','rubberBand')},<?=$time?>);
	setTimeout(function(){delayAnimation('evaluasi<?=$no_js?>','rubberBand')},<?=$time?>);
	<?php
	$time = $time + 500;
}
?>
</script>
	</body>
</html>
