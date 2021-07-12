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
		
// function

function display_jadwal($row)
{
	$cfg = array(
		'show_header'		 => FALSE,
		'pagination_link'	 => FALSE,
		'show_stat'			 => FALSE,
		'show_number'		 => FALSE,
		'row_action'		 => FALSE,
		'row_link'			 => FALSE,
		'jquery'			 => FALSE,
		'table_properties'	 => array(
			'id'	 => 'tabel-jadwal',
			'class'	 => 'table table-bordered table-striped table-hover',
		),
		'empty_message'		 => '<i>kosong</i>',
		'data'				 => array(
			'Kelas'		 => 'kelas_nama',
			'Mulai'		 => 'evaluasi_mulai',
			'Ditutup'	 => 'evaluasi_ditutup',
		),
	);
	return ds_table($cfg, $row['kelas_result']);

}

function display_tipe($row)
{
	return ucfirst($row['tipe']) . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');

}

function display_soal_jml($n, $total)
{
	return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";

}

function display_soal_siswa($row)
{
	return ( ($row['soal_jml'] > 0 && $row['soal_jml'] < $row['soal_total']) ? $row['soal_jml'] : $row['soal_total']) . " pertanyaan";

}

function display_ljs_max($n)
{
	return ($n == 0) ? '<i>tidak dibatasi</i>' : "{$n} kali";

}


// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$editable = (($author_ybs OR $admin) && $row['semester_id'] == $semaktif['id'] && !$row['closed']);

// pills link

$menu_atas_kiri = '<div class="col-sm-12">';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi_soal/browse?evaluasi_id='.$row["id"].'" id="back" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5" title="kembali ke daftar evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Daftar Evaluasi </a>';
				/*
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi" id="butir_soal" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="lihat semua butir soal evaluasi ini" >
				<i class="zmdi zmdi-format-list-bulleted"></i> Butir Soal </a>';
				
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi_nilai/browse?evaluasi_id='.$row["id"].'" id="daftar_nilai" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="lihat semua nilai hasil evaluasi ini" >
				<i class="zmdi zmdi-format-list-numbered"></i> Daftar Nilai </a>';
				*/
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi_ljs/browse?evaluasi_id='.$row["id"].'" id="daftar_ljs" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="lihat semua lembar jawab hasil evaluasi ini" >
				<i class="zmdi zmdi-file-text"></i> Daftar LJS </a>';
				
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi_nilai/statistik?evaluasi_id='.$row["id"].'" id="statistik" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="statistik grafik hasil evaluasi ini" >
				<i class="zmdi zmdi-chart"></i> Statistik </a>';
						
$menu_atas_kiri .= '</div>';


$menu_atas_kanan = '<div class="col-sm-12" align="right">';

if ($user['role'] == 'siswa'):
	if ($row['#available'] && ($row['evaluasi_terkoreksi'] OR ! $row['ljs_id'])):
		$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/form?id='.$row["id"].'" id="jawab" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="kerjakan soal evaluasi ini" ><i class="zmdi zmdi-arrow-edit"></i> Kerjakan ! </a>';
	endif;

	if ($row['ljs_id']):
		$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/id/'.$row["ljs_id"].'" id="ljs" 
				class="btn btn-info btn-sm m-b-5 m-r-5" title="lihat lembar hasil pengerjaan" ><i class="zmdi zmdi-assignment"></i> LJS </a>';
	endif;
	
