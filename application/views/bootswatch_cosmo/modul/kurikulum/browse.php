<?php

$kurikulums = $kurikulum['data'][0];

$uri = $uri.'/'.$kurikulums['kode'];

function display_nama($row) {

	return a("modul/kurikulum/id/{$row['id']}", $row['nama'], 'title="lihat detail data ini"');
}

function display_action($row,$user) {
	$html = '';
	
	if (strpos( $row['kurikulum_ubah'] , $user['role']) !== false) {
		$html = a("modul/kurikulum/form?id={$row['id']}", 'edit', 'class="btn btn-small btn-success" title="ubah data ini"') . " &nbsp; ";
	}
	
	if (strpos( $row['kurikulum_hapus'] , $user['role']) !== false) {
		$html .=a("modul/kurikulum/hapus_kurikulum_isi/{$row['id']}", 'delete', 'onClick="return confirm(\'Apakah Anda yakin hendak menghapusnya?\')"'. 
		'class="btn btn-small btn-success" title="hapus data ini"') . " &nbsp; ";
	}
	
	return $html;
}

function display_download($row) {
	$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);
	
	$file_path = array_node($row, array('lampiran', 'full_path'));
	
	return a($file_path."?download=1", 'download', 'target="_blank" class="btn btn-small btn-success" title="download data ini"');
}

function display_tanggal($row) {
	return tglwaktu($row['updated']);
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Kurikulum',
	$kurikulums['nama'],
);

// pills link

$pills = array();

if (strpos( $kurikulums['tambah'] , $user['role']) !== false) {
	
	$pills[] = array(
		'label'	 => '<i class="icon-star"></i>Tambah '.strtoupper($kurikulums['nama']).'',
		'uri'	 => "modul/kurikulum/form?kurikulum_id={$kurikulums['id']}",
		'attr'	 => 'title="tambah '.$kurikulums['nama'].' baru"',
		'class'	 => 'active'
	);
	
}

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
				'title' => 'ketikan kata kunci pencarian',
		),
		
		'semester_id' => array(
			'semester_id',
			'type' 		=> 'dropdown',
			'name' 		=> 'semester_id',
			'id' 		=> 'semester_id',
			'extra' 	=> 'class="input-medium select"',
			'options' 	=> $this->m_option->semester('semester'),
		),
		
		'updater_id' => array(
			'updater_id',
			'type'		 => 'dropdown',
			'name'		 => 'updater_id',
			'id'		 => 'updater_id',
			'options'	 => array('' => 'author'),
			'extra'		 => 'class="input-large select"',
		),
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
		'id'	 => 'tabel-kurikulum',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		$kurikulums['nama']	 => array(FALSE, 'display_nama'),
		'Tekahir Update'	 => array(FALSE, 'display_tanggal'),
		'Download'	 		 => array(FALSE, 'display_download'),
		'Action'	 		 => array(FALSE, 'display_action', $user),
	),
);


if (strpos( $kurikulums['tambah'] , 'sdm') !== false) {
	
	$table['grouping']['column'] = array('semester_id', 'guru_nama');
		
	$table['grouping']['title'] = array(
			'<span class="title"><b>',
			array('guru_nama', 'strtoupper'),
			'</b></span> &nbsp; ',
		);

}
	
function tnil_config($nama)
{
	return array(
		'pagination_link'	 => FALSE,
		'div_properties'	 => array(
			'id'	 => "div-nilsispel-{$nama}",
			'class'	 => "div-nilsispel-detail",
			'style'	 => "display: block",
		),
		'table_properties'	 => array(
			'id'	 => "tabel-nisispel-{$nama}",
			'class'	 => 'table table-bordered table-striped table-hover',
		),
		'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'show_header'		 => TRUE,
		'show_stat'			 => FALSE,
		'show_number'		 => TRUE,
		'row_action'		 => FALSE,
		'row_link'			 => FALSE,
		'jquery'			 => FALSE,
		'data'				 => array(
			'Nama'		 => array(FALSE, 'display_nama'),
		),
	);

}
		
$bar = '<div>'
			. form_opening($uri, 'method = "get" class = "form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['semester_id'], $request) . '&nbsp;	';


if ($view):

	if (strpos( $kurikulums['tambah'] , 'sdm') !== false) {
		
		$input['updater_id']['options'] = $this->m_option->sdm('author');
		$bar .= form_cell($input['updater_id'], $request) . '&nbsp;';
	}
endif;

$bar .=  	form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
			. a($uri, 'Reset', 'class="btn" title="reset pencarian"')
			. form_close()
			. '</div>';
			

?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Kurikulum')); ?>
	<style>
		.cell_nilai{
			text-align: right;
		}
		.controls{
			font-size: 1.2em;
			margin: 0.2em 0;
			color: black;
		}
		.div-nilsispel-detail{
			display: none;
		}
		.btn-nilai{
			margin-top: 30px;
			margin-bottom: 10px;
		}
	</style>
	<body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php

		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);

		?>

		<div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">

				<div class="page-header">
					<h1><?=strtoupper($kurikulums['nama'])?></h1>
				</div>

				<?php

				echo alert_get();
				echo $bar;
				echo ds_table($table, $resultset);
				
				//echo"<br><br>";
				//print_r($kurikulum);
				//echo"<br><br>";
				//print_r($resultset);
				
				?>
				
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>