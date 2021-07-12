<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class core extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->model('utama_model','utama');
	
	}
	
	/* 
	FUNCTION table UTAMA
	>>	get_data_all_one_table 			= mengambil semua data dalam satu table
		get_data_all_one_table($db, $limit, $offset, $order_coloumn='', $order='asc')
		
	>>	get_detail_all_one_table		= mengambil detail data dari id dalam satu table
		get_detail_all_one_table($db, $limit, $offset)
		
	>>	master_save_one_table			= mengelola data (CRUD) dalam satu table
		master_save_one_table($action, $data, $db, $where_coloumn=0, $id=0)
	
	*/
	
	public function show_menu($limit=0, $offset=1000) {
			
			$db				= 'menu_injek';
			
			$where_coloumn	= 'menu_show';		$where	= '1';
			
			$order_coloumn	= 'menu_order'; 
			
			$order			= 'asc';
			
			$data[$db] = $this->utama->get_data_by_where_one_table($db, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			
			return $data[$db];

	}
	
	public function show_user_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$db				= 'user_injek';
			
			$order_coloumn	= 'user_name'; 
			
			$order			= 'asc';
			
			$data[$db] = $this->utama->get_data_by_where_one_table($db, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			
			return $data[$db];
	
	}
	
	public function check_sid() {
			//$sid 	= $this->session->userdata('sid');
			$sid 	= '';
			if(isset($_SESSION['sid'])){
				$sid 	= $_SESSION['sid'];
			}
			$user	= $this->show_user_by_where('user_sid',$sid,1);
			$id = 0;
			
			foreach($user as $u)
			{
				$id		  =$u->id;
				$position =$u->position;	
			}
				
			if($id==0)
			{	return $sid.$id;	}
			else 
			{	return true;	}		  
		
	}
	
	//////////////////////////////////////////////////////////////////////// view /////////////////////////////////////////////////////////////////////////////////////////////
	public function top(){
		$hasil = $this->check_sid();
		//echo "aaaaaaaaaaa".$hasil;
		
		if(	!$hasil)
		{	redirect('login');	}
		
		$this->load->view('header'); 
		
		$data['menu'] = $this->show_menu();

		$this->load->view('menu',$data);
		
		//$this->load->view('user');
	
	}
	
	public function bottom(){
	
		$this->load->view('footer');
	
	}
	
	public function name_month($language){
		
		if($language=='short_ind'){
			$name[1]	= 'Jan';
			$name[2]	= 'Feb';
			$name[3]	= 'Mar';
			$name[4]	= 'Apl';
			$name[5]	= 'Mei';
			$name[6]	= 'Jun';
			$name[7]	= 'Jul';
			$name[8]	= 'Agst';
			$name[9]	= 'Sep';
			$name[10]	= 'Okt';
			$name[11]	= 'Nov';
			$name[12]	= 'Des';
		}else if($language=='ind'){
			$name[1]	= 'Januari';
			$name[2]	= 'Februari';
			$name[3]	= 'Maret';
			$name[4]	= 'April';
			$name[5]	= 'Mei';
			$name[6]	= 'Juni';
			$name[7]	= 'Juli';
			$name[8]	= 'Agustus';
			$name[9]	= 'September';
			$name[10]	= 'Oktober';
			$name[11]	= 'November';
			$name[12]	= 'Desember';
		}else{
			$name[1]	= 'January';
			$name[2]	= 'February';
			$name[3]	= 'March';
			$name[4]	= 'April';
			$name[5]	= 'May';
			$name[6]	= 'June';
			$name[7]	= 'July';
			$name[8]	= 'August';
			$name[9]	= 'September';
			$name[10]	= 'October';
			$name[11]	= 'November';
			$name[12]	= 'December';
		}
		
		return $name;
		
	}
	
	
	
	///////////////////////////////////////////////////home/////////////////////////////////////////////////////////
	public function show_user($limit=0, $offset=1000) {
		
			$table				= 'user_injek';
			
			$order_coloumn	= 'user_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_all_one_table($table, $limit, $offset, $order_coloumn, $order);
		
			return $data[$table];
	}
	
	public function show_office_administration($limit=0, $offset=1000) {
		
			$table				= 'office_administration';
			
			$order_coloumn	= 'office_administration_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_all_one_table($table, $limit, $offset, $order_coloumn, $order);
		
			return $data[$table];
	}
	
	public function index(){
		
		
		//$data['office_administration']	= $this->show_office_administration();
		
		$data['user'] 				= $this->show_user();
		
		//$data['project']			= $this->show_project();
		
		$this->top(); 
		
		$this->load->view('home');
		
		$this->bottom();
	
	}
	
	
}
?>