else:
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_soal/form?evaluasi_id='.$row["id"].'&redir='.$uri.'/'.$row['id'].'" id="tambah_soal" 
				class="btn btn-primary btn-sm m-b-5 m-r-5" title="tambah butir soal baru" ><i class="zmdi zmdi-plus"></i> Tambah Soal </a>';
	
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/form?id='.$row["id"].'" id="edit" 
				class="btn btn-warning btn-sm m-b-5 m-r-5" title="ubah data evaluasi ini" ><i class="zmdi zmdi-edit"></i> Edit </a>';
				
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/form?id='.$row["id"].'" id="simulasi" 
				class="btn bgm-lime btn-sm m-b-5 m-r-5" title="simulasi pengerjaan evaluasi ini" ><i class="zmdi zmdi-border-color"></i> Simulasi </a>';
	
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/publish?id='.$row["id"].'" id="publish" 
				class="btn btn-success btn-sm m-b-5 m-r-5" title="publikasikan soal evaluasi ini ke semua siswa/peserta" >
				<i class="zmdi zmdi-mail-send"></i> Publish </a>';
	
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/tutup?id='.$row["id"].'" id="tutup" 
				class="btn bgm-deeporange btn-sm m-b-5 m-r-5" title="tutup evaluasi ini" >
				<i class="zmdi zmdi-alert-circle"></i> Tutup </a>';	
				
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/delete?id='.$row["id"].'" id="hapus" 
				class="btn btn-danger btn-sm m-b-5 m-r-5" title="hapus evaluasi ini" >
				<i class="zmdi zmdi-delete"></i> Hapus </a>';	
	
	$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/reuse/'.$row["id"].'" id="reuse" 
				class="btn bgm-purple btn-sm m-b-5 m-r-5" title="gunakan kembali materi ini" ><i class="zmdi zmdi-refresh-alt"></i> Reuse </a>&nbsp;';
						
endif;

$menu_atas_kanan .= '</div>';

$pills_kiri[] = array(
	'label'	 => 'Daftar Evaluasi',
	'uri'	 => "kbm/evaluasi",
	'attr'	 => 'title="kembali ke daftar evaluasi"',
);
$pills_kanan = array();

if ($user['role'] == 'siswa'):

	// pills khusus siswa

	$pills_kanan = array(
		'jawab'	 => array(
			'label'	 => '<i class="icon-pencil"></i> Kerjakan !',
			'uri'	 => "kbm/evaluasi_ljs/form?id={$row['id']}",
			'attr'	 => 'title="kerjakan soal evaluasi ini"',
			'class'	 => 'disabled',
		),
		'ljs'	 => array(
			'label'	 => '<i class="icon-file-alt"></i> LJS',
			'uri'	 => "kbm/evaluasi_ljs/id/{$row['ljs_id']}",
			'attr'	 => 'title="lihat lembar hasil pengerjaan"',
			'class'	 => 'disabled',
		),
	);

	if ($row['#available'] && ($row['evaluasi_terkoreksi'] OR ! $row['ljs_id'])):
		$pills_kanan['jawab']['class'] = 'active';
	endif;

	if ($row['ljs_id']):
		$pills_kanan['ljs']['class'] = 'active';
	endif;

else:


	if ($editable)
		$pills_kanan['edit']['class'] = 'active';

	if (($row['soal_total'] > 0) && ($admin OR $user['id'] == $row['author_id'])):
		$pills_kanan['simulasi']['class'] = 'active';
		$pills_link['soal']['class'] = '';
	endif;

	if (($row['soal_total'] > 0 && !$row['published']) && ($admin OR $user['id'] == $row['author_id']))
		$pills_kanan['publish']['class'] = 'active';

	if ($row['siswa_menjawab'] > 0 && $row['published'] && !$row['closed'])
		$pills_kanan['tutup']['class'] = 'active';

	if (in_array($row['status'], array('draft', 'closed')) && !$row['nilai_kolom_id'])
		$pills_kanan['delete']['class'] = 'active';

	if ($row['published']):
		$pills_link['nilai']['class'] = '';
		$pills_link['statistik']['class'] = '';
	endif;

	if ($row['siswa_menjawab'] > 0)
		$pills_link['ljs']['class'] = '';


	if (($user['role'] == 'admin')||($user['role'] == 'sdm'))
	{
		$pills_kanan['reuse'] = array(
			'label'	 => '<i class="icon-refresh"></i> Reuse',
			'uri'	 => "kbm/evaluasi/reuse/{$row['id']}",
			'attr'	 => 'title="gunakan evaluasi ini untuk pelajaran lain"',
			'class'	 => 'active',
		);
	}

