<?php

class M_dakd_mapel extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array('kode', 'nama', 'nourut', 'no_urut_ktsp'),
			//'fields' => array('kode', 'nama', 'deskripsi'),
		));

	}

	// dasar database

	function insert($data)
	{
		$this->db->trans_start();
		$this->db->insert('dakd_mapel', $data);
		$this->ci->d['form']['id'] = $this->db->insert_id();

		return $this->trans_done('Data mapel berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');

	}

	function query_1()
	{
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);
		$select = array(
			'mapel.*',
		);
		$this->db
			->from('dakd_mapel mapel')
			->order_by('mapel.nama');

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'mapel.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection
		$this->md->select($select);

	}

	function update($data, $id)
	{
		$this->db->trans_start();
		$this->db->update('dakd_mapel', $data, array('id' => $id));
		return $this->trans_done('Data mapel berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$term = $this->ci->d['request']['term'];
		$this->query_1();
		$this->md->like($term, array('mapel.nama', 'mapel.kode%'));
		return $this->md->resultset($index, $limit);

	}

	function rowset($id)
	{
		$this->query_1();
		$this->db->where('mapel.id', $id);
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

}
