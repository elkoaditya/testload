<?php

class M_data_user extends MY_Model
{

	public function __construct()
	{
		parent::__construct(array(
			'fields' => array('alias', 'tentang', 'email', 'username' => FALSE, 'password' => FALSE),
			'fields_required' => array( 'username' => FALSE, 'password' => FALSE),
		));
		$this->dm['admin'] = cfguc_admin('akses', 'data', 'user');
		$this->dm['view'] = cfguc_view('akses', 'data', 'user');

	}

	// login

	function login()
	{
		$this->form->rule();
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		$username = $this->input->post('username');
		$col = ($this->form_validation->valid_email($username)) ? 'email' : 'username';
		$filter['password'] = $this->input->post('password');
		$filter[$col] = $username;

		$sukses = $this->load_profile($filter, TRUE);

		if ($sukses)
			$this->m_log_signin_daily->login();

		return $sukses;

	}

	function login_alumni()
	{
		$this->form->rule();
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

			
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		// if($username != $password){ 
			// return alert_error('ID yang dimasukkan tidak sama');
		// }
		$col = ($this->form_validation->valid_email($username)) ? 'email' : 'username';
		// $filter['password'] = $this->input->post('password');
		$filter[$col] = $username;

		$sukses = $this->load_profile($filter, TRUE, "alumni");

		if ($sukses)
			$this->m_log_signin_daily->login();

		return $sukses;

	}
	function logout()
	{

		if (!$this->ci->d['user'] OR $this->ci->d['user']['id'] == 0)
			return;

		$session_id = $this->session->userdata('session_id');
		$user = $this->ci->d['user']['id'];

		$this->session->renew();
		$this->session->set_userdata('last_logged', $user);

		$this->db->delete('app_session', array('session_id' => $session_id));
		$this->db->update('data_user', array('session_id' => NULL), array('id' => $user));

	}

