<?php

class M_kbm_evaluasi_pembagian_kd extends MY_Model
{
	public function __construct() {
		parent::__construct(array(
				'fields' => array('evaluasi_id','nama', 'soal_jml','posisi_kd'),
				
		));
	}
	
	function browse($index = 0, $limit = 20)
	{
		$r = $this->ci->d['request'];
		$query = array(
				'from' => 'kbm_evaluasi_pembagian_kd',
				'where' => array(
						'evaluasi_id' => $r['evaluasi_id'],
				),
				'order_by' => 'posisi_kd',
		);
	
		return $this->md->query($query)->resultset($index, $limit);
	}

	function rowset($evaluasi_id, $posisi_kd)
	{
		$d = & $this->ci->d;
		
		$query = array(
				'from' => 'kbm_evaluasi_pembagian_kd',
				'order_by' => 'posisi_kd',
		);
		
		$query['where']['evaluasi_id']	= $evaluasi_id;
		$query['where']['posisi_kd']	= $posisi_kd;
		$row = $this->md->query($query)->row();
		
		if (!$row)
			return FALSE;

		// output

		return $row;

	}
	
	function save()
	{
		$d = & $this->ci->d;
		$data = $this->input('fields');
		if($data['soal_jml']==''){
			unset($data['soal_jml']);
		}
		$row = $this->rowset($data['evaluasi_id'] , $data['posisi_kd']);
		//print_r($data);
		
		$this->db->trans_start();
		
		if($row){
			
			$data['updated']	 = $d['datetime'];
			$data['editor_id']	 = $d['user']['id'];
			
			$this->db->where('evaluasi_id', $data['evaluasi_id']);
			$this->db->where('posisi_kd', $data['posisi_kd']);
			$this->db->update('kbm_evaluasi_pembagian_kd', $data);
			
		}else{
			
			$data['registered']  = $d['datetime'];
			$data['editor_id']	 = $d['user']['id'];
			
			$this->db->insert('kbm_evaluasi_pembagian_kd', $data);
		}
			
		return $this->trans_done('Data mapel berhasil diperbarui.', 'Database error, coba beberapa saat lagi.');

	}
}