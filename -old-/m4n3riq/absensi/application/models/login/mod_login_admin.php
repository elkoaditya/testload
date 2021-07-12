<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_login_admin extends CI_Model {

    function verifikasi($send_data='') {
		
		$d = $this->d;
		$data1='';
		$send_data['password'] = MD5($send_data['password']);
		
		if(isset($send_data['username']))
		{
			$this->db->select("*");
			
			$this->db->where('login_username', $send_data['username']);
			$this->db->where('login_password', $send_data['password']);
			$this->db->join('user_login_role role', 'role.login_role_id =  login.login_role_id', 'inner');
			
			$query = $this->db->get('user_login login');
			$a=0;
			
			foreach ($query->result() as $arra1) {
				$a++;
				$datas = array(
					'id' 				=> $arra1->login_id,
					'username' 			=> $arra1->login_username,
					'role' 				=> $arra1->login_role_kode,
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
			
			$data_update['login_sid'] = $this->session->userdata['session_id'];
			$data_update['login_last_access'] = date("Y-m-d H:i:sa");
			$data_update['login_last_ip'] = $this->session->userdata['ip_address'];
			$data_update['login_mac_address'] = $macaddress;
			
			$data1['user']['sid'] = $data_update['login_sid'];
			
			$this->db->where('login_id',$data1['user']['id']);
			$this->db->update('user_login', $data_update);
			
			
			$this->session->set_userdata($data1);
		}
        //$data1['count'] = $a;
        return $data1;
		
		//	$this->session->sess_destroy();
		//return $d;
		
    }
	 function cek_login() {
		
		$this->db->where('login_sid', $this->session->userdata['user']['sid']);
		$this->db->where('login_username', $this->session->userdata['user']['username']);
        $query = $this->db->get('user_login');
		
		$ada=0;
		foreach ($query->result() as $arra1) {
			$ada=1;
		}
		
        return $ada;
		
	//	redirect(base_url().'dashboard/home',$data1);
		//	$this->session->sess_destroy();
		//return $d;
		
    }
}
