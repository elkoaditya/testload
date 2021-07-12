<?php

class M_kbm_artikel extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'fields' => array('nama', 'pelajaran_id', 'konten'),
				'field-guru' => array('guru_catatan'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'artikel');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'artikel');
	}

	// dasar database

	function filter_1($query) {
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		$def = array(
				'term' => '',
				'semester_id' => $d['semaktif']['id'],
				'kelas_id' => 0,
				'pelajaran_id' => 0,
				'mapel_id' => 0,
				'author_id' => 0,
		);

		// normalisasi

		array_default($r, $def);

		if ($r['semester_id'] == 0)
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (!empty($r['term']))
			$query['like'] = array($r['term'], array('author.nama', 'artikel.nama'));

		if ($r['kelas_id'] > 0)
			$query['where']['artikel.kelas_id'] = $r['kelas_id'];

		if ($r['semester_id'] > 0)
			$query['where']['artikel.semester_id'] = $r['semester_id'];

		if ($r['pelajaran_id'] > 0)
			$query['where']['artikel.pelajaran_id'] = $r['pelajaran_id'];

		if ($r['mapel_id'] > 0)
			$query['where']['artikel.mapel_id'] = $r['mapel_id'];

		if ($r['author_id'] > 0 && $d['user']['role'] != 'siswa')
			$query['where']['artikel.author_id'] = $r['author_id'];

		return $query;
	}

	function query_1() {
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
				'from' => 'kbm_artikel artikel',
				'join' => array(
						array('prd_semester semester', 'artikel.semester_id = semester.id', 'inner'),
						array('prd_ta ta', 'semester.ta_id = ta.id', 'inner'),
						array('dprofil_siswa author', 'artikel.author_id = author.id', 'inner'),
						array('dakd_kelas kelas', 'artikel.kelas_id = kelas.id', 'inner'),
						array('dakd_pelajaran pelajaran', 'artikel.pelajaran_id = pelajaran.id', 'inner'),
						array('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner'),
						array('dprofil_sdm guru', 'pelajaran.guru_id = guru.id', 'inner'),
				),
				'select' => array(
						'artikel.*',
						'semester_nama' => 'semester.nama',
						'ta_nama' => 'ta.nama',
						'author_nama' => 'author.nama',
						'author_nis' => 'author.nis',
						'author_nisn' => 'author.nisn',
						'author_gender' => 'author.gender',
						'pelajaran_nama' => 'pelajaran.nama',
						'pelajaran_kode' => 'pelajaran.kode',
						'kelas_nama' => 'kelas.nama',
						'mapel_nama' => 'mapel.nama',
						'guru_nama' => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
						'pelajaran.mapel_id',
						'pelajaran.guru_id',
				),
		);

		if ($d['user']['role'] == 'siswa')
			$query['where']['artikel.author_id'] = $d['user']['id'];

		else if (!$dm['view'])
			$query['where']['pelajaran.guru_id'] = $d['user']['id'];


		return $query;
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$query = $this->query_1();
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);
	}

	function rowset($id) {
		$query = $this->query_1();
		$query['where']['artikel.id'] = $id;
		$row = $this->md->query($query)->row();

		if ($row)
			$row['lampiran'] = (array) json_decode($row['lampiran'], TRUE);

		return $row;
	}

	function save() {
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$artikel_id = (int) $d['form']['id'];
		$edit = (bool) $d['form']['id'];
		$file = $this->upload('upload', 'pdf,doc,docx,xls,xlsx,ppt,pptx,odt,ods,odp,jpg,jpeg,png,gif,zip,rar');
		//$content_path = APP_ROOT . 'content';
		$sdm_admin = user_role('admin', 'sdm');
		$msg_sukses = "Artikel berhasil disimpan.";

		if ($file):
			$old_path = array_node($d, array('form', 'upload', 'full_path'));

			delete($old_path);

			$d['form']['upload'] = $file;

		endif;

		if ($sdm_admin)
			$this->form->ruleset($d['row'], 'validasi-guru');

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		$data = ($sdm_admin) ? $this->input('field-guru', $data) : $data;
		$data['cuplikan'] = (string) substr($data['konten'], 0, 200);
		$data['updated'] = $d['datetime'];
		$data['updater_id'] = $d['user']['id'];
		$belajar = belajar($data['pelajaran_id']);
		$file_ofis = file_ofis($d, array('form', 'upload', 'file_ext'));

		if (!$belajar && $d['user']['role'] == 'siswa')
			alert_error("Anda tidak sedang mengikuti pelajaran tersebut.");

		if (empty($data['konten']) && !$file_ofis)
			alert_error('konten harus berupa tulisan artikel atau upload file office.');

		if ($d['error'])
			return FALSE;

		// olah data baru

		if (!$edit):

			// siapkan data

			$data['semester_id'] = $d['semaktif']['id'];
			$data['author_id'] = $d['user']['id'];
			$data['kelas_id'] = cfgu('kelas_id');

			// prosesi insert

			$this->db->trans_start();
			$this->db->insert('kbm_artikel', $data);

			// id baru ditampung di tabel terpisah dulu biar gak konflik saat error

			$artikel_id = $this->db->insert_id();

			if (!$this->db->trans_status() OR !$artikel_id)
				return $this->trans_rollback('Database error saat menyimpan artikel baru, coba beberapa saat lagi.');

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan artikel baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$data = array();
			$d['form']['id'] = $artikel_id;
			$msg_sukses = "Artikel baru berhasil ditambahkan.";

			if (!$d['form']['upload'])
				return alert_success($msg_sukses);

		endif;

		// olah upload file

		if ($d['form']['upload']):

			$folder = "kbm/artikel/{$artikel_id}/";

			$data['lampiran'] = $this->file_store($d['form']['upload'], $folder, $d['row']['lampiran']);
			$data['lampiran'] = (string) json_encode($data['lampiran']);

		endif;

		// perubahan data

		if (!empty($data)):

			$this->db->trans_start();

			$updfilter['id'] = $d['form']['id'];

			$this->db->update('kbm_artikel', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data admin berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan artikel, coba beberapa saat lagi.');

		endif;

		return alert_success($msg_sukses);
	}

}

