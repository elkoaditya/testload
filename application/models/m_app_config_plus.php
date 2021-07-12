<?php

class M_app_config_plus extends CI_Model
{

	var $ci;

	var $dat = array();

	public function __construct()
	{
		parent::__construct();
		$this->ci = & get_instance();
		

	}
	
	public function get_key()
	{
		$query = $this->db->query(" 
			SELECT
				value
			FROM 
				app_config 
			WHERE 
				id = 4
		");
		
		foreach ($query->result() as $row)
		{
			$key = $row->value;
		}
		
		return $key;
	}
	
	public function reset_password_sdm_new()
	{
		//echo 'aaa';
		$key = $this->get_key();
		//print_r($key);
		
		$query = $this->db->query("
			UPDATE data_user du 
				LEFT JOIN 
					dprofil_sdm ds ON ds.id = du.id
				
			SET 
				du.username = 
					IF(LENGTH (ds.nip)=0,concat('guru',ds.id),SUBSTRING(ds.nip, 1, 8)),
				du.password = 
					concat( 
						MD5( 
							concat( 
								SUBSTRING(MD5(CONCAT(du.id, '".$key."')),1,6) , 
								'fresto6' 
							) 
						) ,  
						MD5( 
							SUBSTRING(MD5(CONCAT(du.id, '".$key."')),1,6) 
						) 
					) 
			WHERE 
					du.role='sdm'
				
		");
		
		$query = $this->db->query("
			DELETE rhs
			FROM 
				secret rhs
			
		");

		$query = $this->db->query("
			INSERT INTO
				secret

			SELECT
				ds.id, ds.nama, ds.prefix, ds.suffix, IF(LENGTH (ds.nip)=0,concat('guru',ds.id),SUBSTRING(ds.nip, 1, 8)), SUBSTRING(MD5(CONCAT( ds.id , '".$key."')),1,6)

			FROM
				dprofil_sdm ds
			
			WHERE
				ds.aktif = 1 
		");
		
		/// HISTORY
		$now = date("Y-m-d H:i:s");
		$keterangan = "RESET PASSWORD SDM WITH KEY ".$key." TIME ".$now." BY ".$this->d['user']['username']."  ".$this->d['user']['id'];
		$query = $this->db->query("
			INSERT INTO
				history_record
			SET
				keterangan 	= '".$keterangan."',
				action		= 'RESET',
				time		= '".$now."',
				user_id		= '".$this->d['user']['id']."';
				
		");
		//echo $query;
	

	}
	
	public function reset_password_angkatan( $angkatan )
	{
		//print_r($this->d['user']);
		//echo 'aaa';
		$key = $this->get_key();
		//print_r($key);
		
		$query = $this->db->query("
			UPDATE data_user du 
				LEFT JOIN 
					dprofil_siswa ds ON ds.id = du.id
				LEFT JOIN 
					dakd_kelas dk ON dk.id = ds.kelas_id
			SET 
				du.username = ds.nis,
				du.password = 
					concat( 
						MD5( 
							concat( 
								SUBSTRING(MD5(CONCAT(du.id, '".$key."')),1,6) , 
								'fresto6' 
							) 
						) ,  
						MD5( 
							SUBSTRING(MD5(CONCAT(du.id, '".$key."')),1,6) 
						) 
					),
				du.username_ori = du.username,
				du.password_ori = du.password
			WHERE 
					du.role='siswa'
				AND
					dk.grade = '".$angkatan."'
		");
		
		$query = $this->db->query("
			UPDATE data_user du 
				LEFT JOIN 
					dprofil_siswa ds ON ds.id = du.id
				LEFT JOIN 
					dakd_kelas dk ON dk.id = ds.kelas_id
			SET 
				du.username_ori = du.username,
				du.password_ori = du.password
			WHERE 
					du.role='siswa'
				AND
					dk.grade = '".$angkatan."'
		");
		
		$query = $this->db->query("
			DELETE rhs
			FROM 
				rahasia rhs
			LEFT JOIN 
				dakd_kelas dk ON dk.id = rhs.kelas_id
			WHERE 
				dk.grade = '".$angkatan."'
		");

		$query = $this->db->query("
			INSERT INTO
				rahasia

			SELECT
				ds.id, ds.nama, ds.kelas_id, ds.nis, SUBSTRING(MD5(CONCAT( ds.id , '".$key."')),1,6)

			FROM
				dprofil_siswa ds
			LEFT JOIN 
				dakd_kelas dk ON dk.id = ds.kelas_id

			WHERE
				ds.aktif = 1 
			AND
				dk.grade = '".$angkatan."'
		");
		
		
		/// HISTORY
		$now = date("Y-m-d H:i:s");
		$keterangan = "RESET PASSWORD ".$angkatan." WITH KEY ".$key." TIME ".$now." BY ".$this->d['user']['username']."  ".$this->d['user']['id'];
		$query = $this->db->query("
			INSERT INTO
				history_record
			SET
				keterangan 	= '".$keterangan."',
				action		= 'RESET',
				time		= '".$now."',
				user_id		= '".$this->d['user']['id']."';
				
		");
		//echo $query;
	

	}
	
	
}