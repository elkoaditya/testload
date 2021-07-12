<?php

class M_nilai_siswa_tool extends MY_Model
{

	public function __construct() {
		parent::__construct();
		
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'evaluasi');
	}
		
	function status_akses_rapor(){
		$d = & $this->ci->d;
		
		$keikutsertaan = (int) $this->input->post('keikutsertaan');
		$array_input_ganti = $this->input->post('input_ganti');
		
		$this->db->trans_begin();
		
		$jml=0;
		$sql_bank_soal_id="";
		foreach($array_input_ganti as $siswa_nilai_id){
			$jml++;
			
			$query_update_evaluasi_nilai = "
				UPDATE nilai_siswa
				SET akses_rapor = ".$keikutsertaan."
				WHERE id = {$siswa_nilai_id}
			";
			$this->db->query($query_update_evaluasi_nilai);
		}
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();

			return alert_error("error saat menjalankan: <br/> {$query_update_evaluasi_nilai}");
		}
		
		
		$trx = $this->trans_done('Keikutsertaan berhasil disimpan.', 'Database error, coba beberapa saat lagi.');
		return $trx;
	}
		
}
		
		