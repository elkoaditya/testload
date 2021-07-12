<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class service extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('service/m_nilai_pelajaran', 'nilai_pelajaran');
		$this->load->model('service/m_nilai_kelas', 'nilai_kelas');
		$this->load->model('service/m_nilai_siswa', 'nilai_siswa');
		$this->load->model('service/m_nilai_absensi', 'nilai_absensi');
		$this->load->model('service/m_nilai_siswa_absensi', 'nilai_siswa_absensi');
		$this->load->model('service/m_admin', 'admin');
		$this->load->model('service/m_guru', 'guru');
		$this->load->model('service/m_jurnal', 'jurnal');
		$this->load->model('service/m_jadwal', 'jadwal');
		$this->load->model('service/m_kaldik', 'kaldik');
		$this->load->model('service/m_jam_ajar', 'jam_ajar');
		$this->load->model('service/m_pengumuman', 'pengumuman');
		$this->load->model('service/m_status_belajar', 'status_belajar');
		$this->load->model('service/m_semester', 'semester');
		
		$this->load->model('service/m_jurnal_siswa', 'jurnal_siswa');
		
	}
/*
	public function verication_kode(){
		$kode_sekolah = $this->input->post('kode_sekolah');
		
		//$sekolah='';
		
		if(strtoupper($kode_sekolah) == 'SMAN1SMG'){
			$sekolah = array(
				'url'		=> 'sman1-smg.fresto.co',
				'sekolah'	=> 'SMAN 1 SMG',
				'image'		=> base_url('content/images').'/SMA1.png',
			);
		}elseif(strtoupper($kode_sekolah) == 'SMAPLDONBOSKO'){
			$sekolah = array(
				'url'		=> 'smapldonbosko.fresto.co',
				'sekolah'	=> 'SMA PL DONBOSKO',
				'image'		=> base_url('content/images').'/SMA1.png',
			);
		}elseif(strtoupper($kode_sekolah) == 'SMATERBANG'){
			$sekolah = array(
				'url'		=> 'smaterbang.fresto.co',
				'sekolah'	=> 'SMA TERBANG',
				'image'		=> base_url('content/images').'/SMA1.png',
			);
		}
		
		if(isset($sekolah)){
			
			$obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $sekolah;

			echo json_encode($obj);
			
		}else{
			
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Kode Tidak ditemukan';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	*/
	public function login(){
		
		$username 		= $this->input->post('username');
		$password 		= $this->input->post('password');
		$kode_sekolah 	= $this->input->post('kode_sekolah');
		$deviceid 		= $this->input->post('deviceid');
		
		//// SMA
		if(strtoupper($kode_sekolah) == 'SMAN1SMG'){
			$url = 'sman1-smg.fresto.co';
		}elseif(strtoupper($kode_sekolah) == 'SMAN3SMG'){
			$url = 'sman3smg.fresto.co';
		}elseif(strtoupper($kode_sekolah) == 'SMAN6SMG'){
			$url = 'sman6smg.fresto.co';
		}elseif(strtoupper($kode_sekolah) == 'SMAN8SMG'){
			$url = 'sman8-smg.fresto.co';
			$new_url = '45.114.118.248/sma_smg8n_absensi';
		}elseif(strtoupper($kode_sekolah) == 'SMAN9SMG'){
			$url = 'sman9-smg.fresto.co';
			$new_url = '45.114.118.248/sma_smg9n_absensi';
		}elseif(strtoupper($kode_sekolah) == 'SMAN11SMG'){
			$url = 'sman11-smg.fresto.co';
		}elseif(strtoupper($kode_sekolah) == 'SMAN14SMG'){
			$url = 'sman14-smg.fresto.co';
		}
		
		/// SMK
		elseif(strtoupper($kode_sekolah) == 'SMKN6SMG'){
			$url = 'smkn6smg.fresto.co';
			$new_url = '45.114.118.225/smk_smg6n_absensi';
		}elseif(strtoupper($kode_sekolah) == 'SMKPKAB'){
			$url = 'smk-penerbangan.smg.fresto.co';
		}
		
		/// SWASTA
		elseif(strtoupper($kode_sekolah) == 'SMAPLDONBOSKO'){
			$url = 'smapldonbosko.fresto.co';
			$new_url = '45.114.118.225/smapldonbosko_absensi';
		}elseif(strtoupper($kode_sekolah) == 'SMATERBANG'){
			$url = 'smaterbang.fresto.co';
		}elseif(strtoupper($kode_sekolah) == 'SMAKRISTAMITRA'){
			$url = 'kristamitra.tk';
		}elseif(strtoupper($kode_sekolah) == 'SMATHERESIANA'){
			$url = 'sma.theresiana.fresto.co';
		}
		
		elseif(strtoupper($kode_sekolah) == 'SMKNUSAPUTERA1'){
			$url = 'smknusaputera1.fresto.co';
		}
		elseif(strtoupper($kode_sekolah) == 'SMASETIABUDHI'){
			$url = 'sma-setiabudhi.fresto.co';
		}
		elseif(strtoupper($kode_sekolah) == 'SMASULTANAGUNG1'){
			$url = 'smaissa1smg.fresto.co';
		}

		/// HOMESCHOLLING
		elseif(strtoupper($kode_sekolah) == 'ANUGRAHBANGSA'){
			$url = 'anugrahbangsa.fresto.co';
		}
		elseif(strtoupper($kode_sekolah) == 'HSKSSBY'){
			$url = 'hsks-sby.fresto.co';
		}
		
		// SMP
		elseif(strtoupper($kode_sekolah) == 'SMPTERBANG'){
			$url = 'smpterbang.fresto.co';
		}
		
		
		if(isset($url)){
			
			$url = 'http://'.$url.'/absensi/service/login_two';
			
			if(isset($new_url)){
			
				$url = 'http://'.$new_url.'/service/login_two';
			}
			
			$post = [
				'username' 		=> $username,
				'password' 		=> $password,
				'kode_sekolah'  => $kode_sekolah,
				'deviceid'		=> $deviceid
			];
			/*$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			$response = curl_exec($ch);
			var_export($response);
			*/
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			//curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			//Send the request
			$response = curl_exec($ch);
			//Close request
			if ($response === FALSE) {
			die('FCM Send Error: ' . curl_error($ch));
			}
			curl_close($ch);
			
		}else{
			
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Kode Tidak ditemukan';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
		
	}
	
	public function login_two(){
		
		/*$username = $this->input->post('username');
		$password = $this->input->post('password');*/
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$kode_sekolah 	= $this->input->post('kode_sekolah');
		
		$key = 'fresto6';

		$new_pass = md5($password.$key).md5($password);
		
		$user = $this->db->query("SELECT * FROM data_user WHERE username = '".$username."' AND password = '".$new_pass."'");
		if ($user->num_rows()>0) {
			
			//// SMA
			if($_SERVER['HTTP_HOST']=='sman1-smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 1 SMG',
					'image'		=> base_url('content/images').'/SMAN_1_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman3smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 3 SMG',
					'image'		=> base_url('content/images').'/SMAN_3_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman6smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 6 SMG',
					'image'		=> base_url('content/images').'/SMAN_6_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman8-smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 8 SMG',
					'image'		=> base_url('content/images').'/SMAN_8_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman9-smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 9 SMG',
					'image'		=> base_url('content/images').'/SMAN_9_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman11-smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 11 SMG',
					'image'		=> base_url('content/images').'/SMAN_11_Semarang.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sman14-smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMAN 14 SMG',
					'image'		=> base_url('content/images').'/SMAN_14_Semarang.png',
				);
			}
			
			//// SMK
			elseif($_SERVER['HTTP_HOST']=='smkn6smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMKN 6 SMG',
					'image'		=> base_url('content/images').'/SMKN_6_Semarang.png',
				);
			}
			
			elseif($_SERVER['HTTP_HOST']=='smk-penerbangan.smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMK PKAB SMG',
					'image'		=> base_url('content/images').'/SMK_Penerbangan.png',
				);
			}
			
			
			//// SWASTA
			elseif($_SERVER['HTTP_HOST']=='smapldonbosko.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA PL DONBOSKOserver5',
					'image'		=> base_url('content/images').'/SMA_PL_DonBosko.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='smaterbang.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA TERBANG',
					'image'		=> base_url('content/images').'/SMA_Terang_Bangsa.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='kristamitra.tk'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA KRISTAMITRA',
					'image'		=> base_url('content/images').'/SMA_Kristamitra.png',
				);
			}elseif($_SERVER['HTTP_HOST']=='sma.theresiana.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA THERESIANA 1',
					'image'		=> base_url('content/images').'/SMA_Theresiana1.png',
				);
			}
			
			elseif($_SERVER['HTTP_HOST']=='smknusaputera1.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMK NUSAPUTERA 1',
					'image'		=> base_url('content/images').'/SMK_nusput.png',
				);
			}
			elseif($_SERVER['HTTP_HOST']=='sma-setiabudhi.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA SETIABUDHI',
					'image'		=> base_url('content/images').'/SMA_sethiabudhi.png',
				);
			}
			elseif($_SERVER['HTTP_HOST']=='smaissa1smg.fresto.co'){
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMA ISLAM SULTAN AGUNG 1 SEMARANG',
					'image'		=> base_url('content/images').'/SMA_sultan_agung.png',
				);
			}
			
			/// HOMESCHOLLING
			elseif($_SERVER['HTTP_HOST']=='anugrahbangsa.fresto.co')
			{	
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'ANUGRAH BANGSA',
					'image'		=> base_url('content/images').'/anugrahbangsa.png',
				);
			}
			
			elseif($_SERVER['HTTP_HOST']=='hsks-sby.fresto.co')
			{	
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'HSKS SURABAYA',
					'image'		=> base_url('content/images').'/hsks_sby.jpg',
				);	
			}
			
			/// SMP
			elseif($_SERVER['HTTP_HOST']=='smpterbang.fresto.co')
			{	
				$sekolah = array(
					'url'		=> $_SERVER['HTTP_HOST'],
					'sekolah'	=> 'SMP TERBANG',
					'image'		=> base_url('content/images').'/SMP_Terang_Bangsa.png',
				);
			}
	
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			/////// NEW SERVER ///////////////////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			elseif(APP_SUBDOMAIN == 'sma_smg8n'){
				$sekolah = array(
					'url'		=> '45.114.118.248/sma_smg8n_absensi',
					'sekolah'	=> 'SMAN 8 SMG',
					'image'		=> base_url('content/images').'/SMAN_8_Semarang.png',
				);
			}
			
			elseif(APP_SUBDOMAIN == 'sma_smg9n'){
				$sekolah = array(
					'url'		=> '45.114.118.248/sma_smg9n_absensi',
					'sekolah'	=> 'SMAN 9 SMG',
					'image'		=> base_url('content/images').'/SMAN_9_Semarang.png',
				);
			}
			
			elseif(APP_SUBDOMAIN == 'smk_smg6n'){
				$sekolah = array(
					'url'		=> '45.114.118.225/smk_smg6n_absensi',
					'sekolah'	=> 'SMKN 6 SMG',
					'image'		=> base_url('content/images').'/SMKN_6_Semarang.png',
				);
			}
			
			elseif(APP_SUBDOMAIN == 'smapldonbosko'){
				$sekolah = array(
					'url'		=> '45.114.118.225/smapldonbosko_absensi',
					'sekolah'	=> 'SMA PL DONBOSKOserver5',
					'image'		=> base_url('content/images').'/SMA_PL_DonBosko.png',
				);
			}
			
				
				
			$sekolah['sekolah'] = SEKOLAH;
			$sekolah['image'] = URL_MASTER.'content/images/'.LOGO_SEKOLAH;
			
			/// update id device
			$data['deviceid'] = $this->input->post('deviceid');
			$sekolah['deviceid'] = $data['deviceid'];
			
			$this->db->where("username", $username);
			$this->db->where("password", $new_pass);
			$this->db->update("data_user",$data);
			//////////////////////////
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $user->result();
			$obj->data_sekolah = $sekolah;
			
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Username dan Password tidak sesuai '.APP_SUBDOMAIN.'a';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function akun(){
		$role	 		 = $this->input->get('role');
		if($role == "admin"){
			$this->admin();
		}
		if($role == "sdm"){
			$this->guru();
		}
		if($role == "siswa"){
			$this->siswa();
		}
	}

	public function admin(){
		$data['role_create']	= $this->input->get('role');
		$data['admin_id'] = (int)$this->input->get('user');
		
		$admin_data = $this->admin->get_data($data);
		
		if ($admin_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->admin = $admin_data->result();
			
			//// FOTO //////
			$no=0;
			foreach($objData->admin as $admin){
				$objXdat = new stdClass();
				$xdat = (array) json_decode($admin->xdat, TRUE);
				foreach($xdat as $idx => $foto){
					$objXdat = $foto;
				}
				$admin->foto = $objXdat;
				$no++;
			}
			/////////////////
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function guru(){
		//$role	 		 = $this->input->get('role');
		$data['role_create']	= $this->input->get('role');
		$data['guru_id'] = (int)$this->input->get('user');
		//$data['guru_id'] = (int)$this->input->get('guru');
		
		$guru_data = $this->guru->get_data($data);
		$wali_data = $this->guru->get_data_wali($data);
		$pelajaran_data = $this->nilai_pelajaran->get_data($data);
		
		if ($guru_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->guru = $guru_data->result();
			$objData->wali = $wali_data->result();
			$objData->pelajaran = $pelajaran_data->result();
			
			//// FOTO //////
			$no=0;
			foreach($objData->guru as $guru){
				$objXdat = new stdClass();
				$xdat = (array) json_decode($guru->xdat, TRUE);
				foreach($xdat as $idx => $foto){
					$objXdat = $foto;
				}
				$guru->foto = $objXdat;
				$no++;
			}
			/////////////////
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function jadwal(){
		
		$role			 	= $this->input->get('role');
		$data['user']		= (int)$this->input->get('user');
		
		$data['jadwal_id'] 	= (int)$this->input->get('jadwal');
		//$data['user'] 	= (int)$this->input->post('guru');
		
		if($role=='siswa'){
			$jadwal_data = $this->jadwal->get_data_siswa($data);
		}else{
			$jadwal_data = $this->jadwal->get_data_guru($data);
		}
		
		if ($jadwal_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->jadwal = $jadwal_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function kaldik(){

		$data['kaldik_id'] = (int)$this->input->get('kaldik');
		
		$kaldik_data = $this->kaldik->get_data($data);
		
		if ($kaldik_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->kaldik = $kaldik_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function jurnal(){

		$data['jurnal_id'] = (int)$this->input->get('jurnal');
		$data['guru_id'] = (int)$this->input->get('guru');
		
		$guru_data = $this->jurnal->get_data($data);
		$jam_ajar_data 	= $this->jam_ajar->get_data();
		
		if ($guru_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->jurnal = $guru_data->result();
			$objData->jam_ajar = $jam_ajar_data->result();
			
			//// GET name jam_ajar
			$array_jam_ajar = array();
			foreach($objData->jurnal as $jurnal_view){
				$temp_jam_ajar_id = str_replace("[","",$jurnal_view->jam_ajar_id);
				$temp_jam_ajar_id = str_replace("]","",$temp_jam_ajar_id);
				$temp_jam_ajar_id = str_replace('"',"",$temp_jam_ajar_id);
				
				if($temp_jam_ajar_id != ''){
					$no=0;
					$array_jam_ajar_id = explode(",",$temp_jam_ajar_id);
					
					foreach($array_jam_ajar_id as $jam_ajar_id){
						$array_jam_ajar[$jam_ajar_id] = 1;
						//$jurnal_view->jam_ajar[$no]->selected = 1;
						$no++;
					}
				}
				
				$no=0;
				foreach($objData->jam_ajar as $jam_ajar_view){
					
					$jurnal_view->jam_ajar[$no] = new stdClass();
					$jurnal_view->jam_ajar[$no]->id = $jam_ajar_view->id;
					$jurnal_view->jam_ajar[$no]->nama = $jam_ajar_view->nama;
					if(isset($array_jam_ajar[$jam_ajar_view->id])){
						if($array_jam_ajar[$jam_ajar_view->id]==1){
							$jurnal_view->jam_ajar[$no]->selected = 1;
						}else{
							$jurnal_view->jam_ajar[$no]->selected = 0;
						}
					}else{
						$jurnal_view->jam_ajar[$no]->selected = 0;
					}
					
					$array_jam_ajar[$jam_ajar_view->id] = 0;
					$no++;
				}
			}
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function pelajaran(){

		$data['guru_id'] = (int)$this->input->get('guru');
		
		$pelajaran_data = $this->nilai_pelajaran->get_data($data);
		
		if ($pelajaran_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->pelajaran = $pelajaran_data->result();

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function siswa(){
		$role			 	= $this->input->get('role');
		$data['user']		= (int)$this->input->get('user');
	
		$data['siswa_nilai_id'] = (int)$this->input->get('siswa');
		$data['kelas_nilai_id'] = (int)$this->input->get('kelas');
		
		$siswa_data = $this->nilai_siswa->get_data($data);
		
		if ($siswa_data->num_rows()>0) {
			
			$objData = new stdClass();
			$objData->siswa = $siswa_data->result();

			if(isset($data['user'])){
				if($data['user']>0){
					//// FOTO //////
					$no=0;
					foreach($objData->siswa as $siswa){
						$objXdat = new stdClass();
						$xdat = (array) json_decode($siswa->xdat, TRUE);
						foreach($xdat as $idx => $foto){
							$objXdat = $foto;
						}
						$siswa->foto = $objXdat;
						$no++;
					}
					/////////////////
				}
			}
			
			$obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function kelas(){
		$role	 				= $this->input->get('role');
		$user					= (int)$this->input->get('user');
		$data['nilai_kelas_id'] = (int)$this->input->get('kelas');
		$data['jam_ajar'] = (int)$this->input->get('jam_ajar');
		$data['guru_id'] = (int)$this->input->get('guru');
		$data['role_create']	= $role;
		//$data['guru_id'] = 277;
		
		$kelas_data 	= $this->nilai_kelas->get_data($data);
		$jam_ajar_data 	= $this->jam_ajar->get_data();
		$pelajaran_data = $this->nilai_pelajaran->get_data($data);
		$guru_data 		= $this->guru->get_data($data);
		$status_belajar_data = $this->status_belajar->get_data();
		//$jam_ajar = $this->db->query("SELECT * FROM dakd_jam_ajar WHERE aktif = 1 ");
		
		if ($kelas_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->kelas 	= $kelas_data->result();
			$objData->jam_ajar 	= $jam_ajar_data->result();
			$objData->pelajaran = $pelajaran_data->result();
			$objData->guru 		= $guru_data->result();
			$objData->status_belajar = $status_belajar_data->result();

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}

	public function kelas_absensi(){
		$role	 				= $this->input->get('role');
		$user					= (int)$this->input->get('user');
		if($role=='admin'){
			$data['guru_id']	= (int)$this->input->get('guru');
		}else{
			$data['guru_id']	= $user;
		}
		
		$data['role_create']	= $role;
		$data['id'] 			= (int)$this->input->get('absensi');
		$data['nilai_kelas_id'] = (int)$this->input->get('kelas');
		$data['tanggal'] 		= $this->input->get('tanggal');
		$data['jam_ajar'] 		= (int)$this->input->get('jam_ajar');
		
		
		$kelas_data = $this->nilai_absensi->get_data($data);
		$jam_ajar_data = $this->jam_ajar->get_data();
		$status_belajar_data = $this->status_belajar->get_data();
		// $jam_ajar = $this->db->query("SELECT * FROM dakd_jam_ajar WHERE aktif = 1 ");
		
		if ($kelas_data->num_rows()>0) {

			// $jamAjarData = new stdClass();
			// $jamAjarData->jam_ajar = $jam_ajar_data->result();

			$objData = new stdClass();
			$objData->kelas = $kelas_data->result();
			$objData->jam_ajar = $jam_ajar_data->result();
			$objData->status_belajar = $status_belajar_data->result();
			
			//// GET name jam_ajar
			$array_jam_ajar = array();
			foreach($objData->kelas as $kelas_view){
				$temp_jam_ajar_id = str_replace("[","",$kelas_view->jam_ajar_id);
				$temp_jam_ajar_id = str_replace("]","",$temp_jam_ajar_id);
				$temp_jam_ajar_id = str_replace('"',"",$temp_jam_ajar_id);
				
				if($temp_jam_ajar_id != ''){
					$no=0;
					$array_jam_ajar_id = explode(",",$temp_jam_ajar_id);
					
					foreach($array_jam_ajar_id as $jam_ajar_id){
						$array_jam_ajar[$jam_ajar_id] = 1;
						//$kelas_view->jam_ajar[$no]->selected = 1;
						$no++;
					}
				}
				
				$no=0;
				foreach($objData->jam_ajar as $jam_ajar_view){
					
					$kelas_view->jam_ajar[$no] = new stdClass();
					$kelas_view->jam_ajar[$no]->id = $jam_ajar_view->id;
					$kelas_view->jam_ajar[$no]->nama = $jam_ajar_view->nama;
					if(isset($array_jam_ajar[$jam_ajar_view->id])){
						if($array_jam_ajar[$jam_ajar_view->id]==1){
							$kelas_view->jam_ajar[$no]->selected = 1;
						}else{
							$kelas_view->jam_ajar[$no]->selected = 0;
						}
					}else{
						$kelas_view->jam_ajar[$no]->selected = 0;
					}
					
					$array_jam_ajar[$jam_ajar_view->id] = 0;
					$no++;
				}
			}
			
			// $objData->kelas->jam_ajar = $jamAjarData;

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			
			

			echo json_encode($obj);
			
		} else{
			$request = new stdClass();
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			if($this->input->get('kelas')){
				$request->nilai_kelas_id = (int)$this->input->get('kelas');
			}
			if($this->input->get('tanggal')){
				$request->tanggal 		= $this->input->get('tanggal');
			}
			if($this->input->get('jam_ajar')){
				$request->jam_ajar 		= (int)$this->input->get('jam_ajar');
			}
			$obj->request = $request;
			echo json_encode($obj);
		}
	}
	
	public function jurnal_siswa(){
		$role	 				= $this->input->get('role');
		$user					= (int)$this->input->get('user');
		
		$data['guru_id']	= (int)$this->input->get('guru');
		
		$data['role_create']	= $role;
		$data['id'] 			= (int)$this->input->get('jurnal');
		$data['nilai_kelas_id'] = (int)$this->input->get('kelas');
		$data['siswa_id'] 		= (int)$this->input->get('siswa');
		$data['tanggal'] 		= $this->input->get('tanggal');
		$data['jam_ajar'] 		= (int)$this->input->get('jam_ajar');
		
		
		$jurnal_data = $this->jurnal_siswa->get_data($data);
		$jam_ajar_data = $this->jam_ajar->get_data();
		$status_belajar_data = $this->status_belajar->get_data();
		// $jam_ajar = $this->db->query("SELECT * FROM dakd_jam_ajar WHERE aktif = 1 ");
		
		if ($jurnal_data->num_rows()>0) {

			// $jamAjarData = new stdClass();
			// $jamAjarData->jam_ajar = $jam_ajar_data->result();

			$objData = new stdClass();
			$objData->jurnal = $jurnal_data->result();
			$objData->jam_ajar = $jam_ajar_data->result();
			$objData->status_belajar = $status_belajar_data->result();
			
			//// GET name jam_ajar
			$array_jam_ajar = array();
			foreach($objData->jurnal as $jurnal_view){
				$temp_jam_ajar_id = str_replace("[","",$jurnal_view->jam_ajar_id);
				$temp_jam_ajar_id = str_replace("]","",$temp_jam_ajar_id);
				$temp_jam_ajar_id = str_replace('"',"",$temp_jam_ajar_id);
				
				if($temp_jam_ajar_id != ''){
					$no=0;
					$array_jam_ajar_id = explode(",",$temp_jam_ajar_id);
					
					foreach($array_jam_ajar_id as $jam_ajar_id){
						$array_jam_ajar[$jam_ajar_id] = 1;
						//$jurnal_view->jam_ajar[$no]->selected = 1;
						$no++;
					}
				}
				
				$no=0;
				foreach($objData->jam_ajar as $jam_ajar_view){
					
					$jurnal_view->jam_ajar[$no] = new stdClass();
					$jurnal_view->jam_ajar[$no]->id = $jam_ajar_view->id;
					$jurnal_view->jam_ajar[$no]->nama = $jam_ajar_view->nama;
					if(isset($array_jam_ajar[$jam_ajar_view->id])){
						if($array_jam_ajar[$jam_ajar_view->id]==1){
							$jurnal_view->jam_ajar[$no]->selected = 1;
						}else{
							$jurnal_view->jam_ajar[$no]->selected = 0;
						}
					}else{
						$jurnal_view->jam_ajar[$no]->selected = 0;
					}
					
					$array_jam_ajar[$jam_ajar_view->id] = 0;
					$no++;
				}
			}
			
			// $objData->kelas->jam_ajar = $jamAjarData;

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			
			

			echo json_encode($obj);
			
		} else{
			$request = new stdClass();
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			if($this->input->get('kelas')){
				$request->nilai_kelas_id = (int)$this->input->get('kelas');
			}
			if($this->input->get('tanggal')){
				$request->tanggal 		= $this->input->get('tanggal');
			}
			if($this->input->get('jam_ajar')){
				$request->jam_ajar 		= (int)$this->input->get('jam_ajar');
			}
			$obj->request = $request;
			echo json_encode($obj);
		}
	}
	
	public function siswa_absensi(){
		$data['kelas'] = (int)$this->input->get('kelas');
		$data['tanggal'] = (int)$this->input->get('tanggal');
		$data['jam_ajar'] = (int)$this->input->get('jam_ajar');
		$data['absensi_nilai_id'] = (int)$this->input->get('absensi');
		
		$absensi_data = $this->nilai_siswa_absensi->get_data($data);
		//$jam_ajar = $this->db->query("SELECT * FROM dakd_jam_ajar WHERE aktif = 1 ");
		
		if ($absensi_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->absensi = $absensi_data->result();
			//$objData->jam_ajar = $jam_ajar->result();
			
			//// FOTO //////
			$no=0;
			foreach($objData->absensi as $absensi){
				$objXdat = new stdClass();
				$xdat = (array) json_decode($absensi->xdat, TRUE);
				foreach($xdat as $idx => $foto){
					$objXdat = $foto;
				}
				$absensi->foto = $objXdat;
				$no++;
			}
			/////////////////

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}

	public function jam_ajar(){
		
		$jam_ajar_data = $this->jam_ajar->get_data();
		
		if ($jam_ajar_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->jam_ajar = $jam_ajar_data->result();

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	
	public function pengumuman(){
		
		$data['role']	 		= $this->input->get('role');
		$data['user']			= (int)$this->input->get('user');
		
		$pengumuman_data = $this->pengumuman->get_data($data);
		
		if ($pengumuman_data->num_rows()>0) {
						
			$objData = new stdClass();
			$objData->pengumuman = $pengumuman_data->result();

	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
	}
	/////////////////// INSERT ////////////
	public function insert_kelas_absensi(){
		/*
		echo $this->input->post('tanggal');
		echo $this->input->post('jam_ajar');
		*/
		$result=0;
		if($this->input->post('tanggal') && $this->input->post('jam_ajar')){
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$data['tanggal']	 			= $this->input->post('tanggal');
			if($role=='admin'){
				$data['guru_id']	 	 		= (int)$this->input->post('guru');
			}else{
				$data['guru_id']	 	 		= $data['modifier_id'];
			}
			$data['role_create']			= $role;
			$data['kelas_nilai_id']		 	= (int)$this->input->post('kelas');
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['pelajaran_nilai_id']	 	= (int)$this->input->post('pelajaran');
			
			$data['materi_ajar']		 	= $this->input->post('materi_ajar');
			$data['status_belajar_id']		= (int)$this->input->post('status_belajar');
			
			$data['jam_masuk']				= $this->input->post('jam_masuk');
			$data['jam_keluar']				= $this->input->post('jam_keluar');
			
			$data['keterangan']	 			= $this->input->post('keterangan');
			
			
			$result = $this->nilai_absensi->insert_data($data);
			
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$data_get['nilai_absensi_id'] = $result->id;
			$nilai_absensi_data = $this->nilai_absensi->get_data($data_get);
			
			$objData->nilai_absensi = $nilai_absensi_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->result		= $result;
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->result		= $result;
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
		
	}
	
	public function insert_jurnal_siswa(){
		/*
		echo $this->input->post('tanggal');
		echo $this->input->post('jam_ajar');
		*/
		$result=0;
		if($this->input->post('tanggal') && $this->input->post('jam_ajar')){
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$data['tanggal']	 			= $this->input->post('tanggal');
			
			$data['role_create']			= $role;
			$data['guru_id']		 		= (int)$this->input->post('guru');
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['pelajaran_nilai_id']	 	= (int)$this->input->post('pelajaran');
			
			$data['materi_ajar']		 	= $this->input->post('materi_ajar');
			$data['status_belajar_id']		= (int)$this->input->post('status_belajar');
			
			$data['jam_masuk']				= $this->input->post('jam_masuk');
			$data['jam_keluar']				= $this->input->post('jam_keluar');
			
			$data['keterangan']	 			= $this->input->post('keterangan');
			
			
			$result = $this->jurnal_siswa->insert_data($data);
			
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$data_get['jurnal_siswa_id'] = $result->id;
			$jurnal_siswa_data = $this->jurnal_siswa->get_data($data_get);
			
			$objData->jurnal_siswa = $jurnal_siswa_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->result		= $result;
			$obj->data = $objData;

			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->result		= $result;
			$obj->data = $dataObj;

			echo json_encode($obj);
		}
		
	}
	
	public function insert_jurnal(){
		
		$result=0;
		
		
		if($this->input->post('judul')){
			$data='';
			$semester_data = $this->semester->get_data($data);
			$semester = $semester_data->row();
			
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			$data['semester_id']			= $semester->id;
			$data['judul']	 				= $this->input->post('judul');
			$data['keterangan']	 			= $this->input->post('keterangan');
			$data['url']	 				= $this->input->post('url');
			$data['type']	 				= $this->input->post('type');
			$data['size']	 				= $this->input->post('size');
			
			if($role=='admin'){
				$data['guru_id']	 	 		= (int)$this->input->post('guru');
			}else{
				$data['guru_id']	 	 		= $data['modifier_id'];
			}
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['tanggal']	 			= $this->input->post('tanggal');
			
			$result = $this->jurnal->insert_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$get['jurnal_id'] = $result->id;
			$jurnal_data = $this->jurnal->get_data($get);
			
			$objData->jurnal = $jurnal_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	public function insert_pengumuman_read(){
		$result=0;
		
		if($this->input->post('pengumuman')){
			$data='';
			$semester_data = $this->semester->get_data($data);
			$semester = $semester_data->row();
			
			$role	 						= $this->input->post('role');
			$data['user_id']	 	 		= (int)$this->input->post('user');
			$data['pengumuman_id']	 	 	= (int)$this->input->post('pengumuman');
			
			$result = $this->pengumuman->insert_data($data);
		}
		//echo $result->ada;
		
		if ($result->ada == 1) {
			$objData = new stdClass();
			
			$get['pengumuman'] 	= $data['pengumuman_id'];
			$get['user'] 		= $data['user_id'];
			$pengumuman_data = $this->pengumuman->get_data($get);
			
			$objData->pengumuman = $pengumuman_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
	}
	
	/////////////////// UPDATE //////////////
	public function update_siswa_absensi(){
		
		$result=0;
		if($this->input->post('id')){
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$data['id']		 				= (int)$this->input->post('id');
			$kelas_id		 				= (int)$this->input->post('kelas');
			
			if($this->input->post('absen')!=""){
				$data['absen']	 				= $this->input->post('absen');
			}
			if($this->input->post('status')!=""){
				$data['status']	 				= $this->input->post('status');
			}
			
			$result = $this->nilai_siswa_absensi->update_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$get['absensi_nilai_id'] = $kelas_id;
			$siswa_absensi_data = $this->nilai_siswa_absensi->get_data($get);
			
			$objData->siswa_absensi = $siswa_absensi_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			//$obj->data = $result;
			$obj->data = $objData;
			$obj->send = $data;
			
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			//$obj->data		= $result;
			$obj->data = $dataObj;
			$obj->send = $data;
			
			echo json_encode($obj);
		}
		
	}
	
	public function update_kelas_absensi(){
		
		$result=0;
		
		if($this->input->post('tanggal') || $this->input->post('jam_ajar')){
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$data['id']		 				= (int)$this->input->post('id');
			$data['tanggal']	 			= $this->input->post('tanggal');
			if($role=='admin'){
				$data['guru_id']	 	 		= (int)$this->input->post('guru');
			}else{
				$data['guru_id']	 	 		= $data['modifier_id'];
			}
			
			$data['role_create']			= $role;
			$data['kelas_nilai_id']		 	= (int)$this->input->post('kelas');
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['pelajaran_nilai_id']	 	= (int)$this->input->post('pelajaran');
			
			$data['materi_ajar']		 	= $this->input->post('materi_ajar');
			$data['status_belajar_id']		= (int)$this->input->post('status_belajar');
			
			$data['jam_masuk']				= $this->input->post('jam_masuk');
			$data['jam_keluar']				= $this->input->post('jam_keluar');
			
			$data['keterangan']	 			= $this->input->post('keterangan');
			//echo"a";
			$result = $this->nilai_absensi->update_data($data);
			//echo"b";
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$get['nilai_absensi_id'] = $data['id'];
			$nilai_absensi_data = $this->nilai_absensi->get_data($get);
			
			$objData->nilai_absensi = $nilai_absensi_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			$obj->check =$result;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	public function update_jurnal_siswa(){
		
		$result=0;
		
		if($this->input->post('tanggal') || $this->input->post('jam_ajar')){
			$role	 						= $this->input->post('role');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$data['id']		 				= (int)$this->input->post('id');
			$data['tanggal']	 			= $this->input->post('tanggal');
			
			$data['guru_id']	 	 		= (int)$this->input->post('guru');
			
			$data['role_create']			= $role;
			
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['pelajaran_nilai_id']	 	= (int)$this->input->post('pelajaran');
			
			$data['materi_ajar']		 	= $this->input->post('materi_ajar');
			$data['status_belajar_id']		= (int)$this->input->post('status_belajar');
			
			$data['jam_masuk']				= $this->input->post('jam_masuk');
			$data['jam_keluar']				= $this->input->post('jam_keluar');
			
			$data['keterangan']	 			= $this->input->post('keterangan');
			//echo"a";
			$result = $this->jurnal_siswa->update_data($data);
			//echo"b";
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$get['jurnal_siswa_id'] = $data['id'];
			$jurnal_siswa_data = $this->jurnal_siswa->get_data($get);
			
			$objData->jurnal_siswa = $jurnal_siswa_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			$obj->check =$result;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	public function update_jurnal(){
		
		$result=0;
		
		if($this->input->post('id')){
			$data='';
			$semester_data = $this->semester->get_data($data);
			$semester = $semester_data->row();
			
			$role	 						= $this->input->post('role');
			$data['id']		 				= (int)$this->input->post('id');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			$data['semester_id']			= $semester->id;
			$data['judul']	 				= $this->input->post('judul');
			$data['keterangan']	 			= $this->input->post('keterangan');
			$data['url']	 				= $this->input->post('url');
			$data['type']	 				= $this->input->post('type');
			$data['size']	 				= $this->input->post('size');
			
			if($role=='admin'){
				$data['guru_id']	 	 		= (int)$this->input->post('guru');
			}else{
				$data['guru_id']	 	 		= $data['modifier_id'];
			}
			$data['jam_ajar_id']	 		= $this->input->post('jam_ajar');
			$data['tanggal']	 			= $this->input->post('tanggal');
			
			$result = $this->jurnal->update_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			$get['jurnal_id'] = $result->id;
			$jurnal_data = $this->jurnal->get_data($get);
			
			$objData->jurnal = $jurnal_data->result();
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	
	
	///////////////// DELETE ///////////////////////////
	public function delete_kelas_absensi(){
		
		$result=0;
		
		if($this->input->post('id')){
			
			$role	 						= $this->input->post('role');
			$data['id']		 				= (int)$this->input->post('id');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$result = $this->nilai_absensi->delete_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	public function delete_jurnal_siswa(){
		
		$result=0;
		
		if($this->input->post('id')){
			
			$role	 						= $this->input->post('role');
			$data['id']		 				= (int)$this->input->post('id');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$result = $this->jurnal_siswa->delete_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
	public function delete_jurnal(){
		
		$result=0;
		
		if($this->input->post('id')){
			
			$role	 						= $this->input->post('role');
			$data['id']		 				= (int)$this->input->post('id');
			$data['modifier_id']	 		= (int)$this->input->post('user');
			
			$result = $this->jurnal->delete_data($data);
		}
		
		if ($result->id > 0) {
			$objData = new stdClass();
			
			
	        $obj = new stdClass();
	        $obj->kode_respon = '00';
			$obj->keterangan = 'Sukses';
			//$obj->data = $objData;
			$obj->send = $data;
			echo json_encode($obj);
			
		} else{
			$dataObj = new stdClass();

	        $obj = new stdClass();
	        $obj->kode_respon = '99';
			$obj->keterangan = 'Tidak Ada Data';
			//$obj->data = $dataObj;
			$obj->send = $data;
			echo json_encode($obj);
		}
		
	}
	
} 