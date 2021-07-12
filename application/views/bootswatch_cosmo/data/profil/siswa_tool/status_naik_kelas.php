<?php

// vars

//$ruri = "{$uri}?evaluasi_id={$request['evaluasi_id']}";
$_SERVER['REQUEST_URI'] = str_replace(APP_SUBDOMAIN.'/','',$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];

// fungsi

function display_select($row){
	$input['checkbox'] = array(
		'input_ganti' => array(
				'name' => 'input_ganti[]',
				'id' => 'input_ganti',
				'value' => $row['id'],
				'style' => 'margin: 10px 10px 14px 0;',
		),
	);
	
	$html = form_checkbox($input['checkbox']['input_ganti']);
	
	return  $html;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Data' => 'data',
	'Profil' => 'data/profil',
	'Edit Naik Kelas / LULUS Siswa'
);


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
	'kelas_id'		 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('kelas'),
	),
	'kelas_grade'		 => array(
		'kelas_grade',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_grade',
		'id'		 => 'kelas_grade',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->grade('grade'),
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
		'id'	 => 'tabel-nilai',
		'class'	 => 'table table-responsive table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Grade'	 		=> 'kelas_grade',
		'Kelas'	 		=> 'kelas_nama',
		'Siswa'	 		=> 'nama',
		'Cek'	 		=> array(FALSE, 'display_select'),
		//'Gender' 		=> array('gender', 'strtoupper'),
		'Update Terakhir' 		=> array('modified', 'tglwaktu'),
		
	),
);

	
$bar = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['kelas_id'], $request) . '&nbsp;'
	. form_cell($input['kelas_grade'], $request) . '&nbsp;'
	. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"'). '&nbsp;'
	. form_close()
	. '</div>';

$input2 = array(
	'naik_kelas_id'		 => array(
		'naik_kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'naik_kelas_id',
		'id'		 => 'naik_kelas_id',
		'extra'		 => 'class="input-medium select"',
		'options'	 => $this->m_option->kelas('naik ke kelas'),
	)
);
	
$bar2 = '<ul class="nav nav-pills pull-right" style="margin-bottom:-5px">'
	.'<li style="margin-right:5px">
		<b>GANTI KELAS</b> &nbsp;&nbsp;
	  </li>'
	.'<li class="active" style="margin-right:5px">
		<input type="checkbox" onClick="toggle(this)" /> <b>Select All</b>
	  </li>'
	.'<li class="active" style="margin-right:5px">'
	. form_cell($input2['naik_kelas_id'], $request) . '&nbsp;'
	.'</li>'
	.'<li class="active" style="margin-right:5px">
		<button type="submit" class="btn btn-success nav nav-pills pull-right" name="ganti_kelas" value="1">
			<i class="icon-save icon-white"></i> GANTI KELAS
		</button></li>'
	.'</ul>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => "Edit Naik Kelas / LULUS Siswa")); ?>
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
					<h1>Edit Naik Kelas / LULUS Siswa</h1>
				</div>

				<?php

				echo alert_get();
				
				echo $bar;
				echo form_opening($ruri, 'method="post" class="form-search well"');
				echo '<input type="hidden" name="ganti_keikutsertaan" value="1">';
				echo '<div>'.$bar2.'<br><br><br></div>';
				
				echo ds_table($table, $resultset);
				echo form_close();

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>

<script>
	function toggle(source) {
	  checkboxes = document.getElementsByName('input_ganti[]');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
		checkboxes[i].checked = source.checked;
	  }
	}
</script>
