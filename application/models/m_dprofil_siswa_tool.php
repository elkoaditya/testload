<?php

class M_dprofil_siswa_tool extends MY_Model
{

	public function __construct() {
		parent::__construct();
		
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'profil', 'siswa');
		$this->dm['view'] = cfguc_view('akses', 'data', 'profil', 'siswa');
	}
		
	function status_naik_kelas(){
		$d = & $this->ci->d;
		
		$naik_kelas_id = (int) $this->input->post('naik_kelas_id');
		$array_input_ganti = $this->input->post('input_ganti');
		
		$this->db->trans_begin();
		
		$jml=0;
		$modified = date("Y-m-d H:i:s");
		foreach($array_input_ganti as $siswa_id){
			$jml++;
			
			$query_update_siswa = "
				UPDATE 
					dprofil_siswa
				SET 
					kelas_id = ".$naik_kelas_id.", 
					modified = '".$modified."'
				WHERE 
					id = {$siswa_id}
			";
			$this->db->query($query_update_siswa);
			//echo $query_update_siswa;
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$query_update_siswa}");
		}
		
		
		$trx = $this->trans_done('Naik Kelas berhasil disimpan.', 'Database error, coba beberapa saat lagi.');
		return $trx;
	}
		
}
		
		