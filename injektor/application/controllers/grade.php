<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class grade extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	}
	
	public function show_kelas_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'dakd_kelas'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_teacher_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'dprofil_sdm'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_periode_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'prd_semester'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_kurikulum_by_all($limit=0, $offset=1000) {
			
			$table			= 'dmst_kurikulum'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_jurusan_by_all($limit=0, $offset=1000) {
			
			$table			= 'dakd_jurusan'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_grade_detail_by_all($limit=0, $offset=1000) {
			
			$table			= 'dmst_grade'; 
			$where_coloumn	= 'aktif';
			$where			= 1;
			
			$data[$table]	= $this->utama->get_data_by_where_one_table($table, $limit, $offset, 
				$where_coloumn, $where, $order_coloumn='', $order='asc');
			
			return $data[$table];
	}
	
	public function show_grade_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'dakd_kelas';
			$order_coloumn	= 'nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_grade_by_id($id) {
			
			$table				= 'dakd_kelas';
			$where_coloumn	= 'id'; 
			
			$data[$table] = $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			return $data[$table];
	}
	
	public function show_grade_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table				= 'grade';
			$order_coloumn	= 'grade_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $limit, $offset, $where_coloumn, $where, $size,$order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_grade_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'grade_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_grade_by_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_grade_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'grade,nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_study_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'dakd_pelajaran.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function save_grade($action,$id=0,$id1=0) {

			$table	= 'dakd_kelas';
			$where_coloumn			= 'id';
			
			if($id1==0)
			{	$id1					= $this->input->post('kelas_id');	}
			$data1['nama']			= $this->input->post('nama');
			$data1['wali_id']		= $this->input->post('kelas_wali_id');
			$data1['jurusan_id']	= $this->input->post('jurusan_id');
			$data1['grade']			= $this->input->post('grade');
			$data1['kurikulum_id']	= $this->input->post('kurikulum_id');
			$data1['gurubk_id']		= $this->input->post('kelas_gurubk_id');
			
			
			$data1['aktif']			= 1;
			$data1['lock']			= 1;
			$data1['modified']		= date('Y-m-d H:i:s');
			$data1['modifier_id']	= 1;
			
			if($data1['wali_id']==''){
				unset($data1['wali_id']);
			}
			if($data1['jurusan_id']==''){
				unset($data1['jurusan_id']);
			}
			if($data1['kurikulum_id']==''){
				unset($data1['kurikulum_id']);
			}
			if($data1['gurubk_id']==''){
				unset($data1['gurubk_id']);
			}
			
			$this->utama->master_crud_one_table($action,$data1,$table,$where_coloumn,$id1);
			
			$where_coloumn1[0] = "nama"; 			$where1[0] = $this->input->post('nama');
			$where_coloumn1[1] = "wali_id"; 		$where1[1] = $this->input->post('kelas_wali_id');
			
			$size	= 2;
			
			$kelas		= $this->show_kelas_by_multiwhere($where_coloumn1, $where1, $size);
			
			$periode	= $this->show_periode_by_where('status', 'aktif');
			
			foreach($kelas as $u)
			{	$data2['kelas_id'] = $u->id;	}
			
			foreach($periode as $p)
			{	$data2['semester_id'] = $p->id;	}
			
			$table	= 'nilai_kelas';
			$where_coloumn			= 'id';
			
			if($id==0)
			{	
				$id = $this->input->post('nilai_kelas_id');	
			}else{
				$data2['kelas_id']	= 	$this->input->post('kelas_id');
			}
			
			$data2['kelas_wali_id']		= $this->input->post('kelas_wali_id');
			$data2['kelas_gurubk_id']	= $this->input->post('kelas_gurubk_id');
			$data2['kurikulum_id']		= $this->input->post('kurikulum_id');
			
			if($data2['kelas_wali_id']==''){
				unset($data2['kelas_wali_id']);
			}
			if($data2['kelas_gurubk_id']==''){
				unset($data2['kelas_gurubk_id']);
			}
			if($data2['kurikulum_id']==''){
				unset($data2['kurikulum_id']);
			}
			$this->utama->master_crud_one_table($action,$data2,$table,$where_coloumn,$id);
			
			if($action=='delete')
			{
				$table	= 'nilai_pelajaran_kelas';
				$data	= '';
				$id 	= $this->input->post('nilai_kelas_id');
				$this->utama->master_crud_one_table($action,$data,$table,'kelas_nilai_id',$id);
			}
	}
	
	
	/////////////////// UPDATE PENGAJAR //////////////////////////////////////////
	public function update_dakd_pelajaran_kelas($kelas_id, $pelajaran_id_awal, $pelajaran_id_update){
		
		$query = 
		"
			UPDATE 
				`dakd_pelajaran_kelas`
			SET 
				pelajaran_id = ".$pelajaran_id_update."
			WHERE 
				kelas_id = ".$kelas_id."
				AND
				pelajaran_id = ".$pelajaran_id_awal."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function update_nilai_pelajaran_kelas($kelas_id, $nilai_kelas_id,  $nilai_pelajaran_id_awal, $pelajaran_id_awal, 
	$nilai_pelajaran_id_update, $pelajaran_id_update){
		
		$query = 
		"
			UPDATE 
				`nilai_pelajaran_kelas`
			SET 
				pelajaran_id		= ".$pelajaran_id_update.",
				pelajaran_nilai_id	= ".$nilai_pelajaran_id_update."
			WHERE 
				kelas_id		= ".$kelas_id."
				AND
				kelas_nilai_id		= ".$nilai_kelas_id."
				AND
				pelajaran_id	= ".$pelajaran_id_awal."
				AND
				pelajaran_nilai_id	= ".$nilai_pelajaran_id_awal."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function update_nilai_siswa_pelajaran($nilai_kelas_id, $nilai_pelajaran_id_awal, $nilai_pelajaran_id_update){
		
		$query = 
		"
			UPDATE 
				`nilai_siswa_pelajaran`
			SET 
				pelajaran_nilai_id = ".$nilai_pelajaran_id_update."
			WHERE 
				kelas_nilai_id = ".$nilai_kelas_id."
				AND
				pelajaran_nilai_id = ".$nilai_pelajaran_id_awal."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function educator_update($action,$id=0,$id1=0) {
			
		$data['pelajaran_update']	= $this->input->post('pelajaran_update');
		$data['pelajaran_update']	= explode("/",$data['pelajaran_update']);
		
		$data['pelajaran_id_update']		= $data['pelajaran_update'][1];
		$data['nilai_pelajaran_id_update']	= $data['pelajaran_update'][0];
		
		$data['pelajaran_id_awal']		= $this->input->post('pelajaran_id_awal');
		$data['nilai_pelajaran_id_awal']= $this->input->post('nilai_pelajaran_id_awal');
		
		$data['kelas_id']				= $this->input->post('kelas_id');
		$data['nilai_kelas_id']			= $this->input->post('nilai_kelas_id');
		
		//print_r($data);
		$this->update_dakd_pelajaran_kelas($data['kelas_id'], $data['pelajaran_id_awal'], $data['pelajaran_id_update']);
		$this->update_nilai_pelajaran_kelas($data['kelas_id'], $data['nilai_kelas_id'],  $data['nilai_pelajaran_id_awal'], $data['pelajaran_id_awal'], $data['nilai_pelajaran_id_update'], $data['pelajaran_id_update']);
		$this->update_nilai_siswa_pelajaran($data['nilai_kelas_id'], $data['nilai_pelajaran_id_awal'], $data['nilai_pelajaran_id_update']);
	}
	
	////////////////////////////// grade /////////////////////////////////////////////////////////
	public function home($action='', $id=0, $id1=0){
		
		if($action!='')
		{	
			$this->save_grade($action, $id, $id1);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
		
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
		
		$core->top(); 
			
		$this->load->view('grade/list_grade',$data);
		
		$core->bottom();
	
	}
	
	public function detail($action='', $id=0, $id1=0){
		
		if(($action!='')&&($action!='id'))
		{	
			if($action=='educator_update')
			{
				$this->educator_update($action, $id, $id1);
				redirect($this->uri->segment(1).'/'.$this->uri->segment(2).'/id/'.$id);
			}else{
				$this->save_grade($action, $id, $id1);
				redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
			}
		}
		
		require('core.php');
		$core = new core();
	
		
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
			
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_kelas.id";				$where[1] = $id;
		
		$data['grade'] = $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, 4, $where_coloumn, $where, $jml_where);
		
		
	/////////////////PELAJARAN//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dprofil_sdm.*,
			nilai_pelajaran.id 		as pelajaran_nilai_id,
			nilai_pelajaran.siswa_jml,
			dmst_jabatan.nama 		as nama_jabatan,
			dakd_kategori_mapel.kode as kode_kategori_mapel,
			dakd_mapel.kode 		as kode_mapel,
			dakd_mapel.nama 		as nama_mapel,
			dakd_pelajaran.id 		as pelajaran_id,
			dakd_pelajaran.nama 	as nama_pelajaran,
			nilai_pelajaran.kkm,
			prd_semester.id 		as id_semester,
			prd_semester.nama 		as nama_semester
			
			";
		
		$table	= 'nilai_pelajaran_kelas';
		
		$table_join[0]		= 'nilai_pelajaran';
		$where_join[0]	= "nilai_pelajaran.id = nilai_pelajaran_kelas.pelajaran_nilai_id";
		
		$table_join[1]		= 'dakd_pelajaran';
		$where_join[1]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[2]		= 'dakd_mapel';
		$where_join[2]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[3]		= 'dakd_kategori_mapel';
		$where_join[3]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[4]		= 'dprofil_sdm';
		$where_join[4]	= "nilai_pelajaran.guru_id = dprofil_sdm.id";
		
		$table_join[5]		= 'dmst_jabatan';
		$where_join[5]	= "dmst_jabatan.id = dprofil_sdm.jabatan_id";
		
		$table_join[6]		= 'prd_semester';
		$where_join[6]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$table_join[7]		= 'nilai_kelas';
		$where_join[7]	= "nilai_kelas.id = nilai_pelajaran_kelas.kelas_nilai_id";
		
		$table_join[8]		= 'dakd_kelas';
		$where_join[8]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$jml_join	= 9;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";						$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_pelajaran_kelas.kelas_nilai_id";		$where[1] = $id;
		
		$data['pelajaran'] = $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
	/////////////////SISWA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		$select ="
			dprofil_siswa.*,
			dakd_kelas.nama as  nama_kelas,
			
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			";
			
		$table	= 'nilai_kelas';
		
		$table_join[0]		= 'nilai_siswa';
		$where_join[0]	= "nilai_siswa.kelas_nilai_id = nilai_kelas.id";
		
		$table_join[1]		= 'dprofil_siswa';
		$where_join[1]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[2]		= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]		= 'prd_semester ';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$jml_join	= 4;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_kelas.id";				$where[1] = $id;
		
		$data['siswa'] = $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		$core->top(); 
			
		$this->load->view('grade/detail_grade',$data);
		
		$core->bottom();
	}
	
	public function form($action, $id=0, $id1=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$select ="
			nilai_kelas.id as nilai_kelas_id,
			nilai_kelas.kelas_wali_id,
			nilai_kelas.kelas_gurubk_id,
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
			
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_kelas.id";				$where[1] = $id;
		
		$data['grade']			= $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, 4, $where_coloumn, $where, $jml_where);	
		
		$data['teacher']		= $this->show_teacher_by_where('mengajar', 1);
		
		$data['kurikulum']	 	= $this->show_kurikulum_by_all();
		
		$data['jurusan']		= $this->show_jurusan_by_all();
		
		$data['grade_detail']		= $this->show_grade_detail_by_all();
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('grade/form_grade',$data);
		
		$core->bottom();
	
	}
	
	public function form_study_grade($kelas_nilai_id, $kelas_id, $pelajaran_nilai_id, $pelajaran_id, $url='detail'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= 'educator_update';
		
		$select ="
			nilai_kelas.id 		as nilai_kelas_id,
			dakd_kelas.*,
			nilai_pelajaran_kelas.pelajaran_nilai_id 	as nilai_pelajaran_id,
			dakd_pelajaran.id 	as pelajaran_id,
			dakd_pelajaran.nama as nama_pelajaran,
			dakd_mapel.nama 	as nama_mapel,
			
			prd_semester.id 	as id_semester,
			prd_semester.nama 	as nama_semester,
			dprofil_sdm.nama 	as nama_guru
			
			";
		
		$table	= 'nilai_kelas';
		
		$table_join[0]		= 'dakd_kelas';
		$where_join[0]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[1]		= 'nilai_pelajaran_kelas';
		$where_join[1]	= "nilai_pelajaran_kelas.kelas_nilai_id = nilai_kelas.id";
		
		$table_join[2]		= 'dakd_pelajaran';
		$where_join[2]	= "dakd_pelajaran.id = nilai_pelajaran_kelas.pelajaran_id";
		
		$table_join[3]		= 'dakd_mapel';
		$where_join[3]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[4]		= 'dprofil_sdm';
		$where_join[4]	= "dprofil_sdm.id = dakd_pelajaran.guru_id";
		
		$table_join[5]		= 'prd_semester';
		$where_join[5]	= "prd_semester.id = nilai_kelas.semester_id";
			
		$jml_where = 3;
		
		$where_coloumn[0]	= "prd_semester.status";									$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_kelas.id";											$where[1] = $kelas_nilai_id;
		$where_coloumn[2]	= "nilai_pelajaran_kelas.pelajaran_nilai_id";				$where[2] = $pelajaran_nilai_id;
		
		$data['grade'] = $this->show_select_grade_by_multiwhere_multitable($select,$table, $table_join, $where_join, 6, $where_coloumn, $where, $jml_where);
		
		////////////////////////// pelajaran ////////////////////////////////////
		$select ="
			nilai_pelajaran.id as nilai_pelajaran_id,
			dakd_pelajaran.*,
			dprofil_sdm.nama as nama_guru,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			
			";
		
		$table	= 'dakd_pelajaran';
		
		$table_join[0]		= 'nilai_pelajaran';
		$where_join[0]	= "nilai_pelajaran.pelajaran_id = dakd_pelajaran.id";
		
		$table_join[1]		= 'dprofil_sdm';
		$where_join[1]	= "dprofil_sdm.id = dakd_pelajaran.guru_id";
		
		$table_join[2]		= 'prd_semester';
		$where_join[2]	= "prd_semester.id = nilai_pelajaran.semester_id";
			
		$jml_where = 1;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$data['study']			= $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, 3, $where_coloumn, $where, $jml_where);	
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('grade/form_study_grade',$data);
		
		$core->bottom();
	
	}
	
}	
?>