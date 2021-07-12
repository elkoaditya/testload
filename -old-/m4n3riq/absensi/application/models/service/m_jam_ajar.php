<?php 

class M_jam_ajar extends CI_Model {
	
	function get_data(){
		
		$jam_ajar_data = $this->db->query("
				SELECT 
					* 
				FROM 
					dakd_jam_ajar 
				WHERE 
					aktif = 1
				ORDER BY
					CHAR_LENGTH(nama),
					nama asc
			");
		
		return $jam_ajar_data;
	}
}
