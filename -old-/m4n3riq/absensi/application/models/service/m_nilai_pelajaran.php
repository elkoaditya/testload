<?php 

class M_nilai_pelajaran extends CI_Model {

	function get_data($data){
		
		$where_id = "";
		if(isset($data['guru_id'])){
			if(isset($data['role_create'])){
				if(($data['guru_id'] > 0)&&($data['role_create']=='sdm')){
					$where_id = " AND nipel.guru_id = ".$data['guru_id'];
				}
			}
			/*
			if(($data['guru_id'] > 0)&&($data['guru_id']!=821)&&($data['guru_id']!=11)&&($data['guru_id']!=1)){
					$where_id = " AND nipel.guru_id = ".$data['guru_id'];
				}
			*/
		}
		
		$pelajaran_data = $this->db->query("
				SELECT 
					nipel.id,
					CONCAT (mapel.nama,' / ', kategori.nama,' / ', kurikulum.nama) as pelajaran_nama,
					guru.id as guru_id,
					guru.nama as guru_nama
				FROM 
					dakd_mapel mapel
				JOIN 
					dakd_pelajaran pelajaran ON pelajaran.mapel_id = mapel.id
				JOIN 
					nilai_pelajaran nipel ON nipel.pelajaran_id = pelajaran.id
				JOIN
					dmst_kurikulum kurikulum ON nipel.kurikulum_id = kurikulum.id
				JOIN 
					dprofil_sdm guru ON guru.id = nipel.guru_id
				JOIN 
					dakd_kategori_mapel kategori ON  pelajaran.kategori_id = kategori.id 
				JOIN 
					prd_semester semester ON semester.id =  nipel.semester_id
				WHERE 
					semester.status = 'aktif'
					".$where_id."
				GROUP BY
					mapel.id, kategori.id
				ORDER BY 
					mapel.nama asc, kategori.nama asc
			");
		
		return $pelajaran_data;
	}
	
	
}