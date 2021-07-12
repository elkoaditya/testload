<?php 

class M_kaldik extends CI_Model {
	
	function check_data($data, $chek=''){
		
		$this->db->select("
			*
		");
		if($chek=='id'){
			$this->db->where("id", $data['id']);
		}
		$check = $this->db->get("dmst_kaldik kaldik")->result_array();
		
		$result = new stdClass();
		$result->id = 0;
		foreach($check as $view){
			$result->id = $view['id'];
		}
		
		return $result;
	}
	
	function get_data($data){
		$where_id = "";
		if(isset($data['kaldik_id'])){	
			if($data['kaldik_id'] > 0){
				$where_id = " AND kaldik.id = ".$data['kaldik_id'];
			}
		}
		
		$kaldik_data = $this->db->query("
				SELECT 
					kaldik.*,
					CONCAT ('".base_url('content/'.APP_SCOPE.'/kaldik')."','/',kaldik.file) as file_kaldik,
					CONCAT (semester.nama,' ', ta.nama) as semester_nama
					
				FROM 
					dmst_kaldik kaldik
				JOIN 
					prd_semester semester ON semester.id =  kaldik.semester_id
				JOIN 
					prd_ta ta ON ta.id =  semester.ta_id
				WHERE 
					semester.status = 'aktif'
					AND
					kaldik.aktif = 1
					".$where_id."
				ORDER BY 
					semester.id desc
			");
		
		return $kaldik_data;
	}
}
?>