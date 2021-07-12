<?php

$r = & $this->d['request'];
$r['evaluasi_id'] = $row['id'];
$r['term'] = '';
$r['kelas_id'] = '';
$r['order_by'] = '';

$ruri_nilai = "kbm/evaluasi_nilai/browse?evaluasi_id={$row['id']}";
$resultset = $this->m_kbm_evaluasi_nilai->browse(0, 2000);

// fungsi

function disnil_ljs($row) {
	if (!$row['ljs_id'])
		return '<i>kosong</i>';

	if (!$row['evaluasi_terkoreksi'])
		return a("kbm/evaluasi_ljs/koreksi?id={$row['ljs_id']}", 'Koreksi', 'class="btn btn-success btn-small" title="koreksi lembar jawab siswa"');

	return a("kbm/evaluasi_ljs/id/{$row['ljs_id']}", 'Lihat', 'class="btn btn-info btn-small" title="lihat lembar jawab siswa"');
}

function disnil_status($nilai, $kkm) {
	//return "nilai {$nilai}, kkm {$kkm}";
	return ($nilai >= $kkm) ? 'tuntas' : 'belum tuntas';
}

// pills link

$pills[] = array(
		'label' => '<i class="icon-download"></i>Masukan Rapor',
		'uri' => "kbm/evaluasi/rekap?id={$row['id']}",
		'attr' => 'title="Masukan daftar nilai ini ke rekap rapor"',
		'class' => (($row['status'] == 'closed') ? 'active' : 'disabled' ),
);

$pills[] = array(
		'label' => '<i class="icon-download"></i>Download',
		'uri' => "kbm/evaluasi_nilai/download?evaluasi_id={$row['id']}",
		'attr' => 'title="Download daftar nilai ini" target="_blank"',
		'class' => 'active',
);

// input filter/pencarian

$input = array(
		'term' => array(
				'term',
				'placeholder' => 'pencarian',
				'type' => 'input',
				'name' => 'term',
				'id' => 'term',
				'class' => 'input input-small',
		),
		'kelas_id' => array(
				'kelas_id',
				'type' => 'dropdown',
				'name' => 'kelas_id',
				'id' => 'kelas_id',
				'extra' => 'class="input-small select"',
				'options' => $this->m_option->kelas('kelas'),
		),
		'order_by' => array(
				'order_by',
				'type' => 'dropdown',
				'name' => 'order_by',
				'id' => 'order_by',
				'extra' => 'class="input-medium select"',
				'options' => array(
						'kelas, nama' => 'urut: kelas, nama',
						'nilai' => 'urut: nilai',
				),
		),
);


// tabel data

$table = array(
		'table_properties' => array(
				'id' => 'tabel-nilai',
				'class' => 'table table-bordered table-striped table-hover',
		),
		'empty_message' => '<div class="alert alert-block" align="center"><p><i>data kosong / tidak ditemukan</i></p></div>',
		'data' => array(
				'Kelas' => 'kelas_nama',
				'NIS' => 'siswa_nis',
				'Siswa' => 'siswa_nama',
				'Gender' => array('siswa_gender', 'strtoupper'),
				'<div align="right">Poin &nbsp; </div>' => array(
						'evaluasi_poin',
						'prefix' => '<div align="right">',
						'suffix' => array(
								' / ',
								'evaluasi_poin_max',
								'&nbsp; </div>',
						),
				),
				'<div align="right">Nilai &nbsp; </div>' => array(
						'evaluasi_nilai',
						//'formnil_angka',
						'prefix' => '<div align="right"><b>',
						'suffix' => '&nbsp; </b></div>',
				),
				'Status' => array('evaluasi_nilai', 'disnil_status', $row['kkm']),
				'LJS' => array(FALSE, 'disnil_ljs'),
		),
);
// bar form soal

function table_nilai($row, $data, $request, $user)
{
	//$data = $row['kelas_result']['data'];
	//print_r($row['kelas_result']);
	$header_table = "
				<tr>
                    <th>Kelas</th>
					<th>Siswa</th>
					<th>NIS</th>
					<th>Gender</th>
					<th>Poin</th>
					<th>Nilai</th>
					<th>Status</th>
					<th>LJS</th>";
						
	$header_table .= "</tr>";
	
    ?>
    <div class="card" id="table">
        
        <br>
        <div class="table-responsive">
            <table id="data-table-basic-nilai" class="table table-striped">
                <thead>
                 <?php echo $header_table;?>
                </thead>
                <tfoot>
                  <?php echo $header_table;?>
                </tfoot>
                <tbody>
                    <?php
					
					foreach($data as $view)
					{
						echo"<tr>
						 	<td>".$view['kelas_nama']."</td>
							<td>".$view['siswa_nama']."</td>
							<td>".$view['siswa_nis']."</td>
							<td>".$view['siswa_gender']."</td>
							<td>".$view['evaluasi_poin']." / ".$view['evaluasi_poin_max']."</td>
							<td>".$view['evaluasi_nilai']."</td>
							<td>".disnil_status($view['evaluasi_nilai'], $row['kkm'])."</td>
							<td>".disnil_ljs($view)."</td>";
							
						echo"</tr>";
					}
					?>
                </tbody>
             </table>
           </div>
         </div>
    <?php
}

$no=0;
echo table_nilai($row, $resultset['data'], $request, $user);

/*
echo '<div class="form-horizontal"><fieldset>';
echo '<legend>Daftar Nilai Siswa</legend>';
echo $bar_cari_nilai;
echo ds_table($table, $resultset);
echo '</fieldset></div><br/>';
*/
?>

<script type="text/javascript">
   
$(document).ready(function() {
	$('#data-table-basic-nilai').DataTable();
} );

$('#data-table-basic-nilai').dataTable( {
  "pageLength": 50
} );

setTimeout(function(){nowAnimation('nilai','fadeInUp')},400);
</script>
