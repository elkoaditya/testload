<?php 

class M_admin extends CI_Model {
	
	function get_data($data){
		
		$where_id = "";
		if(isset($data['admin_id'])){
			if($data['admin_id'] > 0){
				$where_id = " AND admin.id = ".$data['admin_id'];
			}
		}
		
		$admin_data = $this->db->query("
				SELECT 
					admin.*
				FROM 
					dprofil_admin admin
				JOIN 
					data_user user ON user.id = admin.id
				WHERE 
					admin.aktif = 1
					".$where_id."
				ORDER BY 
					admin.nama asc
			");
		
		return $admin_data;
	}

}?>