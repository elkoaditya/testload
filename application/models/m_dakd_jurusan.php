<?php

class M_dakd_jurusan extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'field-baru' => array('nama', 'deskripsi', 'kode'),
			'field-edit' => array('nama', 'deskripsi', 'kode', 'aktif'),
		));

	}

	// dasar database

	function insert($data)
	{
		$data['aktif'] = 1;

		$this->db->trans_start();
		$this->db->insert('dakd_jurusan', $data);
		$this->ci->d['form']['id'] = $this->db->insert_id();

		return $this->trans_done('Data jurusan berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');

	}

	function query_1()
	{
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);
		$select = array(
			'jurusan.*',
		);
		$this->db->from('dakd_jurusan jurusan');

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'jurusan.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection
		$this->md->select($select);

	}

	function update($data, $id)
	{
		$this->db->trans_start();

		$this->db->update('dakd_jurusan', $data, array('id' => $id));

		return $this->trans_done('Data jurusan berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$term = $this->ci->d['request']['term'];
		$this->query_1();
		$this->md->like($term, array('jurusan.nama', 'jurusan.deskripsi'));
		return $this->md->resultset($index, $limit);

	}

	function rowset($id)
	{
		$this->query_1();
		$this->db->where('jurusan.id', $id);
		return $this->md->row();

	}

	function save()
	{
		$d = & $this->d;
		$edit = (bool) $d['form']['id'];

		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$fieldset = ($edit) ? 'field-edit' : 'field-baru';
		$data = $this->inputset($fieldset);
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		if ($edit)
			return $this->update($data, $d['form']['id']);
		else
			return $this->insert($data);

	}

}
