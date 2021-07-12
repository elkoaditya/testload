<?php

class M_user_login extends MY_Model
{

	public function daftar_siswa($offset = 0, $limit = 50)
	{
		if ($limit < 20)
		{
			$limit = 50;
		}

		$term = $this->d['request']['term'];
		$kelas_id = $this->d['request']['kelas_id'];

		$select = array(
			'user.id',
			'user.session_id',
			'session.ip_address',
			'session.user_agent',
			'session.last_activity',
			'siswa.nis',
			'siswa.nisn',
			'siswa.nama',
			'siswa.kelas_id',
			'kelas.nama kelas_nama',
		);

		$this->db
			->select(implode(', ', $select))
			->from('data_user user')
			->join('app_session session', 'user.session_id = session.session_id', 'inner')
			->join('dprofil_siswa siswa', 'user.id = siswa.id', 'inner')
			->join('dakd_kelas kelas', 'siswa.kelas_id = kelas.id', 'inner')
			->where('user.role', 'siswa');

		if ($kelas_id > 0)
		{
			$this->db->where('siswa.kelas_id', $kelas_id);
		}

		if ($term)
		{
			$this->md->like($term, 'siswa.nis%', 'siswa.nisn%', 'siswa.nama');
		}

		return $this->md->resultset($offset, $limit);

	}

	public function reset($session_id)
	{
		$this->db->update('data_user', array('session_id' => NULL), array('session_id' => $session_id));
		$this->db->delete('app_session', array('session_id' => $session_id));

	}
	
	public function reset_all_checked()
	{
		$array_input_ganti = $this->input->post('input_ganti');
		
		$this->db->trans_begin();
		
		$jml=0;
		foreach($array_input_ganti as $input_ganti){
			$this->db->update('data_user', array('session_id' => NULL), array('session_id' => $input_ganti));
			$this->db->delete('app_session', array('session_id' => $input_ganti));
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: reset all ");
		}
		
		
		$trx = $this->trans_done('Reset All checked berhasil disimpan.', 'Database error, coba beberapa saat lagi.');
		return $trx;

	}

}
