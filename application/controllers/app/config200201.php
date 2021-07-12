<?php

class Config extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'		 => array(
				'user'		 => array('admin'),
				'model'		 => 'm_app_config',
				'library'	 => 'form',
				'helper'	 => 'form',
			),
			'app/config/index'	 => array(
				'library'	 => 'pagination',
				'request'	 => array(
					'term' => 'clean',
				),
			),
		));

	}

	public function index($index = 0)
	{
		$this->_set('app/config/index');
		$this->d['resultset'] = $this->m_app_config->browse($index, 100);
		$this->_view();

	}

	public function upload_nilai_pelajaran()
	{
		$this->_set('app/config/upload_nilai_pelajaran');
		$this->d['config_value'] = $this->m_app_config->get('upload_nilai_pelajaran');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('upload_nilai_pelajaran'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}

	public function login_sdm()
	{
		$this->_set('app/config/login_sdm');
		$this->d['config_value'] = $this->m_app_config->get('login_sdm');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('login_sdm'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}

	public function login_siswa()
	{
		$this->_set('app/config/login_siswa');
		$this->d['config_value'] = $this->m_app_config->get('login_siswa');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('login_siswa'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}

	public function kunci_password()
	{
		$this->_set('app/config/kunci_password');
		$this->d['config_value'] = $this->m_app_config->get('kunci_password');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('kunci_password'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
	
	public function single_login_siswa()
	{
		$this->_set('app/config/single_login_siswa');
		$this->d['config_value'] = $this->m_app_config->get('single_login_siswa');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('single_login_siswa'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
	
	public function siswa_download_rapor_mid()
	{
		$this->_set('app/config/siswa_download_rapor_mid');
		$this->d['config_value'] = $this->m_app_config->get('siswa_download_rapor_mid');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('siswa_download_rapor_mid'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
	
	public function siswa_download_rapor_uas()
	{
		$this->_set('app/config/siswa_download_rapor_uas');
		$this->d['config_value'] = $this->m_app_config->get('siswa_download_rapor_uas');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('siswa_download_rapor_uas'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
	
	public function pengumuman_depan()
	{
		$this->_set('app/config/pengumuman_depan');
		$this->d['config_value'] = $this->m_app_config->get('pengumuman_depan');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('pengumuman_depan'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
	
	public function siswa_download_kelulusan()
	{
		$this->_set('app/config/siswa_download_kelulusan');
		$this->d['config_value'] = $this->m_app_config->get('siswa_download_kelulusan');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('siswa_download_kelulusan'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}

	public function tanggal_rapor()
	{
		$this->_set('app/config/tanggal_rapor');
		$this->d['config_value'] = $this->m_app_config->private_tgl();

		if ($this->d['post_request'] && !$this->d['error'])
		{
			
			if ($this->m_app_config->save_private_tgl())
			{
				return redir("app/config");
			} 
			//echo "<pre>";
			//print_r($_POST);
			//$this->_dump();
		}else{
			
			$this->_view();
		}

		//$this->_dump();

	}
	
	public function token()
	{
		$this->_set('app/config/token');
		$this->d['config_value'] = $this->m_app_config->get('token');

		if ($this->d['post_request'] && !$this->d['error'])
		{
			if ($this->m_app_config->save('token'))
			{
				return redir("app/config");
			}
		}

		$this->_view();

	}
}
