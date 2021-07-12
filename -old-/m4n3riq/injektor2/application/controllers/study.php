<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class study extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	
	}
	
	public function insert_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id, $agama_id="", $status_insert_agama='1'){
		
		$cetak = "";
		if(($agama_id!="")&&($agama_id!="NULL"))
		{
			if($status_insert_agama==1)
				$cetak = " AND ds.agama_id = ".$agama_id;
			elseif($status_insert_agama==0)
				$cetak = " AND ds.agama_id != ".$agama_id;
			//$this->delete_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id, $agama_id);
		}
		
		$query = 
		"
			INSERT INTO `nilai_siswa_pelajaran` 
			(`siswa_nilai_id` ,  `pelajaran_nilai_id` ,  `pelajaran_kelas_nilai_id` ,  `kelas_nilai_id` )
			
			SELECT  
				ns.id ,  ".$pelajaran_nilai_id." ,  npk.id , ".$kelas_nilai_id."
			FROM  
				nilai_siswa ns
			JOIN
				nilai_pelajaran_kelas npk
				ON
				npk.kelas_nilai_id = ns.kelas_nilai_id
			LEFT JOIN
				dprofil_siswa ds
				ON
				ds.id = ns.siswa_id
			WHERE 
				ns.kelas_nilai_id = ".$kelas_nilai_id."
				AND
				npk.pelajaran_nilai_id = ".$pelajaran_nilai_id."
				".$cetak."
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function delete_pelajaran_kelas_by_query($pelajaran_id, $kelas_id){
		
		$query = 
		"
			DELETE 
			FROM `dakd_pelajaran_kelas` 
			WHERE 
				kelas_id = ".$kelas_id."
				AND
				pelajaran_id = ".$pelajaran_id."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function delete_nilai_pelajaran_kelas_by_query($pelajaran_nilai_id, $kelas_nilai_id){
		
		$query = 
		"
			DELETE 
			FROM `nilai_pelajaran_kelas` 
			WHERE 
				kelas_nilai_id = ".$kelas_nilai_id."
				AND
				pelajaran_nilai_id = ".$pelajaran_nilai_id."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function delete_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id, $agama_id="",$status_delete_agama='1'){
		
		$cetak_join = "";
		$cetak = "";
		
		if($agama_id!="")
		{
			$cetak_join =
				"LEFT JOIN
					nilai_siswa ns
					ON
					nsp.siswa_nilai_id =  ns.id
				LEFT JOIN
					dprofil_siswa ds
					ON
					ds.id = ns.siswa_id";
			if($status_delete_agama==1)
				$cetak = " AND ds.agama_id = ".$agama_id;
			elseif($status_delete_agama==0)
				$cetak = " AND ds.agama_id != ".$agama_id;
		}
		
		$query = 
		"
			DELETE nsp 
			FROM `nilai_siswa_pelajaran` nsp 
			".$cetak_join."
			WHERE 
				nsp.kelas_nilai_id = ".$kelas_nilai_id."
				AND
				nsp.pelajaran_nilai_id = ".$pelajaran_nilai_id."
				".$cetak."
		";
		
		$result	= $this->utama->master_query($query);
		
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
	
	public function show_select_kelas_pelajaran_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'grade,nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_kelas_pelajaran_aktif($nilai_pelajaran_id) {
		
		$select ="
			nilai_pelajaran_kelas.kelas_nilai_id as nilai_kelas_id,
			nilai_pelajaran_kelas.kelas_id as kelas_id,
			dakd_kelas.*,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			
			";
		
		$table	= 'nilai_pelajaran_kelas';
		
		$table_join[0]		= 'dakd_kelas';
		$where_join[0]	= "dakd_kelas.id = nilai_pelajaran_kelas.kelas_id";
		
		$table_join[1]		= 'prd_semester';
		$where_join[1]	= "prd_semester.id = nilai_pelajaran_kelas.semester_id";
			
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "nilai_pelajaran_kelas.pelajaran_nilai_id";		$where[1] = $nilai_pelajaran_id;
			
		$data['grade'] = $this->show_select_kelas_pelajaran_by_multiwhere_multitable($select,$table, $table_join, $where_join, 2, $where_coloumn, $where, $jml_where);
		
		return $data['grade'];
	}
	
	public function show_pelajaran_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'dakd_pelajaran'; 
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
	
	public function show_kategori_by_all($limit=0, $offset=1000) {
			
			$table			= 'dakd_kategori_mapel'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_mapel_by_all($limit=0, $offset=1000) {
			
			$table			= 'dakd_mapel'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_kurikulum_by_all($limit=0, $offset=1000) {
			
			$table			= 'dmst_kurikulum'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_agama_by_all($limit=0, $offset=1000) {
			
			$table			= 'dmst_agama'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
			return $data[$table];
	}
	
	public function show_study_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'study';
			$order_coloumn	= 'study_name'; 
			$order			= 'asc';
			
			$data[$table]	= $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_study_by_id($id) {
			
			$table			= 'study';
			$where_coloumn	= 'study_id'; 
			
			$data[$table]	= $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			return $data[$table];
	}
	
	public function show_nilai_pelajaran_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'nilai_pelajaran';
			$order_coloumn	= 'id'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_study_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'study';
			$order_coloumn	= 'study_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $limit, $offset, $where_coloumn, $where, $size,$order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_study_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'study_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_study_by_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_study_by_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, $group, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'dprofil_sdm.nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable_group($select,$table, $table_join, $where_join, $size_join, $group, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	
	public function show_select_study_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000,$order_coloumn='',$order='') {
			if($order_coloumn == '')
				$order_coloumn	= 'nilai_pelajaran.id'; 
			if($order == '')
				$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_study_by_multiwhere_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $group, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable_group($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $group, $order_coloumn, $order);
			return $data[$table];
	
	}
	
	public function save_study($action,$id=0,$id1=0) {

			$table				= 'dakd_pelajaran';
			$where_coloumn		= 'id';
			$agama_update 		= 0;
			//echo"DDD";
			if($id1==0)
			{	$id1				= $this->input->post('pelajaran_id');	}
			
			$data1['kode']			= $this->input->post('kode');
			$data1['nama']			= $this->input->post('nama');
			$data1['kkm']			= $this->input->post('kkm');
			$data1['mapel_id']		= $this->input->post('mapel_id');
			$data1['guru_id']		= $this->input->post('guru_id');
			$data1['kategori_id']	= $this->input->post('kategori_id');
			$data1['kurikulum_id']	= $this->input->post('kurikulum_id');
			$data1['teori']			= $this->input->post('teori');
			$data1['praktek']		= $this->input->post('praktek');
			//$data1['agama_id']		= $this->input->post('agama_id');
			if($this->input->post('agama_id')=='' OR $this->input->post('agama_id')==0){
				$data1['agama_id']			= 'NULL';
			}else{
				$data1['agama_id']			= $this->input->post('agama_id');
			}
			
			$data1['aktif']			= 1;
			$data1['lock']			= 1;
			$data1['modified']		= date('Y-m-d H:i:s');
			$data1['modifier_id']	= 1;
			
			if($action=='update')
			{ 
				$where_coloumn_agama[0] = "id"; 			$where_agama[0] = $id1;
				$before_pelajaran		= $this->show_pelajaran_by_multiwhere($where_coloumn_agama, $where_agama, 1);	
				foreach($before_pelajaran as $bp)
				{	
					$before_agama_id = $bp->agama_id;
					if($before_agama_id != $data1['agama_id'])
					{	$agama_update = 1;	}
				}
			}
			//echo"EEE";
			//print_r($data1);
			if($action=='delete'){
				$data1_non_aktif['aktif']=0;
				$this->utama->master_crud_one_table('update',$data1_non_aktif,$table,$where_coloumn,$id1);
			}else{
				$this->utama->master_crud_one_table($action,$data1,$table,$where_coloumn,$id1);
			}
			
			$where_coloumn1[0] = "kode"; 			$where1[0] = $this->input->post('kode');
			$where_coloumn1[1] = "nama"; 			$where1[1] = $this->input->post('nama');
			$where_coloumn1[2] = "guru_id"; 		$where1[2] = $this->input->post('guru_id');
			
			$size	= 3;
			
			$pelajaran		= $this->show_pelajaran_by_multiwhere($where_coloumn1, $where1, $size);
			
			$periode	= $this->show_periode_by_where('status', 'aktif');
			
			foreach($pelajaran as $u)
			{	$data2['pelajaran_id'] = $u->id;	}
			
			foreach($periode as $p)
			{	$data2['semester_id'] = $p->id;	}
			
			$table	= 'nilai_pelajaran';
			$where_coloumn			= 'id';
			
			if($id==0)
			{	
				$id = $this->input->post('nilai_pelajaran_id');	
			}
			
			if($action=='update'){
				$data2['pelajaran_id']	= 	$this->input->post('pelajaran_id');
			}
			
			if(($data2['pelajaran_id']!='')&&($data2['pelajaran_id']!=NULL))
			{
				$data2['kurikulum_id']		= $this->input->post('kurikulum_id');
				$data2['guru_id']			= $this->input->post('guru_id');
				/*if(($this->input->post('agama_id')!='')&&($this->input->post('agama_id')!='') )
				{
					$data2['agama_id']			= $this->input->post('agama_id');
				}*/
				if($this->input->post('agama_id')==''||$this->input->post('agama_id')==0){
					$data2['agama_id']			= 'NULL';
				}else{
					$data2['agama_id']			= $this->input->post('agama_id');
				}
				$data2['kkm']				= $this->input->post('kkm');
				$data2['teori']				= $this->input->post('teori');
				$data2['praktek']			= $this->input->post('praktek');
				
				$this->utama->master_crud_one_table($action,$data2,$table,$where_coloumn,$id);
				
				$where_coloumn2[0] = "pelajaran_id"; 			$where2[0] = $data2['pelajaran_id'];
				$where_coloumn2[1] = "semester_id"; 			$where2[1] = $data2['semester_id'];
				
				$size	= 2;
				
				$pelajaran_nilai	= $this->show_nilai_pelajaran_by_multiwhere($where_coloumn2, $where2, $size);
				
				foreach($pelajaran_nilai as $u)
				{	$pelajaran_nilai_id = $u->id;	}
				
				
				$kelas_pelajaran		= $this->show_kelas_pelajaran_aktif($id);
				
				$jumlah_kelas = $this->input->post('jumlah_kelas');
				
				$agama_id = $data2['agama_id'];
				
				
				$no=0;
				//echo"AAA";
				for($x=1;$x<=$jumlah_kelas;$x++)
				{
					if($this->input->post('kelas_nilai'.$x))
					{
						$no++;
						$kelas_nilai_id[$no]	= $this->input->post('kelas_nilai'.$x);
						$kelas_id[$no]			= $this->input->post('kelas'.$x);
						
						//echo $kelas_nilai_id[$no]." ";
						
						$act = 'insert';
						foreach($kelas_pelajaran as $kp)
						{
							//echo $this->input->post('kelas_nilai'.$x);
				
							if($kp->nilai_kelas_id == $kelas_nilai_id[$no])
							{	$act = '';	}
						}
						
						if($act=='insert')
						{
							$table	= 'nilai_pelajaran_kelas';
							
							$data3['pelajaran_id']			= $data2['pelajaran_id'];
							$data3['pelajaran_nilai_id']	= $pelajaran_nilai_id;
							$data3['kelas_id']				= $kelas_id[$no];
							$data3['kelas_nilai_id']		= $kelas_nilai_id[$no];
							$data3['semester_id']			= $data2['semester_id'];
							
							$data4['kelas_id'] 		= $data3['kelas_id'];
							$data4['pelajaran_id']  = $data2['pelajaran_id'];
							
							$this->utama->master_crud_one_table('insert',$data4,'dakd_pelajaran_kelas',$where_coloumn,$id);
							
							$this->utama->master_crud_one_table('insert',$data3,$table);	
							
							$this->insert_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id[$no], $agama_id);	
							
						}elseif($agama_update==1){
							if($before_agama_id>0)
								$this->insert_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id[$no], $before_agama_id,'0');	
						  	if($this->input->post('agama_id')>0)
								$this->delete_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kelas_nilai_id[$no], $agama_id,'0');
						}
						
					}	
				}
				//echo"BBB";
				if($action=='update')
				{
					foreach($kelas_pelajaran as $kp)
					{
						$act = 'delete';
						for($x=1;$x<=$no;$x++)
						{
							if($kp->nilai_kelas_id == $kelas_nilai_id[$x])
							{	$act = '';	}
						}
						
						if($act=='delete')
						{
							
							$this->delete_nilai_pelajaran_kelas_by_query($pelajaran_nilai_id, $kp->nilai_kelas_id);
							
							$this->delete_pelajaran_kelas_by_query($data2['pelajaran_id'], $kp->kelas_id);
							
							$this->delete_nilai_siswa_pelajaran_by_query($pelajaran_nilai_id, $kp->nilai_kelas_id);
						}
					}
				}
				
				//echo"CCC";
				if($action=='delete')
				{
					$data	= '';
					$id_delete 	= $this->input->post('nilai_pelajaran_id');
					
					if($id_delete=='')
					{ $id_delete=$id; }
					
					$table	= 'dakd_pelajaran_kelas';
					$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_id',$id1);
					
					$table	= 'nilai_pelajaran';
					$this->utama->master_crud_one_table($action,$data,$table,'id',$id_delete);
					
					$table	= 'nilai_pelajaran_kelas';
					$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_nilai_id',$id_delete);
					
					$table	= 'nilai_siswa_pelajaran';
					$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_nilai_id',$id_delete);
					
					
				}
			}
			
			if($action=='delete')
			{
				$data	= '';
				$id_delete 	= $this->input->post('nilai_pelajaran_id');
				
				if($id_delete=='')
				{ $id_delete=$id; }
				
				$table	= 'dakd_pelajaran_kelas';
				$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_id',$id1);
				
				$table	= 'nilai_pelajaran';
				$this->utama->master_crud_one_table($action,$data,$table,'id',$id_delete);
				
				$table	= 'nilai_pelajaran_kelas';
				$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_nilai_id',$id_delete);
				
				$table	= 'nilai_siswa_pelajaran';
				$this->utama->master_crud_one_table($action,$data,$table,'pelajaran_nilai_id',$id_delete);
				
				
			}			
	}
	
	
	////////////////////////////// study /////////////////////////////////////////////////////////
	public function home($action='', $id=0, $id1=0){
		
		if($action!='')
		{	
			if(($this->input->post('nama')!='' 
			&& $this->input->post('kode')!=''
			&& $this->input->post('kkm')!='' 
			&& $this->input->post('mapel_id')!='' 
			&& $this->input->post('mapel_id')!=0
			&& $this->input->post('guru_id')!='' 
			&& $this->input->post('guru_id')!=0
			&& $this->input->post('kategori_id')!='' 
			&& $this->input->post('kategori_id')!=0
			&& $this->input->post('kurikulum_id')!='' 
			&& $this->input->post('kurikulum_id')!=0 )
			|| $action=='delete')
			{
				$this->save_study($action, $id, $id1);
				redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
			}else{
				redirect($this->uri->segment(1)."/form/insert?info=alert");
			}
		}
		
		require('core.php');
		
  		$core = new core();
		
		$select ="
			dakd_pelajaran.*,
			nilai_pelajaran.id as nilai_pelajaran_id,
			dprofil_sdm.nama as nama_guru,
			prd_semester.nama as nama_semester,
			dmst_kurikulum.nama as nama_kurikulum,
			dmst_agama.nama as nama_agama
			";
		
		$table	= 'nilai_pelajaran';
		
		$table_join[0]	= 'dakd_pelajaran';
		$where_join[0]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[1]	= 'dprofil_sdm';
		$where_join[1]	= "dprofil_sdm.id = nilai_pelajaran.guru_id";
		
		$table_join[2]	= 'dakd_mapel';
		$where_join[2]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[3]	= 'dakd_kategori_mapel';
		$where_join[3]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[4]	= 'prd_semester';
		$where_join[4]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$table_join[5]	= 'dmst_kurikulum';
		$where_join[5]	= "dmst_kurikulum.id = nilai_pelajaran.kurikulum_id";
		
		$table_join[6]	= 'dmst_agama';
		$where_join[6]	= "dmst_agama.id = nilai_pelajaran.agama_id";
		
		$jml_join	= 7;
		$jml_where	= 1;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		//$data['study'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		$data['study'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where, 0, 1000, 'dakd_pelajaran.nama', 'asc');
	
		$core->top(); 
			
		$this->load->view('study/list_study',$data);
		
		$core->bottom();
	
	}
	
	public function detail($action='', $id=0, $id1=0){
		
		if(($action!='')&&($action!='id'))
		{	
			$this->save_study($action, $id=0, $id1=0);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		$core = new core();
	
	
	/////////////////PELAJARAN//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dakd_pelajaran.*,
			nilai_pelajaran.id as nilai_pelajaran_id,
			dakd_mapel.nama as nama_mapel,
			dprofil_sdm.nama as nama_guru,
			prd_semester.nama as nama_semester,
			dmst_kurikulum.nama as nama_kurikulum,
			dmst_agama.nama as  nama_agama
			";
		
		$table	= 'nilai_pelajaran';
		
		$table_join[0]	= 'dakd_pelajaran';
		$where_join[0]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[1]	= 'dmst_agama';
		$where_join[1]	= "dmst_agama.id = nilai_pelajaran.agama_id";
		
		$table_join[2]	= 'dprofil_sdm';
		$where_join[2]	= "dprofil_sdm.id = nilai_pelajaran.guru_id";
		
		$table_join[3]	= 'dakd_mapel';
		$where_join[3]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[4]	= 'dakd_kategori_mapel';
		$where_join[4]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[5]	= 'prd_semester';
		$where_join[5]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$table_join[6]	= 'dmst_kurikulum';
		$where_join[6]	= "dmst_kurikulum.id = nilai_pelajaran.kurikulum_id";
		
		$jml_join	= 7;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_pelajaran.id";				$where[1] = $id;
		
		$data['study'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
	
	
	/////////////////KELAS///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			dakd_kelas.*,
			nilai_pelajaran.id as nilai_pelajaran_id,
			prd_semester.nama as nama_semester
			";
		
		$table	= 'nilai_pelajaran';
		
		$table_join[0]	= 'nilai_pelajaran_kelas';
		$where_join[0]	= "nilai_pelajaran_kelas.pelajaran_nilai_id = nilai_pelajaran.id";
		
		$table_join[1]	= 'nilai_kelas';
		$where_join[1]	= "nilai_kelas.id = nilai_pelajaran_kelas.kelas_nilai_id";
		
		$table_join[2]	= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]	= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$jml_join	= 4;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_pelajaran.id";				$where[1] = $id;
		
		$data['kelas'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
	
	/////////////////SISWA//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		$select ="
			dprofil_siswa.*,
			dakd_kelas.nama as  nama_kelas,
			
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			";
			
		$table	= 'nilai_siswa_pelajaran';
		
		$table_join[0]		= 'nilai_pelajaran';
		$where_join[0]	= "nilai_pelajaran.id = nilai_siswa_pelajaran.pelajaran_nilai_id";
		
		$table_join[1]		= 'dakd_pelajaran';
		$where_join[1]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[2]		= 'nilai_siswa';
		$where_join[2]	= "nilai_siswa.id = nilai_siswa_pelajaran.siswa_nilai_id";
		
		$table_join[3]		= 'dprofil_siswa';
		$where_join[3]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[4]		= 'nilai_kelas';
		$where_join[4]	= "nilai_kelas.id = nilai_siswa_pelajaran.kelas_nilai_id";
		
		$table_join[5]		= 'dakd_kelas';
		$where_join[5]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[6]		= 'prd_semester ';
		$where_join[6]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$jml_join	= 7;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_pelajaran.id";				$where[1] = $id;
		
		$data['siswa'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
		$core->top(); 
			
		$this->load->view('study/detail_study',$data);
		
		$core->bottom();
	}
	
	public function form($action, $id=0, $id1=0, $url='home'){
			
		require('core.php');
		$core = new core();
		
		$data['action']	= $action;
		
		$select ="
			dakd_pelajaran.*,
			nilai_pelajaran.id as nilai_pelajaran_id,
			nilai_pelajaran.kkm as nilai_pelajaran_kkm,
			dprofil_sdm.nama as nama_guru,
			prd_semester.nama as nama_semester
			";
		
		$table	= 'nilai_pelajaran';
		
		$table_join[0]	= 'dakd_pelajaran';
		$where_join[0]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[1]	= 'dprofil_sdm';
		$where_join[1]	= "dprofil_sdm.id = nilai_pelajaran.guru_id";
		
		$table_join[2]	= 'dakd_mapel';
		$where_join[2]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[3]	= 'dakd_kategori_mapel';
		$where_join[3]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[4]	= 'prd_semester';
		$where_join[4]	= "prd_semester.id = nilai_pelajaran.semester_id";
		
		$jml_join	= 5;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_pelajaran.id";				$where[1] = $id;
		
		$data['study'] = $this->show_select_study_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
			
		$data['kelas']		= $this->show_kelas_aktif();	
		
		if($action=='update')
		{
			$data['kelas_pelajaran']		= $this->show_kelas_pelajaran_aktif($id);	
		}
		
		$data['teacher']		= $this->show_teacher_by_where('mengajar', 1);
		
		$data['mapel']	 	= $this->show_mapel_by_all();
		
		$data['kategori']	 	= $this->show_kategori_by_all();
		
		$data['kurikulum']	 	= $this->show_kurikulum_by_all();
		
		$data['agama']		 	= $this->show_agama_by_all();
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('study/form_study',$data);
		
		$core->bottom();
	
	}
	
}	
?>