<?php

class M_nilai_org extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array());
		$this->dm['admin'] = cfguc_admin('akses', 'nilai', 'organisasi');
		$this->dm['view'] = cfguc_view('akses', 'nilai', 'organisasi');
		$this->dm['org_terkait'] = $this->org_terkait();

	}

	// dasar database

	function org_terkait()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$user = $this->ci->d['user'];
		$query = array(
			'select' => array('id', 'nama'),
			'from'	 => 'dnakd_organisasi',
		);

		if ($user['role'] == 'siswa')
			return NULL;

		if (!$dm['view'])
			$query['where']['pembina_id'] = $d['user']['id'];

		return $this->md->query($query)->result_series('id', 'nama');

	}

	function filter_2($query)
	{
		$r = & $this->ci->d['request'];
		$dm = & $this->dm;

		if (!$dm['view'])
			return $query;

		if (isset($r['org_id']) && $r['org_id'] > 0)
			$query['where']['niorg.org_id'] = $r['org_id'];

		if (isset($r['semester_id']) == FALSE OR ! $r['semester_id'])
		{
			$r['semester_id'] = $this->md->row_col('id', 'select id from prd_semester order by id desc limit 1');
		}

		$query['where']['niorg.semester_id'] = $r['semester_id'];

		return $query;

	}

	function query_2()
	{
		$d = $this->ci->d;
		$dm = & $this->dm;

		// query dasar

		$query = array(
			'from'		 => 'nilai_organisasi niorg',
			'join'		 => array(
				array('prd_semester semester', 'niorg.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dnakd_organisasi org', 'niorg.org_id = org.id', 'inner'),
				array('dprofil_sdm pembina', 'niorg.pembina_id = pembina.id', 'left'),
			),
			'order_by'	 => 'semester.id desc, org.nama',
			'select'	 => array(
				'niorg.*',
				'ta_nama'			 => 'ta.nama',
				'semester_nama'		 => 'semester.nama',
				'org_nama'			 => 'org.nama',
				'org_aktif'			 => 'org.aktif',
				'pembina_nama'		 => "trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix))",
				'pembina_aktif_id'	 => 'org.pembina_id',
			),
		);

		// filter akses

		if (!$dm['admin'])
			$query['where']['org.aktif'] = 1;

		if (!$dm['view'])
			$query['where']['org.pembina_id'] = $d['user']['id'];

		if ($d['user']['role'] == 'siswa'):
			$query['join'][] = array('nilai_siswa_org nisisorg', 'niorg.id = nisisorg.org_nilai_id', 'inner');
			$query['join'][] = array('nilai_siswa nisis', 'nisisorg.siswa_nilai_id = nisis.id', 'inner');
			$query['where']['nisis.siswa_id'] = $d['user']['id'];
			$query['select']['nisisorg_keterangan'] = 'nisisorg.keterangan';

		endif;

		return $query;

	}

	// operasi data basic

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->filter_2($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function rowset($id)
	{
		$query = $this->query_2();
		$query['where']['niorg.id'] = $id;

		return $this->md->query($query)->row();

	}

	function rowsub_siswa($niorg_id, $index = 0, $limit = 50)
	{
		$r = $this->ci->d['request'];
		$u = $this->ci->d['user'];
		$query = array(
			'select'	 => array(
				'nisisorg.*',
				'nilsis.siswa_id',
				'siswa_nama'	 => 'siswa.nama',
				'siswa_nis'		 => 'siswa.nis',
				'siswa_nisn'	 => 'siswa.nisn',
				'siswa_aktif'	 => 'siswa.aktif',
				'siswa_gender'	 => 'siswa.gender',
				'siswa.agama_id',
				'agama_nama'	 => 'agama.nama',
				'kelas_nama'	 => 'kelas.nama',
			),
			'from'		 => 'nilai_siswa_org nisisorg',
			'join'		 => array(
				array('nilai_siswa nilsis', 'nisisorg.siswa_nilai_id = nilsis.id', 'inner'),
				array('dprofil_siswa siswa', 'nilsis.siswa_id = siswa.id', 'inner'),
				array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				array('dakd_kelas kelas', 'nilsis.kelas_id = kelas.id', 'inner'),
			),
			'where'		 => array(
				'nisisorg.org_nilai_id' => $niorg_id,
			),
			'order_by'	 => 'kelas.grade, kelas.nama, siswa.nama',
		);

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$query['where']['kelas.id'] = $r['kelas_id'];

		if (isset($r['term']) && $r['term'])
			$query['like'] = array($r['term'], 'siswa.nama');

		if ($u['role'] == 'siswa')
			$query['where']['siswa.id'] = $u['id'];

		return $this->md->query($query)->resultset($index, $limit);

	}

	// expor impor

	function expor($niorg_id)
	{

		// deklarasi variabel

		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->ci->d;
			$niorg_id = (int) $niorg_id;
			$kelas_jml = 0;
			$sheet_no = 0;
			$data = array();
			$kelas_list = array();
			$excel_row_offset = 8;
			//$excel_source = 'content/template/nilai_organisasi.blank.xlsx';
			$excel_source = APP_ROOT.'content/'.strtolower(APP_SCOPE).'/template/nilai_organisasi.blank.xlsx';
			$subsql_nisisorg = "(select * from nilai_siswa_org where org_nilai_id = {$niorg_id}) nisisorg";
			$query_nisisorg = array(
				'from'		 => 'dprofil_siswa siswa',
				'join'		 => array(
					array('nilai_siswa nisis', 'siswa.id = nisis.siswa_id', 'inner'),
					array('dakd_kelas kelas', 'nisis.kelas_id = kelas.id', 'inner'),
					array($subsql_nisisorg, 'nisis.id = nisisorg.siswa_nilai_id', 'left'),
				),
				'where'		 => array(
					'nisis.semester_id' => $d['row']['semester_id'],
				),
				'order_by'	 => 'kelas.grade, kelas.nama, siswa.nama',
				'select'	 => array(
					'nisisorg.id',
					'nisisorg.keterangan',
					'siswa_id'		 => 'siswa.id',
					'siswa_nis'		 => 'siswa.nis',
					'siswa_nama'	 => 'siswa.nama',
					'siswa_gender'	 => 'siswa.gender',
					'kelas_id'		 => 'kelas.id',
					'kelas_nama'	 => 'kelas.nama',
					'kelas_wali_id'	 => 'kelas.wali_id',
					'nisis_id'		 => 'nisis.id',
				),
			);
			$wali_query = array(
				'select' => array(
					'id',
					'nama' => "trim(concat_ws(' ', prefix, nama, suffix))"
				),
				'from'	 => 'dprofil_sdm',
			);
			$cfg = array(
				'row.niorg'			 => array(
					'A3' => array(
						'org_nama',
						'prefix' => "Daftar keterangan organisasi ",
						'suffix' => array(
							' ',
							'semester_nama',
							' ',
							'ta_nama',
						),
					),
					'B5' => array('id'),
					'F6' => array('pembina_nama', 'prefix' => 'Pembina : '),
				),
				'row.kelas'			 => array(
					'A10'	 => array(
						'nama',
						'prefix' => 'KELAS : ',
					),
					'A11'	 => array(
						'wali_nama',
						'prefix' => 'Wali Kelas : ',
					),
				),
				'table.nisisorg'	 => array(
					// data pribadi
					'B'	 => array('nisis_id'),
					'C'	 => array('siswa_nis'),
					'D'	 => array('siswa_nama'),
					'E'	 => array('siswa_gender', 'strtoupper'),
					// keterangan
					'F'	 => array('keterangan'),
				),
				'kolom.invicible'	 => array('B'),
			);

		endif;

		// ambil template data sesuai kelas

		$req_kelas_list = (array) $this->input->get_post('kelas_list');
		$req_kelas_list = (array) array_filter($req_kelas_list, 'is_numeric');

		if (empty($req_kelas_list))
			return alert_error("Pilihan daftar kelas yang hendak ditampilkan.", "nilai/ekstrakurikuler/impor/{$niorg_id}");

		$query_nisisorg['where_in']['kelas.id'] = $req_kelas_list;
		$template_result = $this->md->query($query_nisisorg)->result();

		if ($template_result['selected_rows'] == 0)
			return alert_error("Daftar siswa tidak ditemukan pada kelas yang dipilih.", "nilai/ekstrakurikuler/impor/{$niorg_id}");

		$this->load->library('PHPExcel');

		// variabel phpexcel

		if (TRUE):
			$style = array(
				'.umum'		 => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
				),
				'top-double' => array(
					'borders' => array(
						'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
						),
					),
				),
			);
			// rata kiri
			$style['tengah'] = $style['.umum'];
			$style['tengah']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;

			// rata kiri
			$style['kiri'] = $style['.umum'];
			$style['kiri']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;

			// rata kanan dgn inden
			$style['kanan_inden'] = $style['.umum'];
			$style['kanan_inden']['alignment']['horizontal'] = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
			$style['kanan_inden']['alignment']['indent'] = 1;

		endif;

		// siapkan data.dikelompokan per kelas

		foreach ($template_result['data'] as $_row):

			$_kls_id = (int) $_row['kelas_id'];

			if (isset($data[$_kls_id]['jml'])):
				$data[$_kls_id]['jml'] = $data[$_kls_id]['jml'] + 1;

			else:
				$kelas_jml++;
				$data[$_kls_id]['jml'] = 1;
				$data[$_kls_id]['nama'] = $_row['kelas_nama'];
				$data[$_kls_id]['wali_id'] = (int) $_row['kelas_wali_id'];
				$wali_query['where_in']['id'][] = (int) $_row['kelas_wali_id'];
				$kelas_list[] = $_kls_id;

			endif;

			$data[$_kls_id]['data'][] = $_row;

		endforeach;

		// cari data wali kelas

		$wali_array = $this->md->query($wali_query)->result_series('id', 'nama');

		foreach ($kelas_list as $_kls_id)
			$data[$_kls_id]['wali_nama'] = (string) array_node($wali_array, $data[$_kls_id]['wali_id']);

		// mulai buka excel

		$excel_obj = PHPExcel_IOFactory::load($excel_source);

		if (!$excel_obj)
			return exit('File source error.');

		// mulai isi data tiap kelas

		foreach ($kelas_list as $_kls_id):
			$sheet_no++;
			$data_kelas = & $data[$_kls_id];
			$_row_start = $excel_row_offset + 1;
			$_row_end = $excel_row_offset + $data_kelas['jml'];
			$_sheet = clone $excel_obj->getSheetByName('Sheet1');

			$_sheet->setTitle($data_kelas['nama']);
			$excel_obj->addSheet($_sheet, $sheet_no);

			$_sheet = $excel_obj->setActiveSheetIndex($sheet_no);

			// tulis data
			excel_row_write($_sheet, $d['row'], $cfg['row.niorg']);
			excel_row_write($_sheet, $data_kelas, $cfg['row.kelas']);
			excel_table_write($_sheet, $data_kelas['data'], $cfg['table.nisisorg'], $excel_row_offset, 'A');

			// styling blok
			//
			// no urut

			$_sheet->getStyle("A{$_row_start}:A{$_row_end}")->applyFromArray($style['kanan_inden']);

			// text
			$_sheet->getStyle("C{$_row_start}:D{$_row_end}")->applyFromArray($style['kiri']);
			$_sheet->getStyle("E{$_row_start}:E{$_row_end}")->applyFromArray($style['tengah']);
			$_sheet->getStyle("F{$_row_start}:F{$_row_end}")->applyFromArray($style['kiri']);

			// proteksi worksheet/lembarkerja

			$_cell_input = array(
				"F{$_row_start}:F{$_row_end}",
			);

			excel_security_cell_lock($_sheet, 'A1:E' . $_row_end);
			excel_security_cell_unlock($_sheet, $_cell_input);
			excel_security_sheet_lock($_sheet);

			// sembunyikan kolom & baris data sistem

			foreach ($cfg['kolom.invicible'] as $_col)
				$_sheet->getColumnDimension($_col)->setVisible(FALSE);

		endforeach;

		// sembunyikan template

		$excel_obj->removeSheetByIndex(0);

		// keamanan dokumen

		excel_security_doc_lock($excel_obj);

		// output

		return excel_output_2007($excel_obj, "{$d['row']['org_nama']}.xlsx");

	}

	function impor()
	{
		$d = & $this->ci->d;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();
		$sheetnames = $PHPExcel->getSheetNames();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;

		// deklarasi variabel

		if (TRUE):
			$niorg_id = (int) $d['row']['id'];
			$ketchar_max = 400;
			$entry_total = 0;
			$nisis_list = array();
			$nisisorg_insert = array();
			$nisisorg_update = array();
			$nisisorg_delete = array();
			$nisisorg_query = array(
				'from'	 => 'nilai_siswa_org',
				'where'	 => array(
					'org_nilai_id' => (int) $d['row']['id'],
				),
				'select' => array('id', 'siswa_nilai_id'),
			);
			$sql_rekap = "
update nilai_organisasi niorg

inner join (
select org_nilai_id, count(*) jml
from nilai_siswa_org
where org_nilai_id = ?
	and keterangan != ''
group by org_nilai_id
) nisisorg on niorg.id = nisisorg.org_nilai_id

set niorg.siswa_jml = nisisorg.jml

where niorg.id = ?
";

		endif;

		// ambil data nilai org yg telah ada

		$nisisorg_list = $this->md->query($nisisorg_query)->result_series('siswa_nilai_id', 'id');

		// mulai ambil data

		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):

			$sheet = $PHPExcel->setActiveSheetIndex($_sheet_index);
			$row_max = $sheet->getHighestRow();
			$row_start = 9;

			for ($_row_no = $row_start; $_row_no <= $row_max; $_row_no++):
				$_nisis_id = (int) $sheet->getCell('B' . $_row_no)->getValue();

				if ($_nisis_id < 1)
					continue;

				$_cell = 'F' . $_row_no;
				$_keterangan = clean($sheet->getCell($_cell)->getValue());

				if (strlen($_keterangan) > $ketchar_max):
					alert_error("Keterangan pada halaman/sheet {$sheetnames[$_sheet_index]}, kotak/cell {$_cell} tak boleh lebih dari 400 karakter.");
					continue;

				endif;

				$nisis_list[] = $_nisis_id;
				$_ada = array_key_exists($_nisis_id, $nisisorg_list);
				$_kosong = empty($_keterangan);

				// pilih operasi

				if ($_ada && $_kosong):
					$entry_total++;
					$_nisisorg_id = $nisisorg_list[$_nisis_id];
					$nisisorg_delete[] = $_nisisorg_id;

				elseif ($_ada && !$_kosong):
					$entry_total++;
					$_nisisorg_id = $nisisorg_list[$_nisis_id];
					$nisisorg_update[] = array(
						'id'		 => $_nisisorg_id,
						'keterangan' => $_keterangan,
					);

				elseif (!$_ada && !$_kosong):
					$entry_total++;
					$nisisorg_insert[] = array(
						'siswa_nilai_id' => $_nisis_id,
						'org_nilai_id'	 => $niorg_id,
						'keterangan'	 => $_keterangan,
					);

				endif;

			endfor;

		endfor;

		// selesai extract data

		unset($sheet);
		$PHPExcel->disconnectWorksheets();
		unset($PHPExcel);
		@unlink($upload['full_path']);

		if ($entry_total == 0)
			return alert_error("Data siswa kosong/tidak terbaca.");

		// mulai operasi database

		$this->db->trans_begin();

		// delete

		if (!empty($nisisorg_delete))
			$this->db->where_in('id', $nisisorg_delete)->delete('nilai_siswa_org');

		// update

		if (!empty($nisisorg_update))
			$this->db->update_batch('nilai_siswa_org', $nisisorg_update, 'id');

		// insert

		if (!empty($nisisorg_insert))
			$this->db->insert_batch('nilai_siswa_org', $nisisorg_insert);

		// rekap jumlah

		$this->db->query($sql_rekap, array($niorg_id, $niorg_id));
		$this->trans_done('Daftar keterangan ekstrakurikuler telah diperbarui.', 'Database error saat memperbarui keterangan ekstrakurikuler.');

		// selesai

		return !$d['error'];

	}

}
