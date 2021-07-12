<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_login extends CI_Model {

    function verifikasi($send_data='') {
		
		$d = $this->d;
		$data1='';
			$key = 'fresto6';
		//$send_data['nisn'] = MD5($send_data['nisn']);
		
		if(isset($send_data['username']))
		{
			$username	= $send_data['username'];
			$password	= $send_data['password'];
			$new_pass	= md5($password.$key).md5($password);
			
			$this->db->select("*");
			
			$this->db->where('username', $username);
			$this->db->where('password', $new_pass);
			$this->db->where('password', $new_pass);
			
			$query = $this->db->get('data_user user');
			$a=0;
			
			foreach ($query->result() as $arra1) {
				$a++;
				$datas = array(
					'id' 				=> $arra1->id,
					'username' 			=> $arra1->username,
					//'role' 				=> $arra1->role,
					'role' 				=> 'super_admin',
				);
				$data1['user'] = $datas;
				
			}
		}
		
		if(isset($data1['user']['id']))
		{
			/// MAC ADDRESS 
			// Turn on output buffering  
			ob_start();  

			//Get the ipconfig details using system commond  
			system('ipconfig /all');  

			// Capture the output into a variable  
			$mycomsys=ob_get_contents();  

			// Clean (erase) the output buffer  
			ob_clean();  

			$find_mac = "Physical"; 
			//find the "Physical" & Find the position of Physical text  

			$pmac = strpos($mycomsys, $find_mac);  
			// Get Physical Address  

			$macaddress=substr($mycomsys,($pmac+36),17);  
			//Display Mac Address  
			///END MAC ADDRESS 
			
			$data_update['log_sid'] = $this->session->userdata['session_id'];
			$data_update['log_last_access'] = date("Y-m-d H:i:sa");
			$data_update['log_last_ip'] = $this->session->userdata['ip_address'];
			$data_update['log_mac_address'] = $macaddress;
			
			$data1['user']['sid'] = $data_update['log_sid'];
			
			///////// CEK /////////////////////
			$this->db->select("*");
			$this->db->where('log_id',$data1['user']['id']);
			$query = $this->db->get('absensi_log_login');
			
			$ada=0;
			foreach ($query->result() as $arra1) {
				$ada=1;
			}
			if($ada==1){			
				$this->db->where('log_id',$data1['user']['id']);
				$this->db->update('absensi_log_login', $data_update);
			}else{
				$data_update['log_id'] = $data1['user']['id'];
				$this->db->insert('absensi_log_login', $data_update);
			}
			////////////////////////////////////
			
			// UPDATE DATA USER
			$data_user['absensi_sid']	= $data_update['log_sid'];
			
			$this->db->where('id',$data1['user']['id']);
			$this->db->update('data_user', $data_user);
			
			$this->session->set_userdata($data1);
		}
        //$data1['count'] = $a;
        return $data1;
		
		//	$this->session->sess_destroy();
		//return $d;
		
    }
	 function cek_siswa() {
		$ada=0;
		if(isset($this->session->userdata['user']['sid'])){
			$this->db->where('absensi_sid', $this->session->userdata['user']['sid']);
			$this->db->where('username', $this->session->userdata['user']['username']);
			
			$query = $this->db->get('data_user');
			
			
			foreach ($query->result() as $arra1) {
				$ada=1;
			}
		}
		
        return $ada;
		
	
		
    }
}
