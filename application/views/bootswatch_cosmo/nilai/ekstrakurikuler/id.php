<?php

// vars
// function

function display_pembina($row)
{
	return a("data/profil/sdm/id/{$row['pembina_id']}", $row['pembina_nama'], 'title="lihat profil pembina"');

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => 'nilai',
	'Ekstrakurikuler'				 => 'nilai/ekstrakurikuler',
	"#{$row['id']}",
);

// pills link

$pills[] = array(
	'label'	 => 'Daftar Nilai Ekstrakurikuler',
	'uri'	 => "nilai/ekstrakurikuler",
	'attr'	 => 'title="kembali ke daftar nilai ekstrakurikuler"',
);

$pills[] = array(
	'label'	 => 'Detail Ekstrakurikuler',
	'uri'	 => "data/non_akademik/ekstrakurikuler/id/{$row['ekskul_id']}",
	'attr'	 => 'title="lihat detail ekstrakurikuler"',
);

$pills_nisisxkul = array();

if ($admin OR ( $row['semester_id'] == $semaktif['id'] && $user["id"] == $row["pembina_id"]))
{
	$pills_nisisxkul[] = array(
		'label'	 => '<i class="icon-upload"></i>Impor',
		'uri'	 => "nilai/ekstrakurikuler/impor/" . $row['id'],
		'attr'	 => 'title="impor keterangan ekskul siswa"',
		'class'	 => 'active',
	);
}

// data tabel

$detail['umum'] = array(
	'Semester'			 => array(
		'semester_nama',
		'ucfirst',
		'suffix' => array(
			' ',
			'ta_nama',
		),
	),
	'Ekstrakurikuler'	 => array('ekskul_nama'),
	'Pembina'			 => array('pembina_nama'),
);

// input filter/pencarian siswa

$input = array(
	'term'		 => array(
		'term',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-xlarge',
		'placeholder'	 => 'pencarian siswa',
	),
	'kelas_id'	 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-large select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
);

// pagination data siswa

if ($siswa_resultset['overload'] == TRUE)
	$stat = "{$siswa_resultset['start']} sampai {$siswa_resultset['end']}. Total lebih dari {$siswa_resultset['total_rows']} baris.";
else
	$stat = "{$siswa_resultset['start']} sampai {$siswa_resultset['end']} dari {$siswa_resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment' => 5,
	'num_links' => 5,
	'next_link' => '→',
	'prev_link' => '←',
	'first_link' => '&compfn;',
	'last_link' => '&compfn;',
	'base_url' => "{$uri}/{$row['id']}",
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

$this->md->paging($siswa_resultset, $pagination);

// subtabel data siswa

$siswa_table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Kelas'		 => 'kelas_nama',
		'NIS'		 => 'siswa_nis',
		'Nama'		 => 'siswa_nama',
		'L/P'		 => array('siswa_gender', 'strtoupper'),
		'Nilai'		 => 'nilai',
		'Keterangan' => 'keterangan',
	),
);

//baars

$bar = '<div>'
	. form_opening("{$uri}/{$row['id']}", 'method = "get" class = "form-search well"')
	. pills($pills_nisisxkul, 'class="nav nav-pills pull-right"')
	. form_cell($input['term'], $request) . '&nbsp;	'
	. form_cell($input['kelas_id'], $request) . '&nbsp;	'
	. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
	. a("{$uri}/{$row['id']}", 'Reset', 'class="btn" title="reset pencarian"')
	. form_close()
	. '</div>';

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Detail Penilaian Ekstrakurikuler')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Detail Nilai Ekstrakurikuler</h1>
				</div>

				<style>
					.controls{
						font-size: 1.2em;
						margin: 0.2em 0;
						color: black;
					}
				</style>

				<?php

				echo alert_get();

				// data utama

				echo pills($pills);
				echo '<div class="form-horizontal"><fieldset>';

				foreach ($detail['umum'] as $label => $cdat):
					echo "<div class=\"control-group t-data\"><label class=\"control-label\">{$label}</label><div class=\"controls\">"
					. data_cell($cdat, $row) . "</div></div>";
				endforeach;

				echo '</fieldset></div><br/><br/>';

				// daftar siswa

				echo '<div class="form-horizontal"><fieldset>';
				echo '<legend>Daftar Nilai Siswa</legend>';
				echo $bar;
				echo ds_table($siswa_table, $siswa_resultset);
				echo '</fieldset></div><br/><br/>';

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>