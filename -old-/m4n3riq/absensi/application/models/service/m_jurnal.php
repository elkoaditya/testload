<?php 

class M_jurnal extends CI_Model {
	
	function check_data($data, $chek=''){
		
		$this->db->select("
			*
		");
		if($chek=='id'){
			$this->db->where("id", $data['id']);
		}else{
			$this->db->where("judul", $data['judul']);
			$this->db->where("guru_id", $data['guru_id']);
		}
		$check = $this->db->get("jurnal_sdm jurnal")->result_array();
		
		$result = new stdClass();
		$result->id = 0;
		foreach($check as $view){
			$result->id = $view['id'];
		}
		
		return $result;
	}
	
	function get_data($data){
		$where_id = "";
		if(isset($data['guru_id'])){
			if($data['guru_id'] > 0){
				$where_id = " AND guru.id = ".$data['guru_id'];
			}
		}
		if(isset($data['jurnal_id'])){	
			if($data['jurnal_id'] > 0){
				$where_id = " AND jurnal.id = ".$data['jurnal_id'];
			}
		}
		
		$jurnal_data = $this->db->query("
				SELECT 
					jurnal.*,
					guru.nama as guru_nama,
					CONCAT (semester.nama,' ', ta.nama) as semester_nama
					
				FROM 
					jurnal_sdm jurnal
				JOIN 
					dprofil_sdm guru ON guru.id = jurnal.guru_id
				JOIN 
					data_user user ON user.id = guru.id
				JOIN 
					prd_semester semester ON semester.id =  jurnal.semester_id
				JOIN 
					prd_ta ta ON ta.id =  semester.ta_id
				WHERE 
					guru.aktif = 1
					AND
					jurnal.aktif = 1
					".$where_id."
				ORDER BY 
					semester.id desc,
					guru.nama asc
			");
		
		return $jurnal_data;
	}
	
	function insert_data($data){
		
		$this->db->trans_begin();
		
		$check = $this->check_data($data);
		
		if($check->id == 0){
			
			$data['modified']= date("Y-m-d H:i:s");
			
			$this->db->insert("jurnal_sdm",$data);
			$check->id = $this->db->insert_id();
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
	function update_data($data){
		
		$this->db->trans_begin();
		
		$check = $this->check_data($data,'id');
		
		if($check->id > 0){
			
			$data['modified']= date("Y-m-d H:i:s");
			
			$this->db->where("id", $data['id']);
			$this->db->update("jurnal_sdm",$data);
			
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
			$this->db->update("jurnal_sdm",$data_delete);
			
			if($this->db->trans_status() === FALSE){// Check if transaction result successful
				$this->db->trans_rollback();
			}else{
				$this->db->trans_commit();
				
			}
		}
		
		return $check;
		
	}
	
}