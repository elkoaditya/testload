<?php 

class M_jadwal extends CI_Model {
	
	function check_data($data, $chek=''){
		
		$this->db->select("
			*
		");
		if($chek=='id'){
			$this->db->where("id", $data['id']);
		}else{
			$this->db->where("guru_id", $data['guru_id']);
		}
		$check = $this->db->get("jadwal_sdm jadwal")->result_array();
		
		$result = new stdClass();
		$result->id = 0;
		foreach($check as $view){
			$result->id = $view['id'];
		}
		
		return $result;
	}
	
	function get_data_guru($data){
		$where_id = "";
		if(isset($data['user'])){
			if($data['user'] > 0){
				$where_id = " AND guru.id = ".$data['user'];
			}
		}
		if(isset($data['jadwal_id'])){	
			if($data['jadwal_id'] > 0){
				$where_id = " AND jadwal.id = ".$data['jadwal_id'];
			}
		}
		
		$jadwal_data = $this->db->query("
				SELECT 
					jadwal.*,
					CONCAT ('".base_url('content/'.APP_SCOPE.'/jadwal')."','/',jadwal.file) as file_jadwal,
					guru.nama as guru_nama
				FROM 
					jadwal_sdm jadwal
				JOIN 
					dprofil_sdm guru ON guru.id = jadwal.guru_id
				JOIN 
					prd_semester semester ON semester.id =  jadwal.semester_id
				
				WHERE 
					semester.status = 'aktif'
					AND
					guru.aktif = 1
					AND
					jadwal.aktif = 1
					".$where_id."
				ORDER BY 
					semester.id desc,
					guru.nama asc
			");
		
		return $jadwal_data;
	}
	
	function get_data_siswa($data){
		$where_id = "";
		if(isset($data['user'])){
			if($data['user'] > 0){
				$where_id = " AND siswa.id = ".$data['user'];
			}
		}
		if(isset($data['jadwal_id'])){	
			if($data['jadwal_id'] > 0){
				$where_id = " AND jadwal.id = ".$data['jadwal_id'];
			}
		}
		
		$jadwal_data = $this->db->query("
				SELECT 
					jadwal.*,
					CONCAT ('".base_url('content/'.APP_SCOPE.'/jadwal')."','/',jadwal.file) as file_jadwal,
					siswa.nama as guru_nama
				FROM 
					jadwal_kelas jadwal
				JOIN 
					dakd_kelas kelas ON kelas.id = jadwal.kelas_id
				JOIN 
					dprofil_siswa siswa ON siswa.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  jadwal.semester_id
				
				WHERE 
					semester.status = 'aktif'
					AND
					siswa.aktif = 1
					AND
					jadwal.aktif = 1
					".$where_id."
				ORDER BY 
					semester.id desc,
					siswa.nama asc
			");
		
		return $jadwal_data;
	}
}
?>