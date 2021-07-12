<?php

function config_link($key)
{
	//$name = str_replace("_"," ",$key);
	return a("app/config/" . $key, $key,'class="btn btn-success"');

}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Config',
);

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
	'uri_segment'		 => 5,
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
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Nama'			 => array('key', 'config_link'),
		'Konfigurasi'	 => 'value',
	),
);

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Konfigurasi')); ?>

	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1>Konfigurasi</h1>
				</div>

				<?php

				echo alert_get();
				echo ds_table($table, $resultset);

				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>