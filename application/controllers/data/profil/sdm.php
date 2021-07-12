<?php

class Sdm extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'					 => array(
				'user'	 => array('#login'),
				'model'	 => 'm_dprofil_sdm',
			),
			'data/profil/sdm/browse'		 => array(
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array('term' => 'clean'),
			),
			'data/profil/sdm/form'			 => array(
				'user'				 => array('admin', 'sdm', 'siswa'),
				'model'				 => array('m_option', 'm_data_user'),
				'library'			 => 'form',
				'helper'			 => 'form',
				'data'				 => array(
					'row' => array(
						'id'		 => 0,
						'nip'		 => NULL,
						'nuptk'		 => NULL,
						'nama'		 => NULL,
						'prefix'	 => NULL,
						'suffix'	 => NULL,
						'gender'	 => NULL,
						'alamat'	 => NULL,
						'kota'		 => NULL,
						'telepon'	 => NULL,
						'aktif'		 => 1,
						'jabatan_id' => NULL,
						'email'		 => NULL,
						'mengajar'	 => 1,
					),
				),
				'validasi-umum'		 => array(
					array(
						array(
							'field'	 => 'nama',
							'label'	 => 'nama',
							'rules'	 => 'required|trim|alpha_dot_space|min_length[2]|max_length[160]',
						),
						array(
							'field'	 => 'prefix',
							'label'	 => 'title depan',
							'rules'	 => 'trim|alpha_dot_space|max_length[10]',
						),
						array(
							'field'	 => 'suffix',
							'label'	 => 'title belakang',
							'rules'	 => 'trim|clean|max_length[40]',
						),
						array(
							'field'	 => 'gender',
							'label'	 => 'gender',
							'rules'	 => 'required|trim|select[l;p]',
						),
						array(
							'field'	 => 'alamat',
							'label'	 => 'alamat',
							'rules'	 => 'clean|max_length[1024]',
						),
						array(
							'field'	 => 'kota',
							'label'	 => 'kota',
							'rules'	 => 'trim|alpha_dot_space|max_length[40]',
						),
						array(
							'field'	 => 'telepon',
							'label'	 => 'telepon',
							'rules'	 => 'trim|alpha_dot_space|max_length[20]',
						),
					),
				),
				'validasi-khusus'	 => array(
					array(
						array(
							'field'	 => 'nip',
							'label'	 => 'NIP',
							'rules'	 => 'required|max_length[30]',
						),
						array(
							'field'	 => 'nuptk',
							'label'	 => 'NUPTK',
							'rules'	 => 'max_length[32]',
						),
						array(
							'field'	 => 'aktif',
							'label'	 => 'keaktifan',
							'rules'	 => 'as_bool',
						),
						array(
							'field'	 => 'mengajar',
							'label'	 => 'mengajar',
							'rules'	 => 'as_bool',
						),
						array(
							'field'	 => 'jabatan_id',
							'label'	 => 'jabatan',
							'rules'	 => 'required|is_exist[dmst_jabatan.id]',
						),
					),
					'nip'	 => array(
						array(
							'field'	 => 'nip',
							'label'	 => 'NIP',
							'rules'	 => 'required|max_length[30]|is_unique[dprofil_sdm.nip]'
						),
					),
					'nuptk'	 => array(
						array(
							'field'	 => 'nuptk',
							'label'	 => 'NUPTK',
							'rules'	 => 'max_length[32]|is_unique[dprofil_sdm.nuptk]'
						),
					),
				),
				'validasi-akun'		 => array(array(
						array(
							'field'	 => 'email',
							'label'	 => 'email',
							'rules'	 => 'max_length[64]|valid_email|unused_email'
						),
					),
				),
			),
			'data/profil/sdm/impor'			 => array(
				'library'	 => array('PHPExcel', 'form'),
				'helper'	 => 'form',
			),
			'data/profil/sdm/reset_password' => array(
				'user'		 => array('admin'),
				'library'	 => array('form'),
				'helper'	 => 'form',
			),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'profil', 'sdm');
		$this->d['view'] = cfguc_view('akses', 'data', 'profil', 'sdm');

	}

	public function index()
	{
		if(THEME=='material_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}

	}

	public function browse($index = 0,$limit = 100)
	{
		$this->_set('data/profil/sdm/browse');
		$this->d['resultset'] = $this->m_dprofil_sdm->browse($index, $limit);
		$this->_view();

	}

	public function form()
	{
		$this->_set('data/profil/sdm/form');
		$this->form->init('m_dprofil_sdm', 'data/profil/sdm');

		$d = & $this->d;
		$current_user = ($d['user']['id'] == $d['form']['id']);

		if(THEME=='material_admin'){
			if ($d['post_request'] && !$d['error'] && ($d['admin'] ||$current_user)):
				if ($this->m_dprofil_sdm->save()):
					$redir = "data/profil/sdm/" . (($this->input->post('ulang')) ? "form" : "id/{$d['form']['id']}");
					return redir($redir);
				endif;
			endif;
		}
		else{
			if (!$d['admin'] && !$current_user)
				return alert_error("Anda tidak dapat mengubah data profil lainnya.", '');
			
			if ($d['post_request'] && !$d['error']):
				if ($this->m_dprofil_sdm->save()):
					$redir = "data/profil/sdm/" . (($this->input->post('ulang')) ? "form" : "id/{$d['form']['id']}");
					return redir($redir);
				endif;
			endif;
		}
		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		if(THEME=='material_admin'){
			$redir = "data/profil/sdm/form?id={$id}";
			return redir($redir);
		}else{
			$this->_set('data/profil/sdm/id');
			$this->_rowset('m_dprofil_sdm', $id, 'data/profil/sdm');
			$this->m_dprofil_sdm->rowsub($id);
			$this->_view();
		}
	}

	public function impor()
	{
		$d = & $this->d;

		if (!$d['admin'])
			return alert_error("Anda tidak dapat menambah data guru.");

		$this->_set('data/profil/sdm/impor');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dprofil_sdm->impor())
				return redir("data/profil/sdm");

		$this->form->set();
		$this->_view();

	}

	public function reset_password($id = 0)
	{
		$d = & $this->d;

		$this->_set('data/profil/sdm/reset_password');
		$this->_rowset('m_dprofil_sdm', $id, 'data/profil/sdm');

		if ($this->input->post('konfirmasi_password') === 'b1smillah')
		{
			if ($this->m_dprofil_sdm->reset_password($d['row']))
			{
				return redir('data/profil/sdm/id/' . $d['row']['id']);
			}
			else
			{
				alert_error('Entah kenapa gagal.');
			}
		}

		$this->_view();

	}
	
	public function reset_password_back($id = 0)
	{
		$d = & $this->d;

		//$this->_set('data/profil/sdm/reset_password');
		$this->_rowset('m_dprofil_sdm', $id, 'data/profil/sdm');

		if ($this->m_dprofil_sdm->reset_password_back($d['row']))
		{
			return redir('data/profil/sdm/id/' . $d['row']['id']);
		}
			
	}

}
