<?php 

class M_status_belajar extends CI_Model {
	
	function get_data(){
		
		$status_belajar_data = $this->db->query("
				SELECT 
					* 
				FROM 
					dakd_status_belajar 
				WHERE 
					aktif = 1
				ORDER BY
					nama asc
			");
		
		return $status_belajar_data;
	}
}
