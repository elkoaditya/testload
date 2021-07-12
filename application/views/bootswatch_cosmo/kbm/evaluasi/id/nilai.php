<?php

$r = & $this->d['request'];
$r['evaluasi_id'] = $row['id'];
$r['term'] = '';
$r['kelas_id'] = '';
$r['order_by'] = '';

$ruri_nilai = "kbm/evaluasi_nilai/browse?evaluasi_id={$row['id']}";
$uri_nilai = "kbm/evaluasi_nilai/browse";
$resultset = $this->m_kbm_evaluasi_nilai->browse(0, 200);

// echo "<pre>";
// print_r($user);
// print_r($row);
// echo "</pre>";
// fungsi

function disnil_ljs($row, $plus_isian, $plus_uraian) {
	if (!$row['ljs_id'])
		return '<i>kosong</i>';

	if ((!$row['evaluasi_terkoreksi']) || ($plus_isian==1) || ($plus_uraian==1)){
		$html = a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'Lihat', 'class="btn btn-info btn-small" title="lihat lembar jawab siswa"');
		$html .= "&nbsp";
		$html .= a("kbm/evaluasi_ljs/koreksi?id={$row['ljs_id']}", 'Koreksi', 'class="btn btn-success btn-small" title="koreksi lembar jawab siswa"');
		
		return $html;
	}
	return a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'Lihat', 'class="btn btn-info btn-small" title="lihat lembar jawab siswa"');
}

function display_aktif($row)
{	
	if ($row['aktif']==1)
		return '<div style="color:green;"><b>BOLEH IKUT</b></div> ';

	else
		return '<div style="color:red;"><b>TIDAK BOLEH IKUT</b></div>';

}

function disnil_status($nilai, $kkm) {
	//return "nilai {$nilai}, kkm {$kkm}";
	return ($nilai >= $kkm) ? 'tuntas' : 'belum tuntas';
}

// pills link

	$pills[] = array(
			'label' => '<i class="icon-download"></i>Masukan Rapor',
			'uri' => "kbm/evaluasi/rekap?id={$row['id']}",
			'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
		'class' => 'active',
			// 'class' => (($row['status'] == 'closed') ? 'active' : 'disabled' ),
	);

$pills[] = array(
		//'label' => '<i class="icon-download"></i>Download',
		//'uri' => "kbm/evaluasi_nilai/download?evaluasi_id={$row['id']}",
		'label' => '<i class="icon-download"></i>Rekalkulasi & Download',
		'uri' => "kbm/evaluasi_tool/recal_dl_nilai?evaluasi_id={$row['id']}",
		'attr' => 'title="Download daftar nilai ini" target="_blank"',
		'class' => 'active',
);

$pills[] = array(
		'label' => '<i class="icon-search"></i>Surveillance',
		'uri' => "kbm/evaluasi_ljs/surveillance?evaluasi_id={$row['id']}&kelas_id=0",
		'attr' => 'title="Surveillance daftar nilai ini" target="_blank"',
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
		'base_url' => $uri_nilai,
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
				'Gender' => array('siswa_gender', 'strtoupper'),
				/*'<div align="right">Poin &nbsp; </div>' => array(
						'evaluasi_poin',
						'prefix' => '<div align="right">',
						'suffix' => array(
								' / ',
								'evaluasi_poin_max',
								'&nbsp; </div>',
						),
				),*/
				
				
				//'Status'	 => array(FALSE, 'display_aktif'),
		),
);
if( ($row['plus_isian']==1) || ($row['plus_uraian']==1)	){
	$table['data']['<div align="right">Nilai Pilgan&nbsp; </div>'] = array(
			'evaluasi_nilai_utama',
			//'formnil_angka',
			'prefix' => '<div align="right"><b>',
			'suffix' => '&nbsp; </b></div>',
	);
}

if($row['plus_isian']==1) {
	$table['data']['<div align="right">Nilai Isian&nbsp; </div>'] = array(
			'evaluasi_nilai_isian',
			//'formnil_angka',
			'prefix' => '<div align="right"><b>',
			'suffix' => '&nbsp; </b></div>',
	);
}

if($row['plus_uraian']==1){
	$table['data']['<div align="right">Nilai Uraian&nbsp; </div>'] = array(
			'evaluasi_nilai_uraian',
			//'formnil_angka',
			'prefix' => '<div align="right"><b>',
			'suffix' => '&nbsp; </b></div>',
	);
}
$table['data']['<div align="right">Nilai Total&nbsp; </div>'] = array(
		'evaluasi_nilai',
		//'formnil_angka',
		'prefix' => '<div align="right"><b>',
		'suffix' => '&nbsp; </b></div>',
);

$table['data']['Status']	= array('evaluasi_nilai', 'disnil_status', $row['kkm']);
$table['data']['LJS'] 		= array(FALSE, 'disnil_ljs', $row['plus_isian'], $row['plus_uraian']);



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

echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Daftar Nilai Siswa</legend>';
echo $bar_cari_nilai;
//print_r($resultset);
echo ds_table($table, $resultset);
echo '</fieldset></div><br/>';
