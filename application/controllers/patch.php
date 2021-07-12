<?php

class Patch extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function reset_user() {
		$query = $this->db
					->select('id, username')
					->from('data_user')
					->get();

		if ($query->num_rows() == 0)
			exit('ilang');

		foreach ($query->result_array() as $usr):
			$bat[] = array(
					'id' => $usr['id'],
					'password' => crypto($usr['username']),
			);

		endforeach;

		$this->db->update_batch('data_user', $bat, 'id');
		exit('done');
	}

	public function reset_guru() {
		$query = $this->db
					->select('id, nama')
					->from('data_user')
					->or_like('nama', 'guru')
					->get();

		if ($query->num_rows() == 0)
			exit('ilang');

		foreach ($query->result_array() as $usr):
			//$label = 'nip' . $usr['nama'];
			$bat[] = array(
					'id' => $usr['id'],
					'nama' => $usr['nama'],
			);

		endforeach;

		$this->db->update_batch('dprofil_sdm', $bat, 'id');
		exit('done');
	}

	public function reset_siswa() {
		$query = $this->db
					->select('id, nama')
					->from('data_user')
					->or_like('nama', 'siswa')
					->get();

		if ($query->num_rows() == 0)
			exit('ilang');

		foreach ($query->result_array() as $usr):
			//$label = 'nip' . $usr['nama'];
			$bat[] = array(
					'id' => $usr['id'],
					'nama' => $usr['nama'],
			);

		endforeach;

		$this->db->update_batch('dprofil_siswa', $bat, 'id');
		exit('done');
	}

	public function kelas4() {
		$query = $this->db
					->select('id, nis')
					->from('dprofil_siswa')
					->where('kelas_id', 4)
					->get();
		if ($query->num_rows() == 0)
			exit('ilang');

		foreach ($query->result_array() as $usr):
			$bat[] = array(
					'id' => $usr['id'],
					'password' => crypto($usr['nis']),
			);

		endforeach;

		$this->db->update_batch('data_user', $bat, 'id');
		exit('done');
	}

}

