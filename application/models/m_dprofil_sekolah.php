<?php

class M_dprofil_sekolah extends MY_Model {

	public function __construct() {
		parent::__construct(array(
			'fields' => array('label', 'data'),
		));
	}

	// operasi data

	function all() {
		return $this->md->result('select * from dprofil_sekolah order by id');
	}

	function insert($data) {
		$id = $this->md->quick_insert('dprofil_sekolah', $data);

		if (!$id)
			return FALSE;

		$this->d['row_id'] = $id;
		return $id;
	}

	function rowset($id) {
		return $this->md->rowset($id, 'dprofil_sekolah');
	}

	function save() {
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];

		$this->form->ruleset($row);
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$data = $this->inputset($row, 'fields');

		if (!$data)
			return alert_info('Tak ada perubahan untuk disimpan.');

		$data['modified'] = $this->d['datetime'];
		$data['modifier_id'] = $this->d['user']['id'];

		if ($edit)
			$sukses = $this->update($data, $sesi['id']);
		else
			$sukses = $this->insert($data);

		if ($sukses)
			return alert_success('Data berhasil disimpan.');
		else
			return alert_error('Database error, coba beberapa saat lagi.');
	}

	function update($data, $ids) {
		return $this->md->quick_update('dprofil_sekolah', $data, $ids);
	}

}