	function load_profile($ids = FALSE, $login = TRUE, $form_login = "index")
	{
		$this->load->model('m_app_config');

		if (!$ids)
			$ids = (int) $this->session->data('user_id');

		if (!$ids)
			return alert_error('Profil user invalid');

		$shape = array(
			'select' => array(
				'user.id', 'user.username', 'user.password', 'user.username_new', 'user.password_new',
				'user.approve_user', 'user.username_ori', 'user.password_ori',
				'user.role', 'user.expire', 'user.nama', 'user.alias',
				'user.avatar', 'user.xdat', 'user.login_last', 'user.session_id',
			),
			'from'	 => 'data_user user',
		);
		$row = $this->md->query($shape)->rowset($ids);

		if ($row == FALSE && $login)
			return alert_error('username atau password salah.');

		else if ($row == FALSE)
			return alert_error('user tidak ditemukan.');

		if ($row['expire'] && $row['expire'] != '0000-00-00' && $row['expire'] < $this->ci->d['datetime'])
			return alert_error('username Anda telah ditangguhkan.');

		if (strlen($row['session_id']) > 10)
		{
			$session = $this->cek_session($row['session_id']);
			$single_login_siswa = $this->m_app_config->get('single_login_siswa');
			
			if (in_array($row['role'], array('siswa')) && $session && ($single_login_siswa=='enable'))
			{
				return alert_error("Anda telah login dari IP: {$session->ip_address}.");
			}
		}

		array_jdec($row, 'xdat');

		$data = array(
			'login_last' => $this->ci->d['datetime'],
			'session_id' => $this->session->userdata('session_id'),
		);

		
		$user = array(
			'id'			 => (int) $row['id'],
			'role'			 => $row['role'],
			'username'		 => $row['username'],
			'avatar'		 => $row['avatar'],
			'alias'			 => $row['alias'],
			'nama'			 => $row['nama'],
			'display_name'	 => (($row['alias']) ? $row['alias'] : $row['username']),
			'config'		 => (array) array_node($row['xdat'], 'config'),
			'preferences'	 => (array) array_node($row['xdat'], 'preferences'),
		);

		if (($user['role'] != 'siswa')&&($form_login == "alumni")){
			return alert_error(" Profil alumni tidak ditemukan.");
		}
		
		if ($user['role'] == 'siswa')
		{
			$login = $this->m_app_config->get('login_siswa');

			if ($login != 'enable')
			{
				return alert_error('Sistem dalam perbaikan.');
			} 
			
			$login_exambro_siswa = $this->m_app_config->get('login_exambro_siswa');

			if ($login_exambro_siswa == 'enable')
			{
				$logintest	= $this->input->post('logint');
				if ($logintest != 'ok')
				{
					return alert_error('Silahkan KELUAR dari APLIKASI dahulu lalu login dengan SEB / EXAMBRO terbaru.');
				}
			}
			
			
			// if($form_login == "alumni"){
				// $user['role'] = 'alumni';
			// } 
			$user['form_login'] = $form_login; 
			$this->load_config_siswa($user); 
		}
		else if ($user['role'] == 'sdm')
		{
			$login = $this->m_app_config->get('login_sdm');

			if ($login != 'enable')
			{
				return alert_error('Sistem dalam perbaikan.');
			}

			$this->load_config_sdm($user);
		}
		else if ($user['role'] == 'wali')
		{
			$this->load_config_wali($user);
		}
		else if ($user['role'] == 'admin')
		{
			$user['aktif'] = TRUE;
			$user['config'] = array(
				'akses' => array(
					'app'		 => 'admin',
					'log'		 => 'admin',
					'periode'	 => 'admin',
					'data'		 => array(
						'user'			 => 'admin',
						'master'		 => array(
							'agama'			 => 'admin',
							'kota'			 => 'admin',
							'jabatan'		 => 'admin',
							'kolom_nilai'	 => 'admin',
							'kurikulum'		 => 'admin',
							'aspek_pribadi'	 => 'admin',
						),
						'profil'		 => array(
							'admin'		 => 'admin',
							'sdm'		 => 'admin',
							'siswa'		 => 'admin',
							'wali'		 => 'admin',
							'sekolah'	 => 'admin',
						),
						'non_akademik'	 => array(
							'organisasi' => 'admin',
							'ekskul'	 => 'admin',
						),
						'akademik'		 => array(
							'jurusan'		 => 'admin',
							'kelas'			 => 'admin',
							'kategori_mapel' => 'admin',
							'mapel'			 => 'admin',
							'pelajaran'		 => 'admin',
						),
					),
					'kbm'		 => array(
						'artikel'		 => 'admin',
						'materi'		 => 'admin',
						'evaluasi'		 => 'admin',
						'jurnal_kelas'	 => 'admin',
						'absensi'		 => 'admin',
					),
					'nilai'		 => array(
						'organisasi'		 => 'admin',
						'ekskul'			 => 'admin',
						'kelas'				 => 'admin',
						'pelajaran'			 => 'admin',
						'siswa'				 => 'admin',
						'siswa_pelajaran'	 => 'admin',
					),
				/*
				    'ta' => array(
				    'kelas' => 'admin',
				    'siswa' => 'admin',
				    ),
				 *
				 */
				),
			);
		}


		// sdm yg tak aktif lg

		if (!$user['aktif'])
			return alert_error('Profil tidak ditemukan .');

		// akses : admin, entry, view, none

		$this->ci->d['user'] = $user;
		$this->md->quick_update('data_user', $data, $row['id']);
		$this->session->set_userdata('user', $user);
		$this->session->set_userdata('user_id', (int) $this->ci->d['user']['id']);

		
			
		/////////////////////////////////////////////
		/// CEK GANTI USER PASS BARU by SISWA
		if ($user['role'] == 'siswa')
		{
			$cek_change_up = $this->m_app_config->get('change_userpass_by_siswa');
			if ($cek_change_up == 'enable')
			{
				if(($row['username'] == $row['username_ori']) || ($row['password'] == $row['password_ori']))
				{
					return redir("data/user/form_required?id=".$row['id']);
				}
			} 
		}
		////////////////////////////////////////////
			
		return TRUE;

	}

