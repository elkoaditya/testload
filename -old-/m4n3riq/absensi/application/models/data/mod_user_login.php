<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class mod_user_login extends CI_Model {


    function listing($send_data = "") {
		
		$d = $this->d;
	
		$this->db->select("user_login.*,role.login_role_nama, user.login_username as modified_username");
		$this->db->join('user_login user', 'user.login_id =  user_login.login_modified_id', 'left');
		$this->db->join('user_login_role role', 'role.login_role_id =  user_login.login_role_id', 'left');
		
		if(!empty($send_data['id'])){ 
			$this->db->where('user_login.login_id', $send_data['id'], false);
		}
		$this->db->where('user_login.login_aktif', 1, false);
        $query = $this->db->get('user_login');
        $a=0;
        foreach ($query->result() as $arra1) {
            $a++;
			$datas = array(
				'login_id' 				=> $arra1->login_id,
				'login_username' 		=> $arra1->login_username,
				'login_role_id' 		=> $arra1->login_role_id,
				'login_last_access'		=> $arra1->login_last_access,
				'login_modified_time'	=> $arra1->login_modified_time,
				'login_aktif' 			=> $arra1->login_aktif,
				
				'login_role_nama' 		=> $arra1->login_role_nama,
				
				'modified_username' 				=> $arra1->modified_username,
			);
			$data1['data'][$a] = $datas;
			
        }
		//lembaga_user_id2
        $data1['count'] = $a;
        return $data1;
		
		return $d;
    }
	
	function save($send_data = "") {
		$d = $this->d;
		
		$data = array(
			//'login_perusahaan_id' 	=> '1',
			'login_username' 		=> $send_data['login_username'],
			'login_role_id' 		=> $send_data['login_role_id'],
			'login_aktif' 			=> $send_data['login_aktif'],
			'login_modified_time'	=> date("Y-m-d H:i:sa"),
			'login_modified_id'		=> $this->session->userdata['user']['id'],
			
			);
		
		if(($send_data['login_password']!="")&&($send_data['login_password']==$send_data['confirmed_password']))
		{	$data['login_password']	= MD5($send_data['login_password']);	}
	
		if(isset($send_data['user_login_id'])){
			$this->db->where('login_id', $send_data['user_login_id']);
			$this->db->update('user_login', $data);
		}else{
			$data['user_login_created'] = date("Y-m-d H:i:sa");
			$this->db->insert('user_login', $data);
		}
		
		
    }
	

}
