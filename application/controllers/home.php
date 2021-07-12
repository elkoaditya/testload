<?php

class Home extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'model' => 'm_data_user',
				),
				'home/login' => array(
						'user' => 'anonim',
						'model' =>  array('m_app_config','m_log_signin_daily'),
						'library' => array('form', 'user_agent'),
						'helper' => 'form',
						'validation' => array(
								array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required'
								),
								array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required|crypto'
								),
						),
				),
				'home/reset' => array(
						'helper' => 'form'
				),
				'home/alumni' => array(
						'user' => 'anonim',
						'model' =>  array('m_app_config','m_log_signin_daily'),
						'library' => array('form', 'user_agent'),
						'helper' => 'form',
						'validation' => array(
								array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required'
								),
								array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required|crypto'
								),
						),
				),
		));
	}

	public function index() {
		if ($this->d['user']['id'] == 0)
			return $this->login();

		if(THEME=='material_admin'){
			$uri = "dashboard/{$this->d['user']['role']}";
			return redir($uri);
		}
		
		return $this->_redir();
	}

	public function error_404() {
		$uri = $this->uri->uri_string();
		alert_error("Halaman yang Anda maksud tidak ditemukan.<br/>\"{$uri}\"");
		$this->_redir();
	}

	public function login() {
		session_start();
		$this->_set('home/login');

		//alert_error("Sistem masih dalam maintenance");
		//$this->d['pengumuman'] = $this->m_app_config->get('pengumuman_depan');
		$this->d['resultset'] = $this->m_app_config->browse(0, 100);
		
		if ($this->d['post_request'] && !$this->d['error'])
			if ($this->m_data_user->login())
			{
				$_SESSION['user_id'] = $this->d['user']['id'];
				return $this->_redir(TRUE);
			}
		$this->_view();
	}

	public function logout() {
		session_start();
		$this->load->model('m_data_user');
		 
		$this->m_data_user->logout();
		session_unset(); 
		session_destroy();
		redir('login');
	}

	public function reset($code = FALSE) {
		$this->_user('anonim');
		$this->_set('home/reset');

		if ($code)
			if ($this->m_data_user->reset_confirm($code))
				return $this->_redir(TRUE);

		if ($this->d['post_request'])
			$this->m_data_user->reset_request();

		$this->_view();
	}

	public function alumni() {
		session_start();
		$this->_set('home/alumni');

		//alert_error("Sistem masih dalam maintenance");
		//$this->d['pengumuman'] = $this->m_app_config->get('pengumuman_depan');
		$this->d['resultset'] = $this->m_app_config->browse(0, 100);
		
		if ($this->d['post_request'] && !$this->d['error'])
			if ($this->m_data_user->login_alumni())
			{
				$_SESSION['user_id'] = $this->d['user']['id'];
				$redir = "data/profil/siswa/id/{$d['user']['id']}";
				return $this->_redir($redir);
				// $this->_dump();
			}
		$this->_view();
	}

}
