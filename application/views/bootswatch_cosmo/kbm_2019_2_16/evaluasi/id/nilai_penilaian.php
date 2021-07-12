<?php

$r = & $this->d['request'];
$r['evaluasi_id'] = $row['id'];
$r['term'] = '';
$r['kelas_id'] = '';
$r['order_by'] = '';

$ruri_nilai 		= "kbm/evaluasi_nilai/browse?evaluasi_id={$row['id']}";
$resultset 			= $this->m_kbm_evaluasi_nilai->browse(0, 50);
$pengerjaan_ljs 	= $this->m_kbm_evaluasi_nilai->browse_all();	


foreach ($resultset['data'] as $key => $nisisljs){
	if($nisisljs['evaluasi_terkoreksi']){
		$resultset['data'][$key]['jawaban'] = $pengerjaan_ljs['jawaban'][$nisisljs['siswa_id']]['nisisljs_array'];
	}
	// if(isset($pengerjaan_ljs['jawaban'][$nisisljs['siswa_id']]['nisisljs_array']){
		// $resultset['data'][$key]['jawaban'] = $pengerjaan_ljs['jawaban'][$nisisljs['siswa_id']]['nisisljs_array'];
	// }
}

// $d = & $this->ci->d;	
// echo "<pre>";
// print_r($pengerjaan_ljs); 
// echo "</pre>";
// fungsi
function disnil_ljs2($row) {
	echo "<pre>";
	// print_r($user);
	// print_r($row);
	echo "</pre>";
}


function disnil_ljs($row, $kkm) {
	// if (!$row['status'])
	// if ($row['status'] != 'published')
	// return '<i>kosong</i>';
	$set_return = "";
	if (!$row['evaluasi_terkoreksi']){	
		$set_return =  a("kbm/evaluasi_ljs/form_penilaian?id={$row['evaluasi_id']}&siswa_id={$row['user_id']}&kelas_id={$row['kelas_id']}", 'Kerjakan', 'class="btn btn-success btn-small" title="koreksi lembar jawab siswa"');
	}else{
		
	// if (!$row['evaluasi_terkoreksi'])
		// return a("kbm/evaluasi_ljs/koreksi?id={$row['ljs_id']}", 'Koreksi', 'class="btn btn-success btn-small" title="koreksi lembar jawab siswa"');
	
	$remidi[$row['user_id']] = '';
	$no_soal = 0;
	foreach ($row['jawaban'] as $key => $nisisljs){
		$no_soal++;
		$row['jawaban'][$key]['no_soal'] = $no_soal;
		if($nisisljs['poin_kkm']<$kkm){
			$remidi[$row['user_id']] .= '<tr><td>'.$no_soal.'</td><td>'.$nisisljs['poin'].'/'.$nisisljs['poin_max'].'</td><td>'.$nisisljs['poin_kkm'].'</td></tr>';
		}
	}
	 
	// $table = array(
			// 'table_properties' => array(
					// 'id' => 'tabel-nilai',
					// 'class' => 'table table-bordered table-striped table-hover',
			// ),
			// 'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
			// 'data' => array(
					// 'Nomor Soal' => 'kelas_nama',
					// 'Poin' => 'siswa_nis',
			// ),
	// );
	// echo ds_table($table, $row); 
	// $modal_remidi = json_encode($row['jawaban']);
	
	$set_return =  a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'Lihat', 'class="btn btn-info btn-small" title="lihat lembar jawab siswa"');
	$set_return .= " ";
	$set_return .= '<button type="button" class="btn btn-warning btn-small" data-toggle="modal" data-target="#myModal_'.$row['ljs_id'].'"> Ketidaktuntasan </button>';
	$set_return .= '
	<div id="myModal_'.$row['ljs_id'].'" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3 class="modal-title"> <b>Nilai Dibawah KKM</b></h3>
		  </div>
		  <div class="modal-body">
			<table class="table table-bordered"><tr><td> Nomor Soal </td><td> Poin </td><td> Nilai </td></tr>'.$remidi[$row['user_id']].' </table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	  </div>
	</div> ';
	}
	return $set_return;
}

function disnil_status($nilai, $kkm) {
	//return "nilai {$nilai}, kkm {$kkm}";
	return ($nilai >= $kkm) ? 'tuntas' : 'belum tuntas';
}

// pills link
if($author_ybs){
	$pills[] = array(
			'label' => '<i class="icon-download"></i>Masukan Rapor',
			'uri' => "kbm/evaluasi/rekap?id={$row['id']}",
			'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
		'class' => 'active',
			// 'class' => (($row['status'] == 'closed') ? 'active' : 'disabled' ),
	);
}
$pills[] = array(
		'label' => '<i class="icon-download"></i>Download',
		'uri' => "kbm/evaluasi_nilai/download?evaluasi_id={$row['id']}",
		'attr' => 'title="Download daftar nilai ini" target="_blank"',
		'class' => 'active',
);

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-small select"',
				'options' => $this->m_option->kelas('kelas'),
		),
		'order_by' => array(
				'order_by',
				'type' => 'dropdown',
				'name' => 'order_by',
				'id' => 'order_by',
				'extra' => 'class="input-medium select"',
				'options' => array(
						'kelas, nama' => 'urut: kelas, nama',
						'nilai' => 'urut: nilai',
				),
		),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 4,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => $ruri_nilai,
		'full_tag_open' => '<div class="pagination"><ul>',
		'full_tag_close' => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
		'cur_tag_open' => '<li class="active"><a href="#">',
		'cur_tag_close' => '</a></li>',
		'num_tag_open' => '<li>',
		'num_tag_close' => '</li>',
		'first_tag_open' => '<li>',
		'first_tag_close' => '</li>',
		'last_tag_open' => '<li>',
		'last_tag_close' => '</li>',
		'next_tag_open' => '<li>',
		'next_tag_close' => '</li>',
		'prev_tag_open' => '<li>',
		'prev_tag_close' => '</li>',
);
$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
		'table_properties' => array(
				'id' => 'tabel-nilai',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'NIS' => 'siswa_nis',
				'Siswa' => 'siswa_nama', 
				'<div align="right">Poin &nbsp; </div>' => array(
						'evaluasi_poin',
						'prefix' => '<div align="right">',
						'suffix' => array(
								' / ',
								'evaluasi_poin_max',
								'&nbsp; </div>',
						),
				),
				'<div align="right">Nilai &nbsp; </div>' => array(
						'evaluasi_nilai',
						//'formnil_angka',
						'prefix' => '<div align="right"><b>',
						'suffix' => '&nbsp; </b></div>',
				),
				'Status' => array('evaluasi_nilai', 'disnil_status', $row['kkm']),
				'LJS' => array(FALSE, 'disnil_ljs', $row['kkm']),
		),
);

$bar_cari_nilai = '<div>'
		. form_opening('kbm/evaluasi_nilai/browse', 'method="get" class="form-search well"')
		. pills($pills, 'class="nav nav-pills pull-right"')
		. form_hidden('evaluasi_id', $row['id'])
		. form_cell($input['term'], $r) . '&nbsp;'
		. form_cell($input['kelas_id'], $r) . '&nbsp;'
		. form_cell($input['order_by'], $r) . '&nbsp;'
		. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
		. form_close()
		. '</div>';

// output

	// echo "<pre>"; 
	// print_r($resultset);
	// print_r($dpengerjaan_ljs);
	// echo "</pre>";
echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Daftar Nilai Siswa</legend>';
echo $bar_cari_nilai;
echo ds_table($table, $resultset);
echo '</fieldset></div><br/>';
 
?>