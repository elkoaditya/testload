<?php

class M_kbm_vidcall extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields'			 => array('nama', 'jenis_brand', 'tanggal_publish', 'tanggal_tutup', 'tampil_guru'),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'kbm', 'materi');
		$this->dm['view'] = cfguc_view('akses', 'kbm', 'materi');

	}
	
	// dasar database

	function filter_1($query)
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$query['like'] = array($r['term'], array('vidcall.nama'));

		if (isset($r['author_id']) && $r['author_id'] > 0)
			$query['where']['vidcall.author_id'] = $r['author_id'];

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'vidcall.tanggal_publish');
		
		return $query;

	}

	function filtering()
	{
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];

		// normalisasi

		if (!isset($r['semester_id']) OR ! $r['semester_id'])
			$r['semester_id'] = $d['semaktif']['id'];

		// filtering

		if (isset($r['term']))
			$this->md->like($r['term'], 'vidcall.nama');
		
		if (isset($r['author_id']) && $r['author_id'] > 0)
			$this->db->where('vidcall.author_id', $r['author_id']);

		if (isset($r['tanggal_publish']))
			$this->md->like($r['tanggal_publish'], 'vidcall.tanggal_publish');
	}

	function query_2()
	{
		$d = & $this->ci->d;
		$dm = & $this->dm;
		$query = array(
			'select'	 => array(
				'vidcall.*',
				'author_nama'	=> 'author.nama',
				'kelas_nama' 	=> 'GROUP_CONCAT(kelas.nama)',
				
				'COALESCE(vidcall_record.cnt, 0) as jml_pembaca'
			),
			'from'		 => 'kbm_vidcall vidcall',
			'join'		 => array(
				
				array('data_user author', 'vidcall.author_id = author.id', 'inner'),
				array('kbm_vidcall_kelas pengkelas', 'pengkelas.vidcall_id = vidcall.id', 'left'),
				array('dakd_kelas kelas', 'pengkelas.kelas_id = kelas.id', 'left'),
				array('( 
						SELECT vidcall_id, COUNT(*) AS cnt 
						FROM kbm_vidcall_record 
						
						GROUP BY vidcall_id 
					) vidcall_record  ', 'vidcall_record.vidcall_id = vidcall.id', 'left'),
			),
			'order_by'   => "vidcall.id DESC",
			'where'	 	 => array('vidcall.aktif' => 1),
			'group_by' 	 => 'vidcall.id'
		);

		return $query;

	}

	function query_sendiri($query = array())
	{
		$d = & $this->ci->d;
		
		//$query['order_by'] = 'vidcall.prioritas DESC, vidcall.tanggal_publish DESC';
					
		if ($d['user']['role'] != 'admin'){
			$query['where']['author_id'] = $d['user']['id'];
		}

		return $query;

	}
	
	function query_baca_vidcall($query = array())
	{
		$d = & $this->ci->d;
		
		//$query['order_by'] = 'baca_user_id ASC, vidcall.prioritas DESC, vidcall.tanggal_publish DESC';
		
		$now = date("Y-m-d H:i:s");
		$query['where_strings'] = "( ( vidcall.tanggal_publish <= '".$now."' && (vidcall.tanggal_tutup = '0000-00-00 00:00:00' || vidcall.tanggal_tutup is NULL ) ) || " ;
		$query['where_strings'] .= "( vidcall.tanggal_publish <= '".$now."' && vidcall.tanggal_tutup >= '".$now."' ) || " ;
		$query['where_strings'] .= "( vidcall.tanggal_publish = '0000-00-00 00:00:00' || vidcall.tanggal_publish is NULL ) )" ;
			
		if ($d['user']['role'] == 'sdm'){	
			$query['where']['vidcall.tampil_guru'] = '1';
			
		}elseif ($d['user']['role'] == 'siswa'){	
			//$query['where']['vidcall.tampil_siswa'] = '1';
			$query['join'][] = array('kbm_vidcall_kelas pengkel2', 'pengkel2.vidcall_id = vidcall.id AND pengkel2.kelas_id = '.$d['user']['kelas_id'], 'inner');
		}
		
		return $query;
	}
	
	function query_sekolah($query = array())
	{
		
		$query = $this->query_baca_vidcall($query);
		//$query['where']['author.role'] = 'admin';
		
		return $query;

	}
	
	function query_guru($query = array())
	{
		
		$query['where']['author.role'] = 'sdm';
		$query = $this->query_baca_vidcall($query);
		
		return $query;

	}

	// operasi data
	function browse_sendiri($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_sendiri($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function browse_sekolah($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_sekolah($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function browse_guru($index = 0, $limit = 20)
	{
		$query = $this->query_2();
		$query = $this->query_guru($query);
		$query = $this->filter_1($query);

		return $this->md->query($query)->resultset($index, $limit);

	}
	
	function rowset($id)
	{
		$d = & $this->ci->d;
		$query = $this->query_2();
		$query['select'][] = 'vidcall.*';
		$query['where']['vidcall.id'] = $id;


		$row = $this->md->query($query)->row();

		if (!$row)
			return FALSE;

		// output

		return $row;

	}

	function save()
	{
		//require_once(APPPATH.'controllers/zoom/create_meeting.php');
		//require_once(APPPATH.'controllers/zoom/delete.php');
		
		$d = & $this->ci->d;
		$edit = (bool) $d['form']['id'];
		$vidcall_id = (int) $d['form']['id'];
		$kelas_jadwal = NULL;
		
		$peserta = array();
		$msg_sukses = "vidcall berhasil disimpan.";


		$this->form->ruleset($d['row'], 'validasi');
		$this->form->validate();

		if ($d['error'])
			return FALSE;

		$data = $this->input('fields');
		
		if ($d['error'])
			return FALSE;

		// olah data baru
		
		//print_r($data);
		
		// DELETE ZOOM MEETING
		/*
		if($vidcall_id>0){
			$sql_vidcall 		= "select * from kbm_vidcall where id = '".$vidcall_id."'";    
			$query_vidcall 		= $this->db->query($sql_vidcall);
			$result_vidcall 	= $query_vidcall->result_array();
			
			
			foreach($result_vidcall as $rvidcall){
				$metting = delete_meeting($rvidcall['meeting_id']);
			}
		}*/
		// END DELETE ZOOM MEETING
		
		//$temp_tanggal_publish = explode(":",$data['tanggal_publish']);
		//$data['tanggal_publish'] = $temp_tanggal_publish[0].":".$temp_tanggal_publish[1].":00";
		
		/// IF ZOOM
		if($data['jenis_brand']==1){
			//$temp_tanggal_publish 	= explode(" ",$data['tanggal_publish']);
			//$temp_tanggal_tutup 	= explode(" ",$data['tanggal_tutup']);
		
			// ALL ZOOM USE
			$query_zoom_use = 
				'SELECT 
					vidcall.*
				FROM		 
					kbm_vidcall vidcall
				INNER JOIN
					kbm_vidcall_zoom vidcall_zoom ON vidcall.vidcall_zoom_id = vidcall_zoom.id
				WHERE
					vidcall.aktif = 1 
					AND 
					(
						( vidcall.tanggal_publish <= "'.$data['tanggal_publish'].'" AND vidcall.tanggal_tutup >= "'.$data['tanggal_publish'].'")
						OR
						( vidcall.tanggal_publish <= "'.$data['tanggal_tutup'].'" AND vidcall.tanggal_tutup >= "'.$data['tanggal_tutup'].'")
						OR
						( vidcall.tanggal_publish >= "'.$data['tanggal_publish'].'" AND vidcall.tanggal_tutup <= "'.$data['tanggal_tutup'].'")
					)
			';
			$result_zoom_use = $this->md->result($query_zoom_use);
			
			$array_zoom_use = array();
			foreach($result_zoom_use['data'] as $zoom_use){
				$array_zoom_use[] .= $zoom_use['vidcall_zoom_id'];
			}
			
			//print_r($array_zoom_use);
			// ALL ZOOM 
			$query_zoom = 
				'SELECT 
					*
				FROM		 
					kbm_vidcall_zoom
				WHERE
					aktif = 1 
			';
			$result_zoom = $this->md->result($query_zoom);
			
			//$array_zoom = array();
			
			//echo"aaaa";
			//print_r($result_zoom);
			//echo"bbbbb";
			$use_zoom_id = '';
			foreach($result_zoom['data'] as $zoom){
				
				///$array_zoom[] .= $zoom->id;
				if (in_array($zoom['id'], $array_zoom_use)) {
					//echo"z";
				}else{
					//echo"x";
					$use_zoom_id =$zoom['id'];
					$data['vidcall_zoom_id'] 	= $zoom['id'];
					$data['meeting_id'] 		= $zoom['meeting_id'];
					$data['meeting_password'] 	= $zoom['meeting_password'];
					$data['api_key'] 			= $zoom['api_key'];
					$data['api_secret'] 		= $zoom['api_secret'];
					$data['invite'] 			= $zoom['invite'];
					$data['meeting_email'] 		= $zoom['meeting_email'];
					$data['host_key'] 			= $zoom['host_key'];
					break;
				}
			}
			
			if($use_zoom_id == ''){
				return alert_error('Meeting ID ZOOM sudah digunakan semua untuk jadwal diminta. Silahkan cari jadwal ZOOM beda waktu');
			}
			
			
			
			//print_r($array_zoom_use);
			//echo"<br>";
			//print_r($array_zoom);
			
			// BUAT ZOOM MEETING
			/*$menit_durasi 	= 0;
			$default_menit	= "240";
			$data2['durasi'] = $default_menit;
			if($data['tanggal_tutup']!=''){
				$detik_tanggal_publish = strtotime($data['tanggal_publish']);
				$detik_tanggal_tutup = strtotime($data['tanggal_tutup']);
				
				$detik_durasi = $detik_tanggal_tutup - $detik_tanggal_publish;
				
				$menit_durasi = $detik_durasi/60;
			}
			if($menit_durasi < $default_menit){
				$data2['durasi'] = '"'.$menit_durasi.'"';
			}
			
			//print_r($data);
			//print_r($data2);
			$metting = create_meeting(APP_SCOPE,$data, $data2);
			
			$data['meeting_id'] 		= $metting->id;
			$data['durasi'] 			= $metting->durasi;
			$data['password'] 			= $metting->password;
			$data['encrypted_password'] = $metting->encrypted_password;*/
			
			
			// END BUAT ZOOM MEETING
		}
		
		//echo("aaaaa");
		if($data['tanggal_tutup']==''){
			unset($data['tanggal_tutup']);
		}
			
		if (!$edit):
			
			// prep vars

			$data['author_id'] = $d['user']['id'];
			
			$data['registered'] = $d['datetime'];

			// insert siswa

			$this->db->trans_start();
			$this->db->insert('kbm_vidcall', $data);

			$vidcall_id = (int) $this->db->insert_id();

			$trx = $this->trans_done();
			$msg_sukses = "vidcall berhasil ditambahkan.";

			if (!$trx)
				return alert_error('Database error saat menyimpan vidcall baru, coba beberapa saat lagi.');

			// insert berhasil, id baru masukan ke var data utama. reset input data u/ proses berikutnya.

			$d['form']['id'] = $vidcall_id;
			$d['form']['jenis_brand'] = $data['jenis_brand'];
			$data = array();

		endif;

		//echo("bbbbb");
		// perubahan data

		if (!empty($data)):
			
			$this->db->trans_start();
			
			$data['modified'] = $d['datetime'];
			$updfilter['id'] = $vidcall_id;

			$this->db->update('kbm_vidcall', $data, $updfilter);

			if ($edit)
				$msg_sukses = 'Data vidcall berhasil disimpan.';

			$trx = $this->trans_done();

			if (!$trx)
				return alert_error('Database error saat menyimpan vidcall, coba beberapa saat lagi.');

		endif;


		// hapus data kelas sebelumnya

		if ($edit)
			$this->db->delete('kbm_vidcall_kelas', array('vidcall_id' => $vidcall_id));

		// entri jadwal baru

		$klsjadwal_array = array();
		$kelas_jadwal = $this->input->post('kelas');
		foreach ($kelas_jadwal as $kelas):
			$jadwal['kelas_id'] = $kelas;
			$jadwal['vidcall_id'] = $vidcall_id;
			$klsjadwal_array[] = $jadwal;

		endforeach;

		//alert_dump($klsjadwal_array);

		if ($klsjadwal_array):
			// chek tampil siswa
			
			$this->db->insert_batch('kbm_vidcall_kelas', $klsjadwal_array);
			
		endif;
		
		if($data['jenis_brand']!=1){	
			return alert_success($msg_sukses);
		}
		

	}
	
	function query_record_vidcall($id){
		
		$query = array(
				'from' => 'kbm_vidcall_record',
				'select' => array(
						'*',
				),
		);
		
		$query['where']['id'] = $id;
		
		return $query;
	}
	
	function save_first_record_vidcall($vidcall_id ){
		
		$d = & $this->ci->d;
		
		$_raw = array(
			'vidcall_id'	=> $vidcall_id,
			'role'			=> $d['user']['role'],
			'user_id'		=> $d['user']['id'],
			'modified'		=> date('Y-m-d H:i:s'),
			'registered'	=> date('Y-m-d H:i:s'),
			'total_waktu'	=> 0,
			'aktif'			=> 1,
			);
			
		$this->db->trans_start();
		
		$this->db->insert('kbm_vidcall_record' ,$_raw );
		$insert_id = $this->db->insert_id();
		
		$this->db->trans_complete();
		
		return $insert_id;
	}
	
	function save_record_vidcall(){
		
		$id_record_vidcall 	= $this->input->post('id_record_vidcall');
		
		if($id_record_vidcall==''){
			$response['warna'] = '#FF4444';	
			$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
		}else{
			
			$query = $this->query_record_vidcall($id_record_vidcall);
			$hasil = $this->md->query($query)->row();
			
			$_raw = array(
				'id'			=> $id_record_vidcall,
				'total_waktu'	=> ($hasil['total_waktu']+1),
				'modified' 		=> date('Y-m-d H:i:s'),
				);
			
			
			$this->db->trans_start();
			
			$this->db->where('id', $id_record_vidcall);
			$this->db->update('kbm_vidcall_record', $_raw); 
					
			$this->db->trans_complete();
			
			if ($this->db->trans_status() === FALSE){
				$response['warna'] = '#FF4444';	
				$response['message'] = 'Waktu video call GAGAL di simpan, coba "REFRESH" halaman ini dan cek "INTERNET".';	
			}else{	
				$response['warna'] = '#00AAFF';	
				$response['message'] = 'Waktu baca berhasil di simpan.';	
			}
			
			$this->trans_done();
		}
		
		return $response;

	}

	
	function surveillance($index = 0, $limit = 50){
		
		$d = & $this->ci->d;
		$r = & $this->ci->d['request'];
		
		$query = array(
				'select' => array(
						'vidcall.*',
						'kelas_nama'	=> 'kelas.nama',
						'siswa_id' 		=> 'siswa.id',
						'siswa_nis' 	=> 'siswa.nis',
						'siswa_nisn' 	=> 'siswa.nisn',
						'siswa_nama' 	=> 'siswa.nama',
						'siswa_gender' 	=> 'siswa.gender',
						'total_waktu'	=> 'SUM(record.total_waktu)',
						'waktu_awal' 	=> 'MIN(record.modified)',
				),
				'from' => 'kbm_vidcall vidcall',
				'join' => array(
						array('kbm_vidcall_kelas vidcall_kelas', 'vidcall_kelas.vidcall_id = vidcall.id', 'inner'),
						array('dakd_kelas kelas', 'kelas.id = vidcall_kelas.kelas_id', 'inner'),
						array('dprofil_siswa siswa', 'kelas.id = siswa.kelas_id', 'inner'),
						array('kbm_vidcall_record record', 'record.user_id = siswa.id AND record.vidcall_id = vidcall.id', 'left'),
						
				),
				'group_by' => 'siswa.id',
				
		);
		$query['where']['vidcall.id'] = $r['id'];
		if($r['kelas_id'] >0){
			$query['where']['kelas.id'] = $r['kelas_id'];	
		}
		
		$resulset = $this->md->query($query)->resultset($index, $limit);
		
		return $resulset;
		
	}
}
