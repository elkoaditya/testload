<?php

$r = & $this->d['request'];
$r['angket_id'] = $row['id'];
$r['term'] = '';
$r['kelas_id'] = '';
$r['order_by'] = '';

$ruri_nilai = "kbm/angket_nilai/browse?angket_id={$row['id']}";
$resultset = $this->m_kbm_angket_nilai->browse(0, 50);

// fungsi

function disnil_ljs($row) {
	if (!$row['ljs_id'])
		return '<i>kosong</i>';

	if (!$row['angket_terkoreksi'])
		return a("kbm/angket_ljs/koreksi?id={$row['ljs_id']}", 'Koreksi', 'class="btn btn-success btn-small" title="koreksi lembar jawab siswa"');

	return a("kbm/angket_ljs/id/{$row['ljs_id']}", 'Lihat', 'class="btn btn-info btn-small" title="lihat lembar jawab siswa"');
}

function disnil_status($nilai, $kkm) {
	//return "nilai {$nilai}, kkm {$kkm}";
	return ($nilai >= $kkm) ? 'tuntas' : 'belum tuntas';
}

// pills link

$pills[] = array(
		'label' => '<i class="icon-download"></i>Masukan Rapor',
		'uri' => "kbm/angket/rekap?id={$row['id']}",
		'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
		'class' => (($row['status'] == 'closed') ? 'active' : 'disabled' ),
);

$pills[] = array(
		'label' => '<i class="icon-download"></i>Download',
		'uri' => "kbm/angket_nilai/download?angket_id={$row['id']}",
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
				'Menilai Siswa' => 'menilai_siswa_nama',
				'Gender' => array('siswa_gender', 'strtoupper'),
				'<div align="right">Poin &nbsp; </div>' => array(
						'angket_poin',
						'prefix' => '<div align="right">',
						'suffix' => array(
								' / ',
								'angket_poin_max',
								'&nbsp; </div>',
						),
				),
				'<div align="right">Nilai &nbsp; </div>' => array(
						'angket_nilai',
						//'formnil_angka',
						'prefix' => '<div align="right"><b>',
						'suffix' => '&nbsp; </b></div>',
				),
				//'Status' => array('angket_nilai', 'disnil_status', $row['kkm']),
				'LJS' => array(FALSE, 'disnil_ljs'),
		),
);

$bar_cari_nilai = '<div>'
		. form_opening('kbm/angket_nilai/browse', 'method="get" class="form-search well"')
		. pills($pills, 'class="nav nav-pills pull-right"')
		. form_hidden('angket_id', $row['id'])
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
echo ds_table($table, $resultset);
echo '</fieldset></div><br/>';