	function load_config_sdm(&$user)
	{
		$user['aktif'] = FALSE;
		$user['wali'] = FALSE;
		$sdm = $this->md->row("select aktif, wali from dprofil_sdm where id = {$user['id']} limit 1");

		if (!$sdm)
			return;

		$user['aktif'] = (bool) $sdm['aktif'];
		$user['wali'] = (bool) $sdm['wali'];

		// load pelajaran & pengembangan

		$user['walikelas'] = $this->md->result_values('id', "select id from dakd_kelas where wali_id = {$user['id']} and aktif = 1");
		$user['mengajar_list'] = $this->md->result_values('id', "select id from dakd_pelajaran where guru_id = {$user['id']} and aktif = 1");
		$user['pembina']['organisasi'] = $this->md->result_values('id', "select id from dnakd_organisasi where pembina_id = {$user['id']} and aktif = 1");
		$user['pembina']['ekskul'] = $this->md->result_values('id', "select id from dnakd_ekskul where pembina_id = {$user['id']} and aktif = 1");

		// load wali. opsional

		if ($user['wali'])
			$this->load_config_wali($user);

	}

	function load_config_siswa(&$user)
	{
 
		// load data siswa
			
		if($user['form_login'] == "alumni" ){
			$this->db
				->select('siswa.aktif, siswa.kelas_id')
				->from('dprofil_siswa siswa')
				->where('siswa.id', $user['id']);
		}else{
			
			$this->db
				->select('siswa.aktif, siswa.kelas_id, siswa.nis, kelas.grade, kelas.nama as kelas_nama')
				->from('dprofil_siswa siswa')
				->join('dakd_kelas kelas', 'kelas.id = siswa.kelas_id', 'inner')
				->where('siswa.id', $user['id']);
		}
				
		$user['aktif'] = FALSE;
		$user['kelas_id'] = FALSE;
		$siswa = $this->md->row();

		if (!$siswa)
			return;

		// config dasaar

		if($user['form_login'] == "alumni" ){
			
			if((!$siswa['kelas_id'])){
				$updat_ = array(
					'kelas_id' => 0,
				);
				$this->md->quick_update('dprofil_siswa', $updat_, $user['id']);
			}elseif($siswa['kelas_id'] != 0){
				return;
			}
			$user['grade'] 			= 0;
			$user['kelas_id'] 		= 0;
			$user['kelas_nama'] 	= '';
			
		}else{
			$user['grade'] 		= (int) $siswa['grade'];
			$user['nis'] 		= (int) $siswa['nis'];
			$user['kelas_id'] 	= (int) $siswa['kelas_id'];
			$user['kelas_nama'] 	= $siswa['kelas_nama'];
		}
		
		$user['aktif'] 		= (bool) $siswa['aktif'];
		$user['nilai_id'] 	= NULL;
		$user['pelajaran_list'] = array();
		

		if ($this->ci->d['semaktif']['id'] == 0)
			return;

		// record rapor

		$this->db
			->select('id')
			->from('nilai_siswa')
			->where('siswa_id', $user['id'])
			->where('semester_id', $this->ci->d['semaktif']['id']);

		$user['nilai_id'] = (int) $this->md->row_col('id');

		// load pelajaran yg diikuti

		if ($user['nilai_id'] > 0):
			$this->db
				->select('nipel.pelajaran_id')
				->from('nilai_pelajaran nipel')
				->join('nilai_siswa_pelajaran nisispel', 'nipel.id = nisispel.pelajaran_nilai_id', 'inner')
				->where('nisispel.siswa_nilai_id', $user['nilai_id']);

			$user['pelajaran_list'] = $this->md->result_values('pelajaran_id');

		endif;

	}

