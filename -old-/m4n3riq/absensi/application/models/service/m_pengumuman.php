<?php 

class M_pengumuman extends CI_Model {
	
	function check_data($data){
		$this->db->select("*");
		$this->db->join("kbm_pengumuman_read reading ", "reading.pengumuman_id = pengumuman.id","left");
		$this->db->where("reading.user_id", $data['user_id']);
		$this->db->where("reading.pengumuman_id", $data['pengumuman_id']);
		
		$check = $this->db->get("kbm_pengumuman pengumuman")->result_array();
		
		$result = new stdClass();
		$result->ada = 0;
		foreach($check as $view){
			$result->ada = 1;
		}
		
		return $result;
	}
	
	function get_data($data){
		$where_id = "";
		$where_on = "";
		if(isset($data['role'])){
			if($data['role'] =='sdm'){
				$where_id = " AND untuk_guru = 1 ";
			}
			
			if($data['role'] =='siswa'){
				$where_id = " AND untuk_siswa = 1 ";
			}
		}
		
		if(isset($data['pengumuman'])){
			$where_id .= " AND reading.pengumuman_id = ".$data['pengumuman'];
		}
		
		if(isset($data['user'])){
			$where_on = " AND reading.user_id = ".$data['user'];
		}
		
		$pengumuman_data = $this->db->query("
				SELECT 
					pengumuman.*,
					IF(reading.user_id > 0, 'YES', 'NO') as reading
				FROM 
					kbm_pengumuman pengumuman
				LEFT JOIN 
					kbm_pengumuman_read reading 
				ON ( reading.pengumuman_id = pengumuman.id 
					".$where_on." )
				WHERE 
						pengumuman.urut <= 10
					AND
						pengumuman.urut >= 1
					".$where_id."
				ORDER BY 
					pengumuman.urut asc,
					pengumuman.modified desc
			");
		
		return $pengumuman_data;
	}
	
	function insert_data($data){
		
		$check = $this->check_data($data);
		
		if($check->ada == 0){
			$this->db->trans_begin();
			
			$this->db->insert("kbm_pengumuman_read",$data);
			
			$check = $this->check_data($data);
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
	}
}
?>