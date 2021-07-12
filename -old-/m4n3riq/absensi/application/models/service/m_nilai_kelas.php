<?php 

class M_nilai_kelas extends CI_Model {

	function get_data($data){
		
		$where_id = "";
		if(isset($data['nilai_kelas_id'])){
			if($data['nilai_kelas_id'] > 0){
				$where_id = " AND nikel.id = ".$data['nilai_kelas_id'];
			}
		}
		
		$kelas_data = $this->db->query("
				SELECT 
					nikel.id,
					kelas.nama as kelas_nama,
					jurusan.nama as jurusan_nama,
					kelas.wali_id,
					guru.nama as wali_nama
				FROM 
					dakd_kelas kelas
				JOIN 
					nilai_kelas nikel ON nikel.kelas_id = kelas.id
				JOIN 
					dprofil_sdm guru ON guru.id = kelas.wali_id
				JOIN 
					dakd_jurusan jurusan ON jurusan.id =  kelas.jurusan_id
				JOIN 
					prd_semester semester ON semester.id =  nikel.semester_id
				WHERE 
					semester.status = 'aktif'
					".$where_id."
					AND kelas.nama NOT LIKE '%Alumni%'
					AND kelas.nama NOT LIKE '%ALUMNI%'
					AND kelas.nama NOT LIKE '%Keluar%'
					AND kelas.nama NOT LIKE '%KELUAR%'
					AND kelas.nama NOT LIKE 'ZZ%'
					AND kelas.nama NOT LIKE '%TEST%'
				ORDER BY 
					kelas.nama asc
			");
		
		return $kelas_data;
	}
	
	
}