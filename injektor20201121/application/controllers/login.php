<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->model('utama_model','utama');
	
	}
	
	public function show_user_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table				= 'user_injek';
			
			$order_coloumn	= 'user_name';
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_user_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table				= 'user_injek';
			
			$order_coloumn	= 'user_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			
			return $data[$table];
	
	}
	
	public function show_login_by_id($id) {
			
			$table				= 'login';
			
			$where_coloumn	= 'login_id'; 
			
			$data[$table] = $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			
			return $data[$table];
	
	}
	
	public function show_login_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'login_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function save_sid($id,$session_id) {

			$table	= 'user_injek';
			
			$where_coloumn			= 'user_id';
			
			$data['user_sid'] 		= $session_id;
			
			$action					= 'update';
			
			$this->utama->master_crud_one_table($action,$data,$table,$where_coloumn,$id);
			
	}
	
	///////////////////////////LOGIN////////////////////////////////
	public function index(){
		
		$data['false']	= 0;
		$hasil			= 0;
		
		if( $this->input->post('submit') )
		{	
			$hasil = $this->verification();
		}
		//echo $hasil;
		if($hasil==2)
		{	redirect('core');	}
		else
		{	$data['false'] = $hasil;	}
		
		$this->load->view('login',$data);
		
	}
	
	public function verification(){
	
		$user		= $this->input->post('user');
		$pass		= md5($this->input->post('pass'));
		
		$where_coloumn[0] ='user_name';			$where[0] = $user;
		$where_coloumn[1] ='user_pass';			$where[1] = $pass;
		$with_name		= $this->show_user_by_multiwhere($where_coloumn, $where, 2);
		
		$where_coloumn[0] ='user_email';		$where[0] = $user;
		$where_coloumn[1] ='user_pass';			$where[1] = $pass;
		$with_email		= $this->show_user_by_multiwhere($where_coloumn, $where, 2);
		
		$no = 0;
		
		foreach($with_name as $wn)
		{	
			$user	= $wn;
			$id		= $wn->user_id;
			$no++;	
		}
		
		foreach($with_email as $we)
		{	
			$user	= $we;
			$id		= $we->user_id;
			$no++;
		}
		
		if($no==0)
		{	return 1;	}
		else
		{
			$session_id = $this->session->userdata('session_id');
			
			//$this->session->set_userdata('sid',$session_id);
			
			//$this->session->set_userdata('user',$user);
			
			$_SESSION['user'] = $user;
			$_SESSION['sid'] = $session_id;
			
			$this->save_sid($id,$session_id);
			
			return 2;
		}
	}
	
	
	function logout()
	{
		//$this->session->sess_destroy();
		
		// remove all session variables
		session_unset(); 
	
		// destroy the session 
		session_destroy(); 
		$this->index();
	}
}