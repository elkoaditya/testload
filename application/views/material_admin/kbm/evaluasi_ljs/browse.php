<?php
// LJS
// vars

$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";

// fungsi

function display_ljs($row) {
	if ($row['selesai']==0)
		return a("kbm/evaluasi", 'belum selesai', 'class="btn btn-small btn-info disabled" title="teruskan lembar jawab siswa"');
	if (!$row['dikoreksi'])
		return a("kbm/evaluasi_ljs/koreksi?id={$row['id']}", 'koreksi', 'class="btn btn-small btn-info" title="koreksi lembar jawab siswa"');
	
	return a("kbm/evaluasi_ljs/id/{$row['id']}", 'lihat', 'class="btn btn-small btn-info" title="lihat lembar jawab siswa"');
}

// komponen

$this->load->helper('dataset');

// pills link
$menu_atas = '<div class="col-sm-12">';
$menu_atas .= '<a href="'.base_url().'kbm/evaluasi_soal/browse?evaluasi_id='.$evaluasi["id"].'" id="back" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5 m-t-5" title="kembali ke daftar evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Daftar Evaluasi </a>';

$menu_atas .= '<a href="'.base_url().'kbm/evaluasi/id/'.$evaluasi["id"].'" id="detail" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5 m-t-5" title="kembali ke detail evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Detail Evaluasi </a>';

$menu_atas .= '</div>';

function table(&$no,$data,$evaluasi,$menu_atas,$user,$semaktif)
{
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
			
	$header_table = "
				<tr>
                    <th>Kelas</th>
					<th>Nama</th>
					<th>Waktu</th>
                    <th>Dikoreksi</th>
					<th>Poin</th>
					<th>Nilai</th>
					<th>LJS</th>";
	
	
	$header_table .= "</tr>";
	
    $aktif = array('disable', 'aktif');
	$gender = array('l'=>'Laki-laki', 'p'=>'Perempuan');
    ?>
    <div class="card" id="table">
        <div class="card-header">
            <div class="col-sm-12">
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
            <?=$menu_atas;?>
            <br><br><br><br><br>
        </div>

        
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
					
					foreach($data as $view)
					{
						$no++;
						echo"<tr>
						 <td>".$view['kelas_nama']."</td>
						 <td>".$view['siswa_nama']."</td>
						 <td>".tglwaktu($view['waktu'])."</td>
						 
						 <td>".tglwaktu($view['dikoreksi'])."</td>
						 <td>".$view['poin']." / ".$view['poin_max']."</td>
						 <td>".$view['nilai']."</td>
						 <td>".display_ljs($view)."</td>";
						 
						
						
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
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Siswa')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>LJS HASIL EVALUASI</b></h2>
            </div>
			
            <?php
			echo alert_get();
			?>
            
			<?php
			$no=0;
			echo table($no,$resultset['data'],$evaluasi,$menu_atas,$user,$semaktif);
			?>
			
			
        </div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>


<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic').DataTable();
} );

$('#data-table-basic').dataTable( {
  "pageLength": 50
} )

setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){delayAnimation('back','rubberBand')},4000);
setTimeout(function(){delayAnimation('detail','rubberBand')},4400);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			

////table
<?php
$time=3000;
$no_js=0;
if($no>10)
{	$no=10;	}

while($no_js < $no)
{
	$no_js++;
	?>
	setTimeout(function(){delayAnimation('edit<?=$no_js?>','rubberBand')},<?=$time?>);
	setTimeout(function(){delayAnimation('detail<?=$no_js?>','rubberBand')},<?=$time?>);
	setTimeout(function(){delayAnimation('delete<?=$no_js?>','rubberBand')},<?=$time?>);
	<?php
	$time = $time + 500;
}
?>
</script>
	</body>
</html>