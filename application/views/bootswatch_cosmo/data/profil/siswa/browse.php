<?php


// function
function display_bill($row) {
	$html = " <a href='http://idn.fresto.top/public/bill-search?nis={$row['id']}'> Pembayaran </a>&nbsp; ";
	return $html;
}
function display_reset($row) {
	$html = a("data/profil/siswa/reset_password_back/{$row['id']}", 'reset back passw', 'class="btn btn-small btn-success" title="reset kembali password siswa ini"') . " &nbsp; ";
	return $html;
}
function display_edit($row) {
	$html = a("data/profil/siswa/form?id={$row['id']}", 'edit', 'class="btn btn-small btn-success" title="ubah data siswa ini"') . " &nbsp; ";
	return $html;
}

function display_delete($row) {
	$html = a("data/profil/siswa/delete_permanent/{$row['id']}", 'delete permanent', 'class="btn btn-small btn-danger"  onclick="return confirm(\'APAKAH ANDA YAKIN MENGHAPUS SELURUH DATA \n'.$row['nama'].' ?\')" title="hapus data siswa ini"');
	return $html;
}


function display_nama($row) {
	return a("data/profil/siswa/id/{$row['id']}?ringkas=ya", $row['nama'], 'title="lihat detail data siswa ini"');
}

function display_kelas($kls) {
	return ($kls) ? $kls : '-';
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'Profil' => 'data/profil',
		'Siswa',
);

// pills link

/*$pills['impor'] = array(
		'label' => '<i class="icon-download"></i>Impor',
		'uri' => "data/profil/siswa/impor",
		'attr' => 'title="impor data siswa"',
		'class' => 'disabled',
);*/
$pills['tambah_excel'] = array(
		'label' => '<i class="icon-download"></i>Tambah Excel',
		'uri' => "data/profil/siswa/tambah_excel_siswa",
		'attr' => 'title="tambah siswa massal"',
		'class' => 'disabled',
);
$pills['edit_excel'] = array(
		'label' => '<i class="icon-download"></i>Edit Excel',
		'uri' => "data/profil/siswa/edit_excel_siswa",
		'attr' => 'title="edit siswa massal"',
		'class' => 'disabled',
);
$pills['tambah'] = array(
		'label' => '<i class="icon-star"></i>Tambah',
		'uri' => "data/profil/siswa/form",
		'attr' => 'title="tambah siswa baru"',
		'class' => 'disabled',
);

$pills['cetak'] = array(
		'label' => '<i class="icon-download"></i>Cetak Excel',
		'uri' => "data/profil/siswa/print_excel_siswa",
		'attr' => 'title="print excel siswa"',
		'class' => 'active',
);



if ($admin):
	$pills['edit_excel']['class'] = 'active';
	//$pills['tambah']['class'] = 'active';
	if ($semaktif['id'] == 0)
	{
		$pills['tambah']['class'] = 'active';
		$pills['tambah_excel']['class'] = 'active';
	}//$pills['impor']['class'] = 'active';

endif;

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-medium',
				'placeholder' => 'pencarian',
				'title' => 'ketikan kata kunci pencarian',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'options' => $this->m_option->kelas('kelas'),
				'extra' => 'id="kelas_id" class="input-medium select"',
		),
		'kelas_grade'		 => array(
			'kelas_grade',
			'type'		 => 'dropdown',
			'name'		 => 'kelas_grade',
			'id'		 => 'kelas_grade',
			'extra'		 => 'class="input-medium select"',
			'options'	 => $this->m_option->grade('grade'),
		),
		'aktif' => array(
				'aktif',
				'type' => 'dropdown',
				'name' => 'aktif',
				'id' => 'aktif',
				'options' => array(
						'' => 'login',
						'aktif login',
						'disable login',
				),
				'extra' => 'id="aktif" class = "input-medium select" title="siswa yang masih aktif dalam KBM"',
		),
);
$input['kelas_id']['options'][0] = '[alumni/non-aktif]';

// pagination

if ($resultset['overload'] == TRUE)
	$stat = "{$resultset['start']} sampai {$resultset['end']}. Total lebih dari {$resultset['total_rows']} baris.";
else
	$stat = "{$resultset['start']} sampai {$resultset['end']} dari {$resultset['total_rows']} baris.";

$pagination = array(
		'uri_segment' => 5,
		'num_links' => 5,
		'next_link' => '→',
		'prev_link' => '←',
		'first_link' => '&compfn;',
		'last_link' => '&compfn;',
		'base_url' => $this->d['uri'],
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
				'id' => 'tabel-siswa',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'N I S' => 'nis',
				'ID' => 'id',
				'Nama' => array(FALSE, 'display_nama'),
				'PD ID E-Rapor' => 'pd_id_erapor',
				'L/P' => array('gender', 'strtoupper'),
		),
);

if ($user['role'] == 'admin')
	$table['data']['Login'] = array('aktif', array('blokir', 'aktif'));

if ($admin):
	$table['data']['Edit'] = array(FALSE, 'display_edit');
	$table['data']['Reset Back Password'] = array(FALSE, 'display_reset');
	if($user['id'] == 11){ 
		$table['data']['Pembayaran'] = array(FALSE, 'display_bill');
	}
	if ($semaktif['id'] == 0)
	{
		$table['data']['Delete'] = array(FALSE, 'display_delete');
	}
endif;


// bars

$pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. pills($pills, 'class="nav nav-pills pull-right"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['kelas_grade'], $request) . '&nbsp;'
			. form_cell($input['kelas_id'], $request) . '&nbsp;';

if ($user['role'] == 'admin')
	$pencarian .= form_cell($input['aktif'], $request) . '&nbsp;';

$pencarian .= form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"');
			
if ($semaktif['id'] == 0){
	$pencarian .= a("data/profil/siswa_tool/status_naik_kelas", 'EDIT Status Naik Kelas/LULUS', 'class="btn btn-info"'). '&nbsp;';
	
}
$pencarian .= form_close()
			. '</div>';
			
			
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'Siswa')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->
			<div id="tabel">
				<div class="page-header">
					<h1>Siswa</h1>
				</div>

				<?php
				echo alert_get();
				echo $pencarian;
				echo ds_table($table, $resultset);
				?>

			</div>

			<?php $this->load->view(THEME . "/-html-/content/footer"); ?>

    </div><!-- /container -->

		<?php echo cosmo_js(); ?>

	</body>
</html>