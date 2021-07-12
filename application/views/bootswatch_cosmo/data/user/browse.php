<?php

// function

function display_nama($row) {
	return a("data/user/id/{$row['id']}", $row['nama'], 'title="lihat detail user"');
}

function display_action($row) {
	$ci = & get_instance();
	$dat = a("data/profil/{$row['role']}/id/{$row['id']}", 'profil', 'title="lihat profil user"') . ' &nbsp; ';

	if ($ci->d['admin'])
		$dat .= a("data/user/form?id={$row['id']}", 'edit', 'title="edit user"') . ' &nbsp; ';

	return $dat;
}

// komponen

$this->load->helper('dataset');

// breadcrumbs

$breadcrumbs = array(
		'<i class="icon-home"></i>Depan' => '',
		'Data' => 'data',
		'User',
);

// pills link
// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-medium',
		),
		'role' => array(
				'role',
				'type' => 'dropdown',
				'name' => 'role',
				'id' => 'role',
				'extra' => 'class="input-medium select" id="role"',
				'options' => array(
						'' => 'role',
						'sdm' => 'sdm',
						'siswa' => 'siswa',
				),
		),
);

if ($user['role'] == 'admin')
	$input['role']['options']['admin'] = 'admin';

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
				'id' => 'tabel-user',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<p><i>data user kosong/tidak ditemukan</i></p>',
		'data' => array(
				'Nama' => array(FALSE, 'display_nama'),
				'Username' => 'username',
				'Role' => 'role',
				'Aktif' => array('aktif', array('tidak', 'ya')),
				'Expire' => array('expire', 'tgl'),
				'Action' => array(FALSE, 'display_action'),
		),
);

// bars

$pencarian = '<div>'
			. form_opening($uri, 'method="get" class="form-search well"')
			. form_cell($input['term'], $request) . '&nbsp;'
			. form_cell($input['role'], $request) . '&nbsp;'
			. form_submit('cari', 'Cari', 'class="btn btn-success"') . ' '
			. a($uri, 'Reset', 'class="btn"')
			. form_close()
			. '</div>';
?>
<!DOCTYPE html>
<html lang="en">

	<?php $this->load->view(THEME . "/-html-/head", array('title' => 'User')); ?>

  <body class="preview" id="top" data-spy="scroll" data-target=".subnav" data-offset="80">

		<?php
		$this->load->view(THEME . "/-menu-/{$user['role']}");
		echo breacrumbs($breadcrumbs);
		?>

    <div class="container">

			<!-- Typography	================================================== -->

			<div id="tabel">
				<div class="page-header">
					<h1>User</h1>
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