	function load_config_wali(&$user)
	{
		$this->db->select('siswa.id, siswa.aktif')
			->from('dprofil_siswa siswa')
			->join('dprofil_perwalian wali', 'siswa.id = wali.murid_id', 'inner')
			->where('wali_id', $user['id']);
		$user['walimurid'] = $this->md->result_series('id', 'aktif');

	}

	// operasi data

	function browse($index = 0, $limit = 20)
	{
		$term = & $this->ci->d['request']['term'];
		$role = & $this->ci->d['request']['role'];

		if (!in_array($role, array('admin', 'sdm', 'siswa', 'wali')))
			$role = '';

		$shape = array(
			'select' => array(
				'user.*',
			),
			'from'	 => 'data_user user',
			'like'	 => array($term, array('user.nama')),
		);

		if ($this->ci->d['user']['role'] != 'admin')
			$this->db->where("role != 'admin'");

		if ($role != '')
			$this->db->where('role', $role);

		return $this->md->query($shape)->resultset($index, $limit);

	}

	function insert($data)
	{
		$data['role'] = 'admin';
		$data['gender'] = 'l';
		$data['nama'] = $data['alias'];
		$id = $this->md->quick_insert('data_user', $data);

		if (!$id)
			return FALSE;

		$this->d['row_id'] = $id;
		return $id;

	}

	function rowset($id)
	{
		$row = $this->md->rowset($id, 'data_user');

		if (!$row)
			return FALSE;

		$row['tentang'] = base64_decode($row['tentang']);

		return $row;

	}

	function save($required='')
	{
		$d = & $this->ci->d;
		$sesi = $this->ci->form->sesi;
		$row = $this->ci->d['row'];
		$edit = (bool) $sesi['id'];

		$this->form->ruleset($row);
		$this->form->validate();

		if ($this->d['error'])
			return FALSE;

		if($required=='required'){
			$data = $this->inputfilter($row, 'fields_required');
		}else{
			$data = $this->inputfilter($row, 'fields');
		}
		
		$data['username_new'] = $data['username'];
		if (isset($data['password']))
		{	// JIKA PASSWORD KOSOSNG
			if($data['password']==''){
				unset($data['password']);
			}else{
				$data['password'] = crypto($data['password']);
				$data['password_new'] = $data['password'];
			}
		}
		$data['approve_user'] = 1;
		// data hak akses

		if ($this->dm['admin'] && $d['user']['role'] == 'admin' && in_array($d['row']['role'], array('admin', 'sdm')) && $d['row']['id'] != $d['user']['id']):
			$data['xdat'] = (array) json_decode($row['xdat'], TRUE);
			$data['xdat']['config']['akses'] = $this->input_akses();
			$data['xdat'] = json_encode($data['xdat']);
		endif;

		if (!$data)
			return alert_info('Tak ada pembaruan untuk disimpan.');

		$data['tentang'] = base64_encode($data['tentang']);
		$data['modified'] = $d['datetime'];
		$data['modifier_id'] = $d['user']['id'];

		if (!$data['email'])
			$data['email'] = NULL;

		if ($edit)
			$sukses = $this->update($data, $sesi['id']);
		else
			$sukses = $this->insert($data);

		if ($sukses)
			return alert_success('Data berhasil disimpan.');
		else
			return alert_error('Database error, coba beberapa saat lagi.');

	}

	function update($data, $ids)
	{
		return $this->md->quick_update('data_user', $data, $ids);

	}

