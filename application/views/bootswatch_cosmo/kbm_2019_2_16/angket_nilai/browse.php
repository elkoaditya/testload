<?php
// vars

$ruri_reset = "{$uri}?angket_id={$request['angket_id']}";
$ruri = "{$uri}";

// fungsi

function display_ljs($row) {
	if (!$row['ljs_id'])
		return '<i>kosong</i>';

	if (!$row['angket_terkoreksi'])
		return a("kbm/angket_ljs/koreksi?id={$row['ljs_id']}", 'koreksi', 'title="koreksi lembar jawab siswa"');

	return a("kbm/angket_ljs/id/{$row['ljs_id']}", 'lihat', 'title="lihat lembar jawab siswa"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Angket' => 'kbm/angket',
		"#{$angket['id']}" => "kbm/angket/id/{$angket['id']}",
		'Nilai',
);

// pills link

$pills[] = array(
		'label' => '<i class="icon-download"></i>Masukan Rapor',
		//'uri' => "kbm/angket/rekap?id={$row['id']}",
		'uri' => "kbm/angket/rekap?id={$angket['id']}",
		'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
		'class' => (($angket['status'] == 'closed') ? 'active' : 'disabled' ),
);

$pills[] = array(
		'label' => '<i class="icon-download"></i>Download',
		'uri' => "kbm/angket_nilai/download?angket_id={$angket['id']}",
		'attr' => 'title="Kembali ke tampilan angket" target="_blank"',
);

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'keyword',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-medium',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->kelas('kelas'),
		),
		'order_by' => array(
				'order_by',
				'type' => 'dropdown',
				'name' => 'order_by',
				'id' => 'order_by',
				'extra' => 'class="input-large select"',
				'options' => array(
						'kelas, nama' => 'sort: kelas, nama',
						'nilai' => 'sort: nilai',
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
				'id' => 'tabel-nilai',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'Gender' => array('siswa_gender', 'strtoupper'),
				'Siswa' => 'siswa_nama',
				'Menilai Siswa' => 'menilai_siswa_nama',
				
				'Nilai' => array('angket_nilai', 'formnil_angka'),
				'<div align="right">Poin &nbsp; </div>' => array(
						'angket_poin',
						'prefix' => '<div align="right">',
						'suffix' => array(
								' / ',
								'angket_poin_max',
								'&nbsp; </div>',
						),
				),
				'LJS' => array(FALSE, 'display_ljs'),
		),
);

$bar = '<div>'
		. form_opening($uri, 'method="get" class="form-search well"')
		. pills($pills, 'class="nav nav-pills pull-right"')
		. form_hidden('angket_id', $request['angket_id'])
		. form_cell($input['term'], $request) . '&nbsp;'
		. form_cell($input['kelas_id'], $request) . '&nbsp;'
		. form_cell($input['order_by'], $request) . '&nbsp;'
		. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
		. a($ruri_reset, 'Reset', 'class="btn"')
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
			.listing-group {
				margin: 20px 0 10px 0;
			}
			.listing-group .title {
				font-size: 1.4em;
				color: black;
			}
		</style>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					Nilai Hasil Angket:
					<h1><?php echo a("kbm/angket/id/{$angket['id']}", strtoupper($angket['nama']), 'title="kembali ke halaman angket"'); ?></h1>
				</div>

				<?php
				echo alert_get();
				echo $bar;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>