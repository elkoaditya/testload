<?php 

class M_nilai_siswa extends CI_Model {

	function get_data($data){
		//print_r($data);
		$where_id = "";
		$join_id = "";
		
		if(isset($data['user'])){
			if($data['user']>0){
				$where_id .= " AND user.id = ".$data['user'];
			}
		}
		
		if(isset($data['siswa_nilai_id'])){
			if($data['siswa_nilai_id']>0){
				$where_id .= " AND nilsis.id = ".$data['siswa_nilai_id'];
			}
		}
		
		if(isset($data['kelas_nilai_id'])){
			if($data['kelas_nilai_id']>0){
				$where_id .= " AND nilkls.id = ".$data['kelas_nilai_id'];
			}
		}
		
		
		$absensi_data = $this->db->query("
				SELECT 
					nilsis.id,
					siswa.nis,
					siswa.nisn,
					siswa.nama,
					siswa.gender,
					siswa.xdat,
					
					kelas.nama as nama_kelas,
					nilsis.kelas_nilai_id,
					
					semester.id as semester_id
				FROM 
					nilai_siswa nilsis
				LEFT JOIN 
					dprofil_siswa siswa ON nilsis.siswa_id = siswa.id
				LEFT JOIN 
					data_user user ON user.id = siswa.id
				
				LEFT JOIN 
					nilai_kelas nilkls ON nilsis.kelas_nilai_id = nilkls.id
				LEFT JOIN 
					dakd_kelas kelas ON nilkls.kelas_id = kelas.id
				
				LEFT JOIN 
					prd_semester semester ON semester.id =  nilsis.semester_id
				
				WHERE 
					semester.status = 'aktif'
					AND 
					siswa.aktif = '1'
					".$where_id."
				ORDER BY 
					siswa.nama asc, kelas.nama asc
			");
		
		return $absensi_data;
	}
	
}