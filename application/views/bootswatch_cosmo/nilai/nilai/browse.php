<?php

// function

function div_right($txt)
{
	return div('align="right"', $txt);

}

function display_nilai($nilai)
{
	return div_right(formnil_angka($nilai));

}

function display_title($row)
{
	$ci = & get_instance();

	if ($ci->d['user']['role'] == 'siswa')
		return div("title='{$row['mapel_nama']}'", $row['pelajaran_nama']);

	return a("nilai/pelajaran/id/{$row['id']}", $row['pelajaran_nama'], "title=\"{$row['mapel_nama']}\nklik untuk melihat detail nilai pelajaran\"");

}

function display_upload($tgl)
{
	$dt = new DateTime($tgl);
	$batas = new DateTime('2015-');

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Nilai'							 => 'nilai',
	'Pelajaran',
);

// pills link
$pills = array();
$pills2 = array();
if ($admin)
{
	if(APP_SUBDOMAIN == 'sman8-smg.fresto.co'){
		$pills[] = array(
			'label'	 => "<i class=\"icon-upload\"></i>Upload Template KTSP",
			'uri'	 => "nilai/pelajaran/template_sekolah/ktsp",
			'attr'	 => 'title="Upload template nilai pelajaran"',
			'class'	 => 'active',
		);
		$pills[] = array(
			'label'	 => "<i class=\"icon-upload\"></i>Upload Template K13",
			'uri'	 => "nilai/pelajaran/template_sekolah/k13",
			'attr'	 => 'title="Upload template nilai pelajaran"',
			'class'	 => 'active',
		);
	}else{
		$pills2[] = array(
			'label'	 => "<i class=\"icon-upload\"></i>Arsip Deskripsi Mapel",
			'uri'	 => "nilai/pelajaran/upload_deskripsi/expor/".$request['semester_id'],
			'attr'	 => 'title="Upload deskripsi mapel"',
			'class'	 => 'active',
		);
		
		$pills[] = array(
			'label'	 => "<i class=\"icon-upload\"></i>Upload Template Nilai",
			'uri'	 => "nilai/pelajaran/template_sekolah",
			'attr'	 => 'title="Upload template nilai pelajaran"',
			'class'	 => 'active',
		);
		
		$pills2[] = array(
			'label'	 => "<i class=\"icon-upload\"></i>Upload Deskripsi Mapel",
			'uri'	 => "nilai/pelajaran/upload_deskripsi",
			'attr'	 => 'title="Upload deskripsi mapel"',
			'class'	 => 'active',
		);
	}
}

// input filter/pencarian

$input = array(
	'term'			 => array(
		'term',
		'placeholder'	 => 'pencarian',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-small',
	),
	'pelajaran_id'	 => array(
		'pelajaran_id',
		'type'		 => 'dropdown',
		'name'		 => 'pelajaran_id',
		'id'		 => 'pelajaran_id',
		'extra'		 => 'id="pelajaran_id" class="input-medium select"',
		'options'	 => $this->m_option->pelajaran('pelajaran'),
	),
	'semester_id'	 => array(
		'semester_id',
		'type'		 => 'dropdown',
		'name'		 => 'semester_id',
		'id'		 => 'semester_id',
		'extra'		 => 'id = "semester_id" class = "input-medium select"',
		'options'	 => $this->m_option->semester('semester'),
	),
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 4,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => $uri,
	'full_tag_open'		 => '<div class="pagination"><ul>',
	'full_tag_close'	 => "<li class=\"disabled\"><a href=\"#\">{$stat}</a></li></ul></div>",
	'cur_tag_open'		 => '<li class="active"><a href="#">',
	'cur_tag_close'		 => '</a></li>',
	'num_tag_open'		 => '<li>',
	'num_tag_close'		 => '</li>',
	'first_tag_open'	 => '<li>',
	'first_tag_close'	 => '</li>',
	'last_tag_open'		 => '<li>',
	'last_tag_close'	 => '</li>',
	'next_tag_open'		 => '<li>',
	'next_tag_close'	 => '</li>',
	'prev_tag_open'		 => '<li>',
	'prev_tag_close'	 => '</li>',
);

$this->md->paging($resultset, $pagination);

// tabel data

$table = array(
	'table_properties'	 => array(
		'id'	 => 'tabel-nipel',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Semester'		 => array(
			'semester_nama',
			'ucfirst',
			'suffix' => array(
				' ',
				'ta_nama',
			),
		),
		'Pelajaran'		 => array(FALSE, 'display_title'),
		'Pengajar'		 => 'guru_nama',
		div_right('KKM') => array('kkm', 'display_nilai'),
	),
);

if ($user['role'] == 'siswa'):
	$table['data'][div_right('Rata2 Teori')] = array('nas_teori', 'display_nilai');
	$table['data'][div_right('Rata2 Praktek')] = array('nas_praktek', 'display_nilai');
	$table['data'][div_right('Akhir Teori')] = array('siswa_nas_teori', 'display_nilai');
	$table['data'][div_right('Akhir Praktek')] = array('siswa_nas_praktek', 'display_nilai');

else:
	$table['data'][div_right('Akhir Teori')] = array('nas_teori', 'display_nilai');
	$table['data'][div_right('Akhir Praktek')] = array('nas_praktek', 'display_nilai');

endif;

if ($user['role'] == 'admin'):
	$table['data']['Upload'] = array('diolah','tglwaktu');

endif;
// bars

$bar_filter = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. pills($pills2, 'class="nav nav-pills pull-right"')
	. pills($pills, 'class="nav nav-pills pull-right"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['semester_id'], $request) . '&nbsp;';

if ($view)
	$bar_filter .= form_cell($input['pelajaran_id'], $request) . '&nbsp;';

$bar_filter .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"')
	. form_close()
	. '</div>';

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array(' title' => 'Nilai Semester Pelajaran')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Nilai Semester Pelajaran</h1>
				</div>

				<?php

				echo alert_get();
				echo $bar_filter;
				echo ds_table($table, $resultset);

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>