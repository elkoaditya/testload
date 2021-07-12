<?php

function display_nama($row) {

	return a("modul/kurikulum/id/{$row['id']}", $row['nama'], 'title="lihat detail data ini"');
}

function display_action($row) {
	$html = a("modul/kurikulum/form?id={$row['id']}", 'edit', 'class="btn btn-small btn-success" title="ubah data ini"') . " &nbsp; ";
	$html .=a("modul/kurikulum/hapus_kurikulum_isi/{$row['id']}", 'delete', 'onClick="return confirm(\'Apakah Anda yakin hendak menghapusnya?\')"'. 
	'class="btn btn-small btn-success" title="hapus data ini"') . " &nbsp; ";
	
	return $html;
}

function display_download($row) {
	$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);
	
	$file_path = array_node($row, array('lampiran', 'full_path'));
	
	return a($file_path."?download=1", 'download', 'target="_blank" class="btn btn-small btn-success" title="download data ini"');
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
	'<i class="icon-home"></i>Depan' => '',
	'Kurikulum',
);

$input = array(
		'semester_id' => array(
				'semester_id',
				'type' => 'dropdown',
				'name' => 'semester_id',
				'id' => 'semester_id',
				'extra' => 'class="input-medium select"',
				'options' => $this->m_option->semester('semester'),
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
		'id'	 => 'tabel-siswa',
		'class'	 => 'table table-bordered table-striped table-hover',
	),
	'empty_message'		 => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
	'data'				 => array(
		'Nama'			 => array('nama'),
		'Nama Isi'		 => array(FALSE, 'display_nama'),
		'Konfigurasi'	 => 'value',
	),
);

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
			. form_cell($input['semester_id'], $request) . '&nbsp;	'
			. form_submit('cari', 'Cari', 'class = "btn btn-success"') . '&nbsp; '
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
					<h1>Kurikulum</h1>
				</div>

				<?php

				echo alert_get();
				echo $bar;
				//echo ds_table($table, $resultset);
				
				foreach($kurikulum['data'] as $data_kurikulum)
				{
					$nama_sbg = str_replace(" ","_",$data_kurikulum['nama']);
					echo "<div class=\"btn btn-info btn-medium btn-nilai\" onClick=\"$('#div-nilsispel-".$nama_sbg."').slideToggle(400);\">".strtoupper($data_kurikulum['nama'])." </div>";
					//$table_isi_temp	= $table_isi;
					$table_isi_temp = tnil_config($nama_sbg);
					
					//PEMBUAT
					if( $data_kurikulum['id']==4 )
					{	$table_isi_temp['data']['Pembuat'] 	 = array('guru_nama');	}
					
					//DOWNLOAD
					$table_isi_temp['data']['Download']	 = array(FALSE, 'display_download');
						
					if ($admin || ($user['role'] == 'sdm' && ( ($data_kurikulum['id']==3) || ($data_kurikulum['id']==4) ) ))
					{
						$table_isi_temp['data']['Action'] = array(FALSE, 'display_action');
						
						echo "<br/>".a("modul/kurikulum/form?kurikulum_id={$data_kurikulum['id']}",
						 ' <i class="icon-plus"></i> TAMBAH '.strtoupper($data_kurikulum['nama']), 'class="btn btn-success btn-small "')."<br/><br/>";
					}
					
					echo ds_table($table_isi_temp, $isi_kurikulum[$data_kurikulum['id']]);
					echo '<br/>';
				}
				
				?>
				
			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

		</div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>