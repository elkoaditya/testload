<?php

// function

function display_reseter($row)
{
	return a("app/tool/reset_session/{$row['session_id']}", "Reset", 'class="btn btn-sm btn-success" onClick="return confirm(\'Anda ingin menghapus session ini?\');" data-method="post"');

}

function display_time($time)
{
	$datetime = new DateTime();

	$datetime->setTimestamp($time);

	return $datetime->format('Y-m-d H:i');

}

function display_select($row){
	$input['checkbox'] = array(
		'input_ganti' => array(
				'name' => 'input_ganti[]',
				'id' => 'input_ganti',
				'value' => $row['session_id'],
				'style' => 'margin: 10px 10px 14px 0;',
		),
	);
	
	$html = form_checkbox($input['checkbox']['input_ganti']);
	
	return  $html;
}
// komponen

$this->load->helper('dataset');

// hak akses & user scope

$admin = cfguc_admin('akses', 'data', 'non_akademik', 'ekskul');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Tool'							 => 'tool',
	'Siswa login',
);

// input filter/pencarian

$input = array(
	'term'		 => array(
		'term',
		'type'			 => 'input',
		'name'			 => 'term',
		'id'			 => 'term',
		'class'			 => 'input input-medium',
		'placeholder'	 => 'pencarian',
		'title'			 => 'ketikan nama siswa',
	),
	'kelas_id'	 => array(
		'kelas_id',
		'type'		 => 'dropdown',
		'name'		 => 'kelas_id',
		'id'		 => 'kelas_id',
		'options'	 => $this->m_option->kelas('kelas'),
		'extra'		 => 'id="kelas_id" class="input-medium select"',
	),
);
// pagination

if ($resultset['overload'] == TRUE)
{
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
}
else
{
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";
}

$pagination = array(
	'uri_segment'		 => 4,
	'num_links'			 => 5,
	'next_link'			 => '→',
	'prev_link'			 => '←',
	'first_link'		 => '&compfn;',
	'last_link'			 => '&compfn;',
	'base_url'			 => $this->d['uri'],
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

// data

$table = array(
	'show_header'		 => TRUE,
	'pagination_link'	 => TRUE,
	'show_stat'			 => FALSE,
	'show_number'		 => TRUE,
	'row_action'		 => FALSE,
	'row_link'			 => FALSE,
	'jquery'			 => FALSE,
	'table_properties'	 => array(
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<p><i>data kosong</i></p>',
	'data'				 => array(
		'Cek'	 	 => array(FALSE, 'display_select'),
		'NIS'		 => 'nis',
		'Nama'		 => 'nama',
		'Kelas'		 => 'kelas_nama',
		'Aktif'		 => array('last_activity', 'display_time'),
		'IP Address' => 'ip_address',
		'Reset'		 => array(FALSE, 'display_reseter'),
	),
);

// bars

$pencarian = '<div>'
	. form_opening($uri, 'method="get" class="form-search well"')
	. form_cell($input['term'], $request) . '&nbsp;'
	. form_cell($input['kelas_id'], $request) . '&nbsp;'
	. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
	. a($uri, 'Reset', 'class="btn"')
	. form_close()
	. '</div>';

$bar2 = '<ul class="nav nav-pills pull-right" style="margin-bottom:-5px">'
	.'<li class="active" style="margin-right:5px">
		<input type="checkbox" onClick="toggle(this)" /> <b>Select All</b>
	  </li>'
	.'<li class="active" style="margin-right:5px">
		<button type="submit" class="btn btn-success nav nav-pills pull-right" name="reset_all" value="1">
			<i class="icon-save icon-white"></i> Reset All Checked
		</button></li>'
	
	.'</ul>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Siswa login')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Siswa Reset Login</h1>
				</div>

				<?php

				echo alert_get();
				echo $pencarian;
				
				echo form_opening($this->d['uri'], 'method="post" class="form-search well"');
				echo '<input type="hidden" name="reset_all_checked" value="1">';
				echo $bar2;
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