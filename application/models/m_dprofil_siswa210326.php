<?php

class M_dprofil_siswa extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields-umum'		 => array(
				'nis', 'nisn', 'no_un', 'pd_id_erapor', 'aktif',
				'nama', 'gender', 'lahir_tempat', 'lahir_tgl', 'alamat', 'kota', 'telepon',
				'asal_sekolah_nama', 'asal_sekolah_alamat', 'asal_sekolah_jenjang',
				'asal_ijazah_no', 'asal_skhu_no', 'asal_ijazah_tahun',
				'status_keluarga', 'anak_ke',
				'ayah_nama', 'ayah_pekerjaan',
				'ibu_nama', 'ibu_pekerjaan',
				'ortu_alamat', 'ortu_telepon',
				'wali_nama', 'wali_alamat', 'wali_telepon', 'wali_pekerjaan',
				/// Tambahan tgl masuk /////
				'masuk_tgl',
				/// Tambahan baru /////
				'baru_sekolah_nama','baru_sekolah_alamat','baru_sekolah_tgl',
				'baru_kerja_nama','baru_kerja_alamat','baru_kerja_tgl',
				'baru_ket',
			),
			'fields-kelas-agama' => array(
				'kelas_id', 'agama_id',
			),
			'fields-masuk'		 => array(
				'masuk_jalur', 'masuk_tgl',
			),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'profil', 'siswa');
		$this->dm['view'] = cfguc_view('akses', 'data', 'profil', 'siswa');

		$this->dm['map.excel.agama.expor'] = array(
			'F'	 => 'id',
			'G'	 => 'nama',
		);
		
		$this->dm['map.excel.kelas.expor'] = array(
			'B'	 => 'id',
			'C'	 => 'nama',
		);
		
		$this->dm['map.excel.siswa.edit.expor'] = array(
			'B'	 => 'id',
			'C'	 => 'kelas_nama',
			'D'	 => 'nama',
			'E'	 => 'gender',
			'F'	 => 'agama_nama',
			'G'	 => 'masuk_kelas_id',
			'H'	 => 'nis',
			'I'	 => 'nisn',
			'J'	 => 'no_un',
			'K'	 => 'lahir_tempat',
			'L'	 => 'lahir_tgl',
			
			'M'	 => 'alamat',
			'N'	 => 'kota',
			'O'	 => 'telepon',
			
			'P'  => 'asal_sekolah_nama',
			'Q'  => 'asal_sekolah_alamat',
			'R'  => 'asal_sekolah_jenjang',
			'S'  => 'asal_ijazah_tahun',
			'T'  => 'asal_ijazah_no',
			'U'  => 'asal_skhu_no',
			
			'V'  => 'status_keluarga',
			'W'  => 'anak_ke',
			'X'  => 'ayah_nama',
			'Y'  => 'ayah_pekerjaan',
			'Z'  => 'ibu_nama',
			'AA'  => 'ibu_pekerjaan',
			'AB'  => 'ortu_alamat',
			'AC'  => 'ortu_telepon',
			
			'AD'  => 'wali_nama',
			'AE'  => 'wali_pekerjaan',
			'AF'  => 'wali_alamat',
			'AG'  => 'wali_telepon',
			
			
		);
		
		$this->dm['map.excel.siswa.edit.impor'] = array(
			'B'	 => 'id',
			
			'D'	 => 'nama',
			'E'	 => 'gender',
			'G'	 => 'masuk_kelas_id',
			'H'	 => 'nis',
			
			'I'	 => 'nisn',
			'J'	 => 'no_un',
			'K'	 => 'lahir_tempat',
			'L'	 => 'lahir_tgl',
			
			'M'	 => 'alamat',
			'N'	 => 'kota',
			'O'	 => 'telepon',
			
			'P'  => 'asal_sekolah_nama',
			'Q'  => 'asal_sekolah_alamat',
			'R'  => 'asal_sekolah_jenjang',
			'S'  => 'asal_ijazah_tahun',
			'T'  => 'asal_ijazah_no',
			'U'  => 'asal_skhu_no',
			
			'V'  => 'status_keluarga',
			'W'  => 'anak_ke',
			'X'  => 'ayah_nama',
			'Y'  => 'ayah_pekerjaan',
			'Z'  => 'ibu_nama',
			'AA'  => 'ibu_pekerjaan',
			'AB'  => 'ortu_alamat',
			'AC'  => 'ortu_telepon',
			
			'AD'  => 'wali_nama',
			'AE'  => 'wali_pekerjaan',
			'AF'  => 'wali_alamat',
			'AG'  => 'wali_telepon',
		);
		
		$this->dm['map.excel.siswa.tambah.impor'] = array(
			'C'	 => 'kelas_id',
			'D'	 => 'nama',
			'E'	 => 'gender',
			'F'	 => 'agama_id',
			
			'H'	 => 'nis',
			'I'	 => 'nisn',
			'J'	 => 'no_un',
			'K'	 => 'lahir_tempat',
			'L'	 => 'lahir_tgl',
			
			'M'	 => 'alamat',
			'N'	 => 'kota',
			'O'	 => 'telepon',
			
			'P'  => 'asal_sekolah_nama',
			'Q'  => 'asal_sekolah_alamat',
			'R'  => 'asal_sekolah_jenjang',
			'S'  => 'asal_ijazah_tahun',
			'T'  => 'asal_ijazah_no',
			'U'  => 'asal_skhu_no',
			
			'V'  => 'status_keluarga',
			'W'  => 'anak_ke',
			'X'  => 'ayah_nama',
			'Y'  => 'ayah_pekerjaan',
			'Z'  => 'ibu_nama',
			'AA'  => 'ibu_pekerjaan',
			'AB'  => 'ortu_alamat',
			'AC'  => 'ortu_telepon',
			
			'AD'  => 'wali_nama',
			'AE'  => 'wali_pekerjaan',
			'AF'  => 'wali_alamat',
			'AG'  => 'wali_telepon',
		);
	}

	// dasar database

	function query_1()
	{
		// vars

		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);

		$select = array(
			'siswa.*',
			'user.expire',
			'user.username',
			'agama_nama' => 'agama.nama',
			'kelas_nama' => 'kelas.nama',
		);

		// kueri dasar

		$this->db
			->from('dprofil_siswa siswa')
			->join('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner')
			->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'left')
			->join('data_user user', 'siswa.id = user.id', 'left');

		if (!$this->dm['admin'])
			$this->db->where('siswa.aktif', 1);

		// data modifier  terakhir

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'siswa.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// data walikelas

		if ($alldata OR in_array('walikelas', $dataset)):
			$this->db->join('dprofil_sdm kelas_wali', 'kelas.wali_id = kelas_wali.id', 'left');
			$select['kelas_wali_nama'] = 'trim(concat_ws(" ", kelas_wali.prefix, kelas_wali.nama, kelas_wali.suffix))';
		endif;

		// data semester masuk

		if ($alldata OR in_array('masuk', $dataset)):
			$this->db
				->join('prd_semester masuk_semester', 'siswa.masuk_semester_id = masuk_semester.id', 'left')
				->join('prd_ta masuk_ta', 'masuk_semester.ta_id = masuk_ta.id', 'left')
				->join('dakd_kelas masuk_kelas', 'siswa.masuk_kelas_id = masuk_kelas.id', 'left');

			$select['masuk_semester_nama'] = 'masuk_semester.nama';
			$select['masuk_ta_nama'] = 'masuk_ta.nama';
			$select['masuk_kelas_nama'] = 'masuk_kelas.nama';
		endif;

		// data semester keluar

		if ($alldata OR in_array('keluar', $dataset)):
			$this->db
				->join('prd_semester keluar_semester', 'siswa.keluar_semester_id = keluar_semester.id', 'left')
				->join('prd_ta keluar_ta', 'keluar_semester.ta_id = keluar_ta.id', 'left')
				->join('dakd_kelas keluar_kelas', 'siswa.keluar_kelas_id = keluar_kelas.id', 'left');

			$select['keluar_semester_nama'] = 'keluar_semester.nama';
			$select['keluar_ta_nama'] = 'keluar_ta.nama';
			$select['keluar_kelas_nama'] = 'keluar_kelas.nama';
		endif;

		// commit selection

		$this->md->select($select);

	}

	function filtering()
	{
		$r = & $this->ci->d['request'];

		// normalisasi

		if ($r['aktif'] === FALSE)
			$r['aktif'] = '1';

		// filtering

		if (isset($r['term']) && $r['term'])
			$this->md->like($r['term'], 'siswa.nis%', 'siswa.nisn%', 'siswa.nama');

		if (isset($r['aktif']) && $r['aktif'] !== FALSE && in_array($r['aktif'], array('0', '1')))
			$this->db->where('siswa.aktif', $r['aktif']);

		if (isset($r['kelas_id']) && $r['kelas_id'] > 0)
			$this->db->where('kelas.id', $r['kelas_id']);

	}

	function query_base()
	{
		$dm = & $this->dm;
		$query = array(
			'select'	 => array(
				'siswa.*',
				'user.expire',
				'user.username',
				'user.login_last',
				'agama_nama' => 'agama.nama',
				'kelas_nama' => 'kelas.nama',
			),
			'from'		 => 'dprofil_siswa siswa',
			'join'		 => array(
				array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				array('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner'),
				array('data_user user', 'siswa.id = user.id', 'left'),
			),
			'order_by'	 => 'kelas.nama, siswa.nama',
		);

		if (!$dm['view'])
			$query['where_strings'][] = "siswa.kelas_id is not null";

		return $query;

	}

	function query_detail($query)
	{
		// data modifier  terakhir

		$query['join']['modifier'] = array('data_user modifier', 'siswa.modifier_id = modifier.id', 'inner');
		$query['select']['modifier_nama'] = 'modifier.nama';
		$query['select']['modifier_alias'] = 'modifier.alias';

		// data walikelas

		$query['join']['kelas_wali'] = array('dprofil_sdm kelas_wali', 'kelas.wali_id = kelas_wali.id', 'left');
		$query['select']['kelas_wali_nama'] = 'trim(concat_ws(" ", kelas_wali.prefix, kelas_wali.nama, kelas_wali.suffix))';

		// data semester masuk

		$query['join'][] = array('prd_semester masuk_semester', 'siswa.masuk_semester_id = masuk_semester.id', 'left');
		$query['join'][] = array('prd_ta masuk_ta', 'masuk_semester.ta_id = masuk_ta.id', 'left');
		$query['join'][] = array('dakd_kelas masuk_kelas', 'siswa.masuk_kelas_id = masuk_kelas.id', 'left');
		$query['select']['masuk_semester_nama'] = 'masuk_semester.nama';
		$query['select']['masuk_ta_nama'] = 'masuk_ta.nama';
		$query['select']['masuk_kelas_nama'] = 'masuk_kelas.nama';

		// data semester keluar

		$query['join'][] = array('prd_semester keluar_semester', 'siswa.keluar_semester_id = keluar_semester.id', 'left');
		$query['join'][] = array('prd_ta keluar_ta', 'keluar_semester.ta_id = keluar_ta.id', 'left');
		$query['join'][] = array('dakd_kelas keluar_kelas', 'siswa.keluar_kelas_id = keluar_kelas.id', 'left');
		$query['select']['keluar_semester_nama'] = 'keluar_semester.nama';
		$query['select']['keluar_ta_nama'] = 'keluar_ta.nama';
		$query['select']['keluar_kelas_nama'] = 'keluar_kelas.nama';

		return $query;

	}

	function filter_1($query)
	{
		$r = & $this->ci->d['request'];
		$dm = $this->dm;

		// normalisasi

		if ($r['aktif'] === FALSE)
			$r['aktif'] = '1';

		// filtering

		$query['like'] = array($r['term'], array('siswa.nis%', 'siswa.nisn%', 'siswa.nama'));

		if ($r['kelas_id'] === 0)
			$query['where_strings'][] = "siswa.kelas_id is null";

		else if (is_numeric($r['kelas_id']))
			$query['where']['siswa.kelas_id'] = (int) $r['kelas_id'];

		if (in_array($r['aktif'], array('0', '1')) && $dm['admin'])
			$query['where']['siswa.aktif'] = $r['aktif'];

		return $query;

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$query = $this->query_base();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}

	function impor()
	{
		$d = & $this->ci->d;
		$no_label = "NIP";
		$map_string = array(
			'B'	 => 'nuptk',
			'C'	 => 'prefix',
			'D'	 => 'nama',
			'E'	 => 'suffix',
			'F'	 => 'gender',
			'G'	 => 'alamat',
			'H'	 => 'kota',
			'I'	 => 'telepon',
		);
		$colex_note = 'J';

		$this->form->get(FALSE, FALSE);

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx', 'ods'));

		if ($d['error'])
			return FALSE;

		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);

		// var, opsi

		$data_nip = $this->md->result_series('nip', 'id', 'select id, nip from dprofil_siswa');

		$this->db
			->select('username')
			->from('data_user');

		if ($data_nip)
			$this->db->where_not_in('username', array_keys($data_nip));

		$data_username = $this->md->result_values('username');
		$objPHPExcel = PHPExcel_IOFactory::load($upload['full_path']);

		if (!$objPHPExcel):
			unset($objPHPExcel);
			delete($upload['full_path']);
			return alert_error('File excel tak dapat dibaca.');
		endif;

		$sheet = $objPHPExcel->setActiveSheetIndex(0);
		$highest_row = $sheet->getHighestRow();
		$bat_update = array();
		$skipped = 0;
		$registered = 0;
		$updated = 0;
		$entry_nip = array();

		$this->db->trans_start();

		for ($irow = 3; $irow <= $highest_row; $irow++):

			// baca id & keterangan

			$_raw = array();
			$_cell_note = $colex_note . $irow;
			$_nip = trimin(trim($sheet->getCell("A{$irow}")->getValue(), " ,.'`\""));
			$_note = trimin(trim($sheet->getCell($_cell_note)->getValue(), " ,.'`\""));

			// baris yg dilewati. takada nip atau ada keterangan input sebelumnya.

			if (!$_nip OR in_array($_note, array('ditambahkan', 'diperbarui')))
				continue;

			// baca data

			foreach ($map_string as $colex => $coldb):
				$_val = trimin(trim($sheet->getCell("{$colex}{$irow}")->getValue(), " ,.'`\""));
				$_raw[$coldb] = ($_val) ? $_val : '';
			endforeach;

			// normalisasi

			$_nip = substr($_nip, 0, 20);
			$_nip = intif($_nip);
			$_raw['nuptk'] = (string) substr($_raw['nuptk'], 0, 32);
			$_raw['nama'] = (string) substr($_raw['nama'], 0, 160);
			$_raw['prefix'] = (string) substr($_raw['prefix'], 0, 10);
			$_raw['suffix'] = (string) substr($_raw['suffix'], 0, 40);
			$_raw['alamat'] = (string) substr($_raw['alamat'], 0, 1024);
			$_raw['kota'] = (string) substr($_raw['kota'], 0, 40);
			$_raw['telepon'] = (string) substr($_raw['telepon'], 0, 20);
			$_raw['gender'] = (strtolower($_raw['gender']) == 'p') ? 'p' : 'l';

			// cek entry ganda

			if (array_key_exists($_nip, $entry_nip)):
				$sheet->setCellValue($_cell_note, "duplikasi {$no_label} dgn entry cell A{$entry_nip[$_nip]} ");
				$skipped++;
				continue;
			endif;

			// cek nama kosong

			if (empty($_raw['nama'])):
				$sheet->setCellValue($_cell_note, "nama kosong");
				$skipped++;
				continue;
			endif;

			// cek nip baru tapi mirip username

			$nip_aneh = (!array_key_exists($_nip, $data_nip) && in_array($_nip, $data_username));

			if ($nip_aneh):
				$sheet->setCellValue($_cell_note, "{$no_label} mirip dgn username profil pengguna lainnya.");
				$skipped++;
				continue;
			endif;

			// catat nip yg diolah

			$entry_nip[$_nip] = $irow;

			// default value

			$_raw['modified'] = $d['datetime'];
			$_raw['modifier_id'] = $d['user']['id'];
			$_raw['aktif'] = 1;
			$_raw['mengajar'] = 1;

			// insert atau update

			if ($data_nip && array_key_exists($_nip, $data_nip)):

				// update

				$_raw['id'] = $data_nip[$_nip];
				$bat_update[] = $_raw;

				$sheet->setCellValue($_cell_note, "diperbarui");
				$sheet->getRowDimension($irow)->setVisible(false);
				$updated++;

			else:

				// insert user

				$_user = array(
					'nama'			 => trim("{$_raw['prefix']} {$_raw['nama']} {$_raw['suffix']}"),
					'alias'			 => nama_alias($_raw['nama']),
					'gender'		 => $_raw['gender'],
					'username'		 => $_nip,
					'password'		 => crypto($_nip),
					'modified'		 => $d['datetime'],
					'modifier_id'	 => $d['user']['id'],
				);

				$this->db->insert('data_user', $_user);

				$_raw['id'] = $this->db->insert_id();
				$_raw['nip'] = $_nip;

				if ($this->db->trans_status() && $_raw['id'] > 0):

					$this->db->insert('dprofil_siswa', $_raw);

					if ($this->db->trans_status()):
						$sheet->getRowDimension($irow)->setVisible(false);
						$sheet->setCellValue($_cell_note, "ditambahkan");
						$registered++;
					else:
						$sheet->setCellValue($_cell_note, "error insert siswa");
						$skipped++;
					endif;

				else:
					$sheet->setCellValue($_cell_note, "error insert user");
					$skipped++;
				endif;

			endif;

		endfor;

		// eksekusi update

		if ($updated > 0)
			$this->db->update_batch('dprofil_siswa', $bat_update, 'id');

		$entry_status = $this->trans_done();
		$alert_success = "{$registered} ditambahkan. {$updated} diperbarui. ";
		$alert_error = "{$skipped} error/dilewati.";

		if ($registered == 0 && $updated == 0 && $skipped == 0):
			delete($upload['full_path']);
			return alert_info('Tak ada data yang diolah. Kosong.');
		endif;

		if ($entry_status && $skipped == 0):
			delete($upload['full_path']);
			return alert_info("Proses impor berhasil. {$alert_success}");
		endif;

		$sheet->setCellValue("A1", "Perhatian! {$alert_success} {$alert_error}");
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"data-profil-siswa-guru.xls\"");
		header("Cache-Control: max-age=0");
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
		$objWriter->save("php://output");
		unset($sheet);
		unset($objPHPExcel);
		delete($upload['full_path']);
		exit();

	}

	function rowset($id)
	{
		$query = $this->query_base();
		$query = $this->query_detail($query);
		$query['where']['siswa.id'] = $id;

		return $this->md->query($query)->row();

	}

	function rowsub($id)
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$d['siswa_ybs'] = ($d['user']['id'] == $d['row']['id']);
		$d['view_nilai_siswa'] = ($d['siswa_ybs'] OR cfguc_view('akses', 'nilai', 'siswa'));
		$d['nilai_id'] = NULL;
		$d['wali_result'] = $this->md->empty_result();
		$d['nilai_result'] = $this->md->empty_result();
		$d['pelajaran_result'] = $this->md->empty_result();
		$d['ekskul_result'] = $this->md->empty_result();
		$d['organisasi_result'] = $this->md->empty_result();

		// query wali murid

		$query_wali = array(
			'select' => array(
				'perwalian.relasi',
				'wali.id',
				'wali.nama',
				'wali.email',
			),
			'from'	 => 'dprofil_perwalian perwalian',
			'join'	 => array(
				array('data_user wali', 'perwalian.wali_id = wali.id', 'inner'),
			),
			'where'	 => array(
				'perwalian.murid_id' => $id,
			)
		);

		if ($dm['view'] OR $d['siswa_ybs'])
			$d['wali_result'] = $this->md->query($query_wali)->result();

		/* data akademik & non akademik */

		// query nilai keseluruhan semester

		$query_rnilai = array(
			'select'	 => array(
				'nilai.*',
				'nikel.kelas_wali_id',
				'semester_nama'		 => 'semester.nama',
				'ta_nama'			 => 'ta.nama',
				'kelas_nama'		 => 'kelas.nama',
				'kelas_wali_nama'	 => 'kelas_wali.nama',
				'kurikulum_nama'	 => 'kurikulum.nama',
				'nilai_kelas_id'	 => 'nikel.id',
				'semester_aktif_nama'=> 'semester.nama',
			),
			'from'		 => 'nilai_siswa nilai',
			'join'		 => array(
				array('prd_semester semester', 'nilai.semester_id = semester.id', 'inner'),
				array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
				array('dakd_kelas kelas', 'nilai.kelas_id = kelas.id', 'inner'),
				array('nilai_kelas nikel', 'nilai.kelas_nilai_id = nikel.id', 'inner'),
				array('dprofil_sdm kelas_wali', 'nikel.kelas_wali_id = kelas_wali.id', 'inner'),
				array('dmst_kurikulum kurikulum', 'nikel.kurikulum_id = kurikulum.id', 'inner'),
			),
			'where'		 => array(
				'nilai.siswa_id' => $id,
			),
			'order_by'	 => 'nilai.id desc',
		);

		if ($d['view_nilai_siswa'])
			$d['nilai_result'] = $this->md->query($query_rnilai)->result();

		// query nilai, jika sudah masuk semester

		$query_nilai = array(
			'from'	 => 'nilai_siswa nilai',
			'where'	 => array(
				'nilai.siswa_id'	 => $id,
				'nilai.semester_id'	 => $d['semaktif']['id'],
			),
		);

		// query pelajaran yg diambil

		$query_pelajaran = array(
			'select'	 => array(
				'pelajaran.*',
				'kurikulum_nama' => 'kurikulum.nama',
				'kategori_kode'	 => 'kategori.kode',
				'kategori_nama'	 => 'kategori.nama',
				'mapel_nama'	 => 'mapel.nama',
				'agama_nama'	 => "IFNULL(agama.nama,'-')",
				'guru_nama'		 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
			),
			'from'		 => 'dakd_pelajaran pelajaran',
			'join'		 => array(
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
			),
			'order_by'	 => 'kategori.kode, pelajaran.nama'
		);

		// query ekskul yg diikuti

		$query_ekskul = array(
			'select' => array('ekskul.*'),
			'from'	 => 'dnakd_ekskul ekskul',
		);

		// query organisasi yg diikuti

		$query_organisasi = array(
			'select' => array('organisasi.*'),
			'from'	 => 'dnakd_organisasi organisasi',
		);

		/* selama masuk semester akademik berarti sifatnya pasti, sesuai yg dilaksanakan yg akan dijalankan saat semester dimulai			 */

		if ($d['semaktif']['id'] > 0 && !$d['row']['keluar_semester_id']):

			// coba ambil data nilai dahulu

			$d['nilai_id'] = (int) $this->md->query($query_nilai)->row_col('id');

			if (!$d['nilai_id']):

				// nilai tak ditemukan, falling back ke save state

				alert_error('Catatan siswa pada semester yang dimaksud tidak ditemukan.');

			else:

				// nilai ditemukan, mulai telusurinilai2 yg lain
				// daftar pelajaran yg diambil dicocokan dgn entry nilai pelajaran ybs

				$query_pelajaran['join'][] = array('nilai_pelajaran nipel', 'pelajaran.id = nipel.pelajaran_id', 'inner');
				$query_pelajaran['join'][] = array('nilai_siswa_pelajaran nilai', 'nipel.id = nilai.pelajaran_nilai_id', 'inner');
				$query_pelajaran['join'][] = array('dmst_kurikulum kurikulum', 'nipel.kurikulum_id = kurikulum.id', 'inner');
				$query_pelajaran['join'][] = array('dprofil_sdm guru', 'nipel.guru_id = guru.id', 'inner');
				$query_pelajaran['join'][] = array('dmst_agama agama', 'nipel.agama_id = agama.id', 'left');
				$query_pelajaran['where']['nilai.siswa_nilai_id'] = $d['nilai_id'];

				// daftar ekskul yg dibina sesuai entry nilai ybs

				$query_ekskul['join'][] = array('nilai_ekskul nixkul', 'ekskul.id = nixkul.ekskul_id', 'inner');
				$query_ekskul['join'][] = array('nilai_siswa_ekskul nilai', 'nixkul.id = nilai.ekskul_nilai_id', 'inner');
				$query_ekskul['where']['nilai.siswa_nilai_id'] = $d['nilai_id'];

				// daftar organisasi yg diikuti sesuai entry nilai ybs

				$query_organisasi['join'][] = array('nilai_organisasi nilorg', 'organisasi.id = nilorg.org_id', 'inner');
				$query_organisasi['join'][] = array('nilai_siswa_org nilai', 'nilorg.id = nilai.org_nilai_id', 'inner');
				$query_organisasi['where']['nilai.siswa_nilai_id'] = $d['nilai_id'];

			endif;

		endif;

		// bila kelas_id kosong, baik karna sudah lulus ata blm diisi bahkan error, balik sajalah..

		if (!$d['row']['kelas_id'])
			return alert_info('Siswa tidak masuk dalam kelas manapun');

		/* bila gagal ambil nilai atau dalam masa jeda,
		 * maka akan menampilkan data sementara
		 * yg akan dijalankan bila semester dimulai
		 */

		if ($d['semaktif']['id'] == 0):

			// sesuai tabel data pelajaran

			$kelas_id = (int) $d['row']['kelas_id'];
			$agama_id = (int) $d['row']['agama_id'];
			$query_pelajaran['join'][] = array('dprofil_sdm guru', 'pelajaran.guru_id = guru.id', 'inner');
			$query_pelajaran['join'][] = array('dakd_pelajaran_kelas pelkls', 'pelajaran.id = pelkls.pelajaran_id', 'inner');
			$query_pelajaran['join'][] = array('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner');
			$query_pelajaran['join'][] = array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left');
			$query_pelajaran['where'] = "pelajaran.aktif = 1 AND pelkls.kelas_id = {$kelas_id} AND (pelajaran.agama_id is null OR pelajaran.agama_id = {$agama_id})";

		endif;

		// fetch result

		$d['pelajaran_result'] = $this->md->query($query_pelajaran)->result();

		if ($d['semaktif']['id'] > 0):
			$d['ekskul_result'] = $this->md->query($query_ekskul)->result();
			$d['organisasi_result'] = $this->md->query($query_organisasi)->result();
		endif;

	}

	function save()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$edit = (bool) $d['form']['id'];
		$siswa_id = (int) $d['form']['id'];
		$foto = $this->save_foto();
		$xdat = ($edit) ? (array) json_decode($d['row']['xdat'], TRUE) : array();
		//$content_path = APP_ROOT . 'content';
		$update_username_nis = FALSE;

		if ($foto):
			if (is_array($d['form']['upload']) && isset($d['form']['upload']['full_path']))
				delete($d['form']['upload']['full_path']);

			$d['form']['upload'] = $foto;

		endif;

		$this->form->ruleset($d['row'], 'validasi-umum');
		
		//$this->form->ruleset($d['row'], 'validasi-masuk');

		if ($d['edit_mode'] != 'edit-on_semester')
			$this->form->ruleset($d['row'], 'validasi-kelas-agama');

		if (in_array($d['edit_mode'], array('baru-psb', 'baru-pindah', 'edit-baru')))
			$this->form->ruleset($d['row'], 'validasi-masuk');

		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields-umum');

		if (!$data['asal_ijazah_tahun'] OR $data['asal_ijazah_tahun'] == '0000')
			$data['asal_ijazah_tahun'] = NULL;

		if (!$data['nisn'])
			$data['nisn'] = NULL;

		if (!$data['anak_ke'])
			$data['anak_ke'] = NULL;

		if ($d['edit_mode'] != 'edit-on_semester'):
			$data = $this->input('fields-kelas-agama', $data);

			if (!$data['kelas_id'])
				$data['kelas_id'] = NULL;

		endif;

		if (in_array($d['edit_mode'], array('baru-psb', 'baru-pindah', 'edit-baru')))
			$data = $this->input('fields-masuk', $data);

		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		// cek edit nis pada siswa baru
		// cek ada username yg mirip nis baru tidak

		if ($edit && $d['row']['username'] = $d['row']['nis'] && $data['nis'] != $d['row']['nis']):
			$user_nis = $this->user_nis($data['nis'], $siswa_id);

			if (!$user_nis):
				$update_username_nis = TRUE;

			else:
				alert_info("NIS baru tidak dapat digunakan sebagai username karena menyamai username akun '{$user_nis['nama']}' ({$user_nis['role']}).");

			endif;

		endif;

		// mulai simpan data

		$this->db->trans_start();

		// olah data baru

		if (!$edit):

			// insert user baru

			$user['role'] = 'siswa';
			$user['username'] = $data['nis'];
			$user['password'] = crypto($data['nis']);
			$user['nama'] = $data['nama'];
			$user['gender'] = $data['gender'];
			$user['modified'] = $data['modified'];
			$user['modifier_id'] = $data['modifier_id'];
			$user['alias'] = nama_alias($data['nama']);

			$this->db->insert('data_user', $user);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$siswa_id = $this->db->insert_id();

			if (!$this->db->trans_status() OR ! $siswa_id)
				return $this->trans_rollback('Database error saat membuat user baru, coba beberapa saat lagi.');

			// insert siswa

			$data['id'] = $siswa_id;

			$this->db->insert('dprofil_siswa', $data);

			$trx = $this->trans_done();
			$msg_sukses = "Data siswa berhasil ditambahkan. NIS: {$data['nis']}.";

			if (!$trx)
				return alert_error('Database error saat menyimpan profil baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $siswa_id;
			$data = array();

			// fu: untuk siswa baru (insert) pada masa semester, langsung dibuatkan daftar nilai???

			if (!$d['form']['upload'])
				return alert_info($msg_sukses);

		endif;

		// olah upload foto

		if ($d['form']['upload']):

			$folder = "data/profil/siswa/{$siswa_id}/";
			$old_foto = array_node($xdat, array('foto'));

			$xdat['foto'] = $this->file_store($d['form']['upload'], $folder, $old_foto);
			$data['xdat'] = json_encode($xdat);

			$this->m_data_user->generate_thumbnails($siswa_id, $xdat['foto']['full_path']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			$updfilter['id'] = $siswa_id;

			// ubah nama di tabel user

			if ($edit):
				$user['nama'] = $data['nama'];
				$user['gender'] = $data['gender'];

				if ($update_username_nis):
					$user['username'] = $data['nis'];
					$user['password'] = crypto($data['nis']);
				endif;

				$this->db->update('data_user', $user, $updfilter);

			endif;

			$this->db->update('dprofil_siswa', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data siswa berhasil diperbarui.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan artikel, coba beberapa saat lagi.');

		endif;

		if ($update_username_nis)
			alert_info("Username dan password telah disesuaikan dengan NIS baru");

		return alert_success($msg_sukses);

	}

	function save_foto()
	{
		$skala_ideal = (3 / 4);
		$max_width = 360;
		$max_height = round($max_width / $skala_ideal);
		$foto = $this->upload_gambar('foto', 4096, $max_width, $max_height, TRUE);

		if (!$foto)
			return NULL;

		// cek kondisi gambar

		if ($foto['image_width'] < 75 OR $foto['image_height'] < 100):
			delete($foto['full_path']);
			return alert_error('Foto minimal berukuran 75x100 pixel.');
		endif;

		$skala_foto = ($foto['image_width'] / $foto['image_height']);

		if ($skala_foto == $skala_ideal)
			return $foto;

		if ($skala_foto < $skala_ideal):
			$target_width = $foto['image_width'];
			$target_height = round($foto['image_width'] / $skala_ideal);

		else:
			$target_width = round($foto['image_height'] * $skala_ideal);
			$target_height = $foto['image_height'];

		endif;

		try
		{
			$thumb = PhpThumbFactory::create($foto['full_path']);
			$thumb->adaptiveResize($target_width, $target_height);
			$thumb->save($foto['full_path']);
		}
		catch (Exception $e)
		{
			alert_info("Penyesuaian gambar error.<br/>" . $e->getMessage());
			delete($foto['full_path']);
			return NULL;
		}

		$img = getimagesize($foto['full_path']);
		$foto['image_width'] = $img[0];
		$foto['image_height'] = $img[1];
		$foto['full_path'] = path_relative($foto['full_path']);

		return $foto;

	}

	// fungsi tambahan

	function user_nis($nis, $siswa_id)
	{
		$siswa_id = (int) $siswa_id;
		$sql = "select * from data_user where username = ? and id != ?";

		return $this->md->row($sql, array($nis, $siswa_id));

	}
	
	function edit_excel_siswa_expor()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');

		// deklarasi variabel
		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/' . strtolower(APP_SCOPE) . '/template/edit_excel_siswa.blank.xlsx';
			$siswa_query = array(
				'from'	 => 'dprofil_siswa siswa',
				'join'	 => array(
					array('dakd_kelas kelas', 'kelas.id = siswa.kelas_id', 'left'),
					array('dmst_agama agama', 'agama.id = siswa.agama_id', 'left'),
					
				),
				'order_by' => '
								kelas.grade asc,
								length(kelas.nama) asc,
								kelas.nama asc,  
								siswa.nama asc',
				'select' => array(
					'siswa.*',
					'kelas.grade',
					'kelas_nama'	=> 'kelas.nama',
					'agama_nama'	=> 'agama.nama',
				),
			);
			
			$siswa_query['where'] = "siswa.aktif = 1 AND siswa.kelas_id >= 1";
			
			$kelas_query = array(
				'from'	 => 'dakd_kelas',
				'select' => array(
					'*',
				),
				'order_by'=> 'grade ASC, nama ASC',
			);
			
			$style = array(
				'default' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
					'alignment'	 => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					),
					'alignment'	 => array(
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
					),
				),
				
			);
			/*
			$cfg = array(
				'table.siswa' => array(
					// data pribadi
					'B'	 => array('id'),
					'C'	 => array('kelas_nama'),
					'D'	 => array('nama'),
					'E'	 => array('gender'),
					'F'	 => array('nis'),
					'G'	 => array('nisn'),
					'H'	 => array('no_un'),
					'I'	 => array('lahir_tempat'),
					'J'	 => array('lahir_tgl'),
				),
			);*/
			
			$sheet_index = 0;
			$excel_row_offset = 11;
			$wali_query = array(
				'select' => array(
					'id',
					'nama' => "trim(concat_ws(' ', prefix, nama, suffix))"
				),
				'from'	 => 'dprofil_sdm',
			);

		endif;
		
		$siswa_result = $this->md->query($siswa_query)->result();
		$kelas_result = $this->md->query($kelas_query)->result();
		
		$excel = PHPExcel_IOFactory::load($excel_source);
		
		$sheet_index=0;
		
		//// GRADE
		$query_grade = array(
			'select' => array('grade.*'),
			'from'	 => 'dmst_grade grade',
			'order_by'=> 'id DESC',
			'where' => array(
								'aktif' => 1,
						),
		);
		
		$grade_result = $this->md->query($query_grade)->result();
		
		//print_r($grade_result);
		//$grade=12;
		$sheet = $excel->setActiveSheetIndex($sheet_index);
		
		//while($grade>=10):
		foreach($grade_result['data'] as $grade){
			$excel_row = $excel_row_offset;
			$sheet = $excel->setActiveSheetIndex($sheet_index);
			$siswa_data = $siswa_result['data'];
			$no=0;
			$ket_semester = "SEMESTER ".strtoupper($d['semaktif']['nama'])." TAHUN ".$d['semaktif']['ta_nama'];
			$sheet->setCellValue('A2', $ket_semester);
			date_default_timezone_set("Asia/Bangkok");
			$sheet->setCellValue('A3',"tanggal  ".date("Y-m-d H:i:s"));
			
			$format = 'dd/mm/yyyy';
			foreach ($siswa_data as $row):

				if($row['grade']==$grade['id']):
				
					$excel_row++;
					$no++;
					$sheet->setCellValue('A'. $excel_row, $no);
					$date_sample = date('2016-12-01');
					foreach ($dm['map.excel.siswa.edit.expor'] as $colexcel => $dat):
						// nis nisn NO un telepon
						if($dat=='nis' || $dat=='nisn' || $dat=='no_un' || $dat== 'telepon'|| $dat== 'ortu_telepon'|| $dat== 'wali_telepon'){
							$sheet->setCellValueExplicit($colexcel . $excel_row, data_cell($dat, $row),PHPExcel_Cell_DataType::TYPE_STRING);
						}elseif($dat=='lahir_tgl'){
							//$sheet->setCellValueByColumnAndRow(11, $excel_row, data_cell($dat, $row));
							//$sheet->getStyleByColumnAndRow(11, $excel_row)
							//	->getNumberFormat()->setFormatCode(
							//		PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY
							//);
							$date_lahir = new DateTime(data_cell($dat, $row));							
							$sheet->setCellValueByColumnAndRow(11, $excel_row, 
																   PHPExcel_Shared_Date::PHPToExcel( $date_lahir ));

								$sheet->getStyleByColumnAndRow(11, $excel_row)
									->getNumberFormat()->setFormatCode($format);							
						}elseif($dat=='masuk_kelas_id'){
							//////// kelas //////////////
							$objValidation1 =$sheet->getCell($colexcel . $excel_row)->getDataValidation();
							$objValidation1->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
							$objValidation1->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
							$objValidation1->setAllowBlank(false);
							$objValidation1->setShowInputMessage(true);
							$objValidation1->setShowErrorMessage(true);
							$objValidation1->setShowDropDown(true);
							$objValidation1->setErrorTitle('Input error');
							$objValidation1->setError('Value is not in list.');
							$objValidation1->setPromptTitle('Pick from list');
							$objValidation1->setPrompt('Please pick a value from the drop-down list.');
							$array_kelas = "";
							$jml_kelas=0;
							foreach($kelas_result['data'] as $kelas)
							{
								// MAX dropdown
								if($jml_kelas<15){
									$array_kelas .= $kelas['nama'].",";
									$kelas_nama[$kelas['id']] = $kelas['nama'];
								}
								$jml_kelas++;
							}
							//$objValidation->setFormula1('"Item A,Item B,Item C"');
							$objValidation1->setFormula1('"'.$array_kelas.'"');
							$vkelas = data_cell($dat, $row);
							if($vkelas!=""){
								$sheet->setCellValue($colexcel . $excel_row, $kelas_nama[$vkelas]);
							}
						}else{
							$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));	
						}
					endforeach;
					
				endif;
				
					
			endforeach;

			$sheet->getStyle('A12:AG'.$excel_row)->getAlignment()->setWrapText(true); 
			$sheet->getStyle('A12:AG'.$excel_row)->applyFromArray($style['default']);
			$sheet->getStyle('F12:H'.$excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			
			$sheet->getColumnDimension('B')->setVisible(FALSE);
			/*$sheet->getColumnDimension('E')->setVisible(FALSE);
			$sheet->getColumnDimension('F')->setVisible(FALSE);
			*/
			$sheet->getRowDimension('5')->setVisible(FALSE);
			$sheet->getRowDimension('6')->setVisible(FALSE);
			$sheet->getRowDimension('7')->setVisible(FALSE);
			$sheet->getRowDimension('8')->setVisible(FALSE);
			$sheet->getRowDimension('9')->setVisible(FALSE);
			$sheet->getRowDimension('10')->setVisible(FALSE);
			
			excel_security_cell_lock($sheet, 'A1:O'.$excel_row);
			excel_security_cell_unlock($sheet, "G12:AH".$excel_row);
			excel_security_sheet_lock($sheet);
			
			//$grade--;
			$sheet_index++;
		//endwhile
		}
		
		return excel_output_2007($excel, 'edit_excel_siswa.xlsx');
	}
	
	function edit_excel_siswa_impor()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$this->form->get();

		if ($d['error'])
			return FALSE;

		// upload

		$upload = $this->upload('upload', array('xls', 'xlsx'));

		if ($d['error'])
			return FALSE;

		/// masuk di kelas
		$kelas_query = array(
				'from'	 => 'dakd_kelas',
				'select' => array(
					'*',
				),
			);
		$kelas_result = $this->md->query($kelas_query)->result();
		
		foreach($kelas_result['data'] as $kelas){
			$kelas_nama[$kelas['nama']] = $kelas['id'];
		}
							
		// load file
		$upload['full_path'] = APP_ROOT.$upload['full_path'];
		@chmod($upload['full_path'], 0777);
		$this->load->library('PHPExcel');
		$PHPExcel = PHPExcel_IOFactory::load($upload['full_path']);
		$sheet_jml = $PHPExcel->getSheetCount();

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;
		
		$grade=0;
		
		$sheet_jml=3;
		
		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet		= $PHPExcel->setActiveSheetIndex($_sheet_index);
			
			//$semester_id = (int) $sheet->getCell("D5")->getValue();
			//$grade		 = (int) $sheet->getCell("D6")->getValue();
			$row_max	 = $sheet->getHighestRow();
			$row_start	 = 12;
			while($row_max>=$row_start):
				
				$user_temp_id ='';
				foreach ($dm['map.excel.siswa.edit.impor'] as $_excel_col => $_db_col):
					
					
						
					if($_db_col== 'lahir_tgl'){
						$cell_date	= clean($sheet->getCell($_excel_col . $row_start)->getValue());
						$_row[$_db_col] = $this->ExcelToPHPObject($cell_date);
						//$temp_date = $this->ExcelToPHPObject($cell_date);
						//return alert_error($temp_date);
					
					}elseif($_db_col=='masuk_kelas_id'){
						
						$cell_nama	= clean($sheet->getCell($_excel_col . $row_start)->getValue());
						if($cell_nama!=""){
							$_row[$_db_col] = $kelas_nama[$cell_nama];
						}else{
							$_row[$_db_col] = NULL;
						}
						
					}else{
						$_row[$_db_col] = clean($sheet->getCell($_excel_col . $row_start)->getValue());
					}
					
					if($_db_col== 'asal_ijazah_tahun'){
						if (!$_row[$_db_col] OR $_row[$_db_col] == '0000' OR $_row[$_db_col] == 0 OR $_row[$_db_col]=='')
						{	$_row[$_db_col]=NULL;	
							//return alert_error('aa');
						}
					}
					
					if($_db_col== 'id')
					{
						$user_temp_id = $_row[$_db_col];
					}
					if($_db_col== 'nis')
					{
						if($_row[$_db_col]=='' )
						{
							return alert_error('Terjadi kesalahan NIS di kolom '.$_excel_col . $row_start);
						}else{
							
							$user_nis = $this->user_nis($_row[$_db_col],$user_temp_id);
							
							if (!$user_nis):
							
								$update_username_nis = TRUE;
								
								$user['id'] 	  = $user_temp_id;
								$user['username'] = $_row[$_db_col];
								$user['password'] = crypto($user['username']);
							else:
								return alert_error("NIS baru tidak dapat digunakan sebagai username karena menyamai username akun '{$user_nis['nama']}' ({$user_nis['role']}).");
				
							endif;
							
							
						}
					}
					
					if($_db_col== 'nama')
					{
						if($_row[$_db_col]=='' )
						{
							return alert_error('Terjadi kesalahan Nama di kolomo '.$_excel_col . $row_start);
							
						}else{
							
							$user['nama']  = $_row[$_db_col];
							$user['alias'] = nama_alias($_row[$_db_col]);
							// Cek EXCEL kembar
							
						}
					}
				endforeach;
				$data_siswa[] = $_row;
				$data_user[] = $user;
				//return alert_error('TEST 2');
				$row_start++;
			endwhile;		
			//return alert_error('TEST 3');
		endfor;
		
		//return alert_error('TEST 4');
		$this->db->trans_start();
		$this->db->update_batch('dprofil_siswa', $data_siswa, 'id');
		$this->db->update_batch('data_user', $data_user, 'id');
		$this->trans_done('Daftar profil siswa telah diperbarui.', 'Database error saat memperbarui profil siswa.');
	}
	
	function tambah_excel_siswa_expor()
	{
		$this->load->library('PHPExcel');
		$this->load->helper('excel');
		
		if (TRUE):
			$d = & $this->ci->d;
			$dm = & $this->dm;
			$excel_source = APP_ROOT.'content/' . strtolower(APP_SCOPE) . '/template/tambah_excel_siswa.blank.xlsx';
			
			$kelas_query = array(
				'from'	 => 'dakd_kelas kelas',
				'order_by' => '
								kelas.grade asc,
								length(kelas.nama) asc,
								kelas.nama asc',
				'select' => array(
					'*',
				),
			);
			
			$agama_query = array(
				'from'	 => 'dmst_agama agama',
				'order_by' => 'agama.id asc',
				'select' => array(
					'*',
				),
			);
			
			$style = array(
				'default' => array(
					'borders'	 => array(
						'allborders' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN,
						),
					),
					'font'		 => array(
						'size' => 10,
					),
					'alignment'	 => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
					),
					'alignment'	 => array(
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
					),
				),
				
			);
			$excel_row_offset = 2;
		
		endif;
		$kelas_result = $this->md->query($kelas_query)->result();
		$kelas_data = $kelas_result['data'];
		
		$agama_result = $this->md->query($agama_query)->result();
		$agama_data = $agama_result['data'];
		
		$excel = PHPExcel_IOFactory::load($excel_source);
		
		$sheet_index=1;
		$sheet = $excel->setActiveSheetIndex($sheet_index);
		
		$excel_row = $excel_row_offset;
		foreach ($kelas_data as $row):
			$excel_row++;
			foreach ($dm['map.excel.kelas.expor'] as $colexcel => $dat):
				
				$sheet->setCellValue($colexcel . $excel_row, data_cell($dat, $row));
			endforeach;
		endforeach;
		
		$excel_row2 = $excel_row_offset;
		foreach ($agama_data as $row2):
			$excel_row2++;
			foreach ($dm['map.excel.agama.expor'] as $colexcel2 => $dat2):
				$sheet->setCellValue($colexcel2 . $excel_row2, data_cell($dat2, $row2));
			endforeach;
		endforeach;
		
		$sheet->getStyle('B3:C'.$excel_row)->applyFromArray($style['default']);
		$sheet->getStyle('F3:G'.$excel_row2)->applyFromArray($style['default']);
		
		$excel->setActiveSheetIndex(0);
		return excel_output_2007($excel, 'tambah_excel_siswa.xlsx');
		
	}
	
	function tambah_excel_siswa_impor()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
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

		if (!$PHPExcel)
			return alert_error('File excel tak dapat dibaca.');

		if ($sheet_jml < 1)
			return alert_error('Sheet/halaman tidak dapat dibaca.');

		if ($d['error']):
			@unlink($upload['full_path']);
			return FALSE;
		endif;
		
		$grade=0;
		
		$sheet_jml=1;
		
		for ($_sheet_index = 0; $_sheet_index < $sheet_jml; $_sheet_index++):
			$sheet		= $PHPExcel->setActiveSheetIndex($_sheet_index);
			
			//$semester_id = (int) $sheet->getCell("D5")->getValue();
			//$grade		 = (int) $sheet->getCell("D6")->getValue();
			$row_max	 = $sheet->getHighestRow();
			$row_start	 = 12;
			$user['role'] = 'siswa';
					
			while($row_max>=$row_start):
				foreach ($dm['map.excel.siswa.tambah.impor'] as $_excel_col => $_db_col):
					if($_db_col== 'lahir_tgl'){
						$cell_date	= clean($sheet->getCell($_excel_col . $row_start)->getValue());
						$_row[$_db_col] = $this->ExcelToPHPObject($cell_date);
						//$temp_date = $this->ExcelToPHPObject($cell_date);
						//return alert_error($temp_date);
					}else{
						$_row[$_db_col] = clean($sheet->getCell($_excel_col . $row_start)->getValue());
					}
					
					$_row[$_db_col] = str_replace("'","`",$_row[$_db_col]);
					if($_db_col== 'kelas_id' && ($_row[$_db_col]=='' || (! preg_match('/^\d+$/', $_row[$_db_col])) ) )
					{	return alert_error('Terjadi kesalahan Kelas ID di kolom '.$_excel_col . $row_start); }
					elseif($_db_col== 'kelas_id')
					{	$_row[$_db_col] = (int) $_row[$_db_col];	}
					
					if($_db_col== 'agama_id' && ($_row[$_db_col]=='' || (! preg_match('/^\d+$/', $_row[$_db_col])) ) )
					{	return alert_error('Terjadi kesalahan Agama ID di kolom '.$_excel_col . $row_start); }
					elseif($_db_col== 'agama_id')
					{	$_row[$_db_col] = (int) $_row[$_db_col];	}
					
					if($_db_col== 'nis')
					{
						if($_row[$_db_col]=='' )
						{
							return alert_error('Terjadi kesalahan NIS di kolom '.$_excel_col . $row_start);
						}else{
							
							$user_nis = $this->user_nis($_row[$_db_col],0);
							
							if (!$user_nis):
							
								$update_username_nis = TRUE;
							else:
								return alert_error("NIS baru tidak dapat digunakan sebagai username karena menyamai username akun '{$user_nis['nama']}' ({$user_nis['role']}).");
				
							endif;
							
							$user['username'] = $_row[$_db_col];
							$user['password'] = crypto($user['username']);
						}
					}
					
					if($_db_col== 'nama')
					{
						if($_row[$_db_col]=='' )
						{
							return alert_error('Terjadi kesalahan Nama di kolomo '.$_excel_col . $row_start);
							
						}else{
							
							$user['nama']  = $_row[$_db_col];
							$user['alias'] = nama_alias($_row[$_db_col]);
							// Cek EXCEL kembar
							
						}
					}
					
					if($_db_col== 'gender')
					{
						$_row[$_db_col] = strtolower($_row[$_db_col]);
						if($_row[$_db_col]=='' || ($_row[$_db_col]!='p' && $_row[$_db_col]!='l'))
						{
							return alert_error('Terjadi kesalahan Gender di kolom '.$_excel_col . $row_start);
						}else{
							$user['gender'] = $_row[$_db_col];
						}
					}
					
					if($_db_col== 'asal_ijazah_tahun'){
						if (!$_row[$_db_col] OR $_row[$_db_col] == '0000' OR $_row[$_db_col] == 0 OR $_row[$_db_col]=='')
						{	$_row[$_db_col]=NULL;	
							//return alert_error('aa');
						}
					}
					
				endforeach;
			
				$user['modified'] = date('Y-m-d H:i:s');
				$user['modifier_id'] = $d['user']['id'];
				$_row['modifier_id'] = $d['user']['id'];
				
				if(isset($data_siswa))
				{
					foreach($data_siswa as $check_siswa)
					{
						if($check_siswa['nama']==$_row['nama'])
							return alert_error('Terjadi kesamaan Nama dalam EXCEL di baris '. $row_start);
						
						if($check_siswa['nis']==$_row['nis'])
							return alert_error('Terjadi kesamaan NIS dalam EXCEL di kolom '. $row_start);
					}
				}
				
				$data_siswa[] = $_row;
				$data_user[] = $user;
				//return alert_error('TEST 2');
				$row_start++;
				//return alert_error(print_r($_row));
			endwhile;		
			//return alert_error('TEST 3');
		endfor;
		
		$this->db->trans_start();
		$loop=0;
		if(isset($data_user))
		{
			foreach($data_user as $du)
			{
				
				$this->db->insert('data_user', $du);
			
				// id baru ditampung di tabel terpisah dulu biar gak konflik saat error
				$siswa_id = $this->db->insert_id();
				
				$data_siswa[$loop]['id'] = $siswa_id;
				$this->db->insert('dprofil_siswa', $data_siswa[$loop]);
				$loop++;
			}
		}else
		{	return alert_error('Data Siswa di Excel kosong ');	}
		
		$this->trans_done('Daftar profil siswa telah diperbarui.', 'Database error saat memperbarui profil siswa.');
	}
	
	function delete_permanent($id = 0)
	{
		$this->db->trans_start();
		
		$this->db->delete('data_user', array('id' => $id));
		$this->db->delete('dprofil_siswa', array('id' => $id));
		
		$this->trans_done('Data siswa telah dihapus permanent.', 'Database error saat memperbarui profil siswa.');
	}
	
	function pindah_kelas()
	{
		
		$req_kelas_list = (array) $this->input->get_post('kelas');
		$req_siswa_list = (array) $this->input->get_post('siswa');
		$this->db->trans_start();
		
		foreach ($req_siswa_list as $siswa_no => $siswa_id):
		
			//$this->db->update('dprofil_siswa',  array('kelas_id' => $req_kelas_list[0]),  array('id' => $siswa_id);
			$this->db->where('id', $siswa_id);
			$this->db->update('dprofil_siswa', array('kelas_id' => $req_kelas_list[0]));
		endforeach;
		//$this->db->update('dprofil_siswa', array('id' => $id));
		//$this->db->delete('dprofil_siswa', array('id' => $id));
		
		$this->trans_done('Data siswa telah dipindah.', 'Database error saat memperbarui profil siswa.');
	//	$query_nisisxkul['where_in']['kelas.id'] = $req_siswa_list;
	//	$template_result = $this->md->query($query_nisisxkul)->result();
	//echo "<pre>";
	//	print_r($req_kelas_list);
	//	print_r($req_siswa_list);
	//	echo "dsadasfasfas";
	}
	
	function reset_password_back($siswa)
	{
		$user_id = (int) $siswa['id'];
		
		$sql = "select * from rahasia where id = ? ";

		$row = $this->md->row($sql, array($user_id));
		
		$login = array(
			'username'	 => $row['username'],
			'password'	 => crypto($row['password']),
		);
		//print_r($login);
		$this->db->update('data_user', $login, array('id' => $user_id));

		
		return alert_success("Login sudah direset! <br/> Nama: ".$row['nama']."<br/> Username: ".$row['username']." <br/> Password: ".$row['password']." ");

	}
	
	function ExcelToPHP($dateValue = 0, $ExcelBaseDate = 1900) {
		if ($ExcelBaseDate == 1900) {
			$myExcelBaseDate = 25569;
			//    Adjust for the spurious 29-Feb-1900 (Day 60)
			if ($dateValue < 60) {
				--$myExcelBaseDate;
			}
		} else {
			$myExcelBaseDate = 24107;
		}
	
		// Perform conversion
		if ($dateValue >= 1) {
			$utcDays = $dateValue - $myExcelBaseDate;
			$returnValue = round($utcDays * 86400);
			if (($returnValue <= PHP_INT_MAX) && ($returnValue >= -PHP_INT_MAX)) {
				$returnValue = (integer) $returnValue;
			}
		} else {
			$hours = round($dateValue * 24);
			$mins = round($dateValue * 1440) - round($hours * 60);
			$secs = round($dateValue * 86400) - round($hours * 3600) - round($mins * 60);
			$returnValue = (integer) gmmktime($hours, $mins, $secs);
		}
	
		// Return
		return $returnValue;
	}    //    function ExcelToPHP()
	
	function ExcelToPHPObject($dateValue = 0) {
		$dateTime = $this->ExcelToPHP($dateValue);
		$days = floor($dateTime / 86400);
		$time = round((($dateTime / 86400) - $days) * 86400);
		$hours = round($time / 3600);
		$minutes = round($time / 60) - ($hours * 60);
		$seconds = round($time) - ($hours * 3600) - ($minutes * 60);
	
		$dateObj = date_create('1-Jan-1970+'.$days.' days');
		$dateObj = date_format($dateObj,"Y-m-d");
		//$dateObj->setTime($hours,$minutes,$seconds);
	
		return $dateObj;
	}    //    function ExcelToPHPObject()

	
}
