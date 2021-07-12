<?php 

class M_jurnal_siswa extends CI_Model {

	function kelas_nilai($user){
		
		$this->db->select("
			nilkls.*, 
		");
		
		$this->db->where("nilsis.siswa_id", $user);
		$this->db->where("semester.status", "aktif");
		
		$this->db->join("nilai_siswa nilsis","nilsis.kelas_nilai_id = nilkls.id","inner");
		$this->db->join("prd_semester semester","semester.id =  nilkls.semester_id","inner");
		
		$check = $this->db->get("nilai_kelas nilkls")->result_array();
		
		
		foreach($check as $view){
			$result = $view['id'];
			
		}
		
		return $result;
	}
	
	function check_data($data, $chek=''){
		
		$this->db->select("
			jursis.*, 
			admin.nama as nama_admin, 
			sdm.nama as nama_sdm
		");
		if($chek=='id'){
			$this->db->where("jursis.id", $data['id']);
		}else{
			$this->db->where("kelas_nilai_id", $data['kelas_nilai_id']);
			$this->db->where("jam_ajar_id", $data['jam_ajar_id']);
			$this->db->where("tanggal", $data['tanggal']);
		}
		$this->db->join("dprofil_admin admin","admin.id = jursis.modifier_id","left");
		$this->db->join("dprofil_sdm sdm","sdm.id = jursis.modifier_id","left");
		
		$check = $this->db->get("jurnal_siswa jursis")->result_array();
		
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

			}/*else{
				if($view['kelas_nilai_id'] != $data['kelas_nilai_id']){	
					$result->kelas = 'beda';
				}
			}*/
		}
		
		return $result;
	}
	
	function get_data($data){
		
		$where_id = "";
		if(isset($data['jurnal_siswa_id'])){
			if($data['jurnal_siswa_id'] > 0){
				$where_id .= " AND jursis.id = ".$data['jurnal_siswa_id'];
			}
		}
		if(isset($data['guru_id'])){
			if(($data['guru_id'] > 0)&&($data['role_create']=='sdm')){
				$where_id .= " AND jursis.guru_id = ".$data['guru_id'];
			}
		}
		if(isset($data['tanggal'])){
			if($data['tanggal'] > 0){
				$where_id .= " AND jursis.tanggal = '".$data['tanggal']."'";
			}
		}
		if(isset($data['jam_ajar'])){
			if($data['jam_ajar'] > 0){
				$where_id .= " AND jursis.jam_ajar_id LIKE '%".$data['jam_ajar']."%'";
			}
		}
		if(isset($data['kelas_nilai_id'])){
			if($data['kelas_nilai_id'] > 0){
				$where_id .= " AND jursis.kelas_nilai_id = '".$data['kelas']."'";
			}
		}
		if(isset($data['siswa_id'])){
			if(($data['siswa_id'] > 0)&&($data['role_create']=='siswa')){
				$data['kelas_nilai_id'] = $this->kelas_nilai($data['siswa_id']);
				$where_id .= " AND jursis.kelas_nilai_id = '".$data['kelas_nilai_id']."'";
			}
		}
		$absensi_data = $this->db->query("
				SELECT 
					kelas.nama as kelas_nama,
					guru.nama as guru_nama,
					CONCAT (mapel.nama,' / ', kategori.nama,' / ', kurikulum.nama) as pelajaran_nama,
					jam_ajar_id,
					
					jursis.id,
					jursis.tanggal,
					jursis.kelas_nilai_id,
					jursis.pelajaran_nilai_id,
					jursis.guru_id,
					jursis.materi_ajar,
					jursis.status_belajar_id,
					
					DATE_FORMAT(jam_masuk, '%H:%i') as jam_masuk,
					DATE_FORMAT(jam_keluar, '%H:%i') as jam_keluar,
					
					jursis.keterangan,
					
					status_belajar.nama as status_belajar_nama,
					
					jursis.modified,
					jursis.modifier_id,
					
					
					semester.id as semester_id
				FROM 
					nilai_kelas nilkls
				JOIN 
					dakd_kelas kelas ON nilkls.kelas_id = kelas.id
				JOIN 
					prd_semester semester ON semester.id =  nilkls.semester_id
				LEFT JOIN 
					jurnal_siswa jursis ON jursis.kelas_nilai_id = nilkls.id
				LEFT JOIN 
					dakd_status_belajar status_belajar ON status_belajar.id = jursis.status_belajar_id
				LEFT JOIN 
					dprofil_sdm guru ON guru.id = jursis.guru_id
					
				LEFT JOIN 
					nilai_pelajaran nipel ON nipel.id = jursis.pelajaran_nilai_id
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
					jursis.aktif = 1
					AND 
					kelas.aktif = '1'
					".$where_id."
				ORDER BY 
					jursis.id desc
			");
		
		return $absensi_data;
	}

	function insert_data($data){
		
		$this->load->model('m_jurnal_siswa', 'jurnal_siswa');
		$data['kelas_nilai_id'] = $this->kelas_nilai($data['modifier_id']);
		//echo "aa";
		$check = $this->check_data($data);
		//echo "bb";
		if($check->status == 'baru'){
			$this->db->trans_begin();
			
				$data['modified']= date("Y-m-d H:i:s");
				$this->db->insert('jurnal_siswa',$data);
				$jurnal_siswa_id	= $this->db->insert_id();
				
				$check->id = $jurnal_siswa_id;
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				//return $jurnal_siswa_id;
				return $check;
			}
			
		}else{
			return $check;
		}
		
	}
	
	function update_data($data){
		
		$this->db->trans_begin();
		$data['kelas_nilai_id'] = $this->kelas_nilai($data['modifier_id']);
			
		$check = $this->check_data($data,'id');
		
		if($check->id > 0){
			
			$this->db->where("id", $data['id']);
			$this->db->update("jurnal_siswa",$data);
			
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
			$this->db->update("jurnal_siswa",$data_delete);
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
	
}