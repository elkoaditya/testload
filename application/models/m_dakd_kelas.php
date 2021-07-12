<?php

class M_dakd_kelas extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'field-baru' => array('nama', 'jurusan_id', 'grade', 'wali_id', 'gurubk_id', 'kurikulum_id'),
				'field-edit' => array('nama', 'jurusan_id', 'grade', 'wali_id', 'gurubk_id', 'kurikulum_id', 'aktif'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'akademik', 'kelas');
		$this->dm['view'] = cfguc_view('akses', 'data', 'akademik', 'kelas');
	}

	// dasar database

	function filter_1() {
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$this->md->like($r['term'], 'kelas.nama');

		if (isset($r['jurusan_id']) && $r['jurusan_id'] > 0)
			$this->db->where('kelas.jurusan_id', $r['jurusan_id']);

		if (isset($r['grade']) && $r['grade'] > 0)
			$this->db->where('kelas.grade', $r['grade']);

		if (isset($r['wali_id']) && $r['wali_id'] > 0)
			$this->db->where('kelas.wali_id', $r['wali_id']);
	}

	function filter_2($query) {
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$query['like'] = array($r['term'], 'kelas.nama');

		if (isset($r['jurusan_id']) && $r['jurusan_id'] > 0)
			$query['where']['kelas.jurusan_id'] = $r['jurusan_id'];

		if (isset($r['grade']) && $r['grade'] > 0)
			$query['where']['kelas.grade'] = $r['grade'];

		if (isset($r['wali_id']) && $r['wali_id'] > 0)
			$query['where']['kelas.wali_id'] = $r['wali_id'];

		return $query;
	}

	function insert($data) {
		$data['aktif'] = 1;

		$this->db->trans_start();
		$this->db->insert('dakd_kelas', $data);
		$this->ci->d['form']['id'] = $this->db->insert_id();

		return $this->trans_done('Data kelas berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');
	}

	function query_1() {
		$dm = $this->dm;
		$dataset = (array) func_get_args();
		$alldata = (in_array('#all', $dataset));
		$semaktif = $this->ci->d['semaktif'];
		$select = array(
				'kelas.*',
				'jurusan_kode' => 'jurusan.kode',
				'jurusan_nama' => 'jurusan.nama',
				'wali_nama' => 'wali.nama',
				'wali_nip' => 'wali.nip',
				'wali_alias' => 'wali.alias',
				'gurubk_nama' => 'gurubk.nama',
				'gurubk_alias' => 'gurubk.alias',
				'kurikulum_nama' => 'kurikulum.nama',
		);
		$this->db->from('dakd_kelas kelas')
					->join('dakd_jurusan jurusan', 'kelas.jurusan_id = jurusan.id', 'inner')
					->join('dmst_kurikulum kurikulum', 'kelas.kurikulum_id = kurikulum.id', 'inner')
					->join('data_user wali', 'kelas.wali_id = wali.id', 'left')
					->join('data_user gurubk', 'kelas.gurubk_id = gurubk.id', 'left')
					->order_by('grade, jurusan.nama, kelas.nama');

		//*/
		if ($semaktif['id'] > 0):
			$this->db
						->join('nilai_kelas nilai', 'kelas.id = nilai.kelas_id', 'left')
						->where("(nilai.id is null or nilai.semester_id = {$semaktif['id']} )");

			$select['siswa_jml'] = "nilai.siswa_jml";

		endif;
		//*/

		if (!$dm['view'])
			$this->db->where('kelas.aktif', 1);

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'kelas.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection

		$this->md->select($select);
	}

	function query_2() {
		$dm = $this->dm;
		$d = $this->ci->d;
		$query = array(
				'select' => array(
						'kelas.*',
						'jurusan_kode' => 'jurusan.kode',
						'jurusan_nama' => 'jurusan.nama',
						'wali_nama' => "trim(concat_ws(' ',wali.prefix,wali.nama,wali.suffix))",
						'wali_nip' => 'wali.nip',
						'gurubk_nama' => 'gurubk.nama',
						'kurikulum_nama' => 'kurikulum.nama',
				),
				'from' => 'dakd_kelas kelas',
				'join' => array(
						array('dakd_jurusan jurusan', 'kelas.jurusan_id = jurusan.id', 'inner'),
						array('dmst_kurikulum kurikulum', 'kelas.kurikulum_id = kurikulum.id', 'inner'),
						array('dprofil_sdm wali', 'kelas.wali_id = wali.id', 'left'),
						array('dprofil_sdm gurubk', 'kelas.gurubk_id = gurubk.id', 'left'),
				),
				'order_by' => 'grade, jurusan.nama, kelas.nama',
		);

		if ($d['semaktif']['id'] > 0):
			$query['join'][] = array("dprofil_siswa siswa", 'kelas.id = siswa.kelas_id', 'left');
			$query['select']['siswa_jml'] = "COUNT( siswa.id )";
			$query['group_by'] = 'kelas.id';
			/*$sqlsub_nilkls = "select * from nilai_kelas where semester_id = {$d['semaktif']['id']}";
			$query['join'][] = array("({$sqlsub_nilkls}) nilai", 'kelas.id = nilai.kelas_id', 'left');
			$query['select']['siswa_jml'] = "nilai.siswa_jml";*/

		endif;

		if (!$dm['view'])
			$query['where']['kelas.aktif'] = 1;

		return $query;
	}

	function update($data, $id) {

		$this->db->trans_start();

		$this->db->update('dakd_kelas', $data, array('id' => $id));

		return $this->trans_done('Data kelas berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$query = $this->query_2();
		$query = $this->filter_2($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function rowset($id) {
		$query = $this->query_2();
		$query['where']['kelas.id'] = $id;

		return $this->md->query($query)->row();
	}

	function rowsub($id) {
		$d = & $this->ci->d;
		$d['admin_pelajaran'] = cfguc_admin('akses', 'data', 'akademik', 'pelajaran');
		$d['pelajaran_result'] = $this->md->empty_result();
		$d['siswa_result'] = $this->md->empty_result();

		// daftar siswa

		$query_siswa = array(
				'select' => array(
						'siswa.id',
						'siswa.nis',
						'siswa.nisn',
						'siswa.nama',
						'siswa.gender',
						'siswa.agama_id',
						'agama_nama' => 'agama.nama',
				),
				'from' => 'dprofil_siswa siswa',
				'join' => array(
						array('dmst_agama agama', 'siswa.agama_id = agama.id', 'inner'),
				),
				'where' => array(
						'siswa.aktif' => 1,
						'siswa.kelas_id' => $id,
				),
				'order_by' => 'siswa.nama',
		);
		$query_pelajaran = array(
				'select' => array(
						'pelajaran.id',
						'pelajaran.kode',
						'pelajaran.nama',
						'pelajaran.mapel_id',
						'pelajaran.kategori_id',
						'pelajaran.agama_id',
						'pelajaran.guru_id',
						'mapel_nama' => 'mapel.nama',
						'kategori_kode' => 'kategori.kode',
						'kategori_nama' => 'kategori.nama',
						'agama_nama' => "IFNULL(agama.nama, '-')",
						'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
				),
				'from' => 'dakd_pelajaran pelajaran',
				'join' => array(
						array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
						array('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner'),
						array('dprofil_sdm guru', 'pelajaran.guru_id = guru.id', 'inner'),
						array('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left'),
				),
				'where' => array('pelajaran.aktif' => 1),
				'order_by' => 'kategori.id, mapel.nama',
		);

		if ($d['semaktif']['id'] > 0):
			$query_pelajaran['join'][] = array("nilai_pelajaran_kelas pel_kls", 'pelajaran.id = pel_kls.pelajaran_id', 'inner');
			$query_pelajaran['where']['pel_kls.semester_id'] = $d['semaktif']['id'];

		else:
			$query_pelajaran['join'][] = array("dakd_pelajaran_kelas pel_kls", 'pelajaran.id = pel_kls.pelajaran_id', 'inner');

			//if (!$d['admin_pelajaran']):
				$query_pelajaran['where']['pelajaran.aktif'] = 1;
			//endif;

		endif;

		$query_pelajaran['where']['pel_kls.kelas_id'] = $id;
		$d['pelajaran_result'] = $this->md->query($query_pelajaran)->result();
		$d['siswa_result'] = $this->md->query($query_siswa)->result();
	}

	function save() {
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$fieldset = ($edit) ? 'field-edit' : 'field-baru';
		$data = $this->inputset($fieldset);
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		if (!$data['gurubk_id'])
			$data['gurubk_id'] = NULL;

		if ($edit)
			return $this->update($data, $d['form']['id']);
		else
			return $this->insert($data);
	}

	// fungsi terkait

	function pelajaran($row) {
		$select = array(
				'kelas.*',
				'jurusan_nama' => 'jurusan.nama',
		);
		$this->md
					->select($select)
					->from('dakd_kelas kelas')
					->join('dakd_jurusan jurusan', 'kelas.jurusan_id = jurusan.id', 'inner')
					->join('dakd_pelajaran_kelas pel_kelas', 'kelas.id = pel_kelas.kelas_id', 'inner')
					->where('pel_kelas.pelajaran_id', (int) $row['id'])
					->where('kelas.aktif', 1)
					->order_by('kelas.grade, jurusan.nama, kelas.nama');

		$result = $this->md->result();
		$result['list'] = array();

		if ($result['selected_rows'] > 0)
			foreach ($result['data'] as $kls)
				$result['list'][] = (int) $kls['id'];

		return $result;
	}

}

