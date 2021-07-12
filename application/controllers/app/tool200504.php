<?php

class Tool extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'		 => array('admin','sdm'),
				'model'		 => 'm_app_config',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'app/tool/reset_password_sdm'	 => array(
				'library' => array(
					'PHPExcel',
					'reset_password_sdm',
				),
			),
			'app/tool/reset_password_siswa'	 => array(
				'model'		 => array('m_app_config_plus','m_option'),
				'library' => array(
					'PHPExcel',
					'reset_password_siswa',
				),
			),
			
			'app/tool/reset_password_sdm_new'	 		=> array(
				'model'		 => array('m_app_config_plus','m_option'),
			),
			'app/tool/reset_password_siswa_angkatan'	 => array(
				'model'		 => array('m_app_config_plus','m_option'),
			),
			'app/tool/siswa_login'			 => array(
				'model'		 => array('m_user_login', 'm_option'),
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term' => 'clean',
					'kelas_id',
				),
			),
			'app/tool/check_token'			 => array(
				'model'		 => array('m_token','m_option'),
				
			),
		));

	}

	public function index()
	{
		$this->_set('app/tool/index');
		$this->_view();

	}

	public function reset_password_sdm()
	{
		$this->_set('app/tool/reset_password_sdm');

		if ($this->d['post_request'])
		{
			return $this->reset_password_sdm->run();
		}

		$this->_view();

	}

	public function reset_password_siswa()
	{
		$this->_set('app/tool/reset_password_siswa');

		if ($this->d['post_request'])
		{
			return $this->reset_password_siswa->run();
		}

		$this->_view();

	}

	// DOWNLOAD PASSWORD TANPA RESET
	public function print_password_sdm()
	{
		$this->_set('app/tool/reset_password_sdm');

		return $this->reset_password_sdm->download();

		$this->_view();

	}
	
	public function print_password_siswa()
	{
		$this->_set('app/tool/reset_password_siswa');

		return $this->reset_password_siswa->download();

		$this->_view();

	}
	
	public function siswa_login($offset = 0)
	{
		$this->_set('app/tool/siswa_login');

		//keikutsertaan
		if($this->input->post('reset_all_checked'))
		{	$this->m_user_login->reset_all_checked();	}
	
		$this->d['resultset'] = $this->m_user_login->daftar_siswa($offset);

		$this->_view();

	}

	public function reset_session($session_id = '')
	{
		$this->load->model('m_user_login');

		if (strlen($session_id) > 10)
		{
			$this->m_user_login->reset($session_id);

			return alert_success("Session berhasil dihapus.", 'app/tool/siswa_login');
		}

		redir('app/tool/siswa_login');

	}
	
	public function check_token(){
		$this->_set('app/tool/check_token');
		
		$this->d['resultset'] = $this->m_token->check_token();
		
		$this->_view();
	}
	
	public function back_password_to_nis()
	{
		
		$query = $this->db->query(" UPDATE data_user du SET du.password =concat( MD5( concat(du.username, 'fresto6') ) ,  MD5(du.username) ) WHERE du.role='siswa' ");
		//$result = $query->result(); 
		
		redir('app/tool/reset_password_siswa');

	}
	
	public function reset_password_sdm_new()
	{
		$this->_set('app/tool/reset_password_sdm_new');
		$this->m_app_config_plus->reset_password_sdm_new();
		
		$this->print_password_sdm();
	}
	
	public function reset_password_siswa_angkatan($angkatan=10)
	{
		$this->_set('app/tool/reset_password_siswa_angkatan');
		$this->m_app_config_plus->reset_password_angkatan($angkatan);
		
		$this->print_password_siswa();
	}
}
