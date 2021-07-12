<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class organitation extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		
		$this->load->library('session');
		
		$this->load->model('utama_model','utama');
	
	}
	
	public function show_organitation($limit=0, $offset=1000) {
			
			$table				= 'dnakd_organisasi';
			
			$order_coloumn	= 'nama'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_all_one_table($table, $limit, $offset, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_organitation_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table				= 'organitation';
			
			$order_coloumn	= 'organitation_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_organitation_by_id($id) {
			
			$table				= 'organitation';
			
			$where_coloumn	= 'organitation_id'; 
			
			$data[$table] = $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			
			return $data[$table];
	
	}
	
	public function show_organitation_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table				= 'organitation';
			
			$order_coloumn	= 'organitation_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $limit, $offset, $where_coloumn, $where, $size,$order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_organitation_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'organitation_name'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_select_organitation_by_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_select_organitation_by_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, $group, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable_group($select,$table, $table_join, $where_join, $size_join, $group, $limit, $offset, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	
	public function show_select_organitation_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'prd_semester.id'; 
			
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function show_select_organitation_by_multiwhere_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $group, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable_group($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $group, $order_coloumn, $order);
			
			return $data[$table];
	
	}
	
	public function save_organitation($action,$id=0) {

			$table	= 'organitation';
			
			$where_coloumn			= 'organitation_id';
			
			if($id==0)
			{	$id = $this->input->post('organitation_id');	}
			
			if($action!='delete')
			{

				$data['organitation_id']		= $this->input->post('organitation_id');
		   
				$data['organitation_name'] 		= $this->input->post('organitation_name');
				
				$data['organitation_price']		= $this->input->post('organitation_price');
				
				$data['organitation_detail']	= $this->input->post('organitation_detail');
				
				$data['organitation_t_stamp']	= date('Y-m-d H:i:s');
				
				$data['organitation_show']		= $this->input->post('organitation_show');
				
			}else{
			
				$data['organitation_show']	= 0;
			
				$action					= 'update';
			
			}
			$this->utama->master_crud_one_table($action,$data,$table,$where_coloumn,$id);
	}
	
	
	////////////////////////////// organitation /////////////////////////////////////////////////////////
	public function home($action='', $id=0){
		
		if($action!='')
		{	
			$this->save_organitation($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		
  		$core = new core();
		
		
		$table	= 'dnakd_organisasi';
		
		$data['organitation'] = $this->show_organitation();
		
		
		$core->top(); 
			
		$this->load->view('organitation/list_organitation',$data);
		
		$core->bottom();
	
	}
	
	public function detail($action='', $id=0){
		
		if(($action!='')&&($action!='id'))
		{	
			$this->save_organitation($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		
  		$core = new core();
	
	
	/////////////////PEMBINA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dprofil_sdm.*,
			nilai_organisasi.id as organisasi_nilai_id,
			nilai_organisasi.siswa_jml,
			dnakd_organisasi.nama as nama_organisasi,
			
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			
			";
			
		$table	= 'nilai_organisasi';
		
		
		$table_join[0]		= 'dnakd_organisasi';
		
		$where_join[0]	= "dnakd_organisasi.id = nilai_organisasi.org_id";
		
		$table_join[1]		= 'dprofil_sdm';
		
		$where_join[1]	= "nilai_organisasi.pembina_id = dprofil_sdm.id";
		
		$table_join[2]		= 'dmst_jabatan';
		
		$where_join[2]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$table_join[3]		= 'prd_semester ';
		
		$where_join[3]	= "prd_semester.id = nilai_organisasi.semester_id";
		
		$jml_join	= 4;
		
		$jml_where	= 2;
		
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "dprofil_sdm.id";		$where[1] = $id;
		
		$data['pembina'] = $this->show_select_organitation_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
	
	/////////////////SISWA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		$select ="
			nilai_siswa_org.id as siswa_organisasi_nilai_id,
			nilai_siswa_org.keterangan,
			dnakd_organisasi.nama as nama_organisasi,
			
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			
			";
			
		$table	= 'nilai_siswa_org';
		
		
		$table_join[0]		= 'nilai_organisasi';
		
		$where_join[0]	= "nilai_siswa_org.org_nilai_id = nilai_organisasi.id";
		
		$table_join[1]		= 'dnakd_organisasi';
		
		$where_join[1]	= "dnakd_organisasi.id = nilai_organisasi.org_id";
		
		$table_join[2]		= 'prd_semester ';
		
		$where_join[2]	= "prd_semester.id = nilai_organisasi.semester_id";
		
		$jml_join	= 3;
		
		$jml_where	= 2;
		
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "nilai_siswa_org.siswa_nilai_id";		$where[1] = $id;
		
		$data['siswa'] = $this->show_select_organitation_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		$core->top(); 
			
		$this->load->view('organitation/detail_organitation',$data);
		
		$core->bottom();
	
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		
  		$core = new core();
		
		
		$data['array_bln'] = $core->name_month('ind');
		
		$data['action']	= $action;
		
		$data['action']	= $action;
		
		$select ="
			nilai_kelas.id as id_nilai_kelas,
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
		
		$where_coloumn[0]	= "nilai_kelas.id";		$where[0] = $id;
			
		if($id!=0)
		{	
			$data['organitation'] = $this->show_select_homeroom_by_multiwhere_multitable($select,$table, $table_join, $where_join, 4, $where_coloumn, $where, $jml_where);
		}
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('organitation/form_organitation',$data);
		
		$core->bottom();
	
	}
	
}	
?>