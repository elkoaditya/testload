<?php

class M_prd_semester extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'fields' => array('term', 'nama', 'akhir', 'kepsek_id'),
		));
	}

	// dasar database

	function query_1() {
		$query = array(
				'select' => array(
						'semester.*',
						'ta_nama' => 'ta.nama',
						'pembuka_nama' => 'pembuka.nama',
						'pembuka_alias' => 'pembuka.alias',
						'penutup_nama' => 'penutup.nama',
						'penutup_alias' => 'penutup.alias',
				),
				'from' => 'prd_semester semester',
				'join' => array(
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
						array('data_user pembuka', 'semester.pembuka_id = pembuka.id', 'left'),
						array('data_user penutup', 'semester.penutup_id = penutup.id', 'left'),
				),
				'order_by' => 'id desc',
		);

		// commit selection

		$this->md->query($query);
	}

	function update($data, $id) {
		$this->db->trans_start();

		$this->db->update('prd_semester', $data, array('id' => $id));

		return $this->trans_done('Data semester berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$this->query_1();
		return $this->md->resultset($index, $limit);
	}

	function rowset($id) {
		$this->query_1();
		$this->db->where('semester.id', $id);
		return $this->md->row();
	}

	// regulasi

	function save() {
		$d = & $this->ci->d;
		$row = $this->ci->d['row'];
		$sesi = & $this->ci->form->sesi;
		$edit = (bool) $sesi['id'];

		$this->form->get();

		if ($sesi['id'] != $row['id'])
			alert_error('Semester telah berganti.');

		if ($d['error'])
			return FALSE;

		$this->form->ruleset($row, 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->inputset('fields');
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		$this->db->trans_start();

		if ($edit):

			$this->db->update('prd_semester', $data, array('id' => $d['semaktif']['id']));

			return $this->trans_done('Data semester berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

		endif;

		$data['ta_id'] = $d['ta']['id'];
		$data['status'] = 'aktif';
		$data['mulai'] = $d['datetime'];
		$data['pembuka_id'] = $d['user']['id'];

		$this->db->insert('prd_semester', $data);

		$data['id'] = (int) $this->db->insert_id();

		if (!$this->db->trans_status() OR !$data['id'])
			return $this->trans_rollback('Database error saat entry semester.');

		// entry semester

		if (!$this->entry_semester($data))
			return $this->trans_rollback();

		// selesai

		return $this->trans_done('Semester berhasil dimulai.');
	}

	function tutup() {
		$d = & $this->ci->d;
		$row = $this->ci->d['row'];
		$sesi = & $this->ci->form->sesi;

		$this->form->get();

		if ($sesi['id'] != $row['id'])
			alert_error('Semester telah berganti.');

		if ($d['error'])
			return FALSE;

		$data['status'] = 'ditutup';
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		$this->db->trans_start();
		$this->db->update('prd_semester', $data, array('id' => $d['semaktif']['id']));

		return $this->trans_done('Data semester berhasil ditutup.', 'Database error, coba beberapa saat lagi.');
	}

	function terakhir() {
		$this->query_1();
		return $this->md->row();
	}

	// yg u/ rolling tiap semester

	function entry_semester($sem) {

		// daftar siswa

		$siswa_xdat = $this->siswa_data();

		/*
		  dump($siswa_xdat);
		  $this->trans_rollback();
		  exit('ok');
		 *
		 */


		if (!$siswa_xdat)
			return alert_error('Data siswa aktif tidak ditemukan.');

		// ceklist siswa yg baru masuk

		if (!$this->entry_psb($sem))
			return alert_error('Database error saat checklist data PSB.');

		// entry kelas

		$kls_xdat = $this->entry_kelas($sem);

		if (!$kls_xdat)
			return FALSE;

		// entry pelajaran

		$pel_xdat = $this->entry_pelajaran($sem);

		if (!$pel_xdat)
			return FALSE;

		// entry pelajaran-kelas

		$epk = $this->entry_pelajaran_kelas($pel_xdat, $kls_xdat, $sem);

		if (!$epk)
			return FALSE;

		// entry non akademik

		$enakd = $this->entry_nonakademik($sem['id']);

		if (!$enakd)
			return FALSE;

		// entry siswa & nilai2nya

		$sw = $this->entry_siswa($siswa_xdat, $pel_xdat, $kls_xdat, $sem);

		if (!$sw)
			return FALSE;

		// ceklist nilai tahunan
		//if (!$this->entry_tahunan($siswa_xdat,  $sem))
		//return FALSE;
		//alert_info('<pre>' . print_r($sw) . '</pre>');
		//alert_info('<pre>pelajaran: ' . print_r($pel_xdat, TRUE) . '</pre>');
		//alert_info('<pre>kelas: ' . print_r($kls_xdat, TRUE) . '</pre>');
		//alert_info('<pre>siswa: ' . print_r($siswa_xdat, TRUE) . '</pre>');
		// update jumlah peserta pelajaran & kelas

		$ubat_pel = array();
		$ubat_pelkls = array();

		foreach ($pel_xdat as $pel):
			$ubat_pel[] = array(
					'id' => $pel['nilai_id'],
					'siswa_jml' => $pel['siswa_jml'],
			);

			foreach ($pel['kelas'] as $pk):
				$ubat_pelkls[] = array(
						'id' => $pk['nilai_id'],
						'siswa_jml' => $pk['siswa_jml'],
				);
			endforeach;

		endforeach;

		if ($ubat_pel)
			$this->db->update_batch('nilai_pelajaran', $ubat_pel, 'id');

		if ($ubat_pelkls)
			$this->db->update_batch('nilai_pelajaran_kelas', $ubat_pelkls, 'id');

		return $this->db->trans_status();
	}

	function entry_psb($sem) {
		$d = & $this->ci->d;
		$data['masuk_semester_id'] = $sem['id'];
		$this->db->update('dprofil_siswa', $data, 'masuk_semester_id is null and aktif = 1');

		$psb_jml = $this->db->affected_rows();

		if ($psb_jml == 0)
			return TRUE;

		$ta['siswa_masuk'] = $d['ta']['siswa_masuk'] + $psb_jml;
		$this->db->update('prd_ta', $ta, array('id' => $d['ta']['id']));

		return $this->db->trans_status();
	}

	function entry_tahunan($siswa_xdat, $sem) {
		//if ($sem['semester'] != 'gasal')
		return TRUE;

		// data pelajaran

		$sem['ta'] = (int) $sem['ta'];
		$nts_bat = array();
		$ntk_bat = array();
		$kelas_raw = array();

		foreach ($siswa_xdat as $siswa):
			$siswa['id'] = (int) $siswa['id'];
			$siswa['kelas_id'] = (int) $siswa['kelas_id'];

			$nts_bat[] = array(
					'siswa_id' => $siswa['id'],
					'ta' => $sem['ta'],
					'kelas_id' => $siswa['kelas_id'],
			);

			if (!isset($kelas_raw[$siswa['kelas_id']]))
				$kelas_raw[$siswa['kelas_id']] = array(
						'p' => 0,
						'l' => 0,
				);

			$kelas_raw[$siswa['kelas_id']][$siswa['gender']] ++;

		endforeach;

		// susun bat entry kelas

		foreach ($kelas_raw as $_kls_id => $_q):
			$ntk_bat[] = array(
					'ta' => $sem['ta'],
					'kelas_id' => $_kls_id,
					'siswa_p_jml' => $_q['p'],
					'siswa_l_jml' => $_q['l'],
			);
		endforeach;

		// batch insert

		$this->db->insert_batch('nilta_siswa', $nts_bat);
		$this->db->insert_batch('nilta_kelas', $ntk_bat);

		// status eksekusi

		$trans_status = $this->db->trans_status();

		if ($trans_status)
			return TRUE;

		return alert_error('Database error saat membuat entry nilai tahunan.');
	}

	function entry_kelas($sem) {
		$xdata = array();
		$unlocked = array();
		$query = $this->db
				->select('id, nama, wali_id, gurubk_id, kurikulum_id, `lock`')
				->from('dakd_kelas')
				->where('aktif', 1)
				->where('wali_id is not null')
				->get();

		if ($query->num_rows() == 0)
			return alert_error('Data kelas aktif tidak ditemukan.');

		// entry nilai raport tiap2 kelas

		foreach ($query->result_array() as $kls):

			array_autoint($kls);

			$entry = array(
					'semester_id' => $sem['id'],
					'kelas_id' => $kls['id'],
					'kelas_wali_id' => $kls['wali_id'],
					'kelas_gurubk_id' => $kls['gurubk_id'],
					'kurikulum_id' => $kls['kurikulum_id'],
			);

			$this->db->insert('nilai_kelas', $entry);

			$kls['nilai_id'] = $this->db->insert_id();

			if (!$this->db->trans_status() OR !$kls['nilai_id'])
				return alert_error('Database error saat entry nilai kelas ' . a("data/akademik/kelas/id/{$kls['id']}", $kls['nama']) . '.');

			$xdata[$kls['id']] = $kls;

			if (!$kls['lock'])
				$unlocked[] = $kls['id'];

		endforeach;

		// lock record kelas supaya mapel_id, kategori_id, agama_id tidak dirubah

		if ($unlocked):
			$this->db->where_in('id', $unlocked);
			$this->db->update('dakd_kelas', array('lock' => 1));

			if (!$this->db->trans_status())
				return alert_error('Database error saat mengunci data kelas.');

		endif;

		return $xdata;
	}

	function entry_nonakademik($sem_id) {
		$sql_org = "
		insert into nilai_organisasi
		(semester_id, org_id, pembina_id)

		select '{$sem_id}' semester_id, id org_id, pembina_id
		from dnakd_organisasi org
		where org.aktif = 1
";
		$sql_ekskul = "
		insert into nilai_ekskul
		(semester_id, ekskul_id, pembina_id)

		select '{$sem_id}' semester_id, id ekskul_id, pembina_id
		from dnakd_ekskul ekskul
		where ekskul.aktif = 1
";
		$this->db->query($sql_org);
		$this->db->query($sql_ekskul);

		$trx = $this->db->trans_status();

		if (!$trx)
			return alert_error('Database error saat entry non-akademik.');

		return TRUE;
	}

	function entry_pelajaran($sem) {
		$xdat = array();
		$unlocked = array();
		$list = array();
		$select = array(
				'id',
				'nama',
				'kurikulum_id',
				'kategori_id',
				'mapel_id',
				'agama_id' => 'IFNULL(agama_id, 0)',
				'guru_id',
				'kkm',
				'teori',
				'praktek',
				'`lock`',
		);
		$query = $this->md
				->select($select)
				->from('dakd_pelajaran')
				->where('aktif', 1)
				->where('guru_id is not null')
				->get();

		if ($query->num_rows() == 0)
			return alert_error('Data pelajaran aktif tidak ditemukan.');

		// entry nilai raport tiap2 pelajaran

		foreach ($query->result_array() as $pel):

			array_autoint($pel);

			$entry = array(
					'semester_id' => $sem['id'],
					'pelajaran_id' => $pel['id'],
					'kurikulum_id' => $pel['kurikulum_id'],
					'guru_id' => $pel['guru_id'],
					'agama_id' => ( ($pel['agama_id'] > 0) ? $pel['agama_id'] : NULL),
					'kkm' => $pel['kkm'],
					'teori' => $pel['teori'],
					'praktek' => $pel['praktek'],
			);

			$this->db->insert('nilai_pelajaran', $entry);

			$pel['nilai_id'] = $this->db->insert_id();
			$pel['siswa_jml'] = 0;
			$pel['kelas'] = array();

			if (!$this->db->trans_status() OR !$pel['nilai_id'])
				return alert_error('Database error saat entry nilai pelajaran ' . a("data/akademik/pelajaran/id/{$pel['id']}", $pel['nama']) . '.');

			$xdat[$pel['id']] = $pel;
			$list[] = $pel['id'];

			if (!$pel['lock'])
				$unlocked[] = $pel['id'];

		endforeach;

		// lock

		if ($unlocked):
			$this->db->where_in('id', $unlocked);
			$this->db->update('dakd_pelajaran', array('lock' => 1));

			if (!$this->db->trans_status())
				return alert_error('Database error saat mengunci data pelajaran.');

		endif;

		return $xdat;
	}

	function entry_pelajaran_kelas(&$pel_xdat, &$kls_xdat, $sem) {
		$pel_list = (array) array_keys($pel_xdat);
		$kls_list = (array) array_keys($kls_xdat);
		$query = $this->db
				->select('pelajaran_id, kelas_id')
				->from('dakd_pelajaran_kelas')
				->where_in('pelajaran_id', $pel_list)
				->where_in('kelas_id', $kls_list)
				->get();

		if ($query->num_rows() == 0)
			return alert_error('Data pelajaran-kelas tidak ditemukan.');

		foreach ($query->result_array() as $pk):
			$kls_id = (int) $pk['kelas_id'];
			$pel_id = (int) $pk['pelajaran_id'];
			$entry = array(
					'semester_id' => $sem['id'],
					'pelajaran_id' => $pel_id,
					'pelajaran_nilai_id' => $pel_xdat[$pel_id]['nilai_id'],
					'kelas_id' => $kls_id,
					'kelas_nilai_id' => $kls_xdat[$kls_id]['nilai_id'],
			);

			$this->db->insert('nilai_pelajaran_kelas', $entry);

			$pel_xdat[$pel_id]['kelas'][$kls_id]['nilai_id'] = $this->db->insert_id();
			$pel_xdat[$pel_id]['kelas'][$kls_id]['siswa_jml'] = 0;
			$pel_xdat[$pel_id]['kelas_list'][] = $kls_id;

			if (!$this->db->trans_status())
				return alert_error('Database error saat entry nilai pelajaran-kelas.');

		endforeach;

		return TRUE;
	}

	function entry_siswa(&$siswa_xdat, &$pel_xdat, $kls_xdat, $sem) {

		// periksa data tiap siswa

		$siswa_list = array_keys($siswa_xdat);
		$bat = array();

		foreach ($siswa_list as $sid):
			$siswa = & $siswa_xdat[$sid];

			if (!isset($kls_xdat[$siswa['kelas_id']])):
				unset($siswa_xdat[$sid]);
				continue;
			endif;

			$kelas = & $kls_xdat[$siswa['kelas_id']];

			// entry nilai siswa

			$siswa_nilai = array(
					'siswa_id' => $sid,
					'semester_id' => $sem['id'],
					'kelas_id' => $siswa['kelas_id'],
					'kelas_nilai_id' => $kelas['nilai_id'],
			);
			$this->db->insert('nilai_siswa', $siswa_nilai);

			$siswa['nilai_id'] = $this->db->insert_id();

			if (!$this->db->trans_status() OR !$siswa['nilai_id'])
				return alert_error('Database error saaat input siswa ' . a("data/profil/siswa/id/{$sid}", "#{$siswa['nis']}") . '.');

			// distribusi pelajaran tiap siswa
			// olah batch nilai tiap pelajarannya

			foreach (array_keys($pel_xdat) as $pelid):

				$pelid = (int) $pelid;
				$pelajaran = & $pel_xdat[$pelid];
				$kelas_cocok = in_array($siswa['kelas_id'], $pelajaran['kelas_list']);
				$agama_cocok = ($pelajaran['agama_id'] == 0 OR $pelajaran['agama_id'] == $siswa['agama_id']);

				if ($kelas_cocok && $agama_cocok):
					$pelajaran['kelas'][$siswa['kelas_id']]['siswa_jml'] ++;
					$pelajaran['siswa_jml'] ++;
					$bat[] = array(
							'siswa_nilai_id' => $siswa['nilai_id'],
							'pelajaran_nilai_id' => $pelajaran['nilai_id'],
							'pelajaran_kelas_nilai_id' => $pelajaran['kelas'][$siswa['kelas_id']]['nilai_id'],
							'kelas_nilai_id' => $kelas['nilai_id'],
					);

				endif;

			endforeach;

		endforeach;

		if ($bat)
			$this->db->insert_batch('nilai_siswa_pelajaran', $bat);

		if ($this->db->trans_status())
			return TRUE;

		return alert_error('Database error saaat entry nilai pelajaran siswa.');
	}

	function siswa_data() {
		$xdat = array();
		$query = $this->db
				->select('id, kelas_id, agama_id, gender, nis')
				->from('dprofil_siswa')
				->where('kelas_id is not null')
				->get();

		if ($query->num_rows() == 0)
			return FALSE;

		foreach ($query->result_array() as $siswa):
			array_autoint($siswa);

			$xdat[$siswa['id']] = $siswa;

		endforeach;

		return $xdat;
	}

}
