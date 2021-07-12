<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class teacher extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	
	}
	
	
	public function show_user_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'data_user';
			$order_coloumn	= 'nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_teacher_by_id($id) {
			
			$table			= 'teacher';
			$where_coloumn	= 'teacher_id'; 
			
			$data[$table]	= $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			return $data[$table];
	}
	
	public function show_teacher_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table				= 'teacher';
			$order_coloumn	= 'teacher_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size,$order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_teacher_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'teacher_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_teacher_by_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_teacher_by_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, $group, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable_group($select,$table, $table_join, $where_join, $size_join, $group, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	
	public function show_select_teacher_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_teacher_by_multiwhere_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $group, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable_group($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $group, $order_coloumn, $order);
			return $data[$table];
	
	}
	
	public function save_teacher($action,$id=0) {

			$table	= 'data_user';
			$where_coloumn			= 'id';
			
			$nama_guru = str_replace("'","`",$this->input->post('nama'));
			
			if($id==0)
			{	$id = $this->input->post('id');	}
			
			$data1['username']		= $this->input->post('nip');
			$data1['password']		= md5($this->input->post('nip'));
			$data1['alias']			= $nama_guru;
			$data1['nama']			= $nama_guru;
			$data1['gender']			= $this->input->post('gender');
			
			$data1['role']			= 'sdm';
			$data1['modified']		= date('Y-m-d H:i:s');
			$data1['modifier_id']	= 1;
			
			$this->utama->master_crud_one_table($action,$data1,$table,$where_coloumn,$id);
			
			$where1[0] = $nama_guru;		$where_coloumn1[0] = 'nama';
			$where1[1] = $this->input->post('nip');			$where_coloumn1[1] = 'username';
			
			$size	= 2;
			
			$user = $this->show_user_by_multiwhere($where_coloumn1, $where1, $size);
			
			foreach($user as $u)
			{	$data2['id'] = $u->id;	}
			
			$table	= 'dprofil_sdm';
			$where_coloumn			= 'id';
			
			if($id==0)
			{	$id = $this->input->post('id');	}
			
			$data2['nip']			= $this->input->post('nip');
			$data2['nuptk']			= $this->input->post('nuptk');
			$data2['nama']			= $nama_guru;
			$data2['gender']		= $this->input->post('gender');
			$data2['alamat']		= $this->input->post('alamat');
			
			$data2['aktif']			= 1;
			$data2['jabatan_id']	= 2;
			$data2['mengajar']		= 1;
			$data2['modified']		= date('Y-m-d H:i:s');
			$data2['modifier_id']	= 1;
			
			$this->utama->master_crud_one_table($action,$data2,$table,$where_coloumn,$id);
	}
	
	
	////////////////////////////// teacher /////////////////////////////////////////////////////////
	public function home($action='', $id=0){
		
		if($action!='')
		{	
			$this->save_teacher($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		
  		$core = new core();
		
		$select ="
			dprofil_sdm.*,
			dmst_jabatan.nama as nama_jabatan
			";
		
		$table	= 'dprofil_sdm';
		$table_join[0]		= 'dmst_jabatan';
		$where_join[0]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$data['teacher'] = $this->show_select_teacher_by_multitable($select,$table, $table_join, $where_join, 1);
		
		$core->top(); 
			
		$this->load->view('teacher/list_teacher',$data);
		
		$core->bottom();
	
	}
	
	public function detail($action='', $id=0){
		
		if(($action!='')&&($action!='id'))
		{	
			$this->save_teacher($action, $id);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
	
		
		$select ="
			dprofil_sdm.*,
			dmst_jabatan.nama as nama_jabatan
			";
		
		$table	= 'dprofil_sdm';
		$table_join[0]		= 'dmst_jabatan';
		$where_join[0]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$jml_join	= 1;
		$jml_where	= 1;
		
		$where_coloumn[0]	= "dprofil_sdm.id";		$where[0] = $id;
		
		$data['teacher'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		
	/////////////////WALI KELAS//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dprofil_sdm.*,
			dakd_kelas.nama as nama_kelas
			";
		
		$table	= 'dprofil_sdm';
		
		$table_join[0]		= 'nilai_kelas';
		$where_join[0]	= "nilai_kelas.kelas_wali_id = dprofil_sdm.id";
		
		$table_join[1]		= 'dakd_kelas';
		$where_join[1]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[2]		= 'prd_semester';
		$where_join[2]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$jml_join	= 3;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "dprofil_sdm.id";		$where[1] = $id;
		
		$data['kelas'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		
	/////////////////PELAJARAN//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dprofil_sdm.*,
			nilai_pelajaran.id as pelajaran_nilai_id,
			nilai_pelajaran.siswa_jml,
			dmst_jabatan.nama as nama_jabatan,
			dakd_kategori_mapel.kode as kode_kategori_mapel,
			dakd_mapel.kode as kode_mapel,
			dakd_mapel.nama as nama_mapel,
			dakd_pelajaran.nama as nama_pelajaran,
			nilai_pelajaran.kkm,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			
			";
		
		$table	= 'nilai_pelajaran';
		
		$table_join[0]		= 'dakd_pelajaran';
		$where_join[0]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[1]		= 'dakd_mapel';
		$where_join[1]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[2]		= 'dakd_kategori_mapel';
		$where_join[2]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[3]		= 'dprofil_sdm';
		$where_join[3]	= "nilai_pelajaran.guru_id = dprofil_sdm.id";
		
		$table_join[4]		= 'dmst_jabatan';
		$where_join[4]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$table_join[5]		= 'prd_semester';
		$where_join[5]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$jml_join	= 6;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "dprofil_sdm.id";		$where[1] = $id;
		
		$data['pelajaran'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
			
	
	/////////////////ORGANISASI//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
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
		$where_coloumn[1]	= "dprofil_sdm.id";				$where[1] = $id;
		
		$data['organisasi'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
	
	
	/////////////////EKSKUL/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dprofil_sdm.*,
			nilai_ekskul.id as ekskul_nilai_id,
			nilai_ekskul.siswa_jml,
			
			dnakd_ekskul.nama as nama_ekskul,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			";
			
		$table	= 'nilai_ekskul';
		
		$table_join[0]		= 'dnakd_ekskul';
		$where_join[0]	= "dnakd_ekskul.id = nilai_ekskul.ekskul_id";
		
		$table_join[1]		= 'dprofil_sdm';
		$where_join[1]	= "nilai_ekskul.pembina_id = dprofil_sdm.id";
		
		$table_join[2]		= 'dmst_jabatan';
		$where_join[2]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_ekskul.semester_id";
		
		$jml_join	= 4;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "dprofil_sdm.id";				$where[4] = $id;
		
		$data['ekskul'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		$core->top(); 
			
		$this->load->view('teacher/detail_teacher',$data);
		
		$core->bottom();
	}
	
	public function form($action, $id=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$select ="
			dprofil_sdm.*,
			dmst_jabatan.nama as nama_jabatan
			";
		
		$table	= 'dprofil_sdm';
		$table_join[0]		= 'dmst_jabatan';
		$where_join[0]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$jml_join	= 1;
		$jml_where	= 1;
		
		$where_coloumn[0]	= "dprofil_sdm.id";		$where[0] = $id;
		
		$data['teacher'] = $this->show_select_teacher_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('teacher/form_teacher',$data);
		
		$core->bottom();
	
	}
	
}	
?>