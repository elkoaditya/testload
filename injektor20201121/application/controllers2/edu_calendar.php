<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class edu_calendar extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	
	}
	
	public function show_periode_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'prd_semester'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_get($id=''){
		
		$where_id = '';
		if($id!='')
		{
			$where_id = ' AND dk.id = '.$id.'';
		}
	
		$query = 
		"
			SELECT  
				dk.* ,
				pd.nama as nama_semester
			FROM  
				dmst_kaldik dk
			
			LEFT JOIN
				prd_semester pd
				ON
				pd.id = dk.semester_id
			WHERE 
				pd.status = 'aktif'
				AND
				dk.aktif = 1
				".$where_id."
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
		
	}
	
	function do_upload($file)
	{
		//$upload_path = '/var/www/'.$_SERVER['HTTP_HOST'].'/absensi/content/kaldik/';
		$upload_path = APP_ROOT_ABSENSI.'/content/'.APP_SCOPE.'/kaldik/';
		
		$config['upload_path'] = $upload_path;
		//echo $config['upload_path'].'aa';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload($file))
		{
			$error = array('error' => $this->upload->display_errors());
			return $error ;
			//print_r($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			return $data;
			//$this->load->view('upload_success', $data);
		}
	}
	
	////////////////////////////// edu_calendar /////////////////////////////////////////////////////////
	public function save_edu_calendar($action,$id=0) {
		
		$table = 'dmst_kaldik';
		
		if($action=='delete')
		{
			$data	= '';
			$data['aktif']			= 0;
			
			$this->utama->master_crud_one_table('update',$data,$table,'id',$id);
		
		}else{
			
			if($id==0)
			{	$id = $this->input->post('id');	}
			
			$file = $this->do_upload('file');
			//print_r($file);
			$periode	= $this->show_periode_by_where('status', 'aktif');
			
			if(isset($file['upload_data']['file_name'])){
				
				foreach($periode as $p)
				{	$data['semester_id'] = $p->id;	}
				
				$data['file']			= $file['upload_data']['file_name'];
				
				$data['modified']		= date('Y-m-d H:i:s');
				$data['modifier_id']	= 1;
				
				$where_coloumn = 'id';
				
				$this->utama->master_crud_one_table($action,$data,$table,$where_coloumn,$id);
			}
			
		}
	}
		
	
	public function home($action='', $id=0){
		
		if($action!='')
		{	
			$this->save_edu_calendar($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
		
		$data['edu_calendar'] = $this->show_get();
		
		$core->top(); 
		
		$this->load->view('edu_calendar/list_edu_calendar',$data);
		
		$core->bottom();
	
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$data['edu_calendar'] = $this->show_get($id);
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('edu_calendar/form_edu_calendar',$data);
		
		$core->bottom();
	
	}
}