<?php

class M_dprofil_sdm extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'field-umum'	 => array('nama', 'prefix', 'suffix', 'gender', 'alamat', 'kota', 'telepon'),
			'field-khusus'	 => array('nama', 'prefix', 'suffix', 'gender', 'alamat', 'kota', 'telepon', 'nip', 'nuptk', 'aktif', 'jabatan_id', 'mengajar'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'profil', 'sdm');
		$this->dm['view'] = cfguc_view('akses', 'data', 'profil', 'sdm');

	}

	// dasar database

	function query_1()
	{
		$select = array(
			'sdm.*',
			'nama_title'	 => "trim(both ' ,' from concat_ws(' ', sdm.prefix, sdm.nama, sdm.suffix))",
			'jabatan_kode'	 => 'jabatan.kode',
			'jabatan_nama'	 => 'jabatan.nama',
			'user.expire',
			'user.username',
			'user.login_last',
		);
		$this->md->select($select)
			->from('dprofil_sdm sdm')
			->join('dmst_jabatan jabatan', 'sdm.jabatan_id = jabatan.id', 'inner')
			->join('data_user user', 'sdm.id = user.id', 'left')
			->order_by('sdm.nama');

		if (!$this->dm['admin'])
			$this->db->where('sdm.aktif', 1);

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$term = $this->ci->d['request']['term'];
		$this->query_1();
		$this->md->like($term, 'sdm.nama');
		return $this->md->resultset($index, $limit);

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

		$data_nip = $this->md->result_series('nip', 'id', 'select id, nip from dprofil_sdm');

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
			$_nip = clean_excel_value($sheet->getCell("A{$irow}")->getValue());
			$_note = (string) trim($sheet->getCell($_cell_note)->getValue(), " ,.'");

			// baris yg dilewati. takada nip atau ada keterangan input sebelumnya.

			if (!$_nip OR in_array($_note, array('ditambahkan', 'diperbarui')))
				continue;

			// baca data

			foreach ($map_string as $colex => $coldb):
				$_val = clean_excel_value($sheet->getCell("{$colex}{$irow}")->getValue());
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
				$sheet->setCellValue($_cell_note, "duplikasi {$no_label} dgn entry cell A{$entry_nip[$_nip]} ({$_nip})");
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

					$this->db->insert('dprofil_sdm', $_raw);

					if ($this->db->trans_status()):
						$sheet->getRowDimension($irow)->setVisible(false);
						$sheet->setCellValue($_cell_note, "ditambahkan");
						$registered++;
					else:
						$sheet->setCellValue($_cell_note, "error insert sdm");
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
			$this->db->update_batch('dprofil_sdm', $bat_update, 'id');

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
		header("Content-Disposition: attachment; filename=\"data-profil-sdm-guru.xls\"");
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
		$this->query_1();
		$this->db->where('sdm.id', $id);
		return $this->md->row();

	}

	function rowsub($id)
	{
		$d = & $this->ci->d;
		$d['admin_pelajaran'] = cfguc_admin('akses', 'data', 'akademik', 'pelajaran');
		$d['admin_kelas'] = cfguc_admin('akses', 'data', 'akademik', 'kelas');
		$d['admin_ekskul'] = cfguc_admin('akses', 'data', 'non_akademik', 'ekskul');
		$d['admin_organisasi'] = cfguc_admin('akses', 'data', 'non_akademik', 'organisasi');

		/*
		 * ambil data akademik & non akademik yg berkaitan:
		 * 1. pelajaran yg diampu
		 * 4. kelas yg dipimpin
		 * 2. ekstrakurikuler yg dibina
		 * 3. organisasi yg dibina
		 */

		// query pelajaran yg diampu

		$query_pelajaran = array(
			'select'	 => array(
				'pelajaran.*',
				'kurikulum_nama' => 'kurikulum.nama',
				'kategori_kode'	 => 'kategori.kode',
				'kategori_nama'	 => 'kategori.nama',
				'mapel_nama'	 => 'mapel.nama',
				'agama_nama'	 => "IFNULL(agama.nama,'-')",
			),
			'from'		 => 'dakd_pelajaran pelajaran',
			'join'		 => array(
				array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
				array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
			),
			'order_by'	 => 'kategori.kode, pelajaran.nama'
		);

		// query kelas yg dibina

		$query_kelas = array(
			'select'	 => array(
				'kelas.*',
				'jurusan_kode'	 => 'jurusan.kode',
				'jurusan_nama'	 => 'jurusan.nama',
				'kurikulum_nama' => 'kurikulum.nama',
			),
			'from'		 => 'dakd_kelas kelas',
			'join'		 => array(
				array('dakd_jurusan jurusan', 'kelas.jurusan_id = jurusan.id', 'inner'),
			),
			'order_by'	 => 'kelas.grade, jurusan.nama, kelas.nama'
		);

		// query ekskul yg dibina

		$query_ekskul = array(
			'select' => array('ekskul.*'),
			'from'	 => 'dnakd_ekskul ekskul',
		);

		// query organisasi yg dibina

		$query_organisasi = array(
			'select' => array('organisasi.*'),
			'from'	 => 'dnakd_organisasi organisasi',
		);

		if ($d['semaktif']['id'] > 0):
			/* selama masuk semester akademik berarti sifatnya pasti, sesuai yg dilaksanakan yg akan dijalankan saat semester dimulai			 */

			// daftar pelajaran yg diampu/dijalankan dicocokan dgn entry nilai pelajaran ybs

			$query_pelajaran['select']['nilai_id'] = 'nilai.id';
			$query_pelajaran['select']['nilai_agama_id'] = 'nilai.agama_id';
			$query_pelajaran['select'][] = 'nilai.kkm';
			$query_pelajaran['select'][] = 'nilai.teori';
			$query_pelajaran['select'][] = 'nilai.praktek';
			$query_pelajaran['select'][] = 'nilai.siswa_jml';
			$query_pelajaran['select'][] = 'nilai.nas_total';
			$query_pelajaran['select'][] = 'nilai.nas_teori';
			$query_pelajaran['select'][] = 'nilai.nas_praktek';
			$query_pelajaran['select'][] = 'nilai.uas';
			$query_pelajaran['select'][] = 'nilai.uts';
			$query_pelajaran['select'][] = 'nilai.diolah';
			$query_pelajaran['select'][] = 'nilai.valid';
			$query_pelajaran['join'][] = array('nilai_pelajaran nilai', 'pelajaran.id = nilai.pelajaran_id', 'inner');
			$query_pelajaran['join'][] = array('dmst_kurikulum kurikulum', 'nilai.kurikulum_id = kurikulum.id', 'inner');
			$query_pelajaran['join'][] = array('dmst_agama agama', 'nilai.agama_id = agama.id', 'left');
			$query_pelajaran['where']['nilai.guru_id'] = $id;
			$query_pelajaran['where']['nilai.semester_id'] = $d['semaktif']['id'];

			// daftar kelas yg dipimpin sesuai entry nilai kelas ybs

			$query_kelas['select']['nilai_id'] = 'nilai.id';
			$query_kelas['select']['nilai_kurikulum_id'] = 'nilai.kurikulum_id';
			$query_kelas['select'][] = 'nilai.siswa_jml';
			$query_kelas['select'][] = 'nilai.nas_total';
			$query_kelas['select'][] = 'nilai.nas_teori';
			$query_kelas['select'][] = 'nilai.nas_praktek';
			$query_kelas['select'][] = 'nilai.uas';
			$query_kelas['select'][] = 'nilai.uts';
			$query_kelas['select'][] = 'nilai.diolah';
			$query_kelas['select'][] = 'nilai.valid';
			$query_kelas['join'][] = array('nilai_kelas nilai', 'kelas.id = nilai.kelas_id', 'inner');
			$query_kelas['join'][] = array('dmst_kurikulum kurikulum', 'nilai.kurikulum_id = kurikulum.id', 'inner');
			$query_kelas['where']['nilai.kelas_wali_id'] = $id;
			$query_kelas['where']['nilai.semester_id'] = $d['semaktif']['id'];

			// daftar ekskul yg dibina sesuai entry nilai ybs

			$query_ekskul['select']['nilai_id'] = 'nilai.id';
			$query_ekskul['select'][] = 'nilai.siswa_jml';
			$query_ekskul['join'][] = array('nilai_ekskul nilai', 'ekskul.id = nilai.ekskul_id', 'inner');
			$query_ekskul['where']['nilai.pembina_id'] = $id;
			$query_ekskul['where']['nilai.semester_id'] = $d['semaktif']['id'];

			// daftar organisasi yg dibina sesuai entry nilai ybs

			$query_organisasi['select']['nilai_id'] = 'nilai.id';
			$query_organisasi['select'][] = 'nilai.siswa_jml';
			$query_organisasi['join'][] = array('nilai_organisasi nilai', 'organisasi.id = nilai.org_id', 'inner');
			$query_organisasi['where']['nilai.pembina_id'] = $id;
			$query_organisasi['where']['nilai.semester_id'] = $d['semaktif']['id'];

		else:
			/* selama masa jeda semester berarti sifatnya data sementara yg akan dijalankan saat semester dimulai		 */

			// sesuai tabel data pelajaran

			$query_pelajaran['join'][] = array('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner');
			$query_pelajaran['join'][] = array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left');
			$query_pelajaran['where']['pelajaran.guru_id'] = $id;

			// sesuai yg tertera di tabel data kelas

			$query_kelas['join'][] = array('dmst_kurikulum kurikulum', 'kelas.kurikulum_id = kurikulum.id', 'inner');
			$query_kelas['where']['kelas.wali_id'] = $id;

			$query_ekskul['where']['ekskul.pembina_id'] = $id; // sesuai yg tertera di tabel data ekskul

			$query_organisasi['where']['organisasi.pembina_id'] = $id; // sesuai yg tertera di tabel data org

			/* limitasi non admin */

			if (!$d['admin_pelajaran'])
				$query_pelajaran['where']['pelajaran.aktif'] = 1;

			if (!$d['admin_kelas'])
				$query_kelas['where']['kelas.aktif'] = 1;

			if (!$d['admin_ekskul'])
				$query_ekskul['where']['ekskul.aktif'] = 1;

			if (!$d['admin_organisasi'])
				$query_organisasi['where']['organisasi.aktif'] = 1;

		endif;

		// fetch result

		$d['pelajaran_result'] = $this->md->query($query_pelajaran)->result();
		$d['kelas_result'] = $this->md->query($query_kelas)->result();
		$d['ekskul_result'] = $this->md->query($query_ekskul)->result();
		$d['organisasi_result'] = $this->md->query($query_organisasi)->result();

	}

	function save()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$edit = (bool) $d['form']['id'];
		$sdm_id = (int) $d['form']['id'];
		$foto = $this->save_foto();
		$xdat = ($edit) ? (array) json_decode($d['row']['xdat'], TRUE) : array();
		//$content_path = APP_ROOT . 'content';
		$update_username_nip = FALSE;

		if ($foto):
			if (is_array($d['form']['upload']) && isset($d['form']['upload']['full_path']))
				delete($d['form']['upload']['full_path']);

			$d['form']['upload'] = $foto;

		endif;

		if (!$edit)
			$this->form->ruleset($d['row'], 'validasi-akun');

		if ($dm['admin'])
			$this->form->ruleset($d['row'], 'validasi-khusus');

		$this->form->ruleset($d['row'], 'validasi-umum');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$fieldset = ($dm['admin']) ? 'field-khusus' : 'field-umum';
		$data = $this->inputset($fieldset);
		$data['nip'] = rtrim(ltrim($data['nip'])); 
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		// cek edit nip

		if ($dm['admin'] && $edit && $d['row']['username'] = $d['row']['nip'] && $data['nip'] != $d['row']['nip']):
			$user_nip = $this->user_nip($data['nip'], $sdm_id);

			if (!$user_nip):
				$update_username_nip = TRUE;

			else:
				alert_info("NIP baru tidak dapat digunakan sebagai username karena menyamai username akun '{$user_nip['nama']}' ({$user_nip['role']}).");

			endif;

		endif;

		// mulai simpan data

		$this->db->trans_start();

		// olah data baru

		if (!$edit):

			// insert user baru

			$user['role'] = 'sdm';
			$user['username'] = $data['nip'];
			$user['password'] = crypto($data['nip']);
			$user['nama'] = trim("{$data['prefix']} {$data['nama']} {$data['suffix']}");
			$user['gender'] = $data['gender'];
			$user['modified'] = $data['modified'];
			$user['modifier_id'] = $data['modifier_id'];
			$user['alias'] = nama_alias($data['nama']);
			$email = $this->input->post('email');

			if ($email && $this->form_validation->valid_email($email))
				$user['email'] = $email;

			$this->db->insert('data_user', $user);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$sdm_id = $this->db->insert_id();

			if (!$this->db->trans_status() OR ! $sdm_id)
				return $this->trans_rollback('Database error saat membuat user baru, coba beberapa saat lagi.');

			// insert sdm

			$data['id'] = $sdm_id;

			$this->db->insert('dprofil_sdm', $data);

			$trx = $this->trans_done();
			$msg_sukses = "Data guru/sdm berhasil ditambahkan. NIP: {$data['nip']}.";

			if (!$trx)
				return alert_error('Database error saat menyimpan profil baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $sdm_id;
			$data = array();

			if (!$d['form']['upload'])
				return alert_info($msg_sukses);

		endif;

		// olah upload foto

		if ($d['form']['upload']):

			$folder = strtolower(APP_SCOPE) . "/data/profil/sdm/{$sdm_id}/";
			$old_foto = array_node($xdat, array('foto'));

			$xdat['foto'] = $this->file_store($d['form']['upload'], $folder, $old_foto);
			$data['xdat'] = json_encode($xdat);

			$this->m_data_user->generate_thumbnails($sdm_id, $xdat['foto']['full_path']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			$updfilter['id'] = $sdm_id;

			// ubah nama di tabel user

			if ($edit):
				$user['nama'] = trim("{$data['prefix']} {$data['nama']} {$data['suffix']}");
				$user['gender'] = $data['gender'];

				// RESET USER PASS BY CHANGE NIP 
				/*
				if ($update_username_nip):
					$user['username'] = $data['nip'];
					$user['password'] = crypto($data['nip']);
				endif;
				*/
				
				$this->db->update('data_user', $user, $updfilter);

			endif;

			$this->db->update('dprofil_sdm', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data guru/sdm berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan data, coba beberapa saat lagi.');

		endif;

		//if ($update_username_nip)
			//alert_info("Username dan password telah disesuaikan dengan NIP baru");

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

	function user_nip($nip, $sdm_id)
	{
		$sdm_id = (int) $sdm_id;
		$sql = "select * from data_user where username = ? and id != ?";

		return $this->md->row($sql, array($nip, $sdm_id));

	}

	/*
	function reset_password($sdm)
	{
		$user_id = (int) $sdm['id'];
		$password = password_generator($user_id);
		$username = (strpos($sdm['nip'], 'pem') !== FALSE OR is_numeric($sdm['nip'])) ? $sdm['nip'] : substr($sdm['nip'], 0, 6);
		$secret = array(
			'id'		 => $sdm['id'],
			'nama'		 => $sdm['nama'],
			'prefix'	 => $sdm['prefix'],
			'suffix'	 => $sdm['suffix'],
			'username'	 => $username,
			'password'	 => $password,
		);
		$login = array(
			'username'	 => $username,
			'password'	 => crypto($password),
		);

		$this->db->delete('secret', array('id' => $user_id));
		$this->db->insert('secret', $secret);
		$this->db->update('data_user', $login, array('id' => $user_id));

		return alert_success("Login sudah direset! <br/> Username: {$username} <br/> Password: {$password} ");

	}
	*/
	
	function reset_password_back($sdm)
	{
		$user_id = (int) $sdm['id'];
		
		$sql = "select * from secret where id = ? ";

		$row = $this->md->row($sql, array($user_id));
		
		$login = array(
			'username'	 => $row['username'],
			'password'	 => crypto($row['password']),
		);
		//print_r($login);
		$this->db->update('data_user', $login, array('id' => $user_id));

		
		return alert_success("Login sudah direset! <br/> Username: ".$row['username']." <br/> Password: ".$row['password']." ");

	}

}