endif;

$detail['umum'] = array(
	'Pelajaran'	 => array(
		'mapel_nama', 'ucwords',
		'suffix' => array(
			'<div class="subinfo">',
			'pelajaran_nama',
			' oleh ',
			'author_nama',
			'.&nbsp; ',
			'semester_nama',
			' ',
			'ta_nama',
			'</div>',
		),
	),
	'Tipe'		 => array(FALSE, 'display_tipe'),
	'Bentuk'	 => array('pilihan_jml', array('Uraian', 'error', 'error', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
	'KKM'		 => 'kkm',
);

if ($user['role'] == 'siswa'):
	$detail['tambahan'] = array(
		'Jumlah Soal'		 => array(FALSE, 'display_soal_siswa'),
		'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
	);

else:
	$detail['tambahan'] = array(
		'Batas Soal Tampil'	 => array('soal_jml', 'display_soal_jml', $row['soal_total']),
		'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
		'Acak Soal'			 => array('soal_acak', array('tidak', 'ya')),
	);

endif;

// table
$_COOKIE['evaluasi_id'] = $row['id'];

function display_soal($row)
{
	return a("/kbm/evaluasi/pdf?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id'], '<i class="zmdi zmdi-download"></i> DOWNLOAD SOAL', 
	'class="btn btn-primary btn-sm m-b-5 m-r-5" title="cetak soal PDF" target="_blank"');
}

function display_nilai($row)
{
	return a("/kbm/evaluasi_nilai/download?evaluasi_id=".$_COOKIE['evaluasi_id']."&kelas_id=".$row['kelas_id'], 
	'<i class="zmdi zmdi-download"></i> DOWNLOAD NILAI', 'class="btn btn-primary btn-sm m-b-5 m-r-5" title="cetak nilai EXCEL" target="_blank"');
}

function jadwal($row,$request,$user)
{
	$data = $row['kelas_result']['data'];
	//print_r($row['kelas_result']);
	$header_table = "
				<tr>
                    <th>Kelas</th>
					<th>Mulai</th>
					<th>Selesai</th>";
					if ($user['role'] != 'siswa')
					{
						$header_table .= "<th>Soal</th>";
						if($row['published'])
						{
							$header_table .= "<th>Nilai</th>";
						}
					}
						
	$header_table .= "</tr>";
	
    ?>
    <div class="card" id="jadwal">
        
        <br>
        <div class="table-responsive">
            <table id="data-table-basic-jadwal" class="table table-striped">
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
						echo"<tr>
						 		<td>".$view['kelas_nama']."</td>
								<td>".tglwaktu($view['evaluasi_mulai'])."</td>
								<td>".tglwaktu($view['evaluasi_ditutup'])."</td>";
						if ($user['role'] != 'siswa')
						{
							echo"<td>".display_soal($view)."</td>";
							if($row['published'])
							{
								echo"<td>".display_nilai($view)."</td>";
							}
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
<?php $this->load->view(THEME . "/-html-/head", array('title' => "Evaluasi #{$row['id']}")); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
	
?>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>EVALUASI BELAJAR</b></h2>
            </div>
            
			<style>
				.controls{
						font-size: 1.2em;
						margin: 0.2em;
						color: black;
					}
					.subinfo{
						font-size: .8em;
						opacity: .7;
						line-height: .9em;
					}
					#detail-tambahan{
						display: none;
					}
					.informasi1 {
						
						font-size: 15px;
					}
					
					.informasi2 {
						font-weight: bold;
						font-size: 15px;
					}
			</style>
            <?php
			echo alert_get();
			
			?>
			<div class="card">
                <div class="card-header">
                    <h2> <b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]);
							echo (($row['published']) ? '' : ' <div style="color:red">(Belum Dipublikasikan)</div>'); ?></b>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $row['author_nama'];?></li>
                                <li>Mapel <?php echo $row['mapel_nama'];?></li>
                                <li>Pelajaran <?php echo $row['pelajaran_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                    
                </div>
                <div class="card-body card-padding">
              		<?=$menu_atas_kiri?>
                    <?=$menu_atas_kanan?>
                    <div role="tabpanel">
                        <ul class="tab-nav" role="tablist">
                            <li class="active">
                            <a href="#informasi" aria-controls="informasi" role="tab" data-toggle="tab">INFORMASI</a></li>
                            <li><a href="#jadwal" aria-controls="jadwal" role="tab" data-toggle="tab">JADWAL & HASIL</a>
                            </li>
                            <li><a href="#soal" aria-controls="soal" role="tab" data-toggle="tab">SOAL</a>
                            </li>
                            <li><a href="#nilai" aria-controls="nilai" role="tab" data-toggle="tab">NILAI</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="informasi">
                            	
                                <div class="card-body card-padding" id="informasi">
                            		<div class="row">
                                		<?php
										echo '<div class="form-horizontal"><fieldset>';
    
										foreach ($detail['umum'] as $label => $cdat):
											echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label>"
											. "<div class=\"controls\">" . data_cell($cdat, $row) . "</div></div>";
										endforeach;
							
										echo '</fieldset></div><br/><br/>'; 
										
										// opsi tambahan

										echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
										echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';
										//echo '<legend>Keterangan Tambahan</legend>';
						
										foreach ($detail['tambahan'] as $label => $cdat):
											echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
											. data_cell($cdat, $row) . "</div></div>";
										endforeach;
										
										echo '</fieldset></div><br/>';
										?>
                                        
                                        
                                     </div>
                                 </div>
                                 
                            </div>
                            <div role="tabpanel" class="tab-pane" id="jadwal">
                                <?php jadwal($row,$request,$user);?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="soal">
                              <?php
							  //echo THEME . "/".$uri."/soal";
                                if ($admin OR ( $user['id'] == $row['author_id'])):
									$this->load->view(THEME . "/".$uri."/soal", $this->d);
								endif;
								?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="nilai">
                            	
                                <?php
								
                                if (($user['role'] == 'siswa')||(!$row['published'])):
									
								else:
									$this->load->view(THEME . "/{$uri}/nilai", $this->d);
				
								endif;
								?>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
			
			
        </div>
    </section>
</section>
<?php //$this->load->view(THEME . "/-html-/content/footer"); ?>

<script type="text/javascript">

$(function () {
	$('#cmd-detail-tambahan').click(function () {
		$('#detail-tambahan').slideToggle(200);
	});
});


$(document).ready(function() {
	$('#data-table-basic-jadwal').DataTable();
} );

$('#data-table-basic-jadwal').dataTable( {
  "pageLength": 50
} )
     
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('jadwal','fadeInUp')},400);
setTimeout(function(){nowAnimation('informasi','fadeInUp')},400);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){delayAnimation('back','rubberBand')},4000);
//setTimeout(function(){delayAnimation('butir_soal','rubberBand')},4200);
//setTimeout(function(){delayAnimation('daftar_nilai','rubberBand')},4400);
setTimeout(function(){delayAnimation('daftar_ljs','rubberBand')},4400);
setTimeout(function(){delayAnimation('statistik','rubberBand')},4800);

setTimeout(function(){delayAnimation('tambah_soal','rubberBand')},5000);
setTimeout(function(){delayAnimation('edit','rubberBand')},5300);
setTimeout(function(){delayAnimation('simulasi','rubberBand')},5600);
setTimeout(function(){delayAnimation('publish','rubberBand')},5900);
setTimeout(function(){delayAnimation('tutup','rubberBand')},6200);
setTimeout(function(){delayAnimation('hapus','rubberBand')},6500);
setTimeout(function(){delayAnimation('reuse','rubberBand')},6800);
</script>

<?php

addon('tinymce');

?>

	</body>
</html>