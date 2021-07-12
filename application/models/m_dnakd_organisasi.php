<?php

class M_dnakd_organisasi extends MY_Model {

	public function __construct() {
		parent::__construct(array(
				'field-baru' => array('nama', 'pembina_id', 'tentang'),
				'field-edit' => array('nama', 'pembina_id', 'tentang', 'aktif'),
		));
	}

	// dasar database

	function filter() {
		$r = $this->ci->d['request'];

		if (isset($r['term']))
			$this->md->like($r['term'], 'organisasi.nama');

		if (isset($r['pembina_id']) && $r['pembina_id'] > 0)
			$this->db->where('organisasi.pembina_id', $r['pembina_id']);
	}

	function insert($data) {
		$data['aktif'] = 1;

		$this->db->trans_start();
		$this->db->insert('dnakd_organisasi', $data);
		$this->ci->d['row_id'] = $this->db->insert_id();

		return $this->trans_done('Data ekstrakurikuler berhasil ditambahkan.', 'Database error, coba beberapa saat lagi.');
	}

	function query_1() {
		$view = cfguc_view('akses', 'data', 'non_akademik', 'organisasi');
		$dataset = (array) func_get_args();
		$alldata = in_array('#all', $dataset);

		if ($alldata OR in_array('organisasi', $dataset)):
			$select = array(
					'organisasi.*',
			);
		else:
			$select = array(
					'organisasi.id',
					'organisasi.nama',
					'organisasi.aktif',
					'organisasi.cuplikan',
					'organisasi.pembina_id',
			);

		endif;

		$this->db->from('dnakd_organisasi organisasi');

		if (!$view)
			$this->db->where('organisasi.aktif', 1);

		// data pembina

		if ($alldata OR in_array('pembina', $dataset)):
			$this->db->join('dprofil_sdm pembina', 'organisasi.pembina_id = pembina.id', 'left');
			$select['pembina_nama'] = "IF(organisasi.pembina_id, trim(concat_ws(' ', pembina.prefix, pembina.nama, pembina.suffix)), '-')";
		endif;

		// data modifikasi

		if ($alldata OR in_array('modif', $dataset)):
			$this->db->join('data_user modifier', 'organisasi.modifier_id = modifier.id', 'inner');
			$select['modifier_nama'] = 'modifier.nama';
			$select['modifier_alias'] = 'modifier.alias';
		endif;

		// commit selection
		$this->md->select($select);
	}

	function update($data, $id) {
		if (!$data['aktif'])
			$data['pembina_id'] = NULL;

		$this->db->trans_start();
		$this->db->update('dnakd_organisasi', $data, array('id' => $id));

		return $this->trans_done('Data ekstrakurikuler berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');
	}

	// operasi data

	function browse($index = 0, $limit = 20) {
		$this->query_1('pembina');
		$this->filter();
		return $this->md->resultset($index, $limit);
	}

	function rowset($id) {
		$this->query_1('#all');
		$this->db->where('organisasi.id', $id);
		return $this->md->row();
	}

	function save() {
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];
		$aktif = ($edit) ? $this->input->post('aktif') : 1;

		if ($aktif)
			$this->form->ruleset($row, 'validasi-aktif');

		$this->form->ruleset($row, 'validasi-umum');
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$fieldset = ($edit) ? 'field-edit' : 'field-baru';
		$data = $this->inputset($fieldset);
		$data['cuplikan'] = character_limiter(strip_tags($data['tentang']), 200);
		$data['modified'] = $this->d['datetime'];
		$data['modifier_id'] = $this->d['user']['id'];

		if ($edit)
			return $this->update($data, $sesi['id']);
		else
			return $this->insert($data);
	}

}

