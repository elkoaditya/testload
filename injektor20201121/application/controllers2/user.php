<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->model('utama_model','utama');
	
	}
	
	public function show_user_position($limit=0, $offset=1000) {
		
			$db				= 'user_position';
			
			$order_coloumn	= 'user_position_id'; 
			
			$order			= 'asc';
			
			$data[$db] = $this->utama->get_data_all_one_table($db, $limit, $offset, $order_coloumn, $order);
		
			return $data[$db];
	}
	
	public function show_user_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$db				= 'user';
			
			$order_coloumn	= 'user_position_id'; 
			
			$order			= 'asc';
			
			$data[$db] = $this->utama->get_data_by_where_one_table($db, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			
			return $data[$db];
	
	}
	
	public function show_user_by_id($id) {
			
			$db				= 'user';
			
			$where_coloumn	= 'user_id'; 
			
			$data[$db] = $this->utama->get_detail_id_one_table($db, $where_coloumn, $id);
			
			return $data[$db];
	
	}
	
	public function show_user_by_multiwhere_multitable($db, $db_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'user_name'; 
			
			$order			= 'asc';
			
			$data[$db] = $this->utama->get_data_by_multiwhere_multitable($db, $db_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			
			return $data[$db];
	
	}
	
	public function save_user($action,$id=0) {

			$db	= 'user';
			
			$where_coloumn			= 'user_id';
			
			if($id==0)
			{	$id = $this->input->post('user_id');	}
			
			if($action!='delete')
			{
				$data['user_id']		= $this->input->post('user_id');
		   
				$data['user_name'] 		= $this->input->post('user_name');
				
				$data['user_branch'] 		= $this->input->post('user_branch');
		   
		   		if($this->input->post('user_pass')!='')
				{	$data['user_pass']		= md5($this->input->post('user_pass'));		}
				
				if($this->input->post('user_position_id')!='')
				{	$data['user_position_id']= $this->input->post('user_position_id');	}
				
				$data['user_phone']		= $this->input->post('user_phone');
				
				$data['user_email']		= $this->input->post('user_email');
				
				$data['user_BB']		= $this->input->post('user_BB');
				
				$data['user_address']	= $this->input->post('user_address');
				
				$data['user_t_stamp']	= date('Y-m-d H:i:s');
				
				$data['user_show']		= $this->input->post('user_show');
				
			}else{
			
				$data['user_show']	= 0;
			
				$action					= 'update';
			
			}
			$this->utama->master_crud_one_table($action,$data,$db,$where_coloumn,$id);
	}
	
	
	////////////////////////////// USER /////////////////////////////////////////////////////////
	public function home($action='', $id=0){
		
		if($action!='')
		{	
			if( (md5($this->input->post('user_pass2'))) == (md5($this->input->post('user_pass'))) )
			{	
				$this->save_user($action, $id);
				redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
			}
			else
			{
				redirect('form/'.$action.'/'.$id);
			}
		}
		
		require('core.php');
		
  		$core = new core();
		
		$db	= 'user';
		
		$db_join[0]	= 'user_position';
		
		$where_join[0]	= "user.user_position_id = user_position.user_position_id";
		
		$where_coloumn[0]	= "user.user_show";				$where[0] = "1";
		
		$data['array_bln'] = $core->name_month('ind');
			
		$data['user'] = $this->show_user_by_multiwhere_multitable($db, $db_join, $where_join, 1, $where_coloumn, $where, 1);
		
		$core->top(); 
			
		$this->load->view('user/list_user',$data);
		
		$core->bottom();
	
	}
	
	public function profile($action='', $id=0){
	
		$session_user = $this->session->userdata('user');
		
		if($action!='')
		{	
			if( (md5($this->input->post('user_pass2'))) == (md5($this->input->post('user_pass'))) )
			{	
				$this->save_user($action, $id);
				redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
			}
			else
			{
				redirect('form/'.$action.'/'.$id);
			}
		}
		
		require('core.php');
		
  		$core = new core();
		
		$db	= 'user';
		
		$db_join[0]	= 'user_position';
		
		$where_join[0]	= "user.user_position_id = user_position.user_position_id";
		
		$where_coloumn[0]	= "user.user_show";				$where[0] = "1";
		
		$where_coloumn[1]	= "user.user_id";				$where[1] = $session_user->user_id;
		
		$data['array_bln'] = $core->name_month('ind');
			
		$data['user'] = $this->show_user_by_multiwhere_multitable($db, $db_join, $where_join, 1, $where_coloumn, $where, 2);
		
		$core->top(); 
			
		$this->load->view('user/profile_user',$data);
		
		$core->bottom();
	
	}
	
	public function form_profile($action, $id=0, $url='profile'){
		
		$this->form($action, $id, $url);
	
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		
  		$core = new core();
		
		
		$data['array_bln'] = $core->name_month('ind');
		
		$data['action']	= $action;
		
		$data['user_position'] = $this->show_user_position();
		
		if($id!=0)
		{	$data['user'] = $this->show_user_by_id($id);	}
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('user/form_user',$data);
		
		$core->bottom();
	
	}
	
}	
?>