<?php

//vars

$r = & $this->d['request'];
$r['angket_id'] = $row['id'];
$r['term'] = '';

$ruri_soal = "kbm/angket_soal/browse?angket_id={$row['id']}";
$editable = (($author_ybs OR $admin) && !$row['closed'] && $row['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$row['published']);
$resultset = $this->m_kbm_angket_soal->browse(0, 50);

// fungsi

function disoal_pertanyaan($row, $published, $pilihan_jml, $uri) {

	// buttons

	$param = "id={$row['id']}&redir={$uri}/{$row['angket_id']}";
	$html = div('class="pull-right soal"');

	if (!$published)
		$html .= a("kbm/angket_soal/delete?{$param}", 'Delete', 'class="btn btn-small btn-warning"') . '&nbsp;';

	$html .= a("kbm/angket_soal/form?{$param}", 'Edit', 'class="btn btn-small btn-success"');
	$html .= '</div>';

	// gambar jika ada

	if ($row['gambar']):

		if (!is_array($row['gambar']))
			$row['gambar'] = (array) json_decode($html['gambar'], TRUE);

		$img['class'] = 'soal-img';
		$img['src'] = array_node($row, 'gambar', 'full_path');

		if (@file_exists($img['src']))
			$html .= div('align="center"', img($img));

	endif;

	// pertanyaan

	$html .= div('class="soal-pertanyaan"', base64_decode($row['pertanyaan']));

	// pilihan, bila ada

	if ($pilihan_jml > 1):

		if (!is_array($row['pilihan']))
			$row['pilihan'] = (array) json_decode($html['pilihan'], TRUE);

		$pilihan['<b>Kunci:</b>'] = (array) array_node($row, 'pilihan', 'kunci');
		$pilihan['<b>Pengecoh:</b>'] = (array) array_node($row, 'pilihan', 'pengecoh');

		foreach (array_keys($pilihan['<b>Kunci:</b>']) as $i)
			$pilihan['<b>Kunci:</b>'][$i] = base64_decode($pilihan['<b>Kunci:</b>'][$i]);

		foreach (array_keys($pilihan['<b>Pengecoh:</b>']) as $i)
			$pilihan['<b>Pengecoh:</b>'][$i] = base64_decode($pilihan['<b>Pengecoh:</b>'][$i]);

		$html .= ul($pilihan);

	endif;

	return $html;
}

function display_pertanyaan($row, $editable, $deletable, $uri) {
	soal_angket_prepare($row);

	// pills

	$param = "id={$row['id']}&redir={$uri}/{$row['angket_id']}";
	$html = div('class="soal"');
	$html .= div('class="pull-right soal-pills"');

	if ($deletable)
		$html .= a("kbm/angket_soal/delete?{$param}", 'Delete', 'class="btn btn-small btn-warning"') . '&nbsp;';
	else
		$html .= "<span class=\"btn btn-small disabled\">Delete</span>" . '&nbsp;';

	if ($editable)
		$html .= a("kbm/angket_soal/form?{$param}", 'Edit', 'class="btn btn-small btn-success"');
	else
		$html .= "<span class=\"btn btn-small disabled\">Edit</span>";

	$html .= '</div>';
	$html .= div('class="soal-pertanyaan"', ($row['pertanyaan'])) . '<br/>';

	// pilihan, bila ada

	if ($row['pilihan']):
		/*
		$html .= "<div><b>Kunci:</b>";
		$html .= ul(array($row['pilihan']['kunci']['label']));
		$html .= "</div>";

		$html .= "<div><b>Pengecoh:</b>";
		*/
		$html .= "<div><b>Pilihan:</b>";
		$html .= ul($row['pilihan']['pengecoh']);
		$html .= "</div>";
		
		$html .= "<div><b>Nilai:</b>";
		$i	= 1;
		while($i<=count($row['pilihan']['pengecoh']))
		{
			$html .= ul(array($row['poin_'.$i]));
			$i++;
		}
		$html .= "</div>";
	endif;

	$html .= "</div>";

	return $html;
}

// komponen

$this->load->helper('soal');

// pills link

$pills[] = array(
		'label' => '<i class="icon-star"></i>Tambah',
		'uri' => "kbm/angket_soal/form?angket_id={$row['id']}&redir={$uri}/{$row['id']}",
		'attr' => 'title="tambah butir soal baru" ',
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
				'class' => 'input input-large',
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
		'base_url' => $ruri_soal,
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
				'id' => 'tabel-soal',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Pertanyaan' => array(FALSE, 'display_pertanyaan', $editable, $deletable, $uri),
		),
);

// bar form soal

$bar_cari_soal = '<div>'
			. form_opening('kbm/angket_soal/browse', 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_hidden('angket_id', $row['id'])
			. form_cell($input['term'], $r) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. form_close()
			. '</div>';

// output

echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Daftar Soal / Pertanyaan</legend>';
echo $bar_cari_soal;
echo ds_table($table, $resultset);
echo '</fieldset></div><br/>';
