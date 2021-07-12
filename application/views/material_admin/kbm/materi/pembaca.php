<?php

// function

function display_nama($row) {
	return a("data/profil/siswa/id/{$row['user_id']}?ringkas=ya", $row['siswa_nama'], 'title="lihat detail data siswa ini"');
}

// user akses

$author = ($user['id'] == $row['author_id']);

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
$menu_atas_kiri = '<div class="col-sm-12">';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/materi/id/'.$row['id'].'" id="back" 
				class="btn bgm-gray btn-sm m-b-5" title="kembali ke tampilan materi" ><i class="zmdi zmdi-arrow-left"></i> Tampilan Materi</a>&nbsp;';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/materi" id="tabel" 
				class="btn bgm-gray btn-sm m-b-5" title="kembali ke daftar materi" ><i class="zmdi zmdi-arrow-left"></i> Daftar Materi </a>';
$menu_atas_kiri .= '</div><br/>';


function table(&$no,$data,$request,$user,$mengajar_list)
{
	$header_table = "
				<tr>
                    <th>Siswa / Kelas</th>
					<th>Membaca</th>
					<th id='jawaban'>Jawaban</th>
                </tr>";
	
    ?>
    
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
						 <td>".display_nama($view)."
						 	<ul class='lgi-attrs'>
								<li>".$view['kelas_nama']."</li>
							</ul>
						</td>
						<td>".$view['baca_count']." kali
							<ul class='lgi-attrs'>
								<li>".date2tgl($view['baca_waktu'])."</li>
							</ul>
						</td>
						<td style='max-width:40%' ><div class='wrapper'>".base64_decode($view['respon_jawaban'])." </div>
							<ul class='lgi-attrs'>
								<li>".date2tgl($view['respon_waktu'])."</li>
							</ul>
						</td>
						</tr>";
					}
					?>
                </tbody>
             </table>
           </div>
    <?php
}
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Materi #{$row['id']}")); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>

	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>DAFTAR PEMBACA</b></h2>
            </div>

            <?php
			echo alert_get();
			?>
            <div class="card" id="pembaca">
                <div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/materi/id/{$row['id']}", $row['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $row['author_nama'];?></li>
                                <li>Mapel <?php echo $row['mapel_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
                <style>
					.table{
						table-layout: fixed;
					}
				</style>
                <div class="card-body card-padding" style="padding-top:0">
              		<?=$menu_atas_kiri?>
                    <?php
                    // pertanyaan

					echo '<br/><br/><div class="well">'
					. '<fieldset>'.p('', '<h4><b>Pertanyaan siswa</b></h4>')
					. '<div style="font-size:15;">'.$row['pertanyaan'].'</div>'
					. '</fieldset></div>';
					?>
                </div>    
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

setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){nowAnimation('pembaca','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('back','rubberBand')},4000);
setTimeout(function(){delayAnimation('tabel','rubberBand')},5000);

</script>
	</body>
</html>