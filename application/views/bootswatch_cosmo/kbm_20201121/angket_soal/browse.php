<?php
// vars

$ruri = "{$uri}?angket_id={$request['angket_id']}";
$editable = (($author_ybs OR $admin) && !$angket['closed'] && $angket['semester_id'] == $semaktif['id']);
$deletable = ($editable && !$angket['published']);

// function

function display_pertanyaan($row, $editable, $deletable, $analized) {
	soal_angket_prepare($row);

	// pills

	$param = "id={$row['id']}";
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

	// skor poin

	//$html .= "<div><b>Skor Poin:</b> {$row['poin_max']}</div>";

	// pilihan, bila ada

	if ($row['pilihan']):

		/*$html .= "<div><b>Kunci:</b>";
		$html .= ul(array($row['pilihan']['kunci']['label']));
		$html .= "</div>";
		*/
		//$html .= "<div><b>Pengecoh:</b>";
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

	// hasil analisa butir sioal

	if ($analized):

		$html .= "<div><b>Analisa Jawaban:</b>";
		$html .= "<ul>";
		$html .= "<li>Tingkat Kesukaran : " . round($row['analisa_index_tk']) . " (" . soal_ana_tk($row['analisa_index_tk']) . ") </li>";
		$html .= "<li>Daya Beda : " . round($row['analisa_index_db']) . " (" . soal_ana_db($row['analisa_index_db']) . ") </li>";
		$html .= "<li>Status : " . soal_analisa($row['analisa_index_db']) . " </li>";
		$html .= "</ul>";
		$html .= "</div>";

	endif;

	$html .= "</div>";

	//$html .= '<pre>' . print_r($row, TRUE) . '</pre>';

	return $html;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		'Soal',
);

// pills link

$pills_kiri = array(
		'eval' => array(
				'label' => 'Detail Angket',
				'uri' => "kbm/angket/id/{$angket['id']}",
				'attr' => 'title="Kembali ke detail angket"',
		),
		'simulasi' => array(
				'label' => '<i class="icon-pencil"></i> Simulasi',
				'uri' => "kbm/angket_ljs/form?id={$angket['id']}",
				'attr' => 'title="simulasi pengerjaan angket ini"',
				'class' => 'disabled',
		),
);
$pills_kanan = array(
		'publish' => array(
				'label' => '<i class="icon-magic"></i> PUBLIKASIKAN !',
				'uri' => "kbm/angket/publish?id={$angket['id']}",
				'attr' => 'title="publikasikan soal angket ini ke semua siswa/peserta" class="btn btn-success"',
				'class' => 'disabled',
		),
		'tambah' => array(
				'label' => '<i class="icon-star"></i> Tambah',
				'uri' => "kbm/angket_soal/form?angket_id={$angket['id']}",
				'attr' => 'title="tambah butir soal baru"',
				'class' => 'disabled',
		),
);

// aktivasi pills

if ($angket['soal_total'] > 0)
	$pills_kiri['simulasi']['class'] = '';

if (($author_ybs OR $admin) && !$angket['published'] && $angket['semester_id'] == $semaktif['id']):
	$pills_kanan['publish']['class'] = 'active';
	$pills_kanan['tambah']['class'] = 'active';
endif;

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
		'base_url' => $ruri,
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
				'Pertanyaan' => array(FALSE, 'display_pertanyaan', $editable, $deletable, $angket['analisa_waktu']),
		),
);

// bars

$bar_pills = pills($pills_kiri);

$bar_search = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills_kanan, 'class="nav nav-pills pull-right"')
			. form_hidden('angket_id', $request['angket_id'])
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($ruri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Soal Angket {$angket['id']}")); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

		<style>
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Butir Soal Angket:
					<h1><?php echo a("kbm/angket/id/{$angket['id']}", strtoupper($angket['nama']), 'title="kembali ke halaman angket"'); ?></h1>
				</div>

				<?php
				echo alert_get();
				echo $bar_pills;
				echo $bar_search;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>