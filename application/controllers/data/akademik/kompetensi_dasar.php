<?php

class Kompetensi_dasar extends MY_Controller {

	public function __construct() {
		parent::__construct(array(
				'controller' => array(
						'model' => 'm_dakd_kompetensi_dasar',
				),
				'data/akademik/kompetensi_dasar/browse' => array(
						'model'	 => 'm_option',
						'library' => 'pagination',
						'helper'	 => 'form',
						'request'	 => array(
							'term'			 => 'clean',
							'kurikulum_id'	 => 'trim|as_int',
							'kategori_id'	 => 'trim|as_int',
							'mapel_id'	 	=> 'trim|as_int',
							'grade'			=> 'trim|as_int',
						),
				),
				'data/akademik/kompetensi_dasar/form' => array(
						'model'	 => 'm_option',
						'library'=> 'form',
						'helper' => 'form',
						'data' => array(
								'row' => array(
										'id' => 0,
										'kode' => NULL,
										'nama' => NULL,
										'kategori_id'	 => NULL,
										'kurikulum_id'	 => 1,
										'kode_erapor_teori'		=> NULL,
										'kode_erapor_praktek'	=> NULL,
								),
						),
						'validasi' => array(
								array(
										array(
												'field' => 'kode',
												'label' => 'kode kategori mapel',
												'rules' => 'required|trim|alpha_dot_space|max_length[100]',
										),
										array(
												'field' => 'nama',
												'label' => 'nama kategori mapel',
												//'rules' => 'required|trim|min_length[2]|max_length[200]',
												'rules' => 'required|trim',
										),
								),
								'kode' => array(
										array(
												'field' => 'kode',
												'label' => 'kode kategori mapel',
												'rules' => 'required|trim|alpha_dot_space|max_length[100]'
										),
								),
								'nama' => array(
										array(
												'field' => 'nama',
												'label' => 'nama kompetensi_dasar',
												//'rules' => 'required|trim|min_length[2]|max_length[200]|is_unique[dakd_kompetensi_dasar.nama]'
												'rules' => 'required|trim'
										),
								),
						),
				),
		));
		$this->d['admin'] = cfguc_admin('akses', 'data', 'akademik', 'kategori_mapel');
		$this->d['view'] = cfguc_view('akses', 'data', 'akademik', 'kategori_mapel');
	}

	public function index() {
		$this->browse();
	}

	public function browse($index = 0) {
		$this->_set('data/akademik/kompetensi_dasar/browse');
		$this->d['resultset'] = $this->m_dakd_kompetensi_dasar->browse($index, 20);
		$this->_view();
	}

	public function form() {
		$d = & $this->d;

		//if (!$d['admin'])
			//return alert_error("Anda tidak dapat mengubah data kategori kompetensi dasar.", 'data/akademik/kompetensi_dasar');

		$this->_set('data/akademik/kompetensi_dasar/form');
		$this->form->init('m_dakd_kompetensi_dasar', 'data/akademik/kompetensi_dasar');

		if ($d['post_request'] && !$d['error'])
			if ($this->m_dakd_kompetensi_dasar->save())
				return redir("data/akademik/kompetensi_dasar");

		$this->form->set();
		$this->_view();
	}

	public function id($id = 0) {
		$this->_set('data/akademik/kompetensi_dasar/id');
		$this->_rowset('m_dakd_kompetensi_dasar', $id, 'data/akademik/kompetensi_dasar');
		$this->_view();
	}
	
	public function chek_nama(){
		
		$response = $this->m_dakd_kompetensi_dasar->chek_nama();
		
		echo json_encode($response);      
    	exit;
		
	}

}
