<?php
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

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'KBM' => 'kbm',
		'Evaluasi' => 'kbm/evaluasi',
		"#{$evaluasi['id']}" => "kbm/evaluasi/id/{$evaluasi['id']}",
		"Nilai" => "kbm/evaluasi_ljs/browse?evaluasi_id={$evaluasi['id']}",
		"LJS",
);

// pills link

$pills[] = array(
		'label' => '<i class="icon-download"></i> Download',
		'uri' => "kbm/evaluasi_ljs/download?evaluasi_id={$evaluasi['id']}",
		'attr' => 'title="download data ljs" target="_blank"',
		'class' => 'disabled',
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
		'base_url' => $uri,
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
				'Siswa' => 'siswa_nama',
				'Waktu' => 'waktu',
				'Dikoreksi' => array('dikoreksi'),
				'<div align="right">Poin</div>' => array(
						'poin',
						'suffix' => array(
								' / ',
								'poin_max',
								'</div>',
						),
						'prefix' => '<div align="right">',
				),
				'<div align="right">Nilai</div>' => array(
						'nilai',
						'formnil_angka',
						'prefix' => '<div align="right"><b>',
						'suffix' => '</b></div>',
				),
				'LJS' => array(FALSE, 'display_ljs'),
		),
);

$bar = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_hidden('evaluasi_id', $request['evaluasi_id'])
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($ruri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "LJS Evaluasi {$evaluasi['id']}")); ?>

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
					LJS Hasil Evaluasi:
					<h1><?php echo a("kbm/evaluasi/id/{$evaluasi['id']}", strtoupper($evaluasi['nama']), 'title="kembali ke halaman evaluasi"'); ?></h1>
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