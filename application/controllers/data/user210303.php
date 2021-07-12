<?php

class User extends MY_Controller
{

	public function __construct()
	{
		parent::__construct(array(
			'controller'		 => array(
				'user'	 => array('#login'),
				'model'	 => 'm_data_user',
			),
			'data/user/browse'	 => array(
				'library'	 => 'pagination',
				'helper'	 => 'form',
				'request'	 => array(
					'term'	 => 'clean',
					'role'	 => 'clean',
				),
			),
			//'data/user/id' => array(				),
			'data/user/form'	 => array(
				'library'		 => 'form',
				'helper'		 => 'form',
				'data'			 => array(
					'row' => array(
						'id'		 => 0,
						'email'		 => NULL,
						'username'	 => NULL,
						'password'	 => NULL,
						'expire'	 => NULL,
						'avatar'	 => NULL,
						'alias'		 => NULL,
						'nama'		 => NULL,
						'gender'	 => NULL,
						'tentang'	 => NULL,
						'role'		 => NULL,
					),
				),
				'validationset'	 => array(
					array(
						array(
							'field'	 => 'alias',
							'label'	 => 'nama pendek',
							'rules'	 => 'required|min_length[2]|max_length[32]',
						),
						array(
							'field'	 => 'tentang',
							'label'	 => 'profil tentang',
							'rules'	 => 'max_length[1024]',
						),
						array(
							'field'	 => 'email',
							'label'	 => 'email',
							'rules'	 => 'trim',
						),
						array(
							'field'	 => 'username',
							'label'	 => 'username',
							'rules'	 => 'required',
						),
					),
					'email'		 => array(
						array(
							'field'	 => 'email',
							'label'	 => 'email',
							'rules'	 => 'trim|max_length[64]|valid_email|unused_email'
						),
					),
					'username'	 => array(
						array(
							'field'	 => 'username',
							'label'	 => 'username',
							'rules'	 => 'trim|required|alpha_dot|max_length[40]|is_unique[data_user.username]'
						),
					),
					'password'	 => array(
						array(
							'field'	 => 'password',
							'label'	 => 'password',
							'rules'	 => 'trim|required|min_length[4]|max_length[32]'
						),
						array(
							'field'	 => 'passconf',
							'label'	 => 'konfirmasi password',
							'rules'	 => 'trim|matches[password]'
						),
					),
				),
			),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'user');
		$this->d['view'] = cfguc_view('akses', 'data', 'user');

	}

	public function index()
	{
		if ($this->d['view'])
			return $this->browse();
		else
			return $this->id($this->d['user']['id']);

	}

	public function browse($index = 0)
	{

		if (!$this->d['view'])
			return redir("data/user/id/{$this->d['user']['id']}");

		$this->_set('data/user/browse');
		$this->d['resultset'] = $this->m_data_user->browse($index, 20);
		$this->_view();

	}

	public function form()
	{
		$this->d['row_id'] = (int) $this->input->get_post('id');
		$current_user = ($this->d['user']['id'] == $this->d['row_id']);

		if ($this->d['row_id'] == 0)
			return alert_error('Tak dapat membuat user baru.');
		
		if(THEME=='material_admin'){
			if (!$this->d['admin'] && !$current_user )
			{	
				alert_error("Anda tidak dapat mengubah data user lain.");
				return redir("data/user/id/{$this->d['user']['id']}");
			}
			
		}else{
			if (!$this->d['admin'] && !$current_user )
				return alert_error("Anda tidak dapat mengubah data user lain.");
	
		}
		
		$this->_set('data/user/form');
			$this->form->init('m_data_user', 'data/user');

			if ($this->d['post_request'] && !$this->d['error'])
				if ($this->m_data_user->save()){
					if ($this->d['user']['role']=='siswa'){
						$redir = "data/profil/siswa/id/{$this->d['row_id']}?ringkas=ya";
						return redir($redir);
					}else{
						return redir("data/user/id/{$this->d['row_id']}");
					}
				}
				
		$this->form->set();
		$this->_view();

	}

	public function id($id = 0)
	{
		if(THEME=='material_admin'){
			$redir = "data/user/form?id={$id}";
			return redir($redir);
		}else{
			$this->_set('data/user/id');
			$this->_rowset('m_data_user', $id, 'data/user');
			$this->_view();
		}
	}

	public function reset_password($id = 0)
	{
		$this->_set('data/user/id');
		$this->_rowset('m_data_user', $id, 'data/user');

		if ($this->input->post('password_konfirmasi') === 'b1smillah')
		{

		}

		$this->_view();

	}

}