	function input_akses()
	{
		$list = array(
			'app'		 => 'a-app',
			'log'		 => 'a-log',
			'periode'	 => 'a-periode',
			'data'		 => array(
				'user'			 => 'a-d-user',
				'master'		 => array(
					'jabatan' => 'a-d-m-jabatan',
				),
				'profil'		 => array(
					'admin'	 => 'a-d-p-admin',
					'sdm'	 => 'a-d-p-sdm',
					'siswa'	 => 'a-d-p-siswa',
				),
				'non_akademik'	 => array(
					'organisasi' => 'a-d-n-organisasi',
					'ekskul'	 => 'a-d-n-ekskul',
				),
				'akademik'		 => array(
					'jurusan'		 => 'a-d-a-jurusan',
					'kelas'			 => 'a-d-a-kelas',
					'kategori_mapel' => 'a-d-a-kategori_mapel',
					'mapel'			 => 'a-d-a-mapel',
					'pelajaran'		 => 'a-d-a-pelajaran',
				),
			),
			'kbm'		 => array(
				'materi'		 => 'a-k-materi',
				'evaluasi'		 => 'a-k-evaluasi',
				'jurnal_kelas'	 => 'a-k-jurnal_kelas',
				'absensi'		 => 'a-k-absensi',
			),
			'nilai'		 => array(
				'organisasi'		 => 'a-n-organisasi',
				'ekskul'			 => 'a-n-ekskul',
				'kelas'				 => 'a-n-kelas',
				'pelajaran'			 => 'a-n-pelajaran',
				'siswa'				 => 'a-n-siswa',
				'siswa_pelajaran'	 => 'a-n-siswa_pelajaran',
			),
		);
		return $this->akses_list($list);

	}

	function akses_list($list)
	{
		$akses = array('view', 'admin');
		$dat = array();

		foreach ($list as $key => $val):

			if (is_array($val)):
				$dat[$key] = $this->akses_list($val);

			else:
				$input = $this->input->post($val);

				if (in_array($input, $akses))
					$dat[$key] = $input;

			endif;

		endforeach;

		return $dat;

	}

	// fungsi terkait

	function generate_thumbnails($user_id, $master_path)
	{

		// buat thumb max
		$this->make_thumbnail($user_id, $master_path);

		// buat thumb 50px
		$this->make_thumbnail($user_id, $master_path, 50);

	}

	function make_thumbnail($user_id, $master_path, $size = 'max')
	{

		if (!file_exists($master_path))
			return;

		$this->load->library('PhpThumbFactory');

		$thumb_path = APP_ROOT . "content/" . strtolower(APP_SCOPE) . "/data/user/{$user_id}/";
		$thumb_file = "{$thumb_path}thumb.{$size}.jpg";

		// siapkan folder

		if (!file_exists($thumb_path)):
			try
			{
				mkdir($thumb_path, 0775, TRUE);
			}
			catch (Exception $e)
			{
				return;
			}
		endif;

		delete($thumb_file);

		// pastikan ukuran
		if (!is_numeric($size)):
			$img = getimagesize($master_path);
			$size = min($img);
		endif;

		// buat & simpan thumbnail

		try
		{
			$thumb = PhpThumbFactory::create($master_path);
			$thumb->adaptiveResizeQuadrant($size, $size, 'T');
			$thumb->save($thumb_file, 'jpg');
		}
		catch (Exception $e)
		{
			return;
		}

		// finishing

		@chmod($thumb_file, 0775);

	}

	function reset_password($user_id)
	{
		$password = password_generator($user_id);

		$this->db->delete('secret', array('id' => $user_id));

	}

	function cek_session($session_id)
	{
		$sess_expiration = $this->config->item('sess_expiration');
		$now = $this->d['dto']->getTimestamp();
		$result = $this
			->db
			->select('session_id, ip_address, user_agent, last_activity')
			->from('app_session')
			->where('session_id', $session_id)
			->limit(1)
			->get();

		if ($result->num_rows() > 0)
		{
			$model = $result->row();

			$expiration = $model->last_activity + $sess_expiration;

			if ($expiration > $now)
			{
				return $model;
			}
			else
			{
				$this->db->delete('app_session', array('session_id' => $session_id));
			}
		}

		return NULL;

	}

}
