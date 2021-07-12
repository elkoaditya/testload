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

function display_jadwal($row) {
	$cfg = array(
			'show_header' => FALSE,
			'pagination_link' => FALSE,
			'show_stat' => FALSE,
			'show_number' => FALSE,
			'row_action' => FALSE,
			'row_link' => FALSE,
			'jquery' => FALSE,
			'table_properties' => array(
					'id' => 'tabel-jadwal',
					'class' => 'table table-bordered table-striped table-hover',
			),
			'empty_message' => '<i>kosong</i>',
			'data' => array(
					'Kelas' => 'kelas_nama',
					'Mulai' => 'evaluasi_mulai',
					'Ditutup' => 'evaluasi_ditutup',
			),
	);
	return ds_table($cfg, $row['kelas_result']);
}

function display_tipe($row) {
	return ucfirst($row['tipe']) . (($row['nilai_posted']) ? "({$row['nilai_kolom_kode']})" : '');
}

function display_soal_jml($n, $total) {
	return ($n == 0 OR $total < $n) ? "<i>semua ({$total} pertanyaan)</i>" : "{$n} pertanyaan";
}

function display_ljs_max($n) {
	return ($n == 0) ? '<i>tidak dibatasi</i>' : "{$n} kali";
}

// komponen

$this->load->helper('dataset');

// hak akses & user scope

$author_ybs = ($user['id'] == $row['author_id']);
$editable = (($author_ybs OR $admin) && $row['semester_id'] == $semaktif['id'] && !$row['closed']);

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$row['id']}" => "kbm/evaluasi/id/{$row['id']}",
		'#publish',
);

// pills link

$pills_kiri[] = array(
		'label' => 'Detail Evaluasi',
		'uri' => "kbm/evaluasi/id/{$row['id']}",
		'attr' => 'title="kembali ke detail evaluasi"',
);


$menu_atas_kiri = '<div class="col-sm-5">';
$menu_atas_kiri .= '<a href="'.base_url().'kbm/evaluasi/id/'.$row["id"].'" id="back" 
				class="btn bgm-gray btn-sm m-b-5 m-r-5" title="kembali ke detail evaluasi" >
				<i class="zmdi zmdi-arrow-left"></i> Detail Evaluasi </a>';
$menu_atas_kiri .= '</div>';

// pilss khusus tutor dan admin

$pills_kanan = array(
		'edit' => array(
				'label' => '<i class="icon-edit"></i> Edit',
				'uri' => "kbm/evaluasi/form?id={$row['id']}",
				'attr' => 'title="ubah data siswa ini"',
				'class' => (($editable) ? 'active' : 'disabled'),
		),
		'simulasi' => array(
				'label' => '<i class="icon-pencil"></i> Simulasi',
				'uri' => "kbm/evaluasi_ljs/form?id={$row['id']}",
				'attr' => 'title="simulasi pengerjaan evaluasi ini"',
				'class' => (($row['soal_total'] > 0) ? 'active' : 'disabled'),
		),
);

$menu_atas_kanan = '<div class="col-sm-7" align="right">';
$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi/form?id='.$row["id"].'" id="edit" 
				class="btn btn-warning btn-sm m-b-5 m-r-5" title="ubah data evaluasi ini" ><i class="zmdi zmdi-edit"></i> Edit </a>';
$menu_atas_kanan .= '<a href="'.base_url().'kbm/evaluasi_ljs/form?id='.$row["id"].'" id="simulasi" 
				class="btn bgm-lime btn-sm m-b-5 m-r-5" title="simulasi pengerjaan evaluasi ini" ><i class="zmdi zmdi-border-color"></i> Simulasi </a>';
$menu_atas_kanan .= '</div>';
// pills wali belum terpikir krn blm ada implementasi login
//
//
// informasi evaluasi

