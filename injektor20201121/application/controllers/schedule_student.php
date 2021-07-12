<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class schedule_student extends CI_Controller {

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
	
	public function show_select_grade_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'grade,nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_kelas_aktif() {
		
		$select ="
			nilai_kelas.id as nilai_kelas_id,
			dakd_kelas.*,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			dprofil_sdm.nama as nama_wali,
			dmst_kurikulum.nama as nama_kurikulum
			
			";
		
		$table	= 'nilai_kelas';
		
		$table_join[0]		= 'dakd_kelas';
		$where_join[0]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[1]		= 'dmst_kurikulum';
		$where_join[1]	= "dmst_kurikulum.id = nilai_kelas.kurikulum_id";
		
		$table_join[2]		= 'dprofil_sdm';
		$where_join[2]	= "dprofil_sdm.id = nilai_kelas.kelas_wali_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
			
		$jml_where = 1;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
			
		$data['grade'] = $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, 4, $where_coloumn, $where, $jml_where);
		
		return $data['grade'];
	}
	
	public function show_get($id=''){
		
		$where_id = '';
		if($id!='')
		{
			$where_id = ' AND js.id = '.$id.'';
		}
		
		$query = 
		"
			SELECT  
				js.* ,
				dk.nama as nama_kelas,
				pd.nama as nama_semester
			FROM  
				jadwal_kelas js
			LEFT JOIN
				dakd_kelas dk
				ON
				dk.id = js.kelas_id
			LEFT JOIN
				prd_semester pd
				ON
				pd.id = js.semester_id
			WHERE 
				pd.status = 'aktif'
				AND
				js.aktif = 1
				AND
				dk.aktif = 1
				".$where_id."
				
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
	}
	
	function do_upload($file)
	{
		//$upload_path = '/var/www/'.$_SERVER['HTTP_HOST'].'/absensi/content/'.APP_SCOPE.'/jadwal/';
		$upload_path = APP_ROOT_ABSENSI.'/content/'.APP_SCOPE.'/jadwal/';
		
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
	
	////////////////////////////// schedule_student /////////////////////////////////////////////////////////
	public function save_schedule_student($action,$id=0) {
		
		$table	= 'jadwal_kelas';
		
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
				$data['kelas_id'] 		= $this->input->post('kelas_id');
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
			$this->save_schedule_student($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
		
		$data['schedule_student'] = $this->show_get();
		
		$core->top(); 
			
		$this->load->view('schedule_student/list_schedule_student',$data);
		
		$core->bottom();
	
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$data['kelas']		= $this->show_kelas_aktif();	
		
		$data['schedule_student'] = $this->show_get($id);
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('schedule_student/form_schedule_student',$data);
		
		$core->bottom();
	
	}
}