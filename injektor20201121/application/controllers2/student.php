<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class student extends CI_Controller {

	function __construct(){
		
		parent::__construct();
		$this->load->library('session');
		$this->load->model('utama_model','utama');
	
	}
	
	function crypto($string, $key = 'fresto6')
	{
	
		return md5($string . $key) . md5($string);
	
	}

	public function insert_one_kbm_materi_siswa_by_query($user_id, $kelas_id)
	{
		$query = 
		"
			SELECT
				materi.id,
				materi.nama,
				materi.siswa_total
			FROM 
				dakd_pelajaran pelajaran
			JOIN
				dakd_pelajaran_kelas pelkelas	ON pelkelas.pelajaran_id	= pelajaran.id
			JOIN
				kbm_materi materi 				ON materi.pelajaran_id		= pelajaran.id
			JOIN
				prd_semester semester			ON materi.semester_id		= semester.id
			
			WHERE
				semester.status = 'aktif'
				AND
				pelkelas.kelas_id = ".$kelas_id."
		";
		
		$result = $this->utama->master_query_result($query);
		
		$loop1=0;
		$loop2=0;
		//echo $user_id." n ". $kelas_id;
		$jumlah=0;
		if($result)
		{
			foreach($result as $u){
					
				if( (($loop2 % 200) == 0) && ($loop2>0) )
				{	
					$loop1++;
					$loop2=0; 
				}
				
				$insert_pembaca[$loop1][$loop2] =array(
						  'materi_id' => $u->id ,
						  'user_id' => $user_id 
					   );
				
				$jumlah = $u->siswa_total+1;
				//$jumlah = $u->siswa_total;	   
				$update_materi[$loop1][$loop2] =array(
						  'id' => $u->id ,
						  'siswa_total' => (int)$jumlah
					   );
					   
				$loop2++;
				
			}
			
			for($loop_materi=0;$loop_materi<=$loop1;$loop_materi++)
			{
				$this->utama->master_crud_batch_table('insert', $insert_pembaca[$loop_materi], 'kbm_materi_baca');
				$this->utama->master_crud_batch_table('update', $update_materi[$loop_materi], 'kbm_materi', 'id');
			}
		}
	}
	
	public function insert_one_nilai_siswa_pelajaran_by_query( $siswa_nilai_id, $pelajaran_nilai_id, $pelajaran_kelas_nilai_id, $kelas_nilai_id){
		
		$query = 
		"
			INSERT
				nilai_siswa_pelajaran
			SET
				siswa_nilai_id				= ".$siswa_nilai_id.",
				pelajaran_nilai_id 			= ".$pelajaran_nilai_id.",
				pelajaran_kelas_nilai_id 	= ".$pelajaran_kelas_nilai_id.",
				kelas_nilai_id 				= ".$kelas_nilai_id."
				
		";
		
		$this->utama->master_query($query);
	
	}
	
	public function update_one_nilai_siswa_pelajaran_by_query( $id, $pelajaran_nilai_id, $pelajaran_kelas_nilai_id, $kelas_nilai_id){
		
		$query = 
		"
			UPDATE
				nilai_siswa_pelajaran
			SET
				pelajaran_nilai_id 			= ".$pelajaran_nilai_id.",
				pelajaran_kelas_nilai_id 	= ".$pelajaran_kelas_nilai_id.",
				kelas_nilai_id 				= ".$kelas_nilai_id."
			WHERE
				id = ".$id."	
		";
		
		$this->utama->master_query($query);
	
	}
	
	public function delete_one_nilai_siswa_pelajaran_by_query( $id){
		
		$query = 
		"
			DELETE FROM
				nilai_siswa_pelajaran
			WHERE
				id = ".$id."	
		";
		
		$this->utama->master_query($query);
	
	}
	
	public function chek_mapel_dan_agama_pelajaran_kelas($kelas_nilai_id, $agama_id){
		
		$query = 
		"
			SELECT  
				npk.*,
				dp.nama as nama_pelajaran,
				dm.nama as nama_mapel,
				dm.id as id_mapel,
				da.nama as nama_agama,
				da.id as id_agama,
				dkm.id as id_kategori_mapel 
			FROM  
				nilai_pelajaran_kelas npk
			LEFT JOIN
				nilai_pelajaran np
				ON
				np.id = npk.pelajaran_nilai_id
			LEFT JOIN
				dakd_pelajaran dp
				ON
				dp.id = np.pelajaran_id
			LEFT JOIN
				dakd_mapel dm
				ON
				dm.id = dp.mapel_id
			LEFT JOIN
				dakd_kategori_mapel dkm
				ON
				dkm.id = dp.kategori_id
			LEFT JOIN
				dmst_agama da
				ON
				da.id = np.agama_id
			WHERE 
					npk.kelas_nilai_id = ".$kelas_nilai_id."
				AND 
					(np.`agama_id` IS NULL OR np.`agama_id` = 0 OR np.`agama_id` = ".$agama_id.")
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
	}
	
	public function chek_mapel_dan_agama_pelajaran_siswa($siswa_nilai_id){
		
		$query = 
		"
			SELECT  
				nsp.*,
				dp.nama as nama_pelajaran,
				dm.nama as nama_mapel,
				dm.id as id_mapel,
				da.nama as nama_agama,
				da.id as id_agama ,
				dkm.id as id_kategori_mapel 
			FROM  
				nilai_siswa_pelajaran nsp
			LEFT JOIN
				nilai_pelajaran np
				ON
				np.id = nsp.pelajaran_nilai_id
			LEFT JOIN
				dakd_pelajaran dp
				ON
				dp.id = np.pelajaran_id
			LEFT JOIN
				dakd_mapel dm
				ON
				dm.id = dp.mapel_id
			LEFT JOIN
				dakd_kategori_mapel dkm
				ON
				dkm.id = dp.kategori_id
			LEFT JOIN
				dmst_agama da
				ON
				da.id = np.agama_id
			WHERE 
				nsp.siswa_nilai_id = ".$siswa_nilai_id."
			
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
	}
	
	public function chek_nilai_siswa_pelajaran($siswa_nilai_id, $kelas_nilai_id){
		
		$query = 
		"
			SELECT  
				* 
			FROM  
				nilai_siswa_pelajaran
			WHERE 
				kelas_nilai_id = ".$kelas_nilai_id."
				AND
				siswa_nilai_id = ".$siswa_nilai_id."
			Limit 1
		";
		
		$result	= $this->utama->master_query_result($query);
		
		return $result;
	}
	
	public function update_nilai_siswa_pelajaran_by_query_where_agama($siswa_nilai_id, $kelas_nilai_id, $agama_id="")
	{
		$query = 
		"
			SELECT  
				nsp.id 
			FROM  
				nilai_siswa_pelajaran nsp
				JOIN 
					nilai_pelajaran np
				ON 
					np.id = nsp.pelajaran_nilai_id
			WHERE 
				nsp.kelas_nilai_id = ".$kelas_nilai_id."
				AND
				nsp.siswa_nilai_id = ".$siswa_nilai_id."
				AND
				np.agama_id != ".$agama_id."
				
		";
		
		$result	= $this->utama->master_query_result($query);
		
		$ada=0;
		foreach($result as $r)
		{
			$query = 
			"
				DELETE 
				FROM  
					nilai_siswa_pelajaran
				WHERE 
					id = ".$r->id."
					
			";
			$this->utama->master_query($query);	
		}
		
		$query = 
		"
			SELECT  
				np.* 
			FROM  
				nilai_siswa_pelajaran nsp
				JOIN 
					nilai_pelajaran np
				ON 
					np.id = nsp.pelajaran_nilai_id
			WHERE 
				nsp.kelas_nilai_id = ".$kelas_nilai_id."
				AND
				nsp.siswa_nilai_id = ".$siswa_nilai_id."
				AND
				np.agama_id = ".$agama_id."
				
			Limit 1
		";
		
		$result	= $this->utama->master_query_result($query);
		
		$ada=0;
		foreach($result as $r)
		{	$ada=1; }
		
		if($ada==0)
		{
			$query = 
			"
				INSERT INTO `nilai_siswa_pelajaran` 
				(`siswa_nilai_id` ,  `pelajaran_nilai_id` ,  `pelajaran_kelas_nilai_id` ,  `kelas_nilai_id` )
				
				SELECT  
					".$siswa_nilai_id." ,  npk.pelajaran_nilai_id ,  npk.id , npk.kelas_nilai_id 
				FROM  
					nilai_pelajaran np
				JOIN
					nilai_pelajaran_kelas npk
					ON
					npk.pelajaran_nilai_id = np.id
				WHERE 
					npk.kelas_nilai_id = ".$kelas_nilai_id."
					AND 
					np.`agama_id` = ".$agama_id."
			";
			
			$this->utama->master_query($query);
			
		}
		
	}
	
	public function insert_nilai_siswa_pelajaran_by_query($siswa_nilai_id, $kelas_nilai_id, $agama_id=""){
		
		$cetak = "";
		if($agama_id!="")
		{
			$cetak = " OR np.`agama_id` = ".$agama_id;
		}
		
		$query = 
		"
			INSERT INTO `nilai_siswa_pelajaran` 
			(`siswa_nilai_id` ,  `pelajaran_nilai_id` ,  `pelajaran_kelas_nilai_id` ,  `kelas_nilai_id` )
			
			SELECT  
				".$siswa_nilai_id." ,  npk.pelajaran_nilai_id ,  npk.id , npk.kelas_nilai_id 
			FROM  
				nilai_pelajaran np
			JOIN
				nilai_pelajaran_kelas npk
				ON
				npk.pelajaran_nilai_id = np.id
			WHERE 
				npk.kelas_nilai_id = ".$kelas_nilai_id."
				AND
				(np.`agama_id` IS NULL OR np.`agama_id` ='0' ".$cetak.")
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function delete_nilai_siswa_pelajaran_by_query($siswa_nilai_id){
		
		$query = 
		"
			DELETE 
			FROM `nilai_siswa_pelajaran` 
			WHERE 
				
				siswa_nilai_id = ".$siswa_nilai_id."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function delete_nilai_siswa_pelajaran_by_query_where_not_kelas($siswa_nilai_id, $not_kelas_nilai_id){
		
		$query = 
		"
			DELETE 
			FROM nilai_siswa_pelajaran
			WHERE 
				kelas_nilai_id != ".$not_kelas_nilai_id."
				AND
				siswa_nilai_id = ".$siswa_nilai_id."
				
		";
		
		$result	= $this->utama->master_query($query);
		
	}
	
	public function show_user_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=2000) {
			
			$table			= 'data_user';
			$order_coloumn	= 'nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_siswa_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=2000) {
			
			$table			= 'dprofil_siswa'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_periode_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table			= 'prd_semester'; 
			$order_coloumn	= 'nama';
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_agama_by_all($limit=0, $offset=1000) {
			
			$table			= 'dmst_agama'; 
			
			$data[$table]	= $this->utama->get_data_all_one_table($table, $limit, $offset);
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
	
	public function show_student_by_where($where_coloumn, $where, $limit=0, $offset=1000) {
			
			$table				= 'student';
			$order_coloumn	= 'student_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_where_one_table($table, $limit, $offset, $where_coloumn, $where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_student_by_id($id) {
			
			$table				= 'student';
			$where_coloumn	= 'student_id'; 
			
			$data[$table] = $this->utama->get_detail_id_one_table($table, $where_coloumn, $id);
			return $data[$table];
	}
	
	public function show_student_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table				= 'student';
			$order_coloumn	= 'student_name'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $limit, $offset, $where_coloumn, $where, $size,$order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_kelas_pelajaran_aktif($nilai_kelas_id) {
		
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
		
		$table_join[1]		= 'nilai_pelajaran';
		$where_join[1]	= "nilai_pelajaran.id = nilai_pelajaran_kelas.pelajaran_nilai_id";
		
		$table_join[2]		= 'prd_semester';
		$where_join[2]	= "prd_semester.id = nilai_pelajaran_kelas.semester_id";
			
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "nilai_pelajaran_kelas.kelas_nilai_id";		$where[1] = $nilai_kelas_id;
			
		$data['grade'] = $this->show_select_kelas_pelajaran_by_multiwhere_multitable($select,$table, $table_join, $where_join, 3, $where_coloumn, $where, $jml_where);
		
		return $data['grade'];
	}
	
	public function show_select_kelas_pelajaran_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'kelas_nilai_id'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_nilai_siswa_by_multiwhere($where_coloumn = array(), $where = array(), $size, $limit=0, $offset=1000) {
			
			$table			= 'nilai_siswa';
			$order_coloumn	= 'id'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_one_table($table, $where_coloumn, $where, $size, $order_coloumn, $order, $limit, $offset);
			return $data[$table];
	}
	
	public function show_kelas_by_multiwhere_multitable($table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'nama'; 
			$order			= 'asc';
			
			$data[$table] = $this->utama->get_data_by_multiwhere_multitable($table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_student_by_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_student_by_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, $group, 
	$limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multitable_group($select,$table, $table_join, $where_join, $size_join, $group, $limit, $offset, $order_coloumn, $order);
			return $data[$table];
	}
	
	
	public function show_select_student_by_multiwhere_multitable($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $limit=0, $offset=1000,$order_coloumn='',$order='') {
			
			if($order_coloumn == '')
				$order_coloumn	= 'prd_semester.id'; 
			if($order == '')
				$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function show_select_student_by_multiwhere_multitable_group($select,$table, $table_join = array(), $where_join = array(), $size_join, 
	$where_coloumn = array(), $where = array(), $size_where, $group, $limit=0, $offset=1000) {
			
			$order_coloumn	= 'nilai_kelas.semester_id'; 
			$order			= 'desc';
			
			$data[$table] = $this->utama->get_select_data_by_multiwhere_multitable_group($select,$table, $table_join, $where_join, $size_join, $limit, $offset, $where_coloumn, $where, $size_where, $group, $order_coloumn, $order);
			return $data[$table];
	}
	
	public function save_student($action, $id=0, $id1=0) {

			$table	= 'data_user';
			$where_coloumn			= 'id';
			
			$nama_siswa = str_replace("'","`",$this->input->post('nama'));
			//$nama_siswa = strtoupper($nama_siswa);
			$alias_siswa = explode(" ",$nama_siswa);
			
			if($id1==0)
			{
				$id1 = $this->input->post('siswa_id');
			}
			$data1['username']		= $this->input->post('nis');
			$data1['password']		= $this->crypto($this->input->post('nis'));
			$data1['alias']			= $alias_siswa[0];
			$data1['nama']			= $nama_siswa;
			$data1['gender']		= $this->input->post('gender');
			
			$data1['role']			= 'siswa';
			$data1['modified']		= date('Y-m-d H:i:s');
			$data1['modifier_id']	= 1;
			
			
			$this->utama->master_crud_one_table($action,$data1,$table,$where_coloumn,$id1);
			
			$where1[0] = $nama_siswa;		$where_coloumn1[0] = 'nama';
			$where1[1] = $this->input->post('nis');			$where_coloumn1[1] = 'username';
			
			$size	= 2;
			
			$user = $this->show_user_by_multiwhere($where_coloumn1, $where1, $size);
			
			////////////////////////////////////////////////////////////////////////////
			foreach($user as $u)
			{	$data2['id'] = $u->id;	}
			
			$nilai_kelas_id			= $this->input->post('nilai_kelas_id');
			
			$table				= 'nilai_kelas';
			$table_join2[0]		= 'dakd_kelas';
			$where_join2[0]	    = "dakd_kelas.id = nilai_kelas.kelas_id";
			
			$size_where = 1;
			$size_join = 1;
			
			$where_coloumn2[0]	= "nilai_kelas.id";		$where2[0] = $nilai_kelas_id;
			
			$nilai_kelas = $this->show_kelas_by_multiwhere_multitable($table, $table_join2, $where_join2, $size_join, $where_coloumn2, $where2, $size_where);
			
			$data2['kelas_id'] ='';
			foreach($nilai_kelas as $nk)
			{	$data2['kelas_id'] = $nk->kelas_id;	}
			
			///////////////////////////////////////////////////////////////////////////
			$table	= 'dprofil_siswa';
			$where_coloumn			= 'id';
			
			if($id1==0)
			{
				$id1 = $this->input->post('siswa_id');
			}
			$data2['nis']			= $this->input->post('nis');
			if(($this->input->post('nisn')!='')&&($this->input->post('nisn')!=0))
			{	$data2['nisn']			= $this->input->post('nisn');	 }
			$data2['nama']			= $nama_siswa;
			$data2['gender']		= $this->input->post('gender');
			if(($this->input->post('agama_id')!='')&&($this->input->post('agama_id')!=0) )
			{
				$data2['agama_id']			= $this->input->post('agama_id');
			}else
			{	$data2['agama_id']			= '7';	}
			$data2['lahir_tempat']	= $this->input->post('lahir_tempat');
			$data2['lahir_tgl']		= $this->input->post('lahir_tgl');
			$data2['alamat']		= $this->input->post('alamat');
			$data2['kota']			= $this->input->post('kota');
			$data2['telepon']		= $this->input->post('telepon');
			
			$data2['aktif']			= 1;
			$data2['modified']		= date('Y-m-d H:i:s');
			$data2['modifier_id']	= 1;
			
			$this->utama->master_crud_one_table($action,$data2,$table,$where_coloumn,$id1);
			
			$size	= 2;
			$where_coloumn3[0] = "nis"; 			$where3[0] = $this->input->post('nis');
			$where_coloumn3[1] = "nama"; 			$where3[1] = $nama_siswa;
			if(($this->input->post('nisn')!='')&&($this->input->post('nisn')!=0))
			{
				$size++;
				$where_coloumn3[2] = "nisn"; 			$where3[2] = $this->input->post('nisn');
			}
			$siswa		= $this->show_siswa_by_multiwhere($where_coloumn3, $where3, $size);
			
			$periode	= $this->show_periode_by_where('status', 'aktif');
			
			
			$data3['siswa_id']	= 	$id1;
			foreach($siswa as $u)
			{	$data3['siswa_id'] = $u->id;	}
			
			foreach($periode as $p)
			{	$data3['semester_id'] = $p->id;	}
			
			///////////////////////////////////////////////////////////////////////////////////////////////
			$table	= 'nilai_siswa';
			$where_coloumn			= 'id';
			
			if($id==0)
			{	
				$id = $this->input->post('nilai_siswa_id');	
			}
			
			$data3['kelas_nilai_id']	= $nilai_kelas_id;
			$data3['kelas_id']			= $data2['kelas_id'];
			
			//absen
			if(($this->input->post('absen_no')==0)||($this->input->post('absen_no')=='')){
				// kosong
				$data3['absen_no']			= NULL;
			}else{
				$data3['absen_no']			= $this->input->post('absen_no');
			}
			
			$this->utama->master_crud_one_table($action,$data3,$table,$where_coloumn,$id);
			
			$where_coloumn4[0] = "siswa_id"; 			$where4[0] = $data3['siswa_id'];
			$where_coloumn4[1] = "semester_id"; 		$where4[1] = $data3['semester_id'];
			
			$size	= 2;
			
			$siswa_nilai	= $this->show_nilai_siswa_by_multiwhere($where_coloumn4, $where4, $size);
			
			foreach($siswa_nilai as $u)
			{	$siswa_nilai_id = $u->id;	}
			
			
			//$kelas_pelajaran		= $this->show_kelas_pelajaran_aktif($nilai_kelas_id);
			
			if($action=='insert')
			{
				$this->insert_nilai_siswa_pelajaran_by_query($siswa_nilai_id, $nilai_kelas_id, $data2['agama_id']);
				$this->insert_one_kbm_materi_siswa_by_query($data3['siswa_id'], $data3['kelas_id']);
			}
			elseif($action=='update')
			{
				//$this->insert_one_kbm_materi_siswa_by_query($data3['siswa_id'], $data3['kelas_id']);
				/*
				$this->delete_nilai_siswa_pelajaran_by_query_where_not_kelas($siswa_nilai_id, $nilai_kelas_id);
				$chek = $this->chek_nilai_siswa_pelajaran($siswa_nilai_id, $nilai_kelas_id);
				$ada=0;
				
				//print_r($chek);
				foreach($chek as $c)
				{	$ada = 1;	}
				
				if($ada==0)
				{	$this->insert_nilai_siswa_pelajaran_by_query($siswa_nilai_id, $nilai_kelas_id, $data2['agama_id']);	}
				
				$this->update_nilai_siswa_pelajaran_by_query_where_agama($siswa_nilai_id, $nilai_kelas_id, $data2['agama_id']);
				*/
				$chek_siswa = $this->chek_mapel_dan_agama_pelajaran_siswa($siswa_nilai_id);
				$chek_kelas = $this->chek_mapel_dan_agama_pelajaran_kelas($nilai_kelas_id, $data2['agama_id']);
				foreach($chek_siswa as $cs)
				{	
					$ada=0;
					foreach($chek_kelas as $ck)
					{	
						//echo "AA".$cs->id_kategori_mapel." ".$ck->id_kategori_mapel." ".$cs->id_mapel." ".$ck->id_mapel." ".$cs->id_agama." ".$ck->id_agama;
						if( ($cs->id_kategori_mapel==$ck->id_kategori_mapel)&&($cs->id_mapel==$ck->id_mapel)&&($cs->id_agama==$ck->id_agama) )
						{	
							//echo "BB";
							$ada=1;	
							$t_pelajaran_nilai			= $ck->pelajaran_nilai_id;
							$t_pelajaran_kelas_nilai	= $ck->id;
							$t_kelas_nilai				= $ck->kelas_nilai_id;
						}
						
					}
					if($ada==0)
					{
						$this->delete_one_nilai_siswa_pelajaran_by_query($cs->id);
					}elseif($ada==1){
						$this->update_one_nilai_siswa_pelajaran_by_query( $cs->id, $t_pelajaran_nilai, $t_pelajaran_kelas_nilai, $t_kelas_nilai);
					}
				}
				
				foreach($chek_kelas as $ck)
				{
					$ada=0;
					foreach($chek_siswa as $cs)
					{
						if( ($cs->id_kategori_mapel==$ck->id_kategori_mapel)&&($cs->id_mapel==$ck->id_mapel)&&($cs->id_agama==$ck->id_agama) )
						{	$ada=1;	}
					}
					if($ada==0)
					{
						$this->insert_one_nilai_siswa_pelajaran_by_query( $siswa_nilai_id, $ck->pelajaran_nilai_id, $ck->id, $ck->kelas_nilai_id);
					}
				}
				
			}
			elseif($action=='delete')
			{
				$this->delete_nilai_siswa_pelajaran_by_query($id);
			}
			
	}
	
	
	////////////////////////////// student /////////////////////////////////////////////////////////
	public function home($action='', $id=0, $id1=0){
		
		if($action!='')
		{	
			if(($this->input->post('nama')!='' 
			&& $this->input->post('nis')!='' 
			&& $this->input->post('agama_id')!='' 
			&& $this->input->post('nilai_kelas_id')!='' 
			&& $this->input->post('nilai_kelas_id')!=0)
			|| $action=='delete')
			{
				$this->save_student($action, $id, $id1);
				//redirect($this->uri->segment(1).'/'.$this->uri->segment(2));
			}else{
				redirect($this->uri->segment(1)."/form/insert?info=alert");
			}
		}
		
		require('core.php');
		$core = new core();
		
		$select ="
			nilai_kelas.id as id_nilai_kelas,
			dprofil_siswa.*,
			dakd_kelas.nama as nama_kelas,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			nilai_siswa.id as siswa_nilai_id,
			dmst_agama.nama as nama_agama
			";
		
		$table	= 'nilai_siswa';
		
		$table_join[0]		= 'dprofil_siswa';
		$where_join[0]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[1]		= 'nilai_kelas';
		$where_join[1]	= "nilai_kelas.id = nilai_siswa.kelas_nilai_id";
		
		$table_join[2]		= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$table_join[4]		= 'dmst_agama';
		$where_join[4]	= "dmst_agama.id =dprofil_siswa.agama_id";
		
		$jml_where = 1;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		//$data['student'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 5, $where_coloumn, $where, $jml_where);
		$data['student'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 5, $where_coloumn, $where, $jml_where, 0, 1000, 'dprofil_siswa.nama', 'asc');
		
		
		$core->top(); 
			
		$this->load->view('student/list_student',$data);
		
		$core->bottom();
	}
	
	public function home_angkatan($action='', $id=0, $id1=0){
		
		require('core.php');
		$core = new core();
		
		$select ="
			nilai_kelas.id as id_nilai_kelas,
			dprofil_siswa.*,
			dakd_kelas.nama as nama_kelas,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			nilai_siswa.id as siswa_nilai_id,
			dmst_agama.nama as nama_agama
			";
		
		$table	= 'nilai_siswa';
		
		$table_join[0]		= 'dprofil_siswa';
		$where_join[0]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[1]		= 'nilai_kelas';
		$where_join[1]	= "nilai_kelas.id = nilai_siswa.kelas_nilai_id";
		
		$table_join[2]		= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$table_join[4]		= 'dmst_agama';
		$where_join[4]	= "dmst_agama.id = dprofil_siswa.agama_id";
		
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "dakd_kelas.grade";		$where[1] = $this->input->post('angkatan');
		
		$data['student'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 5, $where_coloumn, $where, $jml_where);
		
		$data['angkatan']= $this->input->post('angkatan');
		
		$core->top(); 
			
		$this->load->view('student/list_student',$data);
		
		$core->bottom();
	}
	
	public function detail($action='', $id=0, $id1=0){
		
		if(($action!='')&&($action!='id'))
		{	
			$this->save_student($action, $id, $id1);
			redirect($this->uri->segment(1).'/'.$this->uri->segment(2));	
		}
		
		require('core.php');
		
  		$core = new core();
	
	
		$select ="
			nilai_kelas.id as id_nilai_kelas,
			dprofil_siswa.*,
			dakd_kelas.nama as nama_kelas,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			nilai_siswa.id as siswa_nilai_id,
			nilai_siswa.absen_no,
			dmst_agama.nama as nama_agama
			";
		
		$table	= 'nilai_siswa';
		
		$table_join[0]		= 'dprofil_siswa';
		$where_join[0]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[1]		= 'nilai_kelas';
		$where_join[1]	= "nilai_kelas.id = nilai_siswa.kelas_nilai_id";
		
		$table_join[2]		= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$table_join[4]		= 'dmst_agama';
		$where_join[4]	= "dmst_agama.id =dprofil_siswa.agama_id";
		
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "nilai_siswa.id";				$where[1] = $id;
		
		$data['student'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 5, $where_coloumn, $where, $jml_where);
		
		
		/////////////////PELAJARAN//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
		$select ="
			nilai_kelas.id as id_nilai_kelas,
			dprofil_siswa.*,
			dakd_kelas.nama as nama_kelas,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			nilai_siswa_pelajaran.siswa_nilai_id,
			dakd_kategori_mapel.kode as kode_kategori_mapel,
			dakd_mapel.nama as nama_mapel,
			dakd_pelajaran.nama as nama_pelajaran,
			dprofil_sdm.nama as nama_guru,
			nilai_pelajaran.kkm
			";
		
		$table	= 'nilai_siswa_pelajaran';
		
		$table_join[0]		= 'nilai_siswa';
		$where_join[0]	= "nilai_siswa.id = nilai_siswa_pelajaran.siswa_nilai_id";
		
		$table_join[1]		= 'dprofil_siswa';
		$where_join[1]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[2]		= 'nilai_kelas';
		$where_join[2]	= "nilai_kelas.id = nilai_siswa_pelajaran.kelas_nilai_id";
		
		$table_join[3]		= 'dakd_kelas';
		$where_join[3]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[4]		= 'nilai_pelajaran';
		$where_join[4]	= "nilai_pelajaran.id = nilai_siswa_pelajaran.pelajaran_nilai_id";
		
		$table_join[5]		= 'dprofil_sdm';
		$where_join[5]	= "dprofil_sdm.id = nilai_pelajaran.guru_id";
		
		$table_join[6]		= 'dakd_pelajaran';
		$where_join[6]	= "dakd_pelajaran.id = nilai_pelajaran.pelajaran_id";
		
		$table_join[7]		= 'dakd_mapel';
		$where_join[7]	= "dakd_mapel.id = dakd_pelajaran.mapel_id";
		
		$table_join[8]		= 'dakd_kategori_mapel';
		$where_join[8]	= "dakd_kategori_mapel.id = dakd_pelajaran.kategori_id";
		
		$table_join[9]		= 'nilai_pelajaran_kelas';
		$where_join[9]	= "nilai_pelajaran_kelas.id = nilai_siswa_pelajaran.pelajaran_kelas_nilai_id";
		
		$table_join[10]		= 'prd_semester';
		$where_join[10]	= "prd_semester.id = nilai_pelajaran_kelas.semester_id";
		
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_siswa_pelajaran.siswa_nilai_id";		$where[1] = $id;
		
		$data['pelajaran'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 11, $where_coloumn, $where, $jml_where);
		
		
		/////////////////ORGANISASI//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
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
		
		$data['organisasi'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
	
	
	/////////////////EKSKUL/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$select ="
			nilai_siswa_ekskul.id as siswa_ekskul_nilai_id,
			nilai_siswa_ekskul.keterangan,
			
			
			dnakd_ekskul.nama as nama_ekskul,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester
			";
			
		$table	= 'nilai_siswa_ekskul';
		
		$table_join[0]		= 'nilai_ekskul';
		$where_join[0]	= "nilai_siswa_ekskul.ekskul_nilai_id = nilai_ekskul.id";
		
		$table_join[1]		= 'dnakd_ekskul';
		$where_join[1]	= "dnakd_ekskul.id = nilai_ekskul.ekskul_id";
		
		$table_join[2]		= 'prd_semester';
		$where_join[2]	= "prd_semester.id = nilai_ekskul.semester_id";
		
		$jml_join	= 3;
		$jml_where	= 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		$where_coloumn[1]	= "nilai_siswa_ekskul.siswa_nilai_id";		$where[1] = $id;
		
		$data['ekskul'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, $jml_join, $where_coloumn, $where, $jml_where);
		
		$core->top(); 
			
		$this->load->view('student/detail_student',$data);
		
		$core->bottom();
	}
	
	public function form($action, $id=0, $id1=0, $url='home'){
			
		require('core.php');
		
  		$core = new core();
		
		$data['action']	= $action;
		
		$select ="
			nilai_kelas.id as id_nilai_kelas,
			dprofil_siswa.*,
			dakd_kelas.nama as nama_kelas,
			prd_semester.id as id_semester,
			prd_semester.nama as nama_semester,
			nilai_siswa.id as siswa_nilai_id,
			nilai_siswa.absen_no,
			dmst_agama.nama as nama_agama
			";
		
		$table	= 'nilai_siswa';
		
		$table_join[0]		= 'dprofil_siswa';
		$where_join[0]	= "dprofil_siswa.id = nilai_siswa.siswa_id";
		
		$table_join[1]		= 'nilai_kelas';
		$where_join[1]	= "nilai_kelas.id = nilai_siswa.kelas_nilai_id";
		
		$table_join[2]		= 'dakd_kelas';
		$where_join[2]	= "dakd_kelas.id = nilai_kelas.kelas_id";
		
		$table_join[3]		= 'prd_semester';
		$where_join[3]	= "prd_semester.id = nilai_kelas.semester_id";
		
		$table_join[4]		= 'dmst_agama';
		$where_join[4]	= "dmst_agama.id =dprofil_siswa.agama_id";
		
		$jml_where = 2;
		
		$where_coloumn[0]	= "prd_semester.status";		$where[0] = 'aktif';
		
		$where_coloumn[1]	= "nilai_siswa.id";				$where[1] = $id;
		
		$data['student'] = $this->show_select_student_by_multiwhere_multitable($select,$table, $table_join, $where_join, 5, $where_coloumn, $where, $jml_where);
		
		$data['kelas']		= $this->show_kelas_aktif();	
		
		$data['agama']		 = $this->show_agama_by_all();
		
		
		$data['url'] = $url;
		
		$core->top(); 
			
		$this->load->view('student/form_student',$data);
		
		$core->bottom();
	
	}
	
}	
?>