$detail['umum'] = array(
		'Pelajaran' => array(
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
		'Tipe' => array(FALSE, 'display_tipe'),
		'Bentuk' => array('pilihan_jml', array('Uraian', 'error', 'error', 'Pilihan Ganda - 3 opsi', 'Pilihan Ganda - 4 opsi', 'Pilihan Ganda - 5 opsi')),
		'KKM' => 'kkm',
);

$detail['tambahan'] = array(
		'Batas Soal Tampil' => array('soal_jml', 'display_soal_jml', $row['soal_total']),
		'Kesempatan Mencoba' => array('ljs_max', 'display_ljs_max'),
		'Acak Soal' => array('soal_acak', array('tidak', 'ya')),
);

// table

$table = array(
		'table_properties' => array(
				'id' => 'tabel-jadwal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<i>kosong</i>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'Mulai' => array('evaluasi_mulai', 'tglwaktu'),
				'Selesai' => array('evaluasi_ditutup', 'tglwaktu'),
		),
);

$bar_pills = '<div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>'
			. pills($pills_kiri, 'class="nav nav-pills pull-left"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. '</td></tr></table></div>';

// pesan

if (!$error)
	alert_info(div('align="center"', '<h3>Apakah Anda yakin akan mempublikasikan ini ke semua siswa???</h3>'));

$btn_back = a("kbm/evaluasi/id/{$row['id']}", ' <i class="zmdi zmdi-arrow-left"></i> Kembali ke details evaluasi', 'class="btn btn-info btn-sm m-b-5 m-r-5"');

function jadwal($row,$request,$user)
{
	$data = $row['kelas_result']['data'];
	//print_r($row['kelas_result']);
	$header_table = "
				<tr>
                    <th>Kelas</th>
					<th>Mulai</th>
					<th>Selesai</th>";
					
						
	$header_table .= "</tr>";
	
    ?>
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
						
						
						echo"</tr>";
					}
					?>
                </tbody>
             </table>
           </div>
    <?php
}
?>

<html>
<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Publish Evaluasi')); ?>

<section id="main">
<?php
	$this->load->view(THEME . "/-menu-/{$user['role']}");
?>
	<section id="content">

        <div class="container">
        
            <div class="block-header">
                <h2 id="title_page"><b>Publish Evaluasi</b></h2>
            </div>
            
            <div class="card">
            	<div class="card-header">
                    <h2><b><?php 
					echo "<img id=img_sample 
						 		class='lgi-img' 
						 		src=".base_url()."assets/material_admin/img/demo/profile-pics/".$img_sample[array_rand($img_sample)].">
						 	&nbsp;";
							echo a("kbm/evaluasi/id/{$row['id']}", $row['nama'], 'id="title_materi" title="lihat materi" '.$warna[array_rand($warna)]); ?>
                        <small><ul class='lgi-attrs'>
								<li>Oleh <?php echo $row['author_nama'];?></li>
                                <li>Mapel <?php echo $row['mapel_nama'];?></li>
                                </ul>
                        </small></b>
                    </h2>
                </div>
            	<div class="card-body card-padding">

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
				</style>

				<?php
				echo '<div class="row">'.$menu_atas_kiri.$menu_atas_kanan.'</div>';
				echo alert_get();
				//echo $bar_pills;

				echo '<div class="form-horizontal"><fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Informasi Umum</h4></p>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// opsi tambahan

				echo '<div id="cmd-detail-tambahan" class="btn btn-info">Keterangan Tambahan</div><br/><br/>';
				echo '<div id="detail-tambahan" class="form-horizontal"><fieldset>';
				//echo '<p class="f-500 m-b-15 c-black"><h4>Keterangan Tambahan</h4></p>';

				foreach ($detail['tambahan'] as $label => $cdat):
					echo "<div class=\"control-group\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/>';

				// jadwal pelaksanaan
				/*
				echo '<br/><br/><div class="form-horizontal"><fieldset>';
				echo '<p class="f-500 m-b-15 c-black"><h4>Jadwal Pelaksanaan</h4></p>';
				echo '<div class="table-responsive">';
				echo ds_table($table, $row['kelas_result']);
				echo '</div>';
				echo '</fieldset></div><br/>';
				*/
				 jadwal($row,$request,$user);
				// tombol konfirm

				// tombol konfirm

				echo form_opening("{$uri}?id={$row['id']}", '');
// form button

				echo '<fieldset>';
				echo '<div >'
				. $btn_back . ' &nbsp; &nbsp; '
				. '<button type="submit" class="btn btn-success btn-sm m-b-5 m-r-5" id="publish"><i class="zmdi zmdi-mail-send"></i> PUBLIKASIKAN !</button> '
				. '</div>';
				echo '</fieldset>';

				echo form_close();
				?>

			</div>
                </div>
                
			</div>
    </section>
</section>
<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

<script type="text/javascript">

$(document).ready(function() {
	$('#data-table-basic-jadwal').DataTable();
} );

$('#data-table-basic-jadwal').dataTable( {
  "pageLength": 50
} )
    
setTimeout(function(){nowAnimation('title_page','fadeInUp')},500);
//setTimeout(function(){nowAnimation('pencarian','fadeInUp')},600);
setTimeout(function(){nowAnimation('table','fadeInUp')},700);

setTimeout(function () {
	$("#title_page").removeClass("animated");
	$("#title_page").removeClass("fadeInUp");
	
	setTimeout(function(){delayAnimation('title_page','zoomInRight')}, 2400);// i see 2.4s is your animation duration
}, 500);// wait 0.5s
			
setTimeout(function(){delayAnimation('tambah','rubberBand')},5000);
setTimeout(function(){delayAnimation('img_sample','rubberBand')},3000);
setTimeout(function(){delayAnimation('title_materi','rubberBand')},3000);

setTimeout(function(){delayAnimation('hapus','rubberBand')},5000);
setTimeout(function(){delayAnimation('back','rubberBand')},5200);

setTimeout(function(){delayAnimation('edit','rubberBand')},5300);
setTimeout(function(){delayAnimation('simulasi','rubberBand')},5600);

setTimeout(function(){delayAnimation('publish','rubberBand')},5900);

			$(function() {
				$('#cmd-detail-tambahan').click(function() {
					$('#detail-tambahan').slideToggle(200);
				});
			});
		</script>

	</body>
</html>