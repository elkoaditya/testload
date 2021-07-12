<?php 

class M_nilai_siswa_absensi extends CI_Model {

	function check_data($data){
		
		$this->db->select("
			*
		");
		$this->db->where("id", $data['id']);
		
		$check = $this->db->get("nilai_siswa_absensi nilsisabs")->result_array();
		
		$result = new stdClass();
		$result->id = 0;
		foreach($check as $view){
			$result->id = $view['id'];
		}
		
		return $result;
	}
	
	function get_data($data){
		//print_r($data);
		$where_id = "";
		$join_id = "";
		
			if(isset($data['kelas'])){
				if($data['kelas']>0){
					$where_id .= " AND nilkls.id = ".$data['kelas'];
				}
			}
			if(isset($data['tanggal'])){
				if($data['tanggal']>0){
					$join_id .= " AND nilabs.tanggal = ".$data['tanggal'];
				}
			}
			if(isset($data['jam_ajar'])){
				if($data['jam_ajar']>0){
					$join_id .= " AND nilabs.jam_ajar_id = ".$data['jam_ajar'];
				}
			}
			if(isset($data['absensi_nilai_id'])){
				if($data['absensi_nilai_id']){
					$where_id .= " AND nilabs.id = ".$data['absensi_nilai_id'];
				}
			}
			if(isset($data['siswa_absensi_nilai_id'])){
				if($data['siswa_absensi_nilai_id']){
					$where_id .= " AND nilsisabs.id = ".$data['siswa_absensi_nilai_id'];
				}
			}
		
		
		$absensi_data = $this->db->query("
				SELECT 
					nilsisabs.id,
					siswa.nama,
					kelas.nama as kelas_nama,
					siswa.xdat,
					
					siswa.gender,
					nilsis.kelas_nilai_id,
					
					nilabs.tanggal,
					
					nilsisabs.absensi_nilai_id,
					nilsisabs.siswa_nilai_id,
					nilsisabs.absen,
					nilsisabs.status,
					nilsisabs.keterangan,
					nilsisabs.modified,
					nilsisabs.modifier_id,
					
					semester.id as semester_id
				FROM 
					dprofil_siswa siswa
				JOIN 
					nilai_siswa nilsis ON nilsis.siswa_id = siswa.id
				JOIN 
					nilai_kelas nilkls ON nilsis.kelas_nilai_id = nilkls.id
				JOIN 
					dakd_kelas kelas ON nilkls.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  nilsis.semester_id
				LEFT JOIN 
					nilai_siswa_absensi nilsisabs ON nilsisabs.siswa_nilai_id = nilsis.id 
				LEFT JOIN 
					nilai_absensi nilabs ON nilsisabs.absensi_nilai_id = nilabs.id ".$join_id." 
				
				WHERE 
					semester.status = 'aktif'
					AND 
					nilsisabs.aktif = 1
					AND 
					siswa.aktif = '1'
					".$where_id."
				ORDER BY 
					siswa.nama asc, kelas.nama asc
			");
		
		return $absensi_data;
	}
	
	function update_data($data){
		
		$this->db->trans_begin();
		
		$check = $this->check_data($data);
		
		if($check->id > 0){
			
			$data['modified']= date("Y-m-d H:i:s");
			
			$this->db->where("id", $data['id']);
			$this->db->update("nilai_siswa_absensi",$data);
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
	
	
}