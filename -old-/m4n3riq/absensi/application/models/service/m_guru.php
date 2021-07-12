<?php 

class M_guru extends CI_Model {
	
	function get_data($data){
		
		$where_id = "";
		if(isset($data['guru_id'])){
			if($data['guru_id'] > 0){
				$where_id = " AND guru.id = ".$data['guru_id'];
			}
		}
		
		$guru_data = $this->db->query("
				SELECT 
					guru.*
				FROM 
					dprofil_sdm guru
				JOIN 
					data_user user ON user.id = guru.id
				WHERE 
					guru.aktif = 1
					".$where_id."
				ORDER BY 
					guru.nama asc
			");
		
		return $guru_data;
	}
	
	function get_data_wali($data){
		
		$where_id = "";
		if(isset($data['guru_id'])){
			if($data['guru_id'] > 0){
				$where_id = " AND guru.id = ".$data['guru_id'];
			}
		}
		
		$guru_data = $this->db->query("
				SELECT 
					kelas.nama as wali_kelas,
					semester.nama as semester_nama
				FROM 
					dprofil_sdm guru
				JOIN 
					data_user user ON user.id = guru.id
				JOIN 
					nilai_kelas nikel ON nikel.kelas_wali_id = guru.id
				JOIN  
					dakd_kelas kelas ON nikel.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  nikel.semester_id
				WHERE 
					guru.aktif = 1
					AND
					semester.status = 'aktif'
					".$where_id."
				ORDER BY 
					guru.nama asc
			");
		
		return $guru_data;
	}
}
