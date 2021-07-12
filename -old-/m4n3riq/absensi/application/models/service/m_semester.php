<?php 

class M_semester extends CI_Model {
	
	function get_data($data){
		
		$where_id = "";
		if(isset($data['guru_id'])){
			if($data['guru_id'] > 0){
				$where_id = " AND guru.id = ".$data['guru_id'];
			}
		}
		
		$semester_data = $this->db->query("
				SELECT 
					*
				FROM 
					prd_semester semester
				WHERE 
					status = 'aktif'
			");
		
		return $semester_data;
	}
}