<?php

class M_dakd_pelajaran extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'field-baru' => array('kode', 'nama', 'agama_id', 'guru_id', 'teori', 'praktek', 'kurikulum_id', 'mapel_id', 'kategori_id'),
			'field-edit' => array('kode', 'nama', 'agama_id', 'guru_id', 'teori', 'praktek', 'kurikulum_id', 'kategori_id', 'aktif'),
		));

	}

	// dasar database

	function entry_kelas($pel_id, $update = FALSE)
	{
		$pel_id = (int) $pel_id;
		$kelas_list = (array) $this->input->post('kelas_list');
		$kelas_list = array_filter($kelas_list, 'is_numeric');
		$bat = array();

		if (!$kelas_list)
			return FALSE;

		if ($update)
			$this->db->where('pelajaran_id', $pel_id)->delete('dakd_pelajaran_kelas');

		foreach ($kelas_list as $kls):
			$bat[] = array(
				'pelajaran_id'	 => $pel_id,
				'kelas_id'		 => (int) $kls,
			);
		endforeach;

		$this->db->insert_batch('dakd_pelajaran_kelas', $bat);
		return TRUE;

	}

	function filter()
	{
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$this->md->like($r['term'], 'pelajaran.nama');

		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$this->db->where('pelajaran.mapel_id', $r['mapel_id']);

		if (isset($r['kategori_id']) && $r['kategori_id'] > 0)
			$this->db->where('pelajaran.kategori_id', $r['kategori_id']);

		if (isset($r['agama_id']) && is_numeric($r['agama_id'])):
			if ($r['agama_id'] == 0)
				$this->db->where('pelajaran.agama_id is null');
			else
				$this->db->where('pelajaran.agama_id', $r['agama_id']);
		endif;

		if (isset($r['guru_id']) && $r['guru_id'] > 0)
			$this->db->where('pelajaran.guru_id', $r['guru_id']);
		if (isset($r['aktif']) && is_numeric($r['aktif']))
			$this->db->where('pelajaran.aktif', $r['aktif']);
	}

	function insert($data)
	{
		$data['aktif'] = 1;

		$this->db->trans_start();
		$this->db->insert('dakd_pelajaran', $data);
		$this->ci->d['form']['id'] = $this->db->insert_id();
		$entry_kelas = $this->entry_kelas($this->ci->d['form']['id']);

		if (!$entry_kelas)
			return $this->trans_rollback('Daftar kelas harus diisi.');

		return $this->trans_done("Data pelajaran berhasil ditambahkan. Kode: {$data['kode']}", 'Database error, coba beberapa saat lagi.');

	}

	function query_1()
	{
		$view = cfguc_view('akses', 'data', 'akademik', 'pelajaran');
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);
		$select = array(
			'pelajaran.*',
			'mapel_nama'	 => 'mapel.nama',
			'kategori_kode'	 => 'kategori.kode',
			'kategori_nama'	 => 'kategori.nama',
			'kurikulum_nama' => 'kurikulum.nama',
			'agama_nama'	 => "IFNULL(agama.nama,'-')",
			'guru_nama'		 => "IF(pelajaran.guru_id, trim(both ', ' from concat_ws(', ', guru.prefix, guru.nama, guru.suffix)), '-')",
		);
		$this->db
			->from('dakd_pelajaran pelajaran')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('dmst_kurikulum kurikulum', 'pelajaran.kurikulum_id = kurikulum.id', 'inner')
			->join('dmst_agama agama', 'pelajaran.agama_id = agama.id', 'left')
			->join('dprofil_sdm guru', 'pelajaran.guru_id = guru.id', 'left')
			->order_by('pelajaran.nama');

		if (!$view)
			$this->db->where('pelajaran.aktif', 1);

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'pelajaran.modifier_id = modifier.id', 'left');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection

		$this->md->select($select);

	}

	function update($data, $id)
	{
		$this->db->trans_start();
		$this->db->update('dakd_pelajaran', $data, array('id' => $id));

		$entry_kelas = $this->entry_kelas($id, TRUE);

		if (!$entry_kelas)
			return $this->trans_rollback('Daftar kelas harus diisi.');

		return $this->trans_done('Data pelajaran berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$this->query_1();
		$this->filter();
		return $this->md->resultset($index, $limit);

	}

	function cek()
	{
		$query = $this->db
			->select('kelas.id, kelas.nama, pelajaran.mapel_id, mapel.nama mapel_nama, count(*) as pelajaran_jml', FALSE)
			->from('dakd_kelas kelas')
			->join('dakd_pelajaran_kelas pel_kls', 'kelas.id = pel_kls.kelas_id', 'inner')
			->join('dakd_pelajaran pelajaran', 'pel_kls.pelajaran_id = pelajaran.id', 'inner')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->where('pelajaran.aktif', 1)
			->group_by('pel_kls.kelas_id, pelajaran.kategori_id, pelajaran.mapel_id, pelajaran.agama_id')
			->having('pelajaran_jml > 1')
			->get();

		if ($query->num_rows() == 0)
			return TRUE;

		$message = "Terdapat duplikasi mapel dalam satu kelas:" . NL . "<ul>";

		foreach ($query->result_array() as $row):
			$message .= "<li>Kelas " . a("data/akademik/kelas/id/{$row['id']}", $row['nama']) . " mapel {$row['mapel_nama']} </li>";
		endforeach;

		$message .= "</ul>";

		return alert_error($message);

	}

	function rowset($id)
	{
		$this->query_1('#all');
		$this->db->where('pelajaran.id', $id);
		$row = $this->md->row();

		if ($row):
			$this->load->model('m_dakd_kelas');
			$row['kelas_result'] = $this->m_dakd_kelas->pelajaran($row);
			$row['kelas_list'] = $row['kelas_result']['list'];
		endif;

		return $row;

	}

	function save()
	{
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];

		if (!$edit)
			$this->form->ruleset($row, 'validasi-baru');

		$this->form->ruleset($row, 'validasi-umum');
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$fields = ($edit) ? 'field-edit' : 'field-baru';
		$data = $this->inputset($fields);
		$data['modified'] = $this->d['datetime'];
		$data['modifier_id'] = $this->d['user']['id'];

		if (!$data['agama_id'])
			$data['agama_id'] = NULL;

		if ($edit)
			$sukses = $this->update($data, $sesi['id']);
		else
			$sukses = $this->insert($data);

		// checkpoint error

		if (!$sukses)
			return $sukses;

		// cari info mapel rangkap

		$mapel_id = (int) ($edit) ? $row['mapel_id'] : $data['mapel_id'];
		$query = $this->db
			->select('kelas.id, kelas.nama, count(*) as pelajaran_jml', FALSE)
			->from('dakd_kelas kelas')
			->join('dakd_pelajaran_kelas pel_kls', 'kelas.id = pel_kls.kelas_id', 'inner')
			->join('dakd_pelajaran pelajaran', 'pel_kls.pelajaran_id = pelajaran.id', 'inner')
			->where('pelajaran.mapel_id', $mapel_id)
			->where('pelajaran.aktif',1)
			->group_by('pel_kls.kelas_id')
			->having('pelajaran_jml > 1')
			->get();

		if ($query->num_rows() > 0):
			$msg = "<b>Peringatan.</b> Kelas berikut memiliki beberapa mapel yang sama." . NL . "<ul>";

			foreach ($query->result_array() as $kls)
				$msg .= "<li>" . a("data/akademik/kelas/id/{$kls['id']}", $kls['nama']) . "</li>";

			$msg .= "</ul>";

			alert_info($msg);
		endif;

		// selesai

		return $sukses;

	}

	// fungsi terkait

	function guru()
	{
		$d = & $this->ci->d;

		// input semester

		$d['request']['semester_id'] = (int) $this->input->get_post('semester_id');

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
			$d['request']['semester_id'] = $d['semaktif']['id'];

		// querying

		$select = array(
			'pelajaran.*',
			'mapel_nama'	 => 'mapel.nama',
			'kategori_nama'	 => 'kategori.nama',
			'nilsem_pel_id'	 => 'nilsem_pel.id',
			'nilsem_pel.pelajaran_kkm',
			'nilsem_pel.r2nas_ppk',
			'nilsem_pel.r2nas_prk',
			'nilsem_pel.r2nas_skp',
			'prd_semester'	 => 'sem.semester',
			'prd_ta'		 => 'sem.ta',
		);
		$this->md
			->select($select)
			->from('dakd_pelajaran pelajaran')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('nilsem_pelajaran nilsem_pel', 'pelajaran.id = nilsem_pel.pelajaran_id')
			->join('prd_semester sem', 'nilsem_pel.semester_id = sem.id', 'inner')
			->where('nilsem_pel.guru_id', $d['user']['id'])
			->order_by('sem.id, pelajaran_nama');

		// filtering

		if ($d['request']['semester_id'] > 0)
			$this->db->where('sem.id', $d['request']['semester_id']);

		// hasil

		return $this->md->result();

	}

	function siswa()
	{
		$d = & $this->ci->d;

		// input semester

		$d['request']['semester_id'] = (int) $this->input->get_post('semester_id');

		if (!$d['request']['semester_id'] && $d['semaktif']['id'] > 0)
			$d['request']['semester_id'] = $d['semaktif']['id'];

		// querying

		$select = array(
			'pelajaran.*',
			'mapel_nama'		 => 'mapel.nama',
			'kategori_nama'		 => 'kategori.nama',
			'nilsem_pel.pelajaran_kkm',
			'guru_nama'			 => "trim(concat_ws(' ', guru.prefix, guru.nama, guru.suffix))",
			'nilsem_sispel_id'	 => 'nilsem_sispel.id',
			'nilsem_sispel.nas_ppk',
			'nilsem_sispel.nas_prk',
			'nilsem_sispel.nas_skp',
			'kelas_nama'		 => 'kelas.nama',
			'prd_semester'		 => 'sem.semester',
			'prd_ta'			 => 'sem.ta',
		);
		$this->md
			->select($select)
			->from('dakd_pelajaran pelajaran')
			->join('dakd_mapel mapel', 'pelajaran.mapel_id = mapel.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'pelajaran.kategori_id = kategori.id', 'inner')
			->join('nilsem_pelajaran nilsem_pel', 'pelajaran.id = nilsem_pel.pelajaran_id')
			->join('prd_semester sem', 'nilsem_pel.semester_id = sem.id', 'inner')
			->join('dprofil_sdm guru', 'nilsem_pel.guru_id = guru.id', 'inner')
			->join('nilsem_siswa_pelajaran nilsem_sispel', 'nilsem_pel.id = nilsem_sispel.pelajaran_nilsem_id', 'inner')
			->join('dakd_kelas kelas', 'nilsem_sispel.kelas_id = kelas.id', 'inner')
			->where('nilsem_sispel.siswa_id', $d['user']['id'])
			->order_by('sem.id, mapel.nama');

		// filtering

		if ($d['request']['semester_id'] > 0)
			$this->db->where('sem.id', $d['request']['semester_id']);

		// hasil

		return $this->md->result();

	}

}
