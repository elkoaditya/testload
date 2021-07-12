<?php 

class M_nilai_absensi extends CI_Model {

	function check_data($data, $chek=''){
		
		$this->db->select("
			nilabs.*, 
			admin.nama as nama_admin, 
			sdm.nama as nama_sdm
		");
		if($chek=='id'){
			$this->db->where("nilabs.id", $data['id']);
		}else{
			$this->db->where("kelas_nilai_id", $data['kelas_nilai_id']);
			$this->db->where("jam_ajar_id", $data['jam_ajar_id']);
			$this->db->where("tanggal", $data['tanggal']);
		}
		$this->db->join("dprofil_admin admin","admin.id = nilabs.modifier_id","left");
		$this->db->join("dprofil_sdm sdm","sdm.id = nilabs.modifier_id","left");
		$this->db->where("nilabs.aktif", 1);
		
		$check = $this->db->get("nilai_absensi nilabs")->result_array();
		
		//print_r($check);
		$result = new stdClass();
		$result->id = 0;
		$result->status = 'baru';
		$result->kelas = 'baru';
		$result->keterangan = 'Berhasil Input Absensi Baru';
		foreach($check as $view){
			$result->id = $view['id'];
			
			if($chek!='id'){	
				if($view['pelajaran_nilai_id'] == $data['pelajaran_nilai_id']){	
					$result->status = 'sama';
					$result->keterangan = 'Absensi sudah pernah di input ';
				}else{	
					$result->status = 'beda';
					$result->keterangan = 'Absensi diisi mapel lain ';
				}
				
				$result->keterangan .= ' pada '.$view['modified'].' oleh '.
					$view['nama_admin'].$view['nama_sdm'];

			}else{
				if(isset($data['kelas_nilai_id'])){
					if($view['kelas_nilai_id'] != $data['kelas_nilai_id']){	
						$result->kelas = 'beda';
					}
				}
			}
		}
		
		return $result;
	}
	
	function get_data($data){
		
		$where_id = "";
		if(isset($data['nilai_absensi_id'])){
			if($data['nilai_absensi_id'] > 0){
				$where_id .= " AND nilabs.id = ".$data['nilai_absensi_id'];
			}
		}
		if(isset($data['nilai_kelas_id'])){
			if($data['nilai_kelas_id'] > 0){
				$where_id .= " AND nilkls.id = ".$data['nilai_kelas_id'];
			}
		}
		if(isset($data['guru_id'])){
			if(($data['guru_id'] > 0)&&($data['role_create']=='sdm')){
				$where_id .= " AND nilabs.guru_id = ".$data['guru_id'];
			}
		}
		if(isset($data['tanggal'])){
			if($data['tanggal'] > 0){
				$where_id .= " AND nilabs.tanggal = '".$data['tanggal']."'";
			}
		}
		if(isset($data['jam_ajar'])){
			if($data['jam_ajar'] > 0){
				$where_id .= " AND nilabs.jam_ajar_id LIKE '%".$data['jam_ajar']."%'";
			}
		}
		if(isset($data['kelas_nilai_id'])){
			if($data['kelas_nilai_id'] > 0){
				$where_id .= " AND nilabs.kelas_nilai_id = '".$data['kelas']."'";
			}
		}
		
		$absensi_data = $this->db->query("
				SELECT 
					kelas.nama as kelas_nama,
					CONCAT (mapel.nama,' / ', kategori.nama,' / ', kurikulum.nama) as pelajaran_nama,
					jam_ajar_id,
					
					nilabs.id,
					nilabs.tanggal,
					nilabs.kelas_nilai_id,
					nilabs.pelajaran_nilai_id,
					nilabs.guru_id,
					nilabs.materi_ajar,
					nilabs.status_belajar_id,
					
					DATE_FORMAT(jam_masuk, '%H:%i') as jam_masuk,
					DATE_FORMAT(jam_keluar, '%H:%i') as jam_keluar,
					
					nilabs.keterangan,
					
					status_belajar.nama as status_belajar_nama,
					
					nilabs.modified,
					nilabs.modifier_id,
					
					
					semester.id as semester_id
				FROM 
					nilai_kelas nilkls
				JOIN 
					dakd_kelas kelas ON nilkls.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  nilkls.semester_id
				LEFT JOIN 
					nilai_absensi nilabs ON nilabs.kelas_nilai_id = nilkls.id
				LEFT JOIN 
					dakd_status_belajar status_belajar ON status_belajar.id = nilabs.status_belajar_id
				LEFT JOIN 
					dprofil_sdm guru ON guru.id = nilabs.guru_id
					
				LEFT JOIN 
					nilai_pelajaran nipel ON nipel.id = nilabs.pelajaran_nilai_id
				LEFT JOIN 
					dakd_pelajaran pelajaran ON pelajaran.id = nipel.pelajaran_id
				LEFT JOIN 
					dakd_mapel mapel ON mapel.id = pelajaran.mapel_id
				LEFT JOIN
					dmst_kurikulum kurikulum ON nipel.kurikulum_id = kurikulum.id
				LEFT JOIN 
					dakd_kategori_mapel kategori ON  pelajaran.kategori_id = kategori.id 
				
				WHERE 
					semester.status = 'aktif'
					AND 
					nilabs.aktif = 1
					AND 
					kelas.aktif = '1'
					".$where_id."
				ORDER BY 
					nilabs.id desc
			");
		
		return $absensi_data;
	}
/*
	function get_select_data($data){
		
		$where_id = "";
		if(isset($data['nilai_absensi_id'])){
			if($data['nilai_absensi_id'] > 0){
				$where_id .= " AND nilabs.id = ".$data['nilai_absensi_id'];
			}
		}
		if(isset($data['nilai_kelas_id'])){
			if($data['nilai_kelas_id'] > 0){
				$where_id .= " AND nilkls.id = ".$data['nilai_kelas_id'];
			}
		}
		if(isset($data['guru_id'])){
			if($data['guru_id'] > 0){
				$where_id .= " AND nilabs.guru_id = ".$data['guru_id'];
			}
		}
		if(isset($data['tanggal'])){
			if($data['tanggal'] > 0){
				$where_id .= " AND nilabs.tanggal = ".$data['tanggal'];
			}
		}
		if(isset($data['jam_ajar'])){
			if($data['jam_ajar'] > 0){
				$where_id .= " AND nilabs.jam_ajar_id = ".$data['jam_ajar'];
			}
		}
		
		$absensi_data = $this->db->query("
				SELECT 
					kelas.nama as kelas_nama,
					CONCAT (mapel.nama,' / ', kategori.nama,' / ', kurikulum.nama) as pelajaran_nama,
					jam_ajar.id as jam_ajar_id,
					jam_ajar.nama as jam_ajar_nama,
					
					nilabs.id,
					nilabs.tanggal,
					nilabs.kelas_nilai_id,
					nilabs.pelajaran_nilai_id,
					nilabs.guru_id,
					
					nilabs.modified,
					nilabs.modifier_id,
					
					
					semester.id as semester_id
				FROM 
					nilai_kelas nilkls
				JOIN 
					dakd_kelas kelas ON nilkls.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  nilkls.semester_id
				LEFT JOIN 
					nilai_absensi nilabs ON nilabs.kelas_nilai_id = nilkls.id
				LEFT JOIN 
					dakd_jam_ajar jam_ajar ON nilabs.jam_ajar_id = jam_ajar.id
				LEFT JOIN 
					dprofil_sdm guru ON guru.id = nilabs.guru_id
					
				LEFT JOIN 
					nilai_pelajaran nipel ON nipel.id = nilabs.pelajaran_nilai_id
				LEFT JOIN 
					dakd_pelajaran pelajaran ON pelajaran.id = nipel.pelajaran_id
				LEFT JOIN 
					dakd_mapel mapel ON mapel.id = pelajaran.mapel_id
				LEFT JOIN
					dmst_kurikulum kurikulum ON nipel.kurikulum_id = kurikulum.id
				LEFT JOIN 
					dakd_kategori_mapel kategori ON  pelajaran.kategori_id = kategori.id 
				
				WHERE 
					semester.status = 'aktif'
					AND 
					nilabs.aktif = 1
					AND 
					kelas.aktif = '1'
					".$where_id."
				ORDER BY 
					kelas.nama asc
			");
		
		return $absensi_data;
	}
	*/
	
	function insert_data($data){
		$this->load->model('m_nilai_siswa_absensi', 'nilai_siswa_absensi');
		
		$check = $this->check_data($data);
		
		if($check->status == 'baru'){
			$this->db->trans_begin();
			
				$data['modified']= date("Y-m-d H:i:s");
				$this->db->insert('nilai_absensi',$data);
				$absensi_nilai_id	= $this->db->insert_id();
				
				$data_get['kelas_nilai_id'] = $data['kelas_nilai_id'];
				$siswa_absensi_data = $this->nilai_siswa->get_data($data_get);
				$result_siwa	= $siswa_absensi_data->result();
				//print_r($result_siwa);
				$no=0;
				foreach($result_siwa as $siswa){
					$data_siswa[$no]['absensi_nilai_id']	= $absensi_nilai_id;
					$data_siswa[$no]['siswa_nilai_id'] 		= $siswa->id;
					//$data_siswa[$no]['status']				= $siswa->status;
					$data_siswa[$no]['modified']			= date("Y-m-d");
					$no++;
				}
				$this->db->insert_batch('nilai_siswa_absensi', $data_siswa); 
			
				$check->id = $absensi_nilai_id;
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				//return $absensi_nilai_id;
				return $check;
			}
			
		}else{
			return $check;
		}
		
	}
	
	function update_data($data){
		
		$this->db->trans_begin();
		
		$check = $this->check_data($data,'id');
		
		if($check->id > 0){
			
			$this->db->where("id", $data['id']);
			$this->db->update("nilai_absensi",$data);
			
			if($check->kelas =='beda'){
				////// siswa //////
				
				$this->db->set("aktif", 0);
				$this->db->where("absensi_nilai_id", $data['id']);
				$this->db->update("nilai_siswa_absensi");
				
				$data_get['kelas_nilai_id'] = $data['kelas_nilai_id'];
				$siswa_absensi_data = $this->nilai_siswa->get_data($data_get);
				$result_siwa		= $siswa_absensi_data->result();
				//print_r($result_siwa);
				$no=0;
				foreach($result_siwa as $siswa){
					$data_siswa[$no]['absensi_nilai_id']	= $data['id'];
					$data_siswa[$no]['siswa_nilai_id'] 		= $siswa->id;
					//$data_siswa[$no]['status']				= $siswa->status;
					$data_siswa[$no]['modified']			= date("Y-m-d");
					$no++;
				}
				$this->db->insert_batch('nilai_siswa_absensi', $data_siswa); 
					
				//////
			}
			
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
	function delete_data($data){
		
		$this->db->trans_begin();
		
		$check = $this->check_data($data,'id');
		
		if($check->id > 0){
			
			$data_delete['id']			= $data['id'];
			$data_delete['modifier_id']	= $data['modifier_id'];
			$data_delete['modified']	= date("Y-m-d H:i:s");
			
			$this->db->where("id", $data['id']);
			$data_delete['aktif'] = 0;
			$this->db->update("nilai_absensi",$data_delete);
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
	
}