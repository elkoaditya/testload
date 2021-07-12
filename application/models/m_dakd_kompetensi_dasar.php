<?php

class M_dakd_kompetensi_dasar extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array('nama', 'kode', 'grade', 'mapel_id', 'kategori_id', 'kurikulum_id', 
			'kode_erapor_teori', 'kode_erapor_praktek'),
		));

	}

	function filter()
	{
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$this->md->like($r['term'], 'kompetensi_dasar.nama');

		if (isset($r['grade']) && $r['grade'] > 0)
			$this->db->where('kompetensi_dasar.grade', $r['grade']);
		
		if (isset($r['mapel_id']) && $r['mapel_id'] > 0)
			$this->db->where('kompetensi_dasar.mapel_id', $r['mapel_id']);

		if (isset($r['kategori_id']) && $r['kategori_id'] > 0)
			$this->db->where('kompetensi_dasar.kategori_id', $r['kategori_id']);

		if (isset($r['kurikulum_id']) && $r['kurikulum_id'] > 0)
			$this->db->where('kompetensi_dasar.kurikulum_id', $r['kurikulum_id']);
		
	}
	
	// dasar database

	function insert($data)
	{
		$this->db->trans_start();
		$this->db->insert('dakd_kompetensi_dasar', $data);
		$this->ci->d['form']['id'] = $this->db->insert_id();

		return $this->trans_done('Data kategori mapel berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');

	}

	function query_1()
	{
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);
		$select = array(
			'kompetensi_dasar.*',
			'mapel_nama'	 => 'mapel.nama',
			'kategori_nama'	 => 'kategori.nama',
			'kurikulum_nama' => 'kurikulum.nama',
			'grade_nama' => 'grade.nama',
		);
		$this->db
			->from('dakd_kompetensi_dasar kompetensi_dasar')
			->join('dakd_mapel mapel', 'kompetensi_dasar.mapel_id = mapel.id', 'inner')
			->join('dakd_kategori_mapel kategori', 'kompetensi_dasar.kategori_id = kategori.id', 'inner')
			->join('dmst_kurikulum kurikulum', 'kompetensi_dasar.kurikulum_id = kurikulum.id', 'inner')
			->join('dmst_grade grade', 'kompetensi_dasar.grade = grade.id', 'inner')
			->order_by('kurikulum.nama, kategori.nama, mapel.nama, grade.nama, kompetensi_dasar.kode');

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'kompetensi_dasar.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection
		$this->md->select($select);

	}

	function update($data, $id)
	{
		$this->db->trans_start();
		$this->db->update('dakd_kompetensi_dasar', $data, array('id' => $id));
		return $this->trans_done('Data kompetensi dasar berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$term = $this->ci->d['request']['term'];
		$this->query_1();
		$this->filter();
		$this->md->like($term, array('kompetensi_dasar.nama', 'kompetensi_dasar.kode%'));
		return $this->md->resultset($index, $limit);

	}

	function rowset($id)
	{
		$this->query_1();
		$this->db->where('kompetensi_dasar.id', $id);
		return $this->md->row();

	}

	function save()
	{
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];

		$this->form->ruleset($row, 'validasi');
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$data = $this->inputset('fields');
		$data['modified'] = $this->d['datetime'];
		$data['modifier_id'] = $this->d['user']['id'];

		if ($edit)
			return $this->update($data, $sesi['id']);
		else
			return $this->insert($data);

	}

	function chek_nama()
	{
		$query = array(
				'select'	 => array(
					'*'
				),
				'from' => 'dakd_kompetensi_dasar',
				'where'		 => array(
					'kurikulum_id' 	=> $this->input->post('kurikulum_id'),
					'kategori_id' 	=> $this->input->post('kategori_id'),
					'mapel_id' 		=> $this->input->post('mapel_id'),
					'grade' 		=> $this->input->post('grade'),
					'type_nomor'	=> $this->input->post('type_nomor'),
				),
			);
		
		$hasil = $this->md->query($query)->row();
		
		return $hasil;
	}
}
