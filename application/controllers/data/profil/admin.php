<?php

class Admin extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'user' => array('#login'),
						'model' => 'm_dprofil_admin',
				),
				'data/profil/admin/browse' => array(
						'library' => 'pagination',
						'helper' => 'form',
						'request' => array('term' => 'clean'),
				),
				'data/profil/admin/form' => array(
						'user' => array('admin'),
						'model' => array('m_data_user'),
						'library' => array('form', 'PhpThumbFactory'),
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'nama' => NULL,
										'prefix' => NULL,
										'suffix' => NULL,
										'gender' => NULL,
										'alamat' => NULL,
										'kota' => NULL,
										'telepon' => NULL,
										'aktif' => 1,
										'email' => NULL,
										'username' => NULL,
										'password' => NULL,
								),
						),
						'validasi-umum' => array(
								array(
										array(
												'field' => 'nama',
												'label' => 'nama',
												'rules' => 'required|trim|alpha_dot_space|min_length[2]|max_length[160]',
										),
										array(
												'field' => 'prefix',
												'label' => 'title depan',
												'rules' => 'trim|alpha_dot_space|max_length[10]',
										),
										array(
												'field' => 'suffix',
												'label' => 'title belakang',
												'rules' => 'trim|alpha_dot_space|max_length[40]',
										),
										array(
												'field' => 'gender',
												'label' => 'gender',
												'rules' => 'required|trim|select[l;p]',
										),
										array(
												'field' => 'alamat',
												'label' => 'alamat',
												'rules' => 'clean|max_length[1024]',
										),
										array(
												'field' => 'kota',
												'label' => 'kota',
												'rules' => 'trim|alpha_dot_space|max_length[40]',
										),
										array(
												'field' => 'telepon',
												'label' => 'telepon',
												'rules' => 'trim|alpha_dot_space|max_length[20]',
										),
								),
						),
						'validasi-akun' => array(
								array(
										array(
												'field' => 'email',
												'label' => 'email',
												'rules' => 'max_length[64]|valid_email|unused_email'
										),
										array(
												'field' => 'username',
												'label' => 'username',
												'rules' => 'trim|required|alpha_dot|max_length[40]|is_unique[data_user.username]'
										),
										array(
												'field' => 'password',
												'label' => 'password',
												'rules' => 'trim|required|min_length[4]|max_length[32]'
										),
										array(
												'field' => 'passconf',
												'label' => 'konfirmasi password',
												'rules' => 'trim|required|matches[password]'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'profil', 'admin');
		$this->d['view'] = cfguc_view('akses', 'data', 'profil', 'admin');
	}

	public function index() {
		if(THEME=='material_admin'){	
			$this->browse(0,3000);	
		}else{
			$this->browse();
		}
	}

	public function browse($index = 0,$limit = 20) {
		$this->_set('data/profil/admin/browse');
		$this->d['resultset'] = $this->m_dprofil_admin->browse($index, $limit);
		$this->_view();
	}

	public function form() {
		$this->_set('data/profil/admin/form');
		$this->form->init('m_dprofil_admin', 'data/profil/admin');

		$d = & $this->d;
		$current_user = ($d['user']['id'] == $d['form']['id']);

		if (!$d['admin'] && !$current_user)
			return alert_error("Anda tidak dapat mengubah data profil lainnya.", '');

		if ($d['post_request'] && !$d['error']):
			if ($this->m_dprofil_admin->save()):
				$redir = "data/profil/admin/" . (($this->input->post('ulang')) ? "form" : "id/{$d['form']['id']}");
				return redir($redir);
			endif;
		endif;

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		//alert_dump(base_convert(ord('�'), latin, 8));
		if(THEME=='material_admin'){
			$redir = "data/profil/admin/form?id={$id}";
			return redir($redir);
		}else{
			$this->_set('data/profil/admin/id');
			$this->_rowset('m_dprofil_admin', $id, 'data/profil/admin');
			
			$this->d['guru'] 	= $this->m_dprofil_admin->jumlah_guru();
			$this->d['kelas'] 	= $this->m_dprofil_admin->jumlah_kelas();
			$this->d['siswa'] 	= $this->m_dprofil_admin->jumlah_siswa();
			
			$this->_view();
		}
	}